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

class TituloPlaca extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(4,42,''));


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
        $dato=[
            'idgrupoModulo'=>4,
            'idmodulo'=>42,
        ];
        echo view("Layouts/Head",$dato);
        echo view("ReportesGenerales/TituloPlaca/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("ReportesGenerales/TituloPlaca/Index/Scripts");
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
            'fechaFactura>='=>$_POST["fechaInicio"],
            'fechaFactura<='=>$_POST["fechaFin"]
        ];

        $tituloPlaca=$reporteGeneralModel->TituloPlaca($tipofiltro,$filtro,$rango);

        $spread=new Spreadsheet();

        $spread->getProperties()
            ->setCreator("AUTONIZA")
            ->setTitle("Reporte Inmatriculacion del ".$_POST["fechaInicio"]." al ".$_POST["fechaFin"])
            ->setKeywords('PHPSpreadsheet');
        $sheet=$spread->getActiveSheet();
        $sheet->setTitle('Reporte Inmatriculacion');

        $encabezado=[
            'Chasis',
            'Marca',
            'Modelo',
            'Color',
            'Agencia',
            'Bodega',
            'Documento Cliente',
            'Nombre Cliente',
            'Fecha Factura',
            'Fecha Cancelado',
            'Fecha Titulo',
            'Nro titulo',
            'Usuario titulo',
            'Fecha Placa',
            'Usuario Placa',
            'Tipo Placa',
            'Nro Placa',
            'Estado Vehiculo'
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
        $spread->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        foreach($tituloPlaca as $dit){
            $sheet->setCellValue("A".$numeroDeFila, $dit["vin"],null);
            $sheet->setCellValue("B".$numeroDeFila, $dit["marca"],null);
            $sheet->setCellValue("C".$numeroDeFila, $dit["modelo"],null);
            $sheet->setCellValue("D".$numeroDeFila, $dit["color"],null);
            $sheet->setCellValue("E".$numeroDeFila, $dit["agencia"],null);
            $sheet->setCellValue("F".$numeroDeFila, $dit["bodega"],null);
            $sheet->setCellValue("G".$numeroDeFila, $dit["documentoCliente"],null);
            $sheet->setCellValue("H".$numeroDeFila, $dit["nombreCliente"],null);
            $sheet->setCellValue("I".$numeroDeFila, $dit["fechaFactura"],null);
            $sheet->setCellValue("J".$numeroDeFila, $dit["fechaCancelado"],null);
            $sheet->setCellValue("K".$numeroDeFila, $dit["fechaTitulo"],null);
            $sheet->setCellValue("L".$numeroDeFila, $dit["numeroTitulo"],null);
            $sheet->setCellValue("M".$numeroDeFila, $dit["usuarioTitulo"],null);
            $sheet->setCellValue("N".$numeroDeFila, $dit["fechaPlaca"],null);
            $sheet->setCellValue("O".$numeroDeFila, $dit["usuarioPlaca"],null);
            $sheet->setCellValue("P".$numeroDeFila, $dit["tipoPlaca"],null);
            $sheet->setCellValue("Q".$numeroDeFila, $dit["placa"],null);
            $sheet->setCellValue("R".$numeroDeFila, $dit["estadoVin"],null);
            $numeroDeFila++;
        }

        // Guardar el archivo como Excel 2007
        $writer = new Xlsx($spread);
        $filename = 'reporteInmatriculacion.xlsx';
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
                'info'=>view('ReportesGenerales/TituloPlaca/ModalDownload/Index',$dato).view('ReportesGenerales/TituloPlaca/ModalDownload/Scripts')
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
                'fechaFactura>='=>$_POST["fechaInicio"],
                'fechaFactura<='=>$_POST["fechaFin"]
            ];


        $tituloPlaca=$reporteGeneralModel->TituloPlaca($tipofiltro,$filtro,$rango);

        if($tituloPlaca){
            $dats=[
                'detailIndex'=>$tituloPlaca,
            ];
            $result=[
                'tbody'=>view("ReportesGenerales/TituloPlaca/DetailIndex/Index",$dats).view("ReportesGenerales/TituloPlaca/DetailIndex/Scripts"),
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