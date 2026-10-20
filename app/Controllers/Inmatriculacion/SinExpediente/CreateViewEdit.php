<?php

namespace App\Controllers\Inmatriculacion\SinExpediente;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\InmatriculacionModel;

class CreateViewEdit extends BaseController
{
    public function Create()
    {
        $vin=$_POST["vin"];
        $inmatriculacionModel=New InmatriculacionModel();
        $dats=[
            'vin'=>$vin,
            'ciudad'=>$inmatriculacionModel->SelectCiudadPlaca()
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Inmatriculacion/SinExpediente/Create/Index",$dats).view("Inmatriculacion/SinExpediente/Create/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }
}