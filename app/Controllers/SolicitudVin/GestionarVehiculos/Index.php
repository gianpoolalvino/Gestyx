<?php

namespace App\Controllers\SolicitudVin\GestionarVehiculos;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\SolicitudVinModel;
use App\Models\UsuarioModel;
use App\Models\VehiculosVendidosModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();
        $access=json_decode($tokenController->AccessRolUser(26,78,''));


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

        $solicitudVehiculo=New SolicitudVinModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $limit = 20; // Número de registros por página
        $pagina = $this->request->getVar('page') ?? 1;  // Obtener el número de página actual desde la URL, si no existe, será 1
        $start = ($pagina - 1) * $limit;

        $detalleGestion=$solicitudVehiculo->DetailIndexGestion('','','',$hoy,$limit,$start);

            // Obtener el número total de registros
        $countReg = count($solicitudVehiculo->DetailIndexGestion('', '', '',$hoy, '',''));

        // Calcular el número total de páginas
        $totalPages = ceil($countReg / $limit);

        $dato = [
            'idgrupoModulo' => 26,
            'idmodulo' => 78,
            'detailIndex' => $detalleGestion,
            'finish' => $start,
            'count' => $limit,
            'total'=>$countReg,
            'countReg' => $countReg,
            'totalPages' => $totalPages,  // Pasar el total de páginas
            'pagina' => $pagina,
        ];
        echo view("Layouts/Head", $dato);
        echo view("SolicitudVin/GestionarVehiculo/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("SolicitudVin/GestionarVehiculo/Index/Scripts");
    }

    public function DetailIndex()
    {
        $solicitudVehiculo=New SolicitudVinModel();
        $limit = 20; // Número de registros por página
        $estadoVehiculo=$_POST["estadoVehiculo"];
        $filtro = $_POST["filtro"];
        $tipoFiltro = $_POST["tipoFiltr"];
        $fecha=$_POST["fecha"];

        $filterDelete=[
            'idusuario'=>session("idusuario"),
            'idmodulo'=>78,
            'idgrupoModulo'=>26
        ];

        $solicitudVehiculo->DestroyFiltroModulo($filterDelete);

        $filtrosNew=[
            [
                'campo'=>'estadoVehiculo',
                'valor'=>$estadoVehiculo,
                'idusuario'=>session("idusuario"),
                'nombreCampo'=>'Estado Vehiculo',
                'estadoCampo'=>1,
                'idgrupoModulo'=>26,
                'idmodulo'=>78
            ],
            [
                'campo'=>$tipoFiltro,
                'valor'=>$filtro,
                'idusuario'=>session("idusuario"),
                'nombreCampo'=>'Tipo de Filtro',
                'estadoCampo'=>1,
                'idgrupoModulo'=>26,
                'idmodulo'=>78
            ],
            [
                'campo'=>'fecha',
                'valor'=>$fecha,
                'idusuario'=>session("idusuario"),
                'nombreCampo'=>'Fecha',
                'estadoCampo'=>1,
                'idgrupoModulo'=>26,
                'idmodulo'=>78
            ],
        ];

        $rest=$solicitudVehiculo->StorageFiltro($filtrosNew);

        // Obtener la página desde AJAX, si no existe será la página 1
        $pagina = $this->request->getVar('page') ?? 1;
        $start = ($pagina - 1) * $limit;
        // Consultar los registros paginados
        $detail = $solicitudVehiculo->DetailIndexGestion($estadoVehiculo,$tipoFiltro, $filtro,$fecha, $limit, $start);
        // Obtener el número total de registros (sin paginación)
        $countReg = count($solicitudVehiculo->DetailIndexGestion('', '', '', $fecha,'',''));
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
            'tbody' => view("SolicitudVin/GestionarVehiculo/DetailIndex/Index", $dats) . view("SolicitudVin/GestionarVehiculo/DetailIndex/Scripts"),
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

    public function CreateTrasladoMasivo()
    {
        $solicitudVehiculo=New SolicitudVinModel();
        date_default_timezone_set("America/Lima");

        $hoy=date("Y-m-d");
        $dato=[
            'selectVin'=>$solicitudVehiculo->DetailIndexGestion('','', '',$hoy, '', '')
        ];

        $send=[
            'info'=>view("SolicitudVin/CreateTrasladoMasivo/Index",$dato).view("SolicitudVin/CreateTrasladoMasivo/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function DetailIndexExcel()
    {
        $solicitudVehiculo=New SolicitudVinModel();

        $spread = new Spreadsheet();

        $estadoVehiculo=$_POST["estadoVehiculo"];
        $filtro = $_POST["filtro"];
        $tipoFiltro = $_POST["tipoFiltr"];
        $fecha=$_POST["fecha"];

        $detail = $solicitudVehiculo->DetailIndexGestion($estadoVehiculo,$tipoFiltro, $filtro,$fecha, '', '');

        $spread->getProperties()
            ->setCreator("AUTONIZA")
            ->setTitle("Reporte Gestion Vehiculos")
            ->setKeywords('PHPSpreadsheet');
        $sheet = $spread->getActiveSheet();
        $sheet->setTitle('Reporte Panel de Gestion');

        $encabezado = [
            'Tipo de Solicitud',
            'Fecha Solicitud',
            'Hora Solicitud',
            'Fecha Atencion',
            'Fecha Max. Entrega',
            'Chasis',
            'Estado Vehiculo',
            'Evento Actual',
            'Novedades',
            'Marca',
            'Modelo',
            'Color',
            'Ubicacion Actual',
            'Box Actual',
            'Destino',
            'Solicitante',
            'Centro de Costo',
            'Estado Solicitud',
            'Comentarios'
        ];
        $sheet->fromArray($encabezado, null, 'A1');
        $numeroDeFila = 2;

        foreach ($detail as $dit) {
            $sheet->setCellValue("A" . $numeroDeFila, $dit["tipoSolicitud"]);
            if(($dit["fechaSolicitud"]!='No Tiene')){
                $sheet->setCellValueExplicit("B" . $numeroDeFila, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($dit["fechaSolicitud"]), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC)
                    ->getStyle("B" . $numeroDeFila)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
            }else{
                $sheet->setCellValue("B" . $numeroDeFila, $dit["fechaSolicitud"]);
            }// Fecha Cita Entrega
            $sheet->setCellValue("C" . $numeroDeFila, $dit["horaSolicitud"]);
            if(($dit["fechaAtencion"]!='No Tiene')){
                $sheet->setCellValueExplicit("D" . $numeroDeFila, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($dit["fechaAtencion"]), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC)
                    ->getStyle("D" . $numeroDeFila)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
            }else{
                $sheet->setCellValue("D" . $numeroDeFila, $dit["fechaAtencion"]);
            }// Fecha Cita Entrega
            if(($dit["fechaMaximaEntrega"]!='No Tiene')){
                $sheet->setCellValueExplicit("E" . $numeroDeFila, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($dit["fechaMaximaEntrega"]), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC)
                    ->getStyle("E" . $numeroDeFila)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
            }else{
                $sheet->setCellValue("E" . $numeroDeFila, $dit["fechaMaximaEntrega"]);
            }// Fecha Cita Entrega
            $sheet->setCellValue("F" . $numeroDeFila, $dit["vin"]);
            $sheet->setCellValue("G" . $numeroDeFila, $dit["estadoVehiculo"]);
            $sheet->setCellValue("H" . $numeroDeFila, $dit["eventoActual"]);
            $sheet->setCellValue("I" . $numeroDeFila, $dit["novedades"]);
            $sheet->setCellValue("J" . $numeroDeFila, $dit["marca"]);
            $sheet->setCellValue("K" . $numeroDeFila, $dit["modelo"]);
            $sheet->setCellValue("L" . $numeroDeFila, $dit["color"]);
            $sheet->setCellValue("M" . $numeroDeFila, $dit["ubicacionActual"]);
            $sheet->setCellValue("N" . $numeroDeFila, $dit["boxActual"]);
            $sheet->setCellValue("O" . $numeroDeFila, $dit["destino"]);
            $sheet->setCellValue("P" . $numeroDeFila, $dit["solicitante"]);
            $sheet->setCellValue("Q" . $numeroDeFila, $dit["centroCosto"]);
            $sheet->setCellValue("R" . $numeroDeFila, $dit["estadoSolicitud"]);
            $sheet->setCellValue("S" . $numeroDeFila, $dit["comentarioSolicitud"]);
            $numeroDeFila++;
        }

        // Guardar el archivo como Excel 2007
        $writer = new Xlsx($spread);
        $filename = 'vinGestion.xlsx';
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
                'info' => view('VehiculosVendidos/ModalDownload/Index', $dato) . view('VehiculosVendidos/ModalDownload/Scripts')
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