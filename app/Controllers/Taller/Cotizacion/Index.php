<?php

namespace App\Controllers\Taller\Cotizacion;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\CotizacionModel;
use App\Models\InventarioModel;
use App\Models\MarcaModel;
use App\Models\PlanMantenimientoModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();
        $access=json_decode($tokenController->AccessRolUser(19,36,''));


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

        $marcaModel=new MarcaModel();
        $dato = [
            'idgrupoModulo' => 19,
            'idmodulo' => 36,
            'selectMarca'=>$marcaModel->SelectMarca()

        ];
        echo view("Layouts/Head", $dato);
        echo view("Taller/Cotizacion/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Taller/Cotizacion/Index/Scripts");
    }

    public function DetailIndex()
    {
        $cotizacionModel=New CotizacionModel();

        $filtro=[
            'idmarca'=>$_POST["idmarca"],
            'fechaCotizacion>='=>$_POST["fechaInicio"],
            'fechaCotizacion<='=>$_POST["fechaFin"],
        ];

        if($_POST["filtro"]!=''){
            $filtro+=[
                $_POST["filtro"]=>$_POST["search"]
            ];
        }

        $dato=[
            'detailIndex'=>$cotizacionModel->DetailIndex($filtro)
        ];

        $result=[
            'info'=>view("Taller/Cotizacion/DetailIndex/Index",$dato).view("Taller/Cotizacion/DetailIndex/Scripts")
        ];

        echo json_encode($result);
        exit();
    }
}