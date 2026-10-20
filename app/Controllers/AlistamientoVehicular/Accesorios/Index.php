<?php

namespace App\Controllers\AlistamientoVehicular\Accesorios;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\VehiculosVendidosModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();
        $event='Accesorios';
        $access=json_decode($tokenController->AccessRolUser(8,1,''));


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
        $alistamientoModel = new AlistamientoVehicularModel();
        $idevento=1;
        // Parámetros de paginación
        $limit = 20; // Número de registros por página
        $pagina = $this->request->getVar('page') ?? 1;  // Obtener el número de página actual desde la URL, si no existe, será 1
        $start = ($pagina - 1) * $limit;  // Calcular el inicio de los registros
        // Obtener los detalles de los vehículos
        $detail = $alistamientoModel->DetailIndex($idevento,'', '', $limit, $start);
        // Obtener el número total de registros
        $countReg = count($alistamientoModel->DetailIndex($idevento,'', '', '', ''));
        // Calcular el número total de páginas
        $totalPages = ceil($countReg / $limit);

        // Datos para la vista
        $dato = [
            'idgrupoModulo'=>8,
            'idmodulo'=>1,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $limit,
            'total'=>$countReg,
            'countReg' => $countReg,
            'totalPages' => $totalPages,  // Pasar el total de páginas
            'pagina' => $pagina,          // Pasar la página actual
        ];

        // Cargar las vistas
        echo view("Layouts/Head",$dato);
        echo view("AlistamientoVehicular/Accesorios/Index/Index",$dato);
        echo view("Layouts/Footer",['event'=>$event]);
        echo view("AlistamientoVehicular/Accesorios/Index/Scripts");
    }
    public function Indexold()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();
        $idevento=1;
        $limit=10;
        $start=0;
        $finish=10;
        $detail=$alistamientoVehicular->DetailIndex($idevento,'','',$limit,$start);
        $co=$alistamientoVehicular->CountRegistro($idevento,'','');
        $countReg=0;
        foreach($detail as $dt){
            $countReg++;
        }
        $dato=[
            'idgrupoModulo'=>8,
            'idmodulo'=>1,
            'detailIndex'=>$detail,
            'finish'=>$start,
            'count'=>$co[0]["contadorTotal"],
            'countReg'=>$countReg
        ];
        echo view("Layouts/Head",$dato);
        echo view("AlistamientoVehicular/Accesorios/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("AlistamientoVehicular/Accesorios/Index/Scripts");
    }

    public function DetailIndexExcel()
    {
        date_default_timezone_set('America/Lima');
        $hoy=date('Y-m-d');
        $alistamientoVehicular = new AlistamientoVehicularModel();
        $filtro = $_POST["filtro"];
        $tipoFiltro = $_POST["tipoFiltr"];
        $idevento=1;
        $detail = $alistamientoVehicular->DetailIndexExcel($idevento,$tipoFiltro, $filtro);

        $spread = new Spreadsheet();

        $spread->getProperties()
            ->setCreator("AUTONIZA")
            ->setTitle("Reporte Vehiculos Vendidos")
            ->setKeywords('PHPSpreadsheet');
        $sheet = $spread->getActiveSheet();
        $sheet->setTitle('Reporte Vendidos');

        $encabezado = [
            'Chasis',
            'Estado Vehiculo',
            'Marca',
            'Modelo',
            'Color',
            'Agencia',
            'Tiempo en Evento',
            'Prioridad',
            'Ubicacion',
            'Entrega',
            'GPS',
            'Conversion a GAS',
            'Kit de Seguros',
            'Laminas',
            'Otros',
            'Nro de Pedido'
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


            if(!is_null($dit["gas"])){
                                        if($dit["gas"]==1){
                                            $gas='Requiere';
                                         }else if($dit["gas"]==2){
                                            $gas='Instalado';
                                        }else if($dit["gas"]==3){
                                            $gas='Validando';
                                         }
                                         }else{
                                            if ($dit["equipamiento"] != '') {
                                                $det = explode("@@", $dit["equipamiento"]);
                                                foreach ($det as $dts) {
                                                    $detal = explode("##", $dts);
                                                    if(isset($detal[3])){
                                                    // Verificar si $detal[3] contiene "GNV" o "GLP"
                                                    if (strpos($detal[3], 'GNV') !== false || strpos($detal[3], 'GLP') !== false) {
                                                        // Determinar el icono según el estado
                                                        $icon = '';
                                                        if ($detal[2] == 2) {
                                                            $gas='Instalado';
                                                        } else if ($detal[2] == 1) {
                                                            $gas='Requiere';
                                                        }
                                                    }
                                                }}
                                            }

                                         }










            $days='';
            if($dit["fechaCancelado"]!=''){
                $fechaFact=date("Y-m-d",strtotime($dit["fechaCancelado"]));
                $fechaEnt=date("Y-m-d",strtotime($fechaFact."+ 20 days"));
                $fecha1=date_create($hoy);
                $fecha2=date_create($fechaEnt);
                $diff=date_diff($fecha1,$fecha2);
                $days=str_replace('+','',$diff->format('%R%a'));
            }else{
                $days=20;
            }
            $tiempoEnEvento='';
            $fechaInicio = new \DateTime($dit["fechaEventoActual"] . " " . $dit["horaEventoActual"]);
            $fechaFin = new \DateTime($hoy);
            $intervalo = $fechaInicio->diff($fechaFin);
            if ($intervalo->d == 0 || $intervalo->d < 2) {
                $tiempoEnEvento=(($intervalo->d>0)?$intervalo->d." Dias ":'').(($intervalo->h>0)?$intervalo->h." horas ":'').$intervalo->i . " minutos ";
            } else if ($intervalo->d > 2 || $intervalo->d < 3) {
                $tiempoEnEvento=(($intervalo->d>0)?$intervalo->d." Dias ":'').(($intervalo->h>0)?$intervalo->h." horas ":'').$intervalo->i . " minutos ";
            } else if ($intervalo->d > 3) {
                $tiempoEnEvento=(($intervalo->d>0)?$intervalo->d." Dias ":'').(($intervalo->h>0)?$intervalo->h." horas ":'').$intervalo->i . " minutos ";
            }

            $kitSeguro='';
            $lamina='';
            $otros='';
            if($dit["equipamiento"]!=''){
                $det=explode("@@",$dit["equipamiento"]);
                foreach($det as $dts){
                    $detal=explode("##",$dts);
                    if(isset($detal[3])){
                        if (strpos($detal[3], 'KIT DE SEGU') !== false) {
                            $kitSeguro=$detal[3];
                        } }} }

            if($dit["equipamiento"]!=''){
                $det=explode("@@",$dit["equipamiento"]);
                foreach($det as $dts){
                    $detal=explode("##",$dts);
                    if(isset($detal[3])){
                        if (strpos($detal[3], 'LAMINA') !== false) {
                            $lamina=$detal[3];
                        } }} }

            if ($dit["equipamiento"] != '') {
                $det = explode("@@", $dit["equipamiento"]);
                $otros = ''; // Inicializamos la variable $otros como una cadena vacía para concatenar.

                foreach ($det as $dts) {
                    $detal = explode("##", $dts);

                    if (isset($detal[3])) {
                        // Verificar si $detal[3] no contiene ninguna de las palabras especificadas
                        $exclude = false;
                        $excludedWords = ['KIT DE SEGU', 'LAMINA', 'GPS', 'GNV', 'GLP'];

                        foreach ($excludedWords as $word) {
                            if (strpos($detal[3], $word) !== false) {
                                $exclude = true;
                                break;
                            }
                        }

                        if (!$exclude) {
                            // Concatenar el ítem al resultado en $otros
                            $otros .= $detal[3] . " "; // Puedes añadir un espacio u otro separador si lo deseas
                        }
                    }
                }
            }

            $sheet->setCellValue("A" . $numeroDeFila, $dit["vin"]);
            $sheet->setCellValue("B" . $numeroDeFila, $dit["estadoVin"]);
            $sheet->setCellValue("C" . $numeroDeFila, $dit["marca"]);
            $sheet->setCellValue("D" . $numeroDeFila, $dit["modelo"]);
            $sheet->setCellValue("E" . $numeroDeFila, $dit["color"]);
            $sheet->setCellValue("F" . $numeroDeFila, $dit["agencia"]);
            $sheet->setCellValue("G" . $numeroDeFila, $tiempoEnEvento);
            $sheet->setCellValue("H" . $numeroDeFila, $prioridad);
            $sheet->setCellValue("I" . $numeroDeFila, $dit["ubicacionActual"]);
            $sheet->setCellValue("J" . $numeroDeFila, $days);
            $sheet->setCellValue("K" . $numeroDeFila, $gps);
            $sheet->setCellValue("L" . $numeroDeFila, $gas);
            $sheet->setCellValue("M" . $numeroDeFila, $kitSeguro);
            $sheet->setCellValue("N" . $numeroDeFila, $lamina);
            $sheet->setCellValue("O" . $numeroDeFila, $otros);
            $sheet->setCellValue("P" . $numeroDeFila, $dit["numeroPedido"]);
            $numeroDeFila++;
        }

        // Guardar el archivo como Excel 2007
        $writer = new Xlsx($spread);
        $filename = 'reporteAccesorios.xlsx';
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
                'info' => view('AlistamientoVehicular/Accesorios/ModalDownload/Index', $dato) . view('AlistamientoVehicular/Accesorios/ModalDownload/Scripts')
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

    public function DetailIndex()
    {
        $alistamientoVehicular = new AlistamientoVehicularModel();
        $limit = 20; // Número de registros por página
        $filtro = $_POST["filtro"];
        $tipoFiltro = $_POST["tipoFiltr"];
        $idevento=1;
        // Obtener la página desde AJAX, si no existe será la página 1
        $pagina = $this->request->getVar('page') ?? 1;
        $start = ($pagina - 1) * $limit;

        // Consultar los registros paginados
        $detail = $alistamientoVehicular->DetailIndex($idevento,$tipoFiltro, $filtro, $limit, $start);

        // Obtener el número total de registros (sin paginación)
        $countReg = $alistamientoVehicular->CountRegistro($idevento,$tipoFiltro, $filtro);

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
            'tbody'=>view("AlistamientoVehicular/Accesorios/DetailIndex/Index",$dats).view("AlistamientoVehicular/Accesorios/DetailIndex/Scripts"),
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

    public function DetailIndexold()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();
        $idevento=1;
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$alistamientoVehicular->CountRegistro($idevento,$tipoFiltro,$filtro);
        $detail=$alistamientoVehicular->DetailIndex($idevento,$tipoFiltro,$filtro,$limit,$start);
        $cnt=0;
        foreach($detail as $dt){
            $cnt++;
        }

        $countReg=$cnt+$countRegv2;

        $dats=[
            'detailIndex'=>$detail,
            'countReg'=>$countRegv2,
        ];

        $dato=[
            'tbody'=>view("AlistamientoVehicular/Accesorios/DetailIndex/Index",$dats).view("AlistamientoVehicular/Accesorios/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();

    }
}
