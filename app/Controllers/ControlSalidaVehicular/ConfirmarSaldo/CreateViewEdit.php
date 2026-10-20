<?php

namespace App\Controllers\ControlSalidaVehicular\ConfirmarSaldo;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\UsuarioModel;

class CreateViewEdit extends BaseController
{
    public function Create()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();
        $usuarioModel=New UsuarioModel();
        $vin=$_POST["vin"];
        $infoGen=$alistamientoVehicular->ViewVin($vin);

        $filtro=[
            'codigoAgencia'=>$infoGen[0]["codigoAgencia"]
        ];

        $dats=[
            'infoVin'=>$alistamientoVehicular->ViewVin($vin),
            'selectGerente'=>$usuarioModel->ListGerente(),
            'vin'=>$vin
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("ControlSalidaVehicular/ConfirmarSaldo/Create/Index",$dats).view("ControlSalidaVehicular/ConfirmarSaldo/Create/Scripts")
        ];

        echo json_encode($dato);
        exit();
    }
}