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

class ReporteInventario extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(4,75,''));


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
        $reporteGeneral=New ReportesGeneralModel();
        $dato = [
            'idgrupoModulo' => 4,
            'idmodulo' => 75,
            'ubicacion'=>$reporteGeneral->Ubicacion()
        ];
        echo view("Layouts/Head", $dato);
        echo view("ReportesGenerales/ReporteInventario/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("ReportesGenerales/ReporteInventario/Index/Scripts");
    }

    public function DetailIndex()
    {
        $reporteGeneral=New ReportesGeneralModel();

        $ubicacion=$_POST["ubicacion"];
        $filtro=$_POST["filtro"];

        $dato=[
            'reporteInventario'=>$reporteGeneral->DetailInventario($ubicacion,$filtro)
        ];

        $send=[
            'info'=>view("ReportesGenerales/ReporteInventario/DetailIndex/Index",$dato).view("ReportesGenerales/ReporteInventario/DetailIndex/Scripts"),
            'status'=>'success',
            'title'=>'Consulta Exitosa',
            'message'=>'La consulta se realizo correctamente'
        ];

        echo json_encode($send);

    }

    public function DetailIndexExcel()
    {
        $reporteGeneralModel=New ReportesGeneralModel();
        $ubicacion=$_POST["ubicacion"];
        $fecha=date("m/d/Y");
        $filtro=$_POST["filtro"];
        date_default_timezone_set("America/Lima");

        $tituloPlaca=$reporteGeneralModel->DetailInventario($ubicacion,$filtro);

        $spread=new Spreadsheet();

        $spread->getProperties()
            ->setCreator("AUTONIZA")
            ->setTitle("Reporte Invenario Vehiculos al ".$fecha)
            ->setKeywords('PHPSpreadsheet');
        $sheet=$spread->getActiveSheet();
        $sheet->setTitle('Reporte Inventario');

        $encabezado=[
            'Chasis',
            'Marca',
            'Modelo',
            'Color',
            'Año Modelo',
            'Ubicacion',
            'Box',
            'Fecha Ingreso',
            'Fecha Compra',
            'Dias Inventario'
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

        foreach($tituloPlaca as $dit){
            $sheet->setCellValue("A".$numeroDeFila, $dit["vin"],null);
            $sheet->setCellValue("B".$numeroDeFila, $dit["marca"],null);
            $sheet->setCellValue("C".$numeroDeFila, $dit["modelo"],null);
            $sheet->setCellValue("D".$numeroDeFila, $dit["color"],null);
            $sheet->setCellValue("E".$numeroDeFila, $dit["anhoModelo"],null);
            $sheet->setCellValue("F".$numeroDeFila, $dit["ubicacion"],null);
            $sheet->setCellValue("G".$numeroDeFila, $dit["boxubicacion"],null);
            $sheet->setCellValue("H".$numeroDeFila, $dit["fechaIngreso"],null);
            $sheet->setCellValue("I".$numeroDeFila, $dit["fechaCompra"],null);
            $sheet->setCellValue("J".$numeroDeFila, $dit["diasInventario"],null);
            $numeroDeFila++;
        }

        // Guardar el archivo como Excel 2007
        $writer = new Xlsx($spread);
        $filename = 'reporteInventario.xlsx';
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
                'info'=>view('ReportesGenerales/ReporteInventario/ModalDownload/Index',$dato).view('ReportesGenerales/ReporteInventario/ModalDownload/Scripts')
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
}