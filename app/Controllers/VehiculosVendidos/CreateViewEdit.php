<?php

namespace App\Controllers\VehiculosVendidos;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\EventoModel;
use App\Models\UsuarioModel;
use App\Models\VinModel;

class CreateViewEdit extends BaseController
{
    public function Create()
    {
        $usuarioModel=New UsuarioModel();
        $eventoModel=New EventoModel();
        $vinModel=New VinModel();

        $filtroEvento=[
            'vin'=>$_POST["vin"],
            'ideventoActual'=>22,
            'idestadoEvento'=>1
        ];

        $dats=[
            'vin'=>$_POST["vin"],
            'vinInfo'=>$vinModel->VinInfo($_POST["vin"]),
            'selectGerente'=>$usuarioModel->ListGerente(),
            'contadorLiberado'=>$eventoModel->ContadorVerificarEvento($filtroEvento),

        ];
        $dato=[
            'status'=>'success',
            'info'=>view("VehiculosVendidos/Create/Index",$dats).view("VehiculosVendidos/Create/Scripts")
        ];

        echo json_encode($dato);
        exit();
    }
}