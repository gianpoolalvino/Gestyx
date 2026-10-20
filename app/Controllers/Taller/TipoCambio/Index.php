<?php

namespace App\Controllers\Taller\TipoCambio;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\RepuestoModel;
use App\Models\TipoCambioModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();
        $access=json_decode($tokenController->AccessRolUser(19,34,''));


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
        $tipoCambioModel=New TipoCambioModel();
        $hoy=date("Y-m-d");
        $filtro=[
            'fecha>='=>$hoy,
            'fecha<='=>$hoy
        ];

        $detail = $tipoCambioModel->DetailIndex($filtro);

        $dato = [
            'idgrupoModulo' => 19,
            'idmodulo' => 34,
            'detailIndex' => $detail,
        ];
        echo view("Layouts/Head", $dato);
        echo view("Taller/TipoCambio/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Taller/TipoCambio/Index/Scripts");
    }

    public function DetailIndex()
    {
        $tipoCambioModel=New TipoCambioModel();
        if($_POST["fechaInicio"]>$_POST["fechaFin"]){
            $send=[
                'status'=>'warning',
                'title'=>'Error en Fechas',
                'message'=>'La Fecha de inicio no puede ser mayor a la fecha Final'
            ];
            echo json_encode($send);
            exit();
        }

        $filtro=[
            'fecha>='=>$_POST["fechaInicio"],
            'fecha<='=>$_POST["fechaFin"]
        ];
        $detail = $tipoCambioModel->DetailIndex($filtro);

        if($detail){
            $dato=[
                'detail'=>$detail
            ];
            $send=[
                'status'=>'success',
                'title'=>'Registros Encontrados',
                'message'=>'Se Encontraron registros en el Sistema',
                'info'=>view("Taller/TipoCambio/DetailIndex/Index",$dato).view("Taller/TipoCambio/DetailIndex/Scripts")
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'warning',
                'title'=>'Sin Datos',
                'message'=>'No existe registro de tipo de cambio en el sistema'
            ];
            echo json_encode($send);
            exit();
        }
    }
}