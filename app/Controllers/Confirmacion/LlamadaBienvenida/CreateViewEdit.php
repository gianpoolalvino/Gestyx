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
        $equipamientoVin=$alistamientoVehicular->EquipamientoVin($vin);
        $infoVinDatos=$infoGen[0];
        $extraPorMarca=[
            'CHEVROLET'=>['CUPONERA DE DESCUENTOS'],
        ];
        $listaEquipamiento=array_merge(
            array_column($equipamientoVin, 'equipamiento'),
            $extraPorMarca[strtoupper($infoGen[0]['marca'])] ?? []
        );
        $infoVinDatos['equipamiento']=implode("\n", array_map(fn($item)=>"• ".$item, $listaEquipamiento));
        $filtro=[
            'codigoAgencia'=>$infoGen[0]["codigoAgencia"]
        ];
        $dats=[
            'infoVin'=>$infoGen,
            'equipamientoVin'=>$equipamientoVin,
            'datosMensaje'=>$infoVinDatos,
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