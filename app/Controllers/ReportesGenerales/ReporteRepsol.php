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

class ReporteRepsol extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(4,61,''));


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
            'idmodulo' => 61,
        ];
        echo view("Layouts/Head", $dato);
        echo view("ReportesGenerales/ReporteRepsol/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("ReportesGenerales/ReporteRepsol/Index/Scripts");
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

        $tituloPlaca=$reporteGeneralModel->ReporteRepsol($tipofiltro,$filtro,$rango);

        $spread=new Spreadsheet();

        $spread->getProperties()
            ->setCreator("AUTONIZA")
            ->setTitle("Reporte Repsol del ".$_POST["fechaInicio"]." al ".$_POST["fechaFin"])
            ->setKeywords('PHPSpreadsheet');
        $sheet=$spread->getActiveSheet();
        $sheet->setTitle('Reporte Repsol');

        $encabezado=[
            'Chasis',
            'Marca',
            'Modelo',
            'Color',
            'Nombre Cliente',
            'Documento Cliente',
            'Telefono Cliente',
            'Correo Cliente',
            'Placa',
            'Fecha Venta',
            'Conversion a Gas',
            'Proveedor Gas',
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

        foreach($tituloPlaca as $dit){
            $sheet->setCellValue("A".$numeroDeFila, $dit["vin"],null);
            $sheet->setCellValue("B".$numeroDeFila, $dit["marca"],null);
            $sheet->setCellValue("C".$numeroDeFila, $dit["modelo"],null);
            $sheet->setCellValue("D".$numeroDeFila, $dit["color"],null);
            $sheet->setCellValue("E".$numeroDeFila, $dit["nombreCliente"],null);
            $sheet->setCellValue("F".$numeroDeFila, $dit["documentoCliente"],null);
            $sheet->setCellValue("G".$numeroDeFila, $dit["telefonoCliente"],null);
            $sheet->setCellValue("H".$numeroDeFila, $dit["correoCliente"],null);
            $sheet->setCellValue("I".$numeroDeFila, $dit["placa"],null);
            $sheet->setCellValue("J".$numeroDeFila, $dit["fechaVenta"],null);
            $sheet->setCellValue("K".$numeroDeFila, (!is_null($dit["gas"]))?'Convertido a gas':'',null);
            $sheet->setCellValue("L".$numeroDeFila, $dit["proveedorGas"],null);
            $numeroDeFila++;
        }

        // Guardar el archivo como Excel 2007
        $writer = new Xlsx($spread);
        $filename = 'reporteRepsol.xlsx';
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
                'info'=>view('ReportesGenerales/ReporteRepsol/ModalDownload/Index',$dato).view('ReportesGenerales/ReporteAccesorios/ModalDownload/Scripts')
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


        $pdiMecanico=$reporteGeneralModel->ReporteRepsol($tipofiltro,$filtro,$rango);

        if($pdiMecanico){
            $dats=[
                'detailIndex'=>$pdiMecanico,
            ];
            $result=[
                'tbody'=>view("ReportesGenerales/ReporteRepsol/DetailIndex/Index",$dats).view("ReportesGenerales/ReporteRepsol/DetailIndex/Scripts"),
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