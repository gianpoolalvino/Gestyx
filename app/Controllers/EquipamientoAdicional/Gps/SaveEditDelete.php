<?php

namespace App\Controllers\EquipamientoAdicional\Gps;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\EquipamientoAdicionalModel;
use App\Models\EventoModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function SaveGps()
    {
        $equipamientoModel=New EquipamientoAdicionalModel();
        $eventoModel=New EventoModel();
        $vinModel=New VinModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");

        $filtroEquipamiento=[
            'vin'=>$_POST["vinEquipamiento"],
            'idtipoEquipamiento'=>2,
            'idestadoEquipamiento'=>1
        ];

        $equipa=[
            'fechaInstalacion'=>$_POST["fechaInstalacionGps"],
            'idestadoEquipamiento'=>$_POST["estadoEquipamientoGps"],
            'idusuarioFinal'=>session("idusuario"),
        ];

        $updt=$equipamientoModel->UpdateEquipamiento($filtroEquipamiento,$equipa);

        if($updt){
            $filtroUpdateEvento=[
                'ideventoActual'=>5,
                'vin'=>$_POST["vinEquipamiento"],
                'idestadoEvento'=>1
            ];
            $updateVinEvent=[
                'fechaFin'=>$hoy,
                'horaFin'=>$hora,
                'idusuariofinaliza'=>session("idusuario"),
                'idestadoEvento'=>2,
                'comentarios'=>$_POST["comentarioAccesorio"]
            ];
            $updateEvent=$eventoModel->UpdateEvento($filtroUpdateEvento,$updateVinEvent);
        }

        $vinfiltro=[
            'vin'=>$_POST["vinEquipamiento"]
        ];
        if($_POST["estadoEquipamientoGps"]==4){
            $vinUpdate=[
                'gps'=>3
            ];
        }else{
            $vinUpdate=[
                'gps'=>2
            ];
        }


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