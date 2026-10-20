<?php

namespace App\Controllers\IngresoVin;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EventoModel;
use App\Models\ExhibicionModel;
use App\Models\GeneralesModel;
use App\Models\IngresoModel;
use App\Models\TrasladoModel;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use App\Models\VinModel;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class SaveEditDelete extends BaseController
{
    public function SaveDuaf()
    {
        date_default_timezone_set("America/Lima");
        $fechaActual = date("Y-m-d");
        $horaActual = date("H:i:s");
        $ingresoVinModel = new IngresoModel();
        $db = \Config\Database::connect();

        try {
            $db->transBegin();

            $vin = $_POST["vinDuaf"];
            $idIngreso = $_POST['idIngresoDuaf'];

            $filtrodelet = [
                'idingresoVin' => $idIngreso,
                'vin' => $vin
            ];

            $delete = $ingresoVinModel->DeleteDuaf($filtrodelet);

            // Manejo del archivo
            if ($file = $this->request->getFile('resourceDuaf')) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $nombreArchivo = $file->getName();
                    $tipoArchivo = $file->getClientMimeType();

                    // Ruta relativa y absoluta
                    $rutaRelativa = 'resource/duaf/' . $vin . '/';
                    $rutaAbsoluta = WRITEPATH . $rutaRelativa;

                    if (!is_dir($rutaAbsoluta)) {
                        mkdir($rutaAbsoluta, 0777, true);
                    }

                    $file->move($rutaAbsoluta, $nombreArchivo);

                    $rutaArchivo = $rutaRelativa . $nombreArchivo; // Guardar solo la ruta relativa
                } else {
                    throw new \Exception("Archivo no válido o ya fue movido.");
                }
            } else {
                throw new \Exception("Archivo 'resourceDuaf' no recibido.");
            }

            $insertDuaf = [
                'idingresoVin' => $idIngreso,
                'vin' => $vin,
                'fecha' => $fechaActual,
                'hora' => $horaActual,
                'rutaArchivo' => $rutaArchivo,
                'tipoArchivo' => $tipoArchivo,
                'nombreArchivo' => $nombreArchivo,
            ];

            $sd = $ingresoVinModel->StorageDuaf($insertDuaf);

            if ($db->transStatus() === false) {
                $db->transRollback();
                echo json_encode([
                    'status' => 'error',
                    'title' => 'Fallo en la transacción',
                    'message' => 'No se pudo completar el registro del DUAF.',
                ]);
                return;
            } else {
                $db->transCommit();
                echo json_encode([
                    'status' => 'success',
                    'title' => 'DUAF guardado',
                    'message' => 'Se ha registrado correctamente el DUAF.',
                ]);
                return;
            }

        } catch (\Throwable $th) {
            $db->transRollback();
            echo json_encode([
                'status' => 'error',
                'title' => 'Error al guardar DUAF',
                'message' => 'Excepción: ' . $th->getMessage(),
            ]);
            return;
        }
    }

    public function SaveVinCreadoGestyx()
    {
        date_default_timezone_set("America/Lima");
        $fechaActual = date("Y-m-d");
        $vinModel = new VinModel();
        $db = \Config\Database::connect();


        try {
            $db->transBegin();

            $filtro = [
                'codigoMarca' => $_POST["marcaCreate"]
            ];

            $marca = $vinModel->SelectMarcaVehiculo($filtro);
            $bodega = $vinModel->SelectBodegaVehiculo($filtro);

            if ($marca === false || empty($marca)) {
                throw new \Exception("No se encontró información de marca para el código proporcionado.");
            }

            if ($bodega === false || empty($bodega)) {
                throw new \Exception("No se encontró información de bodega para el código proporcionado.");
            }

            $vin = strtoupper($_POST["vinValidado"]);

            $vinExiste = $vinModel->VinInfo($vin);

            if ($vinExiste) {
                echo json_encode([
                    'status' => 'warning',
                    'title' => 'Vin existente',
                    'message' => 'El Vin ' . $vin . ' ya se encuentra en la base de datos de Gestyx'
                ]);
                exit();
            }

            // 📸 Procesar imagen capturada
            $base64Image = $_POST['capturedImage'] ?? null;
            $rutaImagen = null;
            $nombreImagen = null;
            $tipoImagen = null;

            if ($base64Image && preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $data = substr($base64Image, strpos($base64Image, ',') + 1);
                $tipoImagen = $type[1];
                $data = base64_decode($data);

                if ($data === false) {
                    throw new \Exception("Error al decodificar la imagen base64.");
                }

                // 📂 Crear carpeta si no existe
                $vinFolder = FCPATH . 'resource/img/creadoGestyx/' . $vin . '/';
                if (!is_dir($vinFolder)) {
                    mkdir($vinFolder, 0755, true);
                }

                $nombreImagen = uniqid('foto_') . '.' . $tipoImagen;
                $rutaCompleta = $vinFolder . $nombreImagen;

                // 📥 Guardar imagen
                file_put_contents($rutaCompleta, $data);

                // Guardamos ruta relativa para base de datos
                $rutaImagen = 'resource/img/creadoGestyx/' . $vin . '/' . $nombreImagen;
            }

            $vinCreado = [
                'codigoMarca'    => $marca[0]['codigoMarca'],
                'marca'          => $marca[0]['marca'],
                'codigoBodega'   => $bodega[0]['codigoBodega'],
                'bodega'         => $bodega[0]['bodega'],
                'vin'            => $vin,
                'color'          => $_POST["colorVin"],
                'anhoModelo'     => $_POST["yearMod"],
                'fechaCreacion'  => $fechaActual,
                'idusuario'      => session('idusuario'),
                'modelo'         => $_POST["modeloVehiculo"],
                'rutaImagen'     => $rutaImagen,
                'nombreImagen'   => $nombreImagen,
                'tipoImagen'     => $tipoImagen
            ];

            $vinInsertarGestyx = [
                'vin'            => $vin,
                'codigoMarca'    => $marca[0]['codigoMarca'],
                'marca'          => $marca[0]['marca'],
                'codigoBodega'   => $bodega[0]['codigoBodega'],
                'bodega'         => $bodega[0]['bodega'],
                'color'          => $_POST["colorVin"],
                'anhoModelo'     => $_POST["yearMod"],
                'modelo'         => $_POST["modeloVehiculo"],
                'idestadoVin'    => 1,
                'idtipoVin'      => 1
            ];

            $vinModel->StorageVinCreadoModulo($vinCreado);
            $vinModel->StorageVinCreado($vinInsertarGestyx);

            if ($db->transStatus() === false) {
                $db->transRollback();
                throw new \Exception("Error al insertar el VIN.");
            } else {
                $db->transCommit();
                echo json_encode([
                    'status' => 'success',
                    'title' => 'VIN creado',
                    'message' => 'El VIN ha sido registrado correctamente.'
                ]);
            }

        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', '❌ Error al guardar VIN: ' . $e->getMessage());

            echo json_encode([
                'status' => 'danger',
                'title' => 'Error inesperado',
                'message' => 'No se pudo guardar el VIN. Detalles: ' . $e->getMessage()
            ]);
        }
    }



 public function GenerateExcel()
    {
        date_default_timezone_set('America/Lima');
        $fechaReporte=date('d/m/Y');
        // Inicializar el modelo
        $ingresoModel = new IngresoModel();

        // Filtro para obtener los datos
        $filtroReport = [
            'idusuarioGenerado' => session('idusuario'),
            'idestadoReporte'   => 1
        ];

        // Obtener los detalles
        $detail = $ingresoModel->DetailReporteTemporal($filtroReport);

        // Obtener los VINs para filtrar
        $vinFilt = array_column($detail, 'vin');  // Usar array_column para evitar el ciclo manual

        if($_POST['tipoRepoprte']=='porVin'){
// Obtener el reporte de ingresos con los VINs filtrados
            $report = $ingresoModel->DetailReporteIngresoExcel($vinFilt);

            // Crear una nueva instancia de Spreadsheet
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // Ajustar dimensiones de las columnas
            $sheet->getColumnDimension('A')->setWidth(120);
            $this->applyHeaderStyle($sheet, 'A1:T1');  // Función para aplicar estilo de encabezado

            // Definir los encabezados de las columnas
            $headers = [
                'VIN','Fecha ingreso','Marca','Modelo','Color', 'Estado', 'Kilometraje', 'Imagen guia', 'Usuario ingreso',
                'Ubicacion de Ingreso', 'Tipo Daño', 'Severidad Daño', 'Area Daño', 'Sub Area Daño',
                'Reparacion', 'Foto 1', 'Foto 2', 'Foto 3', 'Detalle Repuesto', 'Registro Guia',
                'Solucion', 'Comentarios', 'Usuario Observacion'
            ];

            // Asignar los encabezados a las celdas
            $sheet->fromArray($headers, null, 'A1');
            $sheet->setAutoFilter('A1:T1');
            $sheet->freezePane('A2');

            // Establecer los datos de las filas
            $row = 2;
            foreach ($report as $item) {
                $this->setRowData($sheet, $row, $item);
                $row++;
            }
            // Establecer el ancho automático de las columnas
            $sheet->getColumnDimension('A')->setAutoSize(true);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('H')->setAutoSize(true);
            $sheet->getColumnDimension('I')->setAutoSize(true);
            $sheet->getColumnDimension('J')->setAutoSize(true);
            $sheet->getColumnDimension('K')->setAutoSize(true);
            $sheet->getColumnDimension('L')->setAutoSize(true);
            $sheet->getColumnDimension('M')->setAutoSize(true);
            $sheet->getColumnDimension('N')->setAutoSize(true);
            $sheet->getColumnDimension('R')->setAutoSize(true);
            $sheet->getColumnDimension('S')->setAutoSize(true);
            $sheet->getColumnDimension('T')->setAutoSize(true);
            $sheet->getColumnDimension('U')->setAutoSize(true);
            $sheet->getColumnDimension('V')->setAutoSize(true);
            $sheet->getColumnDimension('W')->setAutoSize(true);
            // Establecer el formato de la columna de fecha
            $sheet->getStyle('B2:B' . ($row - 1))->getNumberFormat()->setFormatCode(NumberFormat::FORMAT_DATE_XLSX14);
            $sheet->getStyle('A2:A' . ($row - 1))->getNumberFormat()->setFormatCode('000000');  // Formato de número


            // Crear un escritor y guardar el archivo Excel
            $writer = new Xlsx($spreadsheet);
            $fileName = 'reporte_ingreso_' . date('YmdHis') . '.xlsx';

            // Forzar la descarga del archivo generado
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');

            // Guardar el archivo en la salida
            $writer->save('php://output');
            exit();
        }else{
// Obtener el reporte de ingresos con los VINs filtrados
            $report = $ingresoModel->DetailReporteIngresoExcelFecha($vinFilt);

// Crear una nueva instancia de Spreadsheet
            $spread = new Spreadsheet();
            $spread->getProperties()
                ->setCreator("AUTONIZA")
                ->setTitle("Reporte Ingreso Vehicular")
                ->setKeywords('PHPSpreadsheet');

// Seleccionar la hoja activa
            $sheet = $spread->getActiveSheet();
            $sheet->setTitle('Reporte Ingreso Vehiculos');

// Insertar logo en la cabecera
            $logoPath = 'resource/img/logoAutoniza.png'; // Reemplaza esto con la ruta de tu logo
            $drawing = new Drawing();
            $drawing->setName('Logo');
            $drawing->setDescription('Logo de la Empresa');
            $drawing->setPath($logoPath);

// Ajustar el tamaño del logo
            $drawing->setHeight(50); // Altura del logo
            $drawing->setWidth(320); // Ancho del logo (ajústalo según sea necesario)
// Ajustar la ubicación del logo en la celda A1
            $drawing->setCoordinates('A1'); // Donde insertar el logo (A1 es solo un ejemplo)
            $drawing->setWorksheet($sheet);

// Encabezado de las columnas
            $encabezado = [
                'Chasis',
                'Marca',
                'Modelo',
                'Color',
                'Ubicacion',
                'Numero Guia',
                'Kilometraje',
                'Estado Vin',
                'Fecha Ingreso',
                'Usuario',
                'Novedades'
            ];

// Ajustar las celdas para el encabezado
            $sheet->fromArray($encabezado, null, 'A5');

// Aplicar color de fondo y estilo a las cabeceras
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'], // Color de texto blanco
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F81BD'], // Color de fondo azul
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ];

// Aplicar estilo a las celdas de las cabeceras (A5:K5)
            $sheet->getStyle('A5:K5')->applyFromArray($headerStyle);

// Aplicar filtro a las cabeceras
            $sheet->setAutoFilter('A5:K5');

// Rellenar los datos del reporte
            $numeroDeFila = 6; // Empezar desde la fila 6 después del encabezado
            foreach ($report as $dit) {
                // Rellenar las celdas con los datos del reporte
                $sheet->setCellValue("A" . $numeroDeFila, $dit["vin"]);
                $sheet->setCellValue("B" . $numeroDeFila, $dit["marca"]);
                $sheet->setCellValue("C" . $numeroDeFila, $dit["modelo"]);
                $sheet->setCellValue("D" . $numeroDeFila, $dit["color"]);
                $sheet->setCellValue("E" . $numeroDeFila, $dit["ubicacion"]);
                $sheet->setCellValue("F" . $numeroDeFila, $dit["nroGuiaRemision"]);
                $sheet->setCellValue("G" . $numeroDeFila, $dit["kilometraje"]);
                $sheet->setCellValue("H" . $numeroDeFila, $dit["estadoVin"]);
                $sheet->setCellValue("I" . $numeroDeFila, $dit["fechaIngreso"]);
                $sheet->setCellValue("J" . $numeroDeFila, $dit["usuario"]);
                $sheet->setCellValue("K" . $numeroDeFila, $dit["novedades"]);

                // Verificar si hay novedades y aplicar un color de fondo amarillo claro a la fila
                if ($dit["novedades"] > 0) {
                    $sheet->getStyle('A' . $numeroDeFila . ':K' . $numeroDeFila)->applyFromArray([
                        'fill' => [
                            'fillType' => Fill::FILL_SOLID,
                            'startColor' => ['rgb' => 'FFFF99'], // Color amarillo claro
                        ]
                    ]);
                }

                $numeroDeFila++;
            }

// Ajustar automáticamente el tamaño de las columnas
            foreach (range('A', 'K') as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }

// Congelar la cabecera (A5:K5) y la primera columna (A)
// La fila 5 se congela (por debajo de la cabecera), y la columna A se congela
            $sheet->freezePane('B6');

// Guardar el archivo como Excel 2007
            $writer = new Xlsx($spread);
            $filename = 'reporteIngreso.xlsx';

// Establecer encabezados para la descarga
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . urlencode($filename) . '"');
            header('Cache-Control: max-age=0');

// Guardar el archivo en la salida
            $writer->save('php://output');
            exit();

        }
    }

    private function applyHeaderStyle($sheet, $range)
    {
        // Aplicar el estilo de la fuente (negrita y tamaño de 12)
        $sheet->getStyle($range)
            ->getFont()->setSize(12)
            ->setBold(true);

        // Aplicar el color de fondo (relleno) a la celda
        $sheet->getStyle($range)
            ->getFill()->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setRGB('4CAF50');

        // Opcional: centrar el texto tanto vertical como horizontalmente
        $sheet->getStyle($range)
            ->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }

private function setRowData($sheet, $row, $item)
    {
        // Asignar valores a las celdas
        $sheet->setCellValue('A' . $row, $item['vin']);
        $sheet->setCellValue('B' . $row, $item['fechaIngreso']);

        $sheet->setCellValue('C' . $row, $item['marca']);
        $sheet->setCellValue('D' . $row, $item['modelo']);
        $sheet->setCellValue('E' . $row, $item['color']);

        $sheet->setCellValue('F' . $row, $item['estadoObservacion']);
        $sheet->setCellValue('H' . $row, $item['kilometraje']);
        $sheet->setCellValue('I' . $row, $item['usuarioIngreso']);
        $sheet->setCellValue('J' . $row, $item['ubicacion']);
        $sheet->setCellValue('K' . $row, $item['tipoDanho']);
        $sheet->setCellValue('L' . $row, $item['severidadDanho']);
        $sheet->setCellValue('M' . $row, $item['areaDanho']);
        $sheet->setCellValue('N' . $row, $item['subAreaDanho']);
        $sheet->setCellValue('R' . $row, $item['reparacion']);
        $sheet->setCellValue('S' . $row, $item['detalleRepuesto']);
        $sheet->setCellValue('T' . $row, ($item['registroGuia'] == 1) ? 'Si Tiene' : 'No tiene');
        $sheet->setCellValue('U' . $row, $item['solucionObservacion']);
        $sheet->setCellValue('V' . $row, $item['comentarioObservacion']);
        $sheet->setCellValue('W' . $row, $item['usuarioObservacion']);


        // Agregar las imágenes a las celdas correspondientes
        $this->addImageIfExists($sheet, 'G' . $row, $item['imagenGuia'], $item['tipoImagen'],$item["idtipoCargaImagen"]);
        $this->addImageIfExists($sheet, 'O' . $row, $item['imagenOne'], $item['tipoImagenOne'],$item["idtipoCargaImagen"]);
        $this->addImageIfExists($sheet, 'P' . $row, $item['imagenTree'], $item['tipoImagenTree'],$item["idtipoCargaImagen"]);
        $this->addImageIfExists($sheet, 'Q' . $row, $item['imagenTwo'], $item['tipoImagenTwo'],$item["idtipoCargaImagen"]);



        // Alinear las celdas de la fila
        $sheet->getStyle('A' . $row . ':T' . $row)->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
    }

    private function addImageIfExists($sheet, $celda, $base64, $tipoImagen,$idtipoCarga)
    {
        if (!empty($base64) && $base64 !== 'null') {
            $this->agregarImagenDesdeBase64($sheet, $celda, $base64, $tipoImagen,$idtipoCarga);
        }
    }

    private function autoSizeColumns($sheet, $columns)
    {
        // Convertir el rango de letras de columnas a un arreglo
        $allColumns = range($columns[0], $columns[1]);
        // Iterar sobre todas las columnas en el rango
        foreach ($allColumns as $column) {
            // Excluir las columnas E, M, N, O
            if (in_array($column, ['E', 'M', 'N', 'O'])) {
                continue;  // Saltar las columnas que no deben ser ajustadas
            }
            // Ajustar el tamaño de la columna
            $sheet->getColumnDimension($column)->setAutoSize(true);
        }
    }



private function agregarImagenDesdeBase64($sheet, $celda, $imagen, $tipoImagen, $idtipoCarga)
{
    // Validar que exista una imagen
    if (!empty($imagen) && $imagen !== 'null') {
        $tempImage = null;

        // Carga tipo base64 (idtipoCarga = 1)
        if ($idtipoCarga == 1) {
            $imagen = str_replace('data:' . $tipoImagen . ';base64,', '', $imagen);
            $data = base64_decode($imagen);

            $tempImage = tempnam(sys_get_temp_dir(), 'img_') . '.' . $tipoImagen;
            file_put_contents($tempImage, $data);
        }

        // Carga desde repositorio (idtipoCarga = 2)
        elseif ($idtipoCarga == 2) {
            // Construir ruta completa desde base_url
            $tempImage = FCPATH . $imagen; // Ruta absoluta en disco (FCPATH apunta al public/)
        }

        // Verificar que la imagen exista (para ambos casos)
        if ($tempImage && file_exists($tempImage)) {
            $drawing = new Drawing();
            $drawing->setName('Imagen');
            $drawing->setDescription('Imagen en la celda');
            $drawing->setPath($tempImage);
            $drawing->setCoordinates($celda);

            // Obtener tamaño original
            list($anchoImagen, $altoImagen) = getimagesize($tempImage);
            $maxAncho = 200;
            $maxAlto = 200;
            $proporcion = min($maxAncho / $anchoImagen, $maxAlto / $altoImagen);

            $anchoAjustado = $anchoImagen * $proporcion;
            $altoAjustado = $altoImagen * $proporcion;

            $drawing->setWidth($anchoAjustado);
            $drawing->setHeight($altoAjustado);

            // Ajustar columna y fila
            $col = $this->obtenerLetraColumnaDeCelda($celda);
            $row = $this->obtenerNumeroFilaDeCelda($celda);
            $sheet->getColumnDimension($col)->setWidth($anchoAjustado / 4);
            $sheet->getRowDimension($row)->setRowHeight($altoAjustado);

            $drawing->setWorksheet($sheet);
        }
    }
}


    private function obtenerNumeroFilaDeCelda($celda)
    {
        // Extraemos la fila de la referencia de la celda (por ejemplo, 'D2' -> 2)
        preg_match('/\d+/', $celda, $matches);
        return $matches[0];  // Retorna el número de fila
    }
    private function obtenerLetraColumnaDeCelda($celda)
    {
        // Extraemos la letra de la columna de la referencia de la celda (por ejemplo, 'D2' -> 'D')
        preg_match('/[A-Z]+/', $celda, $matches);
        return $matches[0];  // Retorna la letra de la columna
    }


    public function SaveIngreso()
    {

        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $ingresoModel=New IngresoModel();
            $vinModel=New VinModel();
            $generalModel=New GeneralesModel();
            date_default_timezone_set("America/Lima");
            $hoy=date("Y-m-d");
            $hora=date("H:i:s");

            $dato=[
                'vin'=>$_POST["vinIngreso"],
                'nroGuiaRemision'=>$_POST["nroGuia"],
                'kilometraje'=>$_POST["kilometraje"],
                'fechaRegistro'=>$hoy,
                'horaRegistro'=>$hora,
                'idusuario'=>session("idusuario"),
                'fechaIngreso'=>$_POST["fechaRecepcion"],
                'idubicacion'=>$_POST["selectUbicacion"],
                'idbox'=>$_POST["boxNuevo"]
            ];

            $archivo = $_FILES['resourceImg']['tmp_name'];
            if (isset($_FILES['resourceImg']) && $_FILES['resourceImg']['error'] == UPLOAD_ERR_OK) {
                //Obtenemos algunos datos necesarios sobre el archivo
                $tipo = $_FILES['resourceImg']['type'];
                $temp = $_FILES['resourceImg']['name'];
                $tps = explode('/', $_FILES['resourceImg']['type']);
                $typo = $tps[1];
                $extensionPermitidas=['pdf','jpeg','jpg','png'];
                $tipoMime=explode("/",$tipo)[1]??'';
                //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                if (!in_array($tipoMime, $extensionPermitidas)) {
                    $send = [
                        "status" => "warning",
                        "title" => "Error de extension",
                        "message" => "El tipo de imagen no es admitido en PDI"
                    ];
                    echo json_encode($send);
                    exit();
                } else {
                    $path = $archivo;
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = $archivo;
                    $dato+=[
                        'imagenGuia' => base64_encode(file_get_contents($data)),
                        'nombreImagen' => $temp,
                        'tipoImagen' => $typo,
                        'fechaCarga' => $hoy,
                        'horaCarga' => $hora
                    ];
                }
            }else{
                $send = [
                    "status" => "danger",
                    "title" => "Error de Carga",
                    "message" => "No se logro cargar el archivo adjunto"
                ];
                echo json_encode($send);
                exit();
            }

            $idingreso=$ingresoModel->StorageIngreso($dato);


            $filtroUpdate=[
                'vin'=>$_POST["vinIngreso"],
            ];

            $filtroubi=[
                'idubicacion'=>$_POST["selectUbicacion"],
            ];

            $ubicacionIngreso=$generalModel->SelectUbicacionGrupo($filtroubi);

            $updateVin=[
                'ingresoVerificado'=>1,
                'idcediIngreso'=>$_POST["selectUbicacion"],
                'cediIngreso'=>$ubicacionIngreso[0]['descripcion'],
                'idubicacionAnterior'=>$_POST["ubicacionAnterior"],
                'idubicacion'=>$_POST["selectUbicacion"],
                'idboxUbicacionActual'=>$_POST["boxNuevo"],
            ];
            $up=$vinModel->UpdateVin($filtroUpdate,$updateVin);
            $database=session("database");
            if($database=='logistica_colombia'){
                $vins=$_POST["vinIngreso"];
                $idubicacion=$_POST["selectUbicacion"];
                $fechaIngreso=$_POST["fechaRecepcion"];
                $sendDms=$this->SendErp($vins,$idubicacion,$fechaIngreso);
            }
                // Sitodo es correcto, confirma la transacción
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al guardar los equipamientos. Por favor, intente nuevamente."
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "idingresoVin"=>$idingreso,
                    "vin"=>$_POST["vinIngreso"],
                    "status" => "success",
                    "title" => "Ingreso Realizado",
                    "message" => "Se Ingreso el vehiculo correctamente"
                ]);
            }
        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }
    }

    private function SendErp($vins='',$idubicacion='',$fechaIngreso='')
    {
        $trasladoModel=New TrasladoModel();
        $url = "https://api.autoniza.net.pe/sincronizaColombia/SendIngresoVin.php";

        $filt=[
            'idubicacion'=>$idubicacion
        ];
        $ubi=$trasladoModel->SelectUbicacionGrupo($filt);
        $descripcionUbicacion=$ubi[0]['descripcion'];
// Los parámetros a enviar
        $data = [
            'vin' => $vins,
            'fechaIngreso' => $fechaIngreso,
            'ubicacion' => $descripcionUbicacion
        ];
// Inicializar cURL
        $ch = curl_init();

// Establecer las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $url);  // URL de la API
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Retorna la respuesta como string
        curl_setopt($ch, CURLOPT_POST, true);  // Usar POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  // Agregar los datos al cuerpo de la solicitud

// Desactivar la verificación SSL (solo para pruebas, no recomendado para producción)
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

// Ejecutar la solicitud cURL
        $response = curl_exec($ch);
        return json_decode($response);
        curl_close($ch);
    }


    public function DeleteObservacion()
    {
        $idobs=$_POST["idobservacionIngresoVin"];
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $ingresoModel=New IngresoModel();
            $filtroObs=[
                'idobservacionIngresoVin'=>$idobs
            ];

            $dest=$ingresoModel->DestroyObservacion($filtroObs);
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al eliminar la observacion. Por favor, intente nuevamente."
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title"=>"Eliminacion Correcta",
                    "message" => "Se Elimino correctamente la observacion"
                ]);
            }
        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function SaveEquipamiento()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $ingresoModel=New IngresoModel();
            $campoCheck = isset($_POST['campoCheck']) ? $_POST['campoCheck'] : [];
            foreach ($campoCheck as $idcheck) {
                $idingresoVin=$_POST["idingresoCheckForm"];
                $vin=$_POST["viningresoCheckForm"];
                $campoName = "options" . $idcheck;
                // Verifica si el campo está presente en el POST
                if (isset($_POST[$campoName])) {
                    // Recupera el valor del campo
                    $valor = $_POST[$campoName];
                    $storageIngresoEq=[
                        'idcheckIngresoVin'=>$idcheck,
                        'resultado'=>$valor,
                        'idingresoVin'=>$idingresoVin,
                        'vin'=>$vin
                    ];
                    $storg=$ingresoModel->StorageCheckEquipamiento($storageIngresoEq);
                }
            }
            // Sitodo es correcto, confirma la transacción
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al guardar los equipamientos. Por favor, intente nuevamente."
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title"=>"Almacenado Correcto",
                    "message" => "Se Agregaron los Equipamientos correctamente"
                ]);
            }
        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }

    }
    public function ProcesarObservacion()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $ingresoModel=New IngresoModel();
            date_default_timezone_set("America/Lima");
            $hoy=date("Y-m-d");
            $hora=date("H:i:s");

            $filtro=[
                'idobservacionIngresoVin'=>$_POST["idobservacionIngresoVin"]
            ];

            $dato=[
                'idestadoObservacion'=>2,
            ];


            $idobservacion = $ingresoModel->UpgradeObservacion($filtro,$dato);

            // Sitodo es correcto, confirma la transacción
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al procesar la observación. Por favor, intente nuevamente."
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title"=>"Procesamiento Correcto",
                    "message" => "Observación procesada exitosamente"
                ]);
            }

        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function UpdateObservacion()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $ingresoModel = new IngresoModel();
            date_default_timezone_set("America/Lima");
            $hoy = date("Y-m-d");
            $hora = date("H:i:s");
            $vin = $_POST["vinObs"];

            $filtro = [
                'idobservacionIngresoVin' => $_POST["idobservacionIngreso"]
            ];

            $dato = [
                'idtipoDanhoVin' => $_POST["tipoDanho"],
                'idseveridadDanhoVin' => $_POST["nivelDanho"],
                'idareaDanhoVin' => $_POST["areaDanho"],
                'idsubAreaDanhoVin' => $_POST["subAreaDanho"],
                'idreparacionVin' => $_POST["reparacion"],
                'detalleRepuesto' => $_POST["detalleRepuesto"],
                'registroGuia' => $_POST["registroGuia"],
                'solucionObservacion' => $_POST["solucion"],
                'comentarios' => $_POST["comentarioObs"],
                'fechaRegistro' => $hoy,
                'horaRegistro' => $hora,
                'idusuario' => session("idusuario"),
                'idestadoObservacion' => 1,
                'idtipoCargaImagen' => 2 // Ahora es repositorio, no base64
            ];

            // Carpeta de destino
            $rutaBase = FCPATH . "resource/ingresoVin/" . $vin . "/DetailObservacion/";
            if (!is_dir($rutaBase)) {
                mkdir($rutaBase, 0777, true);
            }

            // Procesar imagen 1
            if (isset($_FILES['imagenObs1']) && $_FILES['imagenObs1']['error'] == UPLOAD_ERR_OK) {
                $tmp = $_FILES['imagenObs1']['tmp_name'];
                $name = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $_FILES['imagenObs1']['name']);
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $permitidas = ['pdf', 'jpeg', 'jpg', 'png'];
                if (!in_array(strtolower($ext), $permitidas)) {
                    echo json_encode([
                        "status" => "warning",
                        "title" => "Error de extensión",
                        "message" => "El tipo de imagen no es admitido en PDI"
                    ]);
                    exit();
                }
                $nombreFinal = "imgObs1_" . time() . "." . $ext;
                $destino = $rutaBase . $nombreFinal;
                if (move_uploaded_file($tmp, $destino)) {
                    $dato += [
                        'rutaImagen1' => "resource/ingresoVin/{$vin}/DetailObservacion/{$nombreFinal}",
                        'nombreImagen1' => $name,
                        'tipoImagen1' => $ext
                    ];
                } else {
                    echo json_encode([
                        "status" => "danger",
                        "title" => "Error al guardar imagen",
                        "message" => "No se pudo mover imagenObs1 al servidor"
                    ]);
                    exit();
                }
            }

            // Procesar imagen 2
            if (isset($_FILES['imagenObs2']) && $_FILES['imagenObs2']['error'] == UPLOAD_ERR_OK) {
                $tmp = $_FILES['imagenObs2']['tmp_name'];
                $name = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $_FILES['imagenObs2']['name']);
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $permitidas = ['pdf', 'jpeg', 'jpg', 'png'];
                if (!in_array(strtolower($ext), $permitidas)) {
                    echo json_encode([
                        "status" => "warning",
                        "title" => "Error de extensión",
                        "message" => "El tipo de imagen no es admitido en PDI"
                    ]);
                    exit();
                }
                $nombreFinal = "imgObs2_" . time() . "." . $ext;
                $destino = $rutaBase . $nombreFinal;
                if (move_uploaded_file($tmp, $destino)) {
                    $dato += [
                        'rutaImagen2' => "resource/ingresoVin/{$vin}/DetailObservacion/{$nombreFinal}",
                        'nombreImagen2' => $name,
                        'tipoImagen2' => $ext
                    ];
                } else {
                    echo json_encode([
                        "status" => "danger",
                        "title" => "Error al guardar imagen",
                        "message" => "No se pudo mover imagenObs2 al servidor"
                    ]);
                    exit();
                }
            }

            // Procesar imagen 3
            if (isset($_FILES['imagenObs3']) && $_FILES['imagenObs3']['error'] == UPLOAD_ERR_OK) {
                $tmp = $_FILES['imagenObs3']['tmp_name'];
                $name = preg_replace('/[^a-zA-Z0-9_\.-]/', '_', $_FILES['imagenObs3']['name']);
                $ext = pathinfo($name, PATHINFO_EXTENSION);
                $permitidas = ['pdf', 'jpeg', 'jpg', 'png'];
                if (!in_array(strtolower($ext), $permitidas)) {
                    echo json_encode([
                        "status" => "warning",
                        "title" => "Error de extensión",
                        "message" => "El tipo de imagen no es admitido en PDI"
                    ]);
                    exit();
                }
                $nombreFinal = "imgObs3_" . time() . "." . $ext;
                $destino = $rutaBase . $nombreFinal;
                if (move_uploaded_file($tmp, $destino)) {
                    $dato += [
                        'rutaImagen3' => "resource/ingresoVin/{$vin}/DetailObservacion/{$nombreFinal}",
                        'nombreImagen3' => $name,
                        'tipoImagen3' => $ext
                    ];
                } else {
                    echo json_encode([
                        "status" => "danger",
                        "title" => "Error al guardar imagen",
                        "message" => "No se pudo mover imagenObs3 al servidor"
                    ]);
                    exit();
                }
            }

            $idobservacion = $ingresoModel->UpgradeObservacion($filtro, $dato);

            if ($db->transStatus() === FALSE) {
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al guardar la observación. Por favor, intente nuevamente."
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title" => "Actualización Correcta",
                    "message" => "Observación guardada exitosamente"
                ]);
            }

        } catch (\Exception $e) {
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transacción",
                "message" => $e->getMessage()
            ]);
        }
    }



    public function UpdateObservacion_old()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $ingresoModel=New IngresoModel();
            date_default_timezone_set("America/Lima");
            $hoy=date("Y-m-d");
            $hora=date("H:i:s");

            $filtro=[
                'idobservacionIngresoVin'=>$_POST["idobservacionIngreso"]
            ];

            $dato=[
                'idtipoDanhoVin'=>$_POST["tipoDanho"],
                'idseveridadDanhoVin'=>$_POST["nivelDanho"],
                'idareaDanhoVin'=>$_POST["areaDanho"],
                'idsubAreaDanhoVin'=>$_POST["subAreaDanho"],
                'idreparacionVin'=>$_POST["reparacion"],
                'detalleRepuesto'=>$_POST["detalleRepuesto"],
                'registroGuia'=>$_POST["registroGuia"],
                'solucionObservacion'=>$_POST["solucion"],
                'comentarios'=>$_POST["comentarioObs"],
                'fechaRegistro'=>$hoy,
                'horaRegistro'=>$hora,
                'idusuario'=>session("idusuario"),
                'idestadoObservacion'=>1,
            ];


            //Carga de Fotos
            $archivo1 = $_FILES['imagenObs1']['tmp_name'];
            if (isset($_FILES['imagenObs1']) && $_FILES['imagenObs1']['error'] == UPLOAD_ERR_OK) {
                //Obtenemos algunos datos necesarios sobre el archivo
                $tipo1  = $_FILES['imagenObs1']['type'];
                $temp1  = $_FILES['imagenObs1']['name'];
                $tps1  = explode('/', $_FILES['imagenObs1']['type']);
                $typo1  = $tps1[1];
                $extensionPermitidas1=['pdf','jpeg','jpg','png'];
                $tipoMime1 =explode("/",$tipo1)[1]??'';
                //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                if (!in_array($tipoMime1 , $extensionPermitidas1 )) {
                    $send = [
                        "status" => "warning",
                        "title" => "Error de extension",
                        "message" => "El tipo de imagen no es admitido en PDI"
                    ];
                    echo json_encode($send);
                    exit();
                } else {
                    $path = $archivo1;
                    $type1 = pathinfo($path, PATHINFO_EXTENSION);
                    $data1 = $archivo1;
                    $dato+=[
                        'imagenVehiculo1' => base64_encode(file_get_contents($data1)),
                        'nombreImagen1' => $temp1,
                        'tipoImagen1' => $typo1,
                    ];
                }
            }
            $archivo2 = $_FILES['imagenObs2']['tmp_name'];
            if (isset($_FILES['imagenObs2']) && $_FILES['imagenObs2']['error'] == UPLOAD_ERR_OK) {
                //Obtenemos algunos datos necesarios sobre el archivo
                $tipo2  = $_FILES['imagenObs2']['type'];
                $temp2  = $_FILES['imagenObs2']['name'];
                $tps2  = explode('/', $_FILES['imagenObs2']['type']);
                $typo2  = $tps2[1];
                $extensionPermitidas2=['pdf','jpeg','jpg','png'];
                $tipoMime2 =explode("/",$tipo2)[1]??'';
                //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                if (!in_array($tipoMime2, $extensionPermitidas2)) {
                    $send = [
                        "status" => "warning",
                        "title" => "Error de extension",
                        "message" => "El tipo de imagen no es admitido en PDI"
                    ];
                    echo json_encode($send);
                    exit();
                } else {
                    $path = $archivo2;
                    $type2 = pathinfo($path, PATHINFO_EXTENSION);
                    $data2 = $archivo2;
                    $dato+=[
                        'imagenVehiculo2' => base64_encode(file_get_contents($data2)),
                        'nombreImagen2' => $temp2,
                        'tipoImagen2' => $typo2,
                    ];
                }
            }
            $archivo3 = $_FILES['imagenObs3']['tmp_name'];
            if (isset($_FILES['imagenObs3']) && $_FILES['imagenObs3']['error'] == UPLOAD_ERR_OK) {
                //Obtenemos algunos datos necesarios sobre el archivo
                $tipo3  = $_FILES['imagenObs3']['type'];
                $temp3  = $_FILES['imagenObs3']['name'];
                $tps3  = explode('/', $_FILES['imagenObs3']['type']);
                $typo3  = $tps3[1];
                $extensionPermitidas3=['pdf','jpeg','jpg','png'];
                $tipoMime3 =explode("/",$tipo3)[1]??'';
                //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                if (!in_array($tipoMime3 , $extensionPermitidas3)) {
                    $send = [
                        "status" => "warning",
                        "title" => "Error de extension",
                        "message" => "El tipo de imagen no es admitido en PDI"
                    ];
                    echo json_encode($send);
                    exit();
                } else {
                    $path = $archivo3;
                    $type3 = pathinfo($path, PATHINFO_EXTENSION);
                    $data3= $archivo3;
                    $dato+=[
                        'imagenVehiculo3' => base64_encode(file_get_contents($data3)),
                        'nombreImagen3' => $temp3,
                        'tipoImagen3' => $typo3,
                    ];
                }
            }

            $idobservacion = $ingresoModel->UpgradeObservacion($filtro,$dato);

            // Sitodo es correcto, confirma la transacción
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al guardar la observación. Por favor, intente nuevamente."
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title"=>"Actualizacion Correcta",
                    "message" => "Observación guardada exitosamente"
                ]);
            }

        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }
    }
    public function SaveObservacion_old()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $ingresoModel=New IngresoModel();
            date_default_timezone_set("America/Lima");
            $hoy=date("Y-m-d");
            $hora=date("H:i:s");

            $dato=[
                'idtipoDanhoVin'=>$_POST["tipoDanho"],
                'idseveridadDanhoVin'=>$_POST["nivelDanho"],
                'idareaDanhoVin'=>$_POST["areaDanho"],
                'idsubAreaDanhoVin'=>$_POST["subAreaDanho"],
                'idreparacionVin'=>$_POST["reparacion"],
                'detalleRepuesto'=>$_POST["detalleRepuesto"],
                'registroGuia'=>$_POST["registroGuia"],
                'solucionObservacion'=>$_POST["solucion"],
                'comentarios'=>$_POST["comentarioObs"],
                'fechaRegistro'=>$hoy,
                'horaRegistro'=>$hora,
                'idusuario'=>session("idusuario"),
                'idestadoObservacion'=>1,
                'idingresoVin'=>$_POST["idingresoVinObs"],
                'vin'=>$_POST["vinObs"]
            ];


            //Carga de Fotos
            $archivo1 = $_FILES['imagenObs1']['tmp_name'];
            if (isset($_FILES['imagenObs1']) && $_FILES['imagenObs1']['error'] == UPLOAD_ERR_OK) {
                //Obtenemos algunos datos necesarios sobre el archivo
                $tipo1  = $_FILES['imagenObs1']['type'];
                $temp1  = $_FILES['imagenObs1']['name'];
                $tps1  = explode('/', $_FILES['imagenObs1']['type']);
                $typo1  = $tps1[1];
                $extensionPermitidas1=['pdf','jpeg','jpg','png'];
                $tipoMime1 =explode("/",$tipo1)[1]??'';
                //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                if (!in_array($tipoMime1 , $extensionPermitidas1 )) {
                    $send = [
                        "status" => "warning",
                        "title" => "Error de extension",
                        "message" => "El tipo de imagen no es admitido en PDI"
                    ];
                    echo json_encode($send);
                    exit();
                } else {
                    $path = $archivo1;
                    $type1 = pathinfo($path, PATHINFO_EXTENSION);
                    $data1 = $archivo1;
                    $dato+=[
                        'imagenVehiculo1' => base64_encode(file_get_contents($data1)),
                        'nombreImagen1' => $temp1,
                        'tipoImagen1' => $typo1,
                    ];
                }
            }else{
                $send = [
                    "status" => "danger",
                    "title" => "Error de Carga",
                    "message" => "No se logro cargar el archivo adjunto"
                ];
                echo json_encode($send);
                exit();
            }
            $archivo2 = $_FILES['imagenObs2']['tmp_name'];
            if (isset($_FILES['imagenObs2']) && $_FILES['imagenObs2']['error'] == UPLOAD_ERR_OK) {
                //Obtenemos algunos datos necesarios sobre el archivo
                $tipo2  = $_FILES['imagenObs2']['type'];
                $temp2  = $_FILES['imagenObs2']['name'];
                $tps2  = explode('/', $_FILES['imagenObs2']['type']);
                $typo2  = $tps2[1];
                $extensionPermitidas2=['pdf','jpeg','jpg','png'];
                $tipoMime2 =explode("/",$tipo2)[1]??'';
                //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                if (!in_array($tipoMime2, $extensionPermitidas2)) {
                    $send = [
                        "status" => "warning",
                        "title" => "Error de extension",
                        "message" => "El tipo de imagen no es admitido en PDI"
                    ];
                    echo json_encode($send);
                    exit();
                } else {
                    $path = $archivo2;
                    $type2 = pathinfo($path, PATHINFO_EXTENSION);
                    $data2 = $archivo2;
                    $dato+=[
                        'imagenVehiculo2' => base64_encode(file_get_contents($data2)),
                        'nombreImagen2' => $temp2,
                        'tipoImagen2' => $typo2,
                    ];
                }
            }
            $archivo3 = $_FILES['imagenObs3']['tmp_name'];
            if (isset($_FILES['imagenObs3']) && $_FILES['imagenObs3']['error'] == UPLOAD_ERR_OK) {
                //Obtenemos algunos datos necesarios sobre el archivo
                $tipo3  = $_FILES['imagenObs3']['type'];
                $temp3  = $_FILES['imagenObs3']['name'];
                $tps3  = explode('/', $_FILES['imagenObs3']['type']);
                $typo3  = $tps3[1];
                $extensionPermitidas3=['pdf','jpeg','jpg','png'];
                $tipoMime3 =explode("/",$tipo3)[1]??'';
                //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                if (!in_array($tipoMime3 , $extensionPermitidas3)) {
                    $send = [
                        "status" => "warning",
                        "title" => "Error de extension",
                        "message" => "El tipo de imagen no es admitido en PDI"
                    ];
                    echo json_encode($send);
                    exit();
                } else {
                    $path = $archivo3;
                    $type3 = pathinfo($path, PATHINFO_EXTENSION);
                    $data3= $archivo3;
                    $dato+=[
                        'imagenVehiculo3' => base64_encode(file_get_contents($data3)),
                        'nombreImagen3' => $temp3,
                        'tipoImagen3' => $typo3,
                    ];
                }
            }

            $idobservacion = $ingresoModel->StorageObservaciones($dato);

            // Sitodo es correcto, confirma la transacción
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al guardar la observación. Por favor, intente nuevamente."
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title"=>"Almacenado Correcto",
                    "message" => "Observación guardada exitosamente"
                ]);
            }

        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function SaveObservacion()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $ingresoModel = new IngresoModel();
            date_default_timezone_set("America/Lima");
            $hoy = date("Y-m-d");
            $hora = date("H:i:s");
            $vin = $_POST["vinObs"];

            // Carpeta de destino
            $rutaBase = FCPATH . "resource/ingresoVin/" . $vin . "/DetailObservacion/";
            if (!is_dir($rutaBase)) {
                mkdir($rutaBase, 0777, true);
            }

            $dato = [
                'idtipoDanhoVin' => $_POST["tipoDanho"],
                'idseveridadDanhoVin' => $_POST["nivelDanho"],
                'idareaDanhoVin' => $_POST["areaDanho"],
                'idsubAreaDanhoVin' => $_POST["subAreaDanho"],
                'idreparacionVin' => $_POST["reparacion"],
                'detalleRepuesto' => $_POST["detalleRepuesto"],
                'registroGuia' => $_POST["registroGuia"],
                'solucionObservacion' => $_POST["solucion"],
                'comentarios' => $_POST["comentarioObs"],
                'fechaRegistro' => $hoy,
                'horaRegistro' => $hora,
                'idusuario' => session("idusuario"),
                'idestadoObservacion' => 1,
                'idingresoVin' => $_POST["idingresoVinObs"],
                'vin' => $vin,
                'idtipoCargaImagen' => 2 // Ruta física
            ];

            // Procesar las 3 imágenes
            for ($i = 1; $i <= 3; $i++) {
                $campo = 'imagenObs' . $i;
                if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] == UPLOAD_ERR_OK) {
                    $tmpPath = $_FILES[$campo]['tmp_name'];
                    $nombreOriginal = $_FILES[$campo]['name'];
                    $tipoMime = pathinfo($nombreOriginal, PATHINFO_EXTENSION);
                    $extensionesPermitidas = ['pdf', 'jpeg', 'jpg', 'png'];

                    if (!in_array(strtolower($tipoMime), $extensionesPermitidas)) {
                        echo json_encode([
                            "status" => "warning",
                            "title" => "Error de extensión",
                            "message" => "El tipo de imagen no es admitido en PDI"
                        ]);
                        exit();
                    }

                    $nombreFinal = "imgObs{$i}_" . time() . "." . $tipoMime;
                    $rutaDestino = $rutaBase . $nombreFinal;

                    if (move_uploaded_file($tmpPath, $rutaDestino)) {
                        $dato["rutaImagen{$i}"] = "resource/ingresoVin/{$vin}/DetailObservacion/{$nombreFinal}";
                        $dato["nombreImagen{$i}"] = $nombreOriginal;
                        $dato["tipoImagen{$i}"] = $tipoMime;
                    } else {
                        echo json_encode([
                            "status" => "danger",
                            "title" => "Error de carga",
                            "message" => "No se logró guardar el archivo en el servidor"
                        ]);
                        exit();
                    }
                }
            }

            $idobservacion = $ingresoModel->StorageObservaciones($dato);

            if ($db->transStatus() === FALSE) {
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al guardar la observación. Por favor, intente nuevamente."
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title" => "Almacenado Correcto",
                    "message" => "Observación guardada exitosamente"
                ]);
            }

        } catch (\Exception $e) {
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transacción",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function UploadImagenVehiculo()
    {
        $ingresoModel=New IngresoModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $dato=[];
        $archivo = $_FILES['imagenUploadVehiculo']['tmp_name'];
        if (isset($_FILES['imagenUploadVehiculo']) && $_FILES['imagenUploadVehiculo']['error'] == UPLOAD_ERR_OK) {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['imagenUploadVehiculo']['type'];
            $temp = $_FILES['imagenUploadVehiculo']['name'];
            $tps = explode('/', $_FILES['imagenUploadVehiculo']['type']);
            $typo = $tps[1];
            $extensionPermitidas=['pdf','jpeg','jpg','png'];
            $tipoMime=explode("/",$tipo)[1]??'';
            //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
            if (!in_array($tipoMime, $extensionPermitidas)) {
                $send = [
                    "status" => "warning",
                    "title" => "Error de extension",
                    "message" => "El tipo de imagen no es admitido en PDI"
                ];
                echo json_encode($send);
                exit();
            } else {

                $directorio = 'resource/ingresoVin/'.$_POST["vin"]."/";

                // Verifica si el directorio existe, si no, lo crea
                if (!is_dir($directorio)) {
                    mkdir($directorio, 0755, true);
                }
                $hashNombre = hash('sha256', $temp . time()) . '.' . pathinfo($temp, PATHINFO_EXTENSION);

                // Ruta completa del archivo destino
                $rutaDestino = $directorio . $hashNombre;
                // Mover el archivo subido al directorio de destino
                if (move_uploaded_file($archivo, $rutaDestino)) {
                    $path = $archivo;
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = $archivo;
                    $dato+=[
                        'imagenVehiculo' => $rutaDestino,
                        'nombreImagen' => $temp,
                        'tipoImagen' => $typo,
                        'fechaCarga' => $hoy,
                        'horaCarga' => $hora,
                        'comentarios'=>$_POST["comentarioUpload"],
                        'idtipoCarga'=>2
                    ];

                    $filtroImage=[
                        'iddetalleIngresoVehiculoImagen'=>$_POST["iddetalleIngresoVehiculoImagen"],
                        'vin'=>$_POST["vin"]
                    ];

                    $upload=$ingresoModel->UploadImagenVehiculo($filtroImage,$dato);

                    if($upload){
                        $send = [
                            "status" => "success",
                            "title" => "Se Cargo la Imagen",
                            "message" => "La Imagen se cargo correctamente"
                        ];
                        echo json_encode($send);
                        exit();
                    }
                } else {
                    $send = [
                        "status" => "danger",
                        "title" => "Error de Carga",
                        "message" => "Error al mover el archivo ".$temp
                    ];
                    echo json_encode($send);
                    exit();
                }
            }

        }else{
            $send = [
                "status" => "danger",
                "title" => "Error de Carga",
                "message" => "No se logro cargar el archivo adjunto"
            ];
            echo json_encode($send);
            exit();
        }
    }
}