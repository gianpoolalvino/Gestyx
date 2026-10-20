<?php

namespace App\Controllers\Taller\ReporteEncuestaAppTaller;

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
        $access=json_decode($tokenController->AccessRolUser(19,39,''));


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
            'idmodulo' => 39
        ];
        echo view("Layouts/Head", $dato);
        echo view("Taller/ReporteEncuestaAppTaller/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Taller/ReporteEncuestaAppTaller/Index/Scripts");
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
            "Taller",
            "Tecnico",
            "Placa",
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
        $spread->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $encuestaModel=New EncuestaModel();
        $filtro=[
            'fechaConsulta>='=>$_POST["fechaInicio"],
            'fechaConsulta<='=>$_POST["fechaFin"],
            'tipoEncuesta'=>'TALLER'
        ];

        $detailIndex=$encuestaModel->DetailEncuesta($filtro);



        foreach($detailIndex as $di){
            $sheet->setCellValue([1, $numeroDeFila], $di["fechaEncuesta"]);
            $sheet->setCellValue([2, $numeroDeFila], $di["taller"]);
            $sheet->setCellValue([3, $numeroDeFila], $di["nombreTecnico"]);
            $sheet->setCellValue([4, $numeroDeFila], $di["placa"]);
            $sheet->setCellValue([5, $numeroDeFila], $di["documento"]);
            $sheet->setCellValue([6, $numeroDeFila], $di["resultadoAutoniza"]);
            $sheet->setCellValue([7, $numeroDeFila], $di["comentario"]);
            $sheet->setCellValue([8, $numeroDeFila], $di["resultadoMarca"]);
            $sheet->setCellValue([9, $numeroDeFila], $di["comentarioMarca"]);
            $sheet->setCellValue([10, $numeroDeFila], $di["celular"]);
            $sheet->setCellValue([11, $numeroDeFila], $di["email"]);
            $sheet->setCellValue([12, $numeroDeFila], $di["canal"]);
            $numeroDeFila++;
        }

        $fileName = 'ReporteEncuestas.xlsx';
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
            'tipoEncuesta'=>'TALLER'
        ];

        $resultado=[
            'detailIndex'=>$encuestaModel->DetailEncuesta($filtro)
        ];

        $dato=[
            'tbody'=>view("Taller/ReporteEncuestaAppTaller/DetailIndex/Index", $resultado).
                view("Taller/ReporteEncuestaAppTaller/DetailIndex/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }
}