<?php

namespace App\Controllers\EquipamientoAdicional\ConversionGas;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\EquipamientoAdicionalModel;
use App\Models\EventoModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function SaveGas()
    {
        $equipamientoModel=New EquipamientoAdicionalModel();
        $eventoModel=New EventoModel();
        $vinModel=New VinModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $gasConver=explode("-",$_POST["proveedorGas"]);


        $filtroEquipamiento=[
            'vin'=>$_POST["vinEquipamiento"],
            'idtipoEquipamiento'=>9,
            'idestadoEquipamiento'=>1
        ];

        $equipa=[
            'fechaInstalacion'=>$_POST["fechaInstalacionGas"],
            'idestadoEquipamiento'=>2,
            'idusuarioFinal'=>session("idusuario"),
            'idproveedorGas'=>$gasConver[1],
            'idproveedorGasRegion'=>$gasConver[0]
        ];

        $updt=$equipamientoModel->UpdateEquipamiento($filtroEquipamiento,$equipa);

        if($updt){
            $filtroUpdateEvento=[
                'ideventoActual'=>10,
                'vin'=>$_POST["vinEquipamiento"],
                'idestadoEvento'=>1
            ];
            $updateVinEvent=[
                'fechaFin'=>$hoy,
                'horaFin'=>$hora,
                'idusuariofinaliza'=>session("idusuario"),
                'idproveedorGas'=>$gasConver[1],
                'idestadoEvento'=>2,
                'comentarios'=>$_POST["comentarioAccesorio"]
            ];
            $updateEvent=$eventoModel->UpdateEvento($filtroUpdateEvento,$updateVinEvent);
        }

        $vinfiltro=[
            'vin'=>$_POST["vinEquipamiento"]
        ];

        $vinUpdate=[
            'idproveedorGas'=>$gasConver[1],
            'idproveedorGasRegion'=>$gasConver[0],
            'gas'=>2
        ];

        $upv=$vinModel->UpdateVin($vinfiltro,$vinUpdate);

        if($upv){
            $dato=[
                'status'=>'success',
                'title'=>'Conversion a Gas',
                'message'=>'Se realizo la conversion a gas correctamente'
            ];

            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error en Proceso',
                'message'=>'La conversion a gas no se realizo'
            ];
            echo json_encode($dato);
            exit();
        }

    }
}