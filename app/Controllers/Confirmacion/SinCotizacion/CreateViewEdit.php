<?php

namespace App\Controllers\Confirmacion\SinCotizacion;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;

class CreateViewEdit extends BaseController
{
    public function Create()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();
        $agenciaProveedor=new AgenciaProveedorModel();
        $vin=$_POST["vin"];
        $infoGen=$alistamientoVehicular->ViewVin($vin);
        $filtro=[
            'codigoAgencia'=>$infoGen[0]["codigoAgencia"]
        ];
        $dats=[
            'infoVin'=>$alistamientoVehicular->ViewVin($vin),
            'vin'=>$vin
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Confirmacion/SinCotizacion/Create/Index",$dats).view("Confirmacion/SinCotizacion/Create/Scripts")
        ];

        echo json_encode($dato);
        exit();
    }
}