<?php

namespace App\Controllers\ReportesGenerales;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AccessModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlCalidadModel;
use App\Models\EventoModel;
use App\Models\GeneralesModel;
use App\Models\OpcionesGeneralesModel;
use App\Models\ReportesGeneralModel;
use App\Models\VinModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportePdi extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(4,57,''));


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
        $dato = [
            'idgrupoModulo' => 4,
            'idmodulo' => 57,
        ];
        echo view("Layouts/Head", $dato);
        echo view("ReportesGenerales/ReportePdi/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("ReportesGenerales/ReportePdi/Index/Scripts");
    }

    public function DetailIndexExcel()
    {
        $reporteGeneralModel=New ReportesGeneralModel();
        $tipofiltro=$_POST["tipoFiltro"];
        if($_POST["fechaInicio"]==""){
            $result=[
                'status'=>'warning',
                'title'=>'Sin Resultados',
                'message'=>'No ingreso una fecha inicial'
            ];
            echo json_encode($result);
            exit();
        }else if($_POST["fechaFin"]==""){
            $result=[
                'status'=>'warning',
                'title'=>'Sin Resultados',
                'message'=>'No ingreso una fecha final'
            ];
            echo json_encode($result);
            exit();
        }

        if($_POST["fechaInicio"]>$_POST["fechaFin"]){
            $result=[
                'status'=>'warning',
                'title'=>'Sin Resultados',
                'message'=>'La fecha de inicio no puede ser mayor a la fecha final'
            ];
            echo json_encode($result);
            exit();
        }

        $filtro=$_POST["filtro"];

        $rango=[
            'fechaFin>='=>$_POST["fechaInicio"],
            'fechaFin<='=>$_POST["fechaFin"]
        ];

        $tituloPlaca=$reporteGeneralModel->ReportePdi($tipofiltro,$filtro,$rango);

        $spread=new Spreadsheet();

        $spread->getProperties()
            ->setCreator("AUTONIZA")
            ->setTitle("Reporte PDI del ".$_POST["fechaInicio"]." al ".$_POST["fechaFin"])
            ->setKeywords('PHPSpreadsheet');
        $sheet=$spread->getActiveSheet();
        $sheet->setTitle('Reporte PDI');

        $encabezado=[
            'Chasis',
            'Marca',
            'Modelo',
            'Color',
            'Evento',
            'Nombre Cliente',
            'Asesor Venta',
            'Agencia',
            'Fecha Inicio',
            'Fecha Final',
            'Fecha Factura',
            'Fecha Cancelado',
            'Operador',
        ];

        $sheet->fromArray($encabezado,null,'A1');
        $numeroDeFila=2;

        $spread->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);

        foreach($tituloPlaca as $dit){
            $sheet->setCellValue("A".$numeroDeFila, $dit["vin"],null);
            $sheet->setCellValue("B".$numeroDeFila, $dit["marca"],null);
            $sheet->setCellValue("C".$numeroDeFila, $dit["modelo"],null);
            $sheet->setCellValue("D".$numeroDeFila, $dit["color"],null);
            $sheet->setCellValue("E".$numeroDeFila, $dit["eventoActual"],null);
            $sheet->setCellValue("F".$numeroDeFila, $dit["nombreCliente"],null);
            $sheet->setCellValue("G".$numeroDeFila, $dit["vendedor"],null);
            $sheet->setCellValue("H".$numeroDeFila, $dit["agencia"],null);
            $sheet->setCellValue("I".$numeroDeFila, $dit["fechaEvento"],null);
            $sheet->setCellValue("J".$numeroDeFila, $dit["fechaFin"],null);
            $sheet->setCellValue("K".$numeroDeFila, $dit["fechaFactura"],null);
            $sheet->setCellValue("L".$numeroDeFila, $dit["fechaCancelado"],null);
            $sheet->setCellValue("M".$numeroDeFila, $dit["operador"],null);
            $numeroDeFila++;
        }

        // Guardar el archivo como Excel 2007
        $writer = new Xlsx($spread);
        $filename = 'reportePdi.xlsx';
        $writer->save($filename);
// Establecer encabezados para la descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="'. urlencode($filename) .'"');
        header('Cache-Control: max-age=0');

        $savePath = 'resource/exportados/'. $filename;
// Enviar el archivo al navegador
        $writer->save($savePath);

        if(file_exists($savePath)){
            $dato=[
                'rutaArchivo'=>$savePath
            ];

            $send=[
                'status'=>'success',
                'info'=>view('ReportesGenerales/ReportePdi/ModalDownload/Index',$dato).view('ReportesGenerales/ReportePdi/ModalDownload/Scripts')
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'warning',
                'title'=>'Error de creacion',
                'message'=>'El Archivo no se logro crear correctamente reintente'
            ];
            echo json_encode($send);
            exit();
        }

    }

    public function DetailIndex()
    {
        $reporteGeneralModel=New ReportesGeneralModel();

        $tipofiltro=$_POST["tipoFiltro"];

        if($_POST["fechaInicio"]==""){
            $result=[
                'status'=>'warning',
                'title'=>'Sin Resultados',
                'message'=>'No ingreso una fecha inicial'
            ];
            echo json_encode($result);
            exit();
        }else if($_POST["fechaFin"]==""){
            $result=[
                'status'=>'warning',
                'title'=>'Sin Resultados',
                'message'=>'No ingreso una fecha final'
            ];
            echo json_encode($result);
            exit();
        }

        if($_POST["fechaInicio"]>$_POST["fechaFin"]){
            $result=[
                'status'=>'warning',
                'title'=>'Sin Resultados',
                'message'=>'La fecha de inicio no puede ser mayor a la fecha final'
            ];
            echo json_encode($result);
            exit();
        }

        $filtro=$_POST["filtro"];

        $rango=[
            'fechaFin>='=>$_POST["fechaInicio"],
            'fechaFin<='=>$_POST["fechaFin"]
        ];


        $pdiMecanico=$reporteGeneralModel->ReportePdi($tipofiltro,$filtro,$rango);

        if($pdiMecanico){
            $dats=[
                'detailIndex'=>$pdiMecanico,
            ];
            $result=[
                'tbody'=>view("ReportesGenerales/ReportePdi/DetailIndex/Index",$dats).view("ReportesGenerales/ReportePdi/DetailIndex/Scripts"),
                'status'=>'success',
                'title'=>'Busqueda Correcta',
                'message'=>'Busqueda realizada con exito',
            ];
            echo json_encode($result);
            exit();
        }else{
            $result=[
                'status'=>'warning',
                'title'=>'Sin Resultados',
                'message'=>'No se encontraron datos en la aplicacion con los filtros realizados'
            ];
            echo json_encode($result);
            exit();
        }

    }
}