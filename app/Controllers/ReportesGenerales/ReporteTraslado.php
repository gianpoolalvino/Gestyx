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

class ReporteTraslado extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(4,62,''));


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
            'idmodulo' => 62,
        ];
        echo view("Layouts/Head", $dato);
        echo view("ReportesGenerales/ReporteTraslado/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("ReportesGenerales/ReporteTraslado/Index/Scripts");
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


        $filtro=[
            'fechaTraslado>='=>$_POST["fechaInicio"],
            'fechaTraslado<='=>$_POST["fechaFin"],
        ];

        if($_POST["tipoFiltro"]!==''){
            $filtro+=[
                $_POST["tipoFiltro"]=>$_POST["filtro"]
            ];
        }
        $tituloPlaca=$reporteGeneralModel->DetailIndexTraslado($filtro);

        $spread=new Spreadsheet();

        $spread->getProperties()
            ->setCreator("AUTONIZA")
            ->setTitle("Reporte Traslados del ".$_POST["fechaInicio"]." al ".$_POST["fechaFin"])
            ->setKeywords('PHPSpreadsheet');
        $sheet=$spread->getActiveSheet();
        $sheet->setTitle('Reporte Traslados');

        $encabezado=[
            'Chasis',
            'Marca',
            'Modelo',
            'Color',
            'Fecha Traslado',
            'Tipo',
            'Origen',
            'Destino',
            'Fecha Recepcion'
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

        foreach($tituloPlaca as $dit){
            $sheet->setCellValue("A".$numeroDeFila, $dit["vin"],null);
            $sheet->setCellValue("B".$numeroDeFila, $dit["marca"],null);
            $sheet->setCellValue("C".$numeroDeFila, $dit["modelo"],null);
            $sheet->setCellValue("D".$numeroDeFila, $dit["color"],null);
            $sheet->setCellValue("E".$numeroDeFila, $dit["fechaTraslado"],null);
            $sheet->setCellValue("F".$numeroDeFila, $dit["tipoTraslado"],null);
            $sheet->setCellValue("G".$numeroDeFila, $dit["origen"],null);
            $sheet->setCellValue("H".$numeroDeFila, $dit["destino"],null);
            $sheet->setCellValue("I".$numeroDeFila, $dit["fechaRecepcion"],null);
            $numeroDeFila++;
        }

        // Guardar el archivo como Excel 2007
        $writer = new Xlsx($spread);
        $filename = 'reporteTraslado.xlsx';
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
                'info'=>view('ReportesGenerales/ReporteTraslado/ModalDownload/Index',$dato).view('ReportesGenerales/ReporteTraslado/ModalDownload/Scripts')
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
        $reporteModel=New ReportesGeneralModel();

        $fechaInicio=isset($_POST["fechaInicio"])?$_POST["fechaInicio"]:$_GET["fechaInicio"];
        $fechaFin=isset($_POST["fechaFin"])?$_POST["fechaFin"]:$_GET["fechaFin"];

        $filtro=[
            'fechaTraslado>='=>$fechaInicio,
            'fechaTraslado<='=>$fechaFin,
        ];

        if($_POST["tipoFiltro"]!==''){
            $filtro+=[
                $_POST["tipoFiltro"]=>$_POST["filtro"]
            ];
        }

        $dato=[
            'detailIndex'=>$reporteModel->DetailIndexTraslado($filtro)
        ];

        $send=[
            'status'=>'success',
            'title'=>'Operacion Correcta',
            'message'=>'Busqueda Satisfactoria',
            'info'=>view('ReportesGenerales/ReporteTraslado/DetailIndex/Index',$dato).view('ReportesGenerales/ReporteTraslado/DetailIndex/Scripts')
        ];
        echo json_encode($send);
        exit();

    }
}