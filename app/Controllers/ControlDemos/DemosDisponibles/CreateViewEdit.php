<?php

namespace App\Controllers\ControlDemos\DemosDisponibles;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;

class CreateViewEdit extends BaseController
{
    public function Create()
    {
        $vin=$_POST["vin"];
        $controlDemos=New ControlDemosModel();
        $dats=[
            'vin'=>$vin,
            'tipoDemo'=>$controlDemos->TipoDemo()
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("ControlDemos/DemosDisponibles/Create/Index",$dats).view("ControlDemos/DemosDisponibles/Create/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }
}