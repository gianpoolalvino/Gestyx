<?php

namespace App\Controllers\ControlDemos\DemosLiberados;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\VinModel;

class CreateViewEdit extends BaseController
{
    public function Create()
    {
        $vin=$_POST["vin"];
        $idliberacionDemo=$_POST["idliberacionDemo"];
        $controlDemos=New ControlDemosModel();
        $vinModel=New VinModel();

        $filtro=[
            'vin'=>$vin,
            'idliberacionDemo'=>$idliberacionDemo
        ];
        $dats=[
            'vin'=>$vin,
            'tipoDemo'=>$controlDemos->TipoDemo(),
            'vinInfo'=>$controlDemos->ViewLiberado($filtro),
            'idliberacionDemo'=>$idliberacionDemo,
            'hora'=>$controlDemos->Hora(),
            'infoLiberacion'=>$controlDemos->ViewDemoLiberado($idliberacionDemo)
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("ControlDemos/DemosLiberados/Create/Index",$dats).view("ControlDemos/DemosLiberados/Create/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }
}