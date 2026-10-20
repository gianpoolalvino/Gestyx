<?php

namespace App\Controllers\Comisiones\PagoComisiones;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ComisionModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(21,50,''));


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
            'idgrupoModulo'=>21,
            'idmodulo'=>50
        ];
        echo view("Layouts/Head",$dato);
        echo view("Comisiones/PagoComisiones/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("Comisiones/PagoComisiones/Index/Scripts");
    }

    public function DetailIndex()
    {
        $comisionModel=New ComisionModel();

        $estadoComision=$_POST["estadoComision"];
        $tipoFiltro=$_POST["tipoFiltro"];
        $filtro=$_POST["filtro"];
        $fechaInicio=$_POST["fechaInicio"];
        $fechaFin=$_POST["fechaFin"];


        $detailComision=$comisionModel->DetailComision($estadoComision,$tipoFiltro,$fechaInicio,$fechaFin,$filtro);

        $dats=[
            'detailComision'=>$detailComision
        ];

        $send=[
            'info'=>view("Comisiones/PagoComisiones/DetailIndex/Index",$dats).view("Comisiones/PagoComisiones/DetailIndex/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();
    }
}