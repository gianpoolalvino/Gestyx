<?php

namespace App\Controllers\Taller\ReporteEncuestaAppVentas;

use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\EncuestaModel;
use App\Models\InventarioModel;
use App\Models\RepuestoModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
require 'vendor/autoload.php';
class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();
        $access=json_decode($tokenController->AccessRolUser(19,40,''));


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
            'idgrupoModulo' => 19,
            'idmodulo' => 40
        ];
        echo view("Layouts/Head", $dato);
        echo view("Taller/ReporteEncuestaAppVentas/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Taller/ReporteEncuestaAppVentas/Index/Scripts");
    }

    public function DetailIndexExcel()
    {

        $spread=new Spreadsheet();
        $spread->getProperties()
            ->setCreator("AUTONZA")
            ->setTitle("Reporte Encuestas de Taller")
            ->setKeywords('PHPSpreadsheet');

        $sheet=$spread->getActiveSheet();
        $sheet->setTitle("Reporte");
        $encabezado=[
            "Fecha Encuesta",
            "Agencia",
            "Asesor",
            "Documento",
            "Calficacion Autoniza",
            "Comentario de Calficacion Autoniza",
            "Calificacion Marca",
            "Comentario de Calfcacion Marca",
            "Celular",
            "Correo",
            "Medio de Contacto"
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
        $encuestaModel=New EncuestaModel();
        $filtro=[
            'fechaConsulta>='=>$_POST["fechaInicio"],
            'fechaConsulta<='=>$_POST["fechaFin"],
            'tipoEncuesta'=>'VENTAS'
        ];

        $detailIndex=$encuestaModel->DetailEncuesta($filtro);



        foreach($detailIndex as $di){
            $sheet->setCellValue([1, $numeroDeFila], $di["fechaEncuesta"]);
            $sheet->setCellValue([2, $numeroDeFila], $di["nombreAgencia"]);
            $sheet->setCellValue([3, $numeroDeFila], $di["asesor"]);
            $sheet->setCellValue([4, $numeroDeFila], $di["documento"]);
            $sheet->setCellValue([5, $numeroDeFila], $di["resultadoAutoniza"]);
            $sheet->setCellValue([6, $numeroDeFila], $di["comentario"]);
            $sheet->setCellValue([7, $numeroDeFila], $di["resultadoMarca"]);
            $sheet->setCellValue([8, $numeroDeFila], $di["comentarioMarca"]);
            $sheet->setCellValue([9, $numeroDeFila], $di["celular"]);
            $sheet->setCellValue([10, $numeroDeFila], $di["email"]);
            $sheet->setCellValue([11, $numeroDeFila], $di["canal"]);
            $numeroDeFila++;
        }

        $fileName = 'ReporteEncuestasVentas.xlsx';
# Crear un "escritor"
        $writer = new Xlsx($spread);
# Le pasamos la ruta de guardado

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        $writer->save('php://output');
    }

    public function DetailIndex()
    {
        $encuestaModel=New EncuestaModel();

        $filtro=[
            'fechaConsulta>='=>$_POST["fechaInicio"],
            'fechaConsulta<='=>$_POST["fechaFin"],
            'tipoEncuesta'=>'VENTAS'
        ];

        $resultado=[
            'detailIndex'=>$encuestaModel->DetailEncuesta($filtro)
        ];

        $dato=[
            'tbody'=>view("Taller/ReporteEncuestaAppVentas/DetailIndex/Index", $resultado).
                view("Taller/ReporteEncuestaAppVentas/DetailIndex/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }
}