<?php

namespace App\Controllers\EquipamientoAdicional\Onstar;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;

class CreateViewEdit extends BaseController
{
    public function Create()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();
        $vin=$_POST["vin"];
        $dats=[
            'infoVin'=>$alistamientoVehicular->ViewVin($vin),
            'vin'=>$vin
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("EquipamientoAdicional/Onstar/Create/Index",$dats).view("EquipamientoAdicional/Onstar/Create/Scripts")
        ];

        echo json_encode($dato);
        exit();
    }
}