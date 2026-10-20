<?php

namespace App\Controllers\TestBateria\RegistroTestBateria;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\BateriaModel;
use App\Models\VehiculosVendidosModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use function PHPUnit\Framework\isNull;

class Index extends BaseController
{

    public function Index()
    {
        $tokenController=New Tokens();
        $access=json_decode($tokenController->AccessRolUser(27,80,''));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        // Instanciamos el modelo
        $bateriaModel=New BateriaModel();

        date_default_timezone_set("America/Lima");
        $actual=date("Y-m-d");
        $hoy = new \DateTime(); // Obtiene la fecha y hora actuales
        $hoy->modify('-15 days'); // Resta 15 días
        $fechaInicio = $hoy->format('Y-m-d');

        // Parámetros de paginación
        $limit = 20; // Número de registros por página
        $pagina = $this->request->getVar('page') ?? 1;  // Obtener el número de página actual desde la URL, si no existe, será 1
        $start = ($pagina - 1) * $limit;  // Calcular el inicio de los registros
        // Obtener los detalles de los vehículos
        $detail = $bateriaModel->DetailRegistroTest('', '',$fechaInicio,$actual, $limit, $start);
        // Obtener el número total de registros
        $countReg = count($bateriaModel->DetailRegistroTest('', '',$fechaInicio,$actual,null, null));


        // Calcular el número total de páginas
        $totalPages = ceil($countReg / $limit);

        // Datos para la vista
        $dato = [
            'idgrupoModulo' => 27,
            'idmodulo' => 80,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $limit,
            'total'=>$countReg,
            'countReg' => $countReg,
            'totalPages' => $totalPages,  // Pasar el total de páginas
            'pagina' => $pagina,          // Pasar la página actual
        ];

        // Cargar las vistas
        echo view("Layouts/Head", $dato);
        echo view("TestBateria/RegistroTestBateria/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("TestBateria/RegistroTestBateria/Index/Scripts");
    }

    public function DetailIndex()
    {
        $bateriaModel=New BateriaModel();
        $limit = 20; // Número de registros por página
        $filtro = $_POST["filtro"];
        $tipoFiltro = $_POST["tipoFiltr"];
        $fechaInicio=$_POST["fechaInicio"];
        $fechaFin=$_POST["fechaFin"];
        // Obtener la página desde AJAX, si no existe será la página 1
        $pagina = $this->request->getVar('page') ?? 1;
        $start = ($pagina - 1) * $limit;
        // Consultar los registros paginados
        $detail = $bateriaModel->DetailRegistroTest($tipoFiltro, $filtro,$fechaInicio,$fechaFin, $limit, $start);
        // Obtener el número total de registros (sin paginación)
        $countReg = count($bateriaModel->DetailRegistroTest($tipoFiltro, $filtro,$fechaInicio,$fechaFin, null, null));
        // Calcular el número total de páginas
        $totalPages = ceil($countReg / $limit);
        // Generar la paginación HTML
        $paginationHtml = '';
        if ($totalPages > 1) {
            $paginationHtml .= '<nav aria-label="Page navigation example"><ul class="pagination">';

            // Página anterior
            if ($pagina > 1) {
                $paginationHtml .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="changePage(' . ($pagina - 1) . ')"><span class="fas fa-chevron-left"></span></a></li>';
            }

            // Mostrar páginas de 5 en 5
            $range = 10;
            $startPage = max(1, $pagina - floor($range / 2));
            $endPage = min($totalPages, $startPage + $range - 1);

            if ($endPage - $startPage + 1 < $range) {
                $startPage = max(1, $endPage - $range + 1);
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                $activeClass = ($pagina == $i) ? 'active' : '';
                $paginationHtml .= '<li class="page-item ' . $activeClass . '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' . $i . ')">' . $i . '</a></li>';
            }

            // Página siguiente
            if ($pagina < $totalPages) {
                $paginationHtml .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="changePage(' . ($pagina + 1) . ')"><span class="fas fa-chevron-right"></span></a></li>';
            }

            $paginationHtml .= '</ul></nav>';
        }

        // Preparar los datos para la respuesta
        $dats = [
            'detailIndex' => $detail,
            'countReg' => $start,
        ];

        $dato = [
            'tbody' => view("TestBateria/RegistroTestBateria/DetailIndex/Index", $dats) . view("TestBateria/RegistroTestBateria/DetailIndex/Scripts"),
            'countReg' => $countReg,
            'total' => $countReg,
            'totalRegistroPagina'=>$start,
            'currentPage' => $pagina,
            'totalPages' => $totalPages,
            'paginationHtml' => $paginationHtml, // Agregar el HTML de paginación a la respuesta
        ];

        echo json_encode($dato);
        exit();
    }

    public function DetailIndexExcel()
    {
        $bateriaModel=New BateriaModel();

        $tipoFiltro = $_POST["tipoFiltr"];
        $filtro = $_POST["filtro"];
        $fechaInicio=$_POST["fechaInicio"];
        $fechaFin=$_POST["fechaFin"];
        $detail = $bateriaModel->DetailRegistroTest($tipoFiltro, $filtro,$fechaInicio,$fechaFin, null, null);

        $spread = new Spreadsheet();

        $spread->getProperties()
            ->setCreator("AUTONIZA")
            ->setTitle("Reporte Test Bateria")
            ->setKeywords('PHPSpreadsheet');
        $sheet = $spread->getActiveSheet();
        $sheet->setTitle('Reporte Test Bateria');

        $encabezado = [
            'Chasis',
            'Marca',
            'Modelo',
            'Color',
            'Estado Vin',
            'Ubicacion',
            'Estado Test',
            'Evento Actual',
            'Fecha Test',
            'Fecha Proximo Test',
            'Fecha Registro',
            'Ususario'
        ];

        $sheet->fromArray($encabezado, null, 'A1');
        $numeroDeFila = 2;

        foreach ($detail as $dit) {

            $sheet->setCellValue("A" . $numeroDeFila, $dit["vin"]);
            $sheet->setCellValue("B" . $numeroDeFila, $dit["marca"]);
            $sheet->setCellValue("C" . $numeroDeFila, $dit["modelo"]);
            $sheet->setCellValue("D" . $numeroDeFila, $dit["color"]);
            $sheet->setCellValue("E" . $numeroDeFila, $dit["estadoVin"]);
            $sheet->setCellValue("F" . $numeroDeFila, $dit["ubicacion"]);
            $sheet->setCellValue("G" . $numeroDeFila, 'Realizado');
            $sheet->setCellValue("H" . $numeroDeFila, $dit["eventoActual"]);

// Convertir y asignar las fechas correctamente
            if(($dit["fechaTest"]!='No Tiene')){
                $sheet->setCellValueExplicit("I" . $numeroDeFila, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($dit["fechaTest"]), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC)
                    ->getStyle("I" . $numeroDeFila)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
            }else{
                $sheet->setCellValue("I" . $numeroDeFila, $dit["fechaTest"]);
            }// Fecha Cita Entrega

            if($dit["fechaProximoTest"]!='No Tiene') {
                $sheet->setCellValueExplicit("J" . $numeroDeFila, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($dit["fechaProximoTest"]), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC)
                    ->getStyle("J" . $numeroDeFila)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); // Fecha Factura
            }else{
                $sheet->setCellValue("J" . $numeroDeFila, $dit["fechaProximoTest"]);
            }
            if($dit["fechaRegistro"]!='No Tiene'){
                $sheet->setCellValueExplicit("K" . $numeroDeFila, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($dit["fechaRegistro"]), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC)
                    ->getStyle("K" . $numeroDeFila)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); // Fecha Compra
            }else{
                $sheet->setCellValue("K" . $numeroDeFila, $dit["fechaRegistro"]);
            }
            $sheet->setCellValue("L" . $numeroDeFila, $dit["usuario"]);
            $numeroDeFila++;
        }

        // Guardar el archivo como Excel 2007
        $writer = new Xlsx($spread);
        $filename = 'reporteTestBateria.xlsx';
        $writer->save($filename);

        // Establecer encabezados para la descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . urlencode($filename) . '"');
        header('Cache-Control: max-age=0');

        $savePath = 'resource/exportados/' . $filename;
        // Enviar el archivo al navegador
        $writer->save($savePath);

        if (file_exists($savePath)) {
            $dato = [
                'rutaArchivo' => $savePath
            ];

            $send = [
                'status' => 'success',
                'info' => view('TestBateria/ModalDownload/Index', $dato) . view('TestBateria/ModalDownload/Scripts')
            ];
            echo json_encode($send);
            exit();
        } else {
            $send = [
                'status' => 'warning',
                'title' => 'Error de creacion',
                'message' => 'El Archivo no se logro crear correctamente reintente'
            ];
            echo json_encode($send);
            exit();
        }
    }
}