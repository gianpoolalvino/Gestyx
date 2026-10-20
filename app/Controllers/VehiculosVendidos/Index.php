<?php

namespace App\Controllers\VehiculosVendidos;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
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
        // Instanciamos el modelo
        $vehiculosModel = new VehiculosVendidosModel();

        //validador de sesion

        $tokenController=New Tokens();
        $access=json_decode($tokenController->AccessRolUser(1,'',''));


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

        // Parámetros de paginación
        $limit = 20; // Número de registros por página
        $pagina = $this->request->getVar('page') ?? 1;  // Obtener el número de página actual desde la URL, si no existe, será 1
        $start = ($pagina - 1) * $limit;  // Calcular el inicio de los registros

        // Obtener los detalles de los vehículos
        $detail = $vehiculosModel->DetailIndex('', '', $limit, $start);

        // Obtener el número total de registros
        $countReg = count($vehiculosModel->DetailIndex('', '', '', ''));

        // Calcular el número total de páginas
        $totalPages = ceil($countReg / $limit);

        // Datos para la vista
        $dato = [
            'idgrupoModulo' => 1,
            'idmodulo' => '',
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
        echo view("VehiculosVendidos/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("VehiculosVendidos/Index/Scripts");
    }
    public function Index_old()
    {
        $vehiculosModel=new VehiculosVendidosModel();
        $idevento=1;
        $limit=10;
        $start=0;

        $pagina=1;

        $detail=$vehiculosModel->DetailIndex_old('','',$limit,$start);
     //   $co=$vehiculosModel->CountRegistro('','');

        $dato=[
            'idgrupoModulo'=>1,
            'idmodulo'=>'',
            'detailIndex'=>$detail,
            'finish'=>$start,
            'count'=>0,
            'countReg'=>0
        ];
        echo view("Layouts/Head",$dato);
        echo view("VehiculosVendidos/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("VehiculosVendidos/Index/Scripts");
    }

    public function DetailIndex()
    {
        $alistamientoVehicular = new VehiculosVendidosModel();
        $limit = 20; // Número de registros por página
        $filtro = $_POST["filtro"];
        $tipoFiltro = $_POST["tipoFiltr"];

        // Obtener la página desde AJAX, si no existe será la página 1
        $pagina = $this->request->getVar('page') ?? 1;
        $start = ($pagina - 1) * $limit;

        // Consultar los registros paginados
        $detail = $alistamientoVehicular->DetailIndex($tipoFiltro, $filtro, $limit, $start);

        // Obtener el número total de registros (sin paginación)
        $countReg = $alistamientoVehicular->CountRegistro($tipoFiltro, $filtro);

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
            'tbody' => view("VehiculosVendidos/DetailIndex/Index", $dats) . view("VehiculosVendidos/DetailIndex/Scripts"),
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
        $alistamientoVehicular = new VehiculosVendidosModel();

        $tipoFiltro = $_POST["tipoFiltr"];
        $filtro = $_POST["filtro"];
        $detail = $alistamientoVehicular->DetailIndex($tipoFiltro, $filtro, '', '');

        $spread = new Spreadsheet();

        $spread->getProperties()
            ->setCreator("AUTONIZA")
            ->setTitle("Reporte Vehiculos Vendidos")
            ->setKeywords('PHPSpreadsheet');
        $sheet = $spread->getActiveSheet();
        $sheet->setTitle('Reporte Vendidos');

        $encabezado = [
            'Chasis',
            'Marca',
            'Modelo',
            'Color',
            'Agencia',
            'Prioridad',
            'Documento Cliente',
            'Cliente',
            'Tipo de Negocio',
            'Evento Actual',
            'Liberado por Cartera',
            'Revision de Campaña',
            'Bodega',
            'Ubicacion Actual',
            'GPS',
            'GAS',
            'Nombre Vendedor',
            'F. Cita Entrega',
            'Tipo de Placa',
            'Placa',
            'F. Factura',
            'Factura',
            'F. Cancelado',
            'Saldo',
            'Nro Pedido',
            'Fecha Compra',
            'Pago a Marca'
        ];

        $sheet->fromArray($encabezado, null, 'A1');
        $numeroDeFila = 2;

        foreach ($detail as $dit) {
            // Definición de variables y valores
            $prioridad = '';
            $liberadoCartera = '';
            $revisionCampanha = '';
            $gps = '';
            $gas = '';
            $canceladoProveedor='';
            $eventoActual='';

            if($dit["ordenUevn"]>$dit["orden"]){
                $eventoActual=$dit["eventoActualUevn"];
            }else{
                $eventoActual=$dit["eventoActual"];
            }

            // Prioridad
            if (!is_null($dit["urgente"])) {
                if ($dit["urgente"] == 1) {
                    $prioridad = 'Urgente';
                } else if ($dit["urgente"] == 2) {
                    $prioridad = 'Moderado';
                } else {
                    $prioridad = 'Baja';
                }
            } else {
                $prioridad = 'Baja';
            }

            // Liberado por Cartera
            if ($dit["liberadoCartera"] == 2) {
                $liberadoCartera = 'No';
            } else {
                $liberadoCartera = 'Si';
            }

            // Revision de Campaña
            if ($dit["revisionCampanha"] == 1) {
                $revisionCampanha = 'Si';
            } else {
                $revisionCampanha = 'No';
            }

            // GPS
            if (!is_null($dit["gps"])) {
                if ($dit["gps"] == 1) {
                    $gps = 'No Instalado';
                } else {
                    $gps = 'Instalado';
                }
            } else {
                $gps = 'No Requiere';
            }

            // GAS
            if (!is_null($dit["gas"])) {
                if ($dit["gas"] == 1) {
                    $gas = 'No Instalado';
                } else {
                    $gas = 'Instalado';
                }
            } else {
                $gas = 'No Requiere';
            }

            if(!is_null($dit["canceladoProveedor"])){
                if($dit["canceladoProveedor"]==1){
                    $canceladoProveedor='Cancelado';
                }else{
                    $canceladoProveedor='Pendiente Pago';
                }
            }



            // Convertir las fechas de formato dd/mm/yyyy a yyyy-mm-dd para ser compatible con PHP
            // Usamos DateTime::createFromFormat para convertir las fechas.

            // Asignación de valores a las celdas
            // Asignación de valores a las celdas
            // Asignación de valores a las celdas
            $sheet->setCellValue("A" . $numeroDeFila, $dit["vin"]);
            $sheet->setCellValue("B" . $numeroDeFila, $dit["marca"]);
            $sheet->setCellValue("C" . $numeroDeFila, $dit["modelo"]);
            $sheet->setCellValue("D" . $numeroDeFila, $dit["color"]);
            $sheet->setCellValue("E" . $numeroDeFila, $dit["agencia"]);
            $sheet->setCellValue("F" . $numeroDeFila, $prioridad);
            $sheet->setCellValue("G" . $numeroDeFila, $dit["documentoCliente"]);
            $sheet->setCellValue("H" . $numeroDeFila, $dit["nombreCliente"]);
            $sheet->setCellValue("I" . $numeroDeFila, $dit["tipoNegocio"]);
            $sheet->setCellValue("J" . $numeroDeFila, $eventoActual);
            $sheet->setCellValue("K" . $numeroDeFila, $liberadoCartera);
            $sheet->setCellValue("L" . $numeroDeFila, $revisionCampanha);
            $sheet->setCellValue("M" . $numeroDeFila, $dit["bodega"]);
            $sheet->setCellValue("N" . $numeroDeFila, $dit["ubicacionActual"]);
            $sheet->setCellValue("O" . $numeroDeFila, $gps);
            $sheet->setCellValue("P" . $numeroDeFila, $gas);
            $sheet->setCellValue("Q" . $numeroDeFila, $dit["nombreVendedor"]);

// Convertir y asignar las fechas correctamente
            if(($dit["fechaAgendadoExcel"]!='No Tiene')){
            $sheet->setCellValueExplicit("R" . $numeroDeFila, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($dit["fechaAgendadoExcel"]), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC)
                ->getStyle("R" . $numeroDeFila)
                ->getNumberFormat()
                ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
            }else{
                $sheet->setCellValue("R" . $numeroDeFila, $dit["fechaAgendadoExcel"]);
            }// Fecha Cita Entrega
            $sheet->setCellValue("S" . $numeroDeFila, $dit["tipoPlaca"]);
            $sheet->setCellValue("T" . $numeroDeFila, $dit["placa"]);

            if($dit["fechaFacturaExcel"]!='No Tiene') {
                $sheet->setCellValueExplicit("U" . $numeroDeFila, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($dit["fechaFacturaExcel"]), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC)
                    ->getStyle("U" . $numeroDeFila)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); // Fecha Factura
            }else{
                $sheet->setCellValue("U" . $numeroDeFila, $dit["fechaFacturaExcel"]);
            }
            $sheet->setCellValue("V" . $numeroDeFila, $dit["numeroFactura"]);
            if($dit["saldoPendiente"]>0){
                $sheet->setCellValue("W" . $numeroDeFila, 'No Tiene');
            }else{
                $sheet->setCellValueExplicit("W" . $numeroDeFila, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($dit["fechaCanceladoExcel"]), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC)
                    ->getStyle("W" . $numeroDeFila)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD);
            }// Fecha Cancelado
            $sheet->setCellValue("X" . $numeroDeFila, $dit["saldoPendiente"]);
            $sheet->setCellValue("Y" . $numeroDeFila, $dit["numeroPedido"]);
            if($dit["fechaCompraProveedorExcel"]!='No Tiene'){
                $sheet->setCellValueExplicit("Z" . $numeroDeFila, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel($dit["fechaCompraProveedorExcel"]), \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_NUMERIC)
                    ->getStyle("Z" . $numeroDeFila)
                    ->getNumberFormat()
                    ->setFormatCode(NumberFormat::FORMAT_DATE_YYYYMMDD); // Fecha Compra
            }else{
                $sheet->setCellValue("Z" . $numeroDeFila, $dit["fechaCompraProveedorExcel"]);
            }


            $sheet->setCellValue("AA" . $numeroDeFila, $canceladoProveedor);

            $numeroDeFila++;
        }

        // Guardar el archivo como Excel 2007
        $writer = new Xlsx($spread);
        $filename = 'reporteVendidos.xlsx';
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



    public function DetailIndex_old()
    {
        $alistamientoVehicular=new VehiculosVendidosModel();
        $idevento=1;
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
      //  $co=$alistamientoVehicular->CountRegistro($tipoFiltro,$filtro);
        $detail=$alistamientoVehicular->DetailIndex($tipoFiltro,$filtro,$limit,$start);

        $dats=[
            'detailIndex'=>$detail,
            'countReg'=>0,
        ];

        $dato=[
            'tbody'=>view("VehiculosVendidos/DetailIndex/Index",$dats).view("VehiculosVendidos/DetailIndex/Scripts"),
            'countReg'=>0,
            'start'=>$finish,
            'total'=>0,
        ];

        echo json_encode($dato);
        exit();

    }
}
