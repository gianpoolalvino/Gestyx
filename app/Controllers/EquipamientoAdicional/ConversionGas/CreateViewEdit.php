<?php

namespace App\Controllers\EquipamientoAdicional\ConversionGas;
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

        $proveedoresGas=$agenciaProveedor->ProveedorGas();
        $dats=[
            'equipamiento'=>$alistamientoVehicular->EquipamientoVin($vin),
            'proveedorGas'=>$proveedoresGas,
            'infoVin'=>$alistamientoVehicular->ViewVin($vin),
            'vin'=>$vin
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("EquipamientoAdicional/ConversionGas/Create/Index",$dats).view("EquipamientoAdicional/ConversionGas/Create/Scripts")
        ];

        echo json_encode($dato);
        exit();
    }
}