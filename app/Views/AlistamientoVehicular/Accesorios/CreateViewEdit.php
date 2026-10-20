<?php

namespace App\Controllers\AlistamientoVehicular\Accesorios;
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
            'equipamiento'=>$alistamientoVehicular->EquipamientoVinNew($vin,''),
            'proveedorGas'=>$proveedoresGas,
            'infoVin'=>$alistamientoVehicular->ViewVin($vin),
            'vin'=>$vin
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/Accesorios/Create/Index",$dats).view("AlistamientoVehicular/Accesorios/Create/Scripts")
        ];

        echo json_encode($dato);
        exit();
    }

    public function CreateAccesorio()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();
        $agenciaProveedor=new AgenciaProveedorModel();
        $vin=$_POST["vin"];
        $idequipamientoVin=$_POST["idequipamientoVin"];

        $filtro=[
            'vin'=>$vin,
            'idequipamientoVin'=>$idequipamientoVin
        ];

        $viewEq=$alistamientoVehicular->ViewEquipamiento($filtro);
        $proveedoresGas=$agenciaProveedor->ProveedorGas();
        $dats=[
            'viewEq'=>$viewEq,
            'vin'=>$vin,
            'proveedorGas'=>$proveedoresGas,
            'idequipamientoVin'=>$idequipamientoVin
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/Accesorios/CreateAccesorio/Index",$dats).view("AlistamientoVehicular/Accesorios/CreateAccesorio/Scripts")
        ];

        echo json_encode($dato);
        exit();
    }

    public function DetailCreate()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();
        $agenciaProveedor=new AgenciaProveedorModel();
        $vin=$_POST["vin"];
        $idtipoEquipamiento=$_POST["idtipoEquipamiento"];
        $dats=[
            'equipamiento'=>$alistamientoVehicular->EquipamientoVinNew($vin,$idtipoEquipamiento),
            'idtipoEquipamiento'=>$idtipoEquipamiento,
            'vin'=>$vin
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/Accesorios/DetailCreate/Index",$dats).view("AlistamientoVehicular/Accesorios/DetailCreate/Scripts")
        ];

        echo json_encode($dato);
        exit();

    }

    public function Create_old()
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
            'info'=>view("AlistamientoVehicular/Accesorios/Create_old/Index",$dats).view("AlistamientoVehicular/Accesorios/Create_old/Scripts")
        ];

        echo json_encode($dato);
        exit();
    }
}