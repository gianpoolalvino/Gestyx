<?php

namespace App\Controllers\Confirmacion\LlamadaBienvenida;
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
            'equipamientoVin'=>$alistamientoVehicular->EquipamientoVin($vin),
            'vin'=>$vin
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Confirmacion/LlamadaBienvenida/Create/Index",$dats).view("Confirmacion/LlamadaBienvenida/Create/Scripts",$dats)
        ];

        echo json_encode($dato);
        exit();
    }

    public function QrWsp()
    {
        $dato=[
            'status'=>'success',
            'info'=>view("Confirmacion/LlamadaBienvenida/QrWsp/Index").view("Confirmacion/LlamadaBienvenida/QrWsp/ScriptsVersion")
        ];

        echo json_encode($dato);
        exit();
    }

    public function SaveSessionPhone()
    {
        $numeroTelefono=$_POST["numeroTelefono"];
        // Cargar el servicio de sesión
        $session = session();
        // Guardar la variable en la sesión
        $session->set('numeroTelefono', $numeroTelefono);

        if($numeroTelefono){
            echo json_encode(["status"=>'success']);
        }
    }
}