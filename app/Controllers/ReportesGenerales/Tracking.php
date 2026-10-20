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

class Tracking extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(4,44,''));


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
            'idmodulo'=>44,
        ];
        echo view("Layouts/Head",$dato);
        echo view("ReportesGenerales/Tracking/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("ReportesGenerales/Tracking/Index/Scripts");
    }

    public function DetailIndex()
    {
        $reporteGeneralModel=New ReportesGeneralModel();

        $tipofiltro=$_POST["tipoFiltro"];
        $filt=$_POST["filtro"];

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

        $rango=[
            'fechaFactura>='=>$_POST["fechaInicio"],
            'fechaFactura<='=>$_POST["fechaFin"]
        ];

        $trackingVehicular=$reporteGeneralModel->TrackingVehicular($tipofiltro,$filt,$rango);

        if($trackingVehicular){
            $dats=[
                'detailIndex'=>$trackingVehicular,
            ];
            $result=[
                'tbody'=>view("ReportesGenerales/Tracking/DetailIndex/Index",$dats).view("ReportesGenerales/Tracking/DetailIndex/Scripts"),
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