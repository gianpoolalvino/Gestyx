<?php

namespace App\Controllers\Inmatriculacion\TituloPlaca;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\InmatriculacionModel;

class CreateViewEdit extends BaseController
{
    public function ViewRegistro()
    {
        $vin=$_POST["vin"];
        $inmatriculacionModel=New InmatriculacionModel();

        $filtro=[
            'vin'=>$vin
        ];

        $dats=[
            'vin'=>$vin,
            'registro'=>$inmatriculacionModel->ViewRegistroInmatriculacion($filtro)
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Inmatriculacion/TituloPlaca/ViewRegistro/Index",$dats).view("Inmatriculacion/TituloPlaca/ViewRegistro/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }
}