<?php

namespace App\Controllers\EquipamientoAdicional\Onstar;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\EquipamientoAdicionalModel;
use App\Models\EventoModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function SaveOnstar()
    {
        $equipamientoModel=New EquipamientoAdicionalModel();
        $eventoModel=New EventoModel();
        $vinModel=New VinModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");


        $filtroUpdateEvento=[
            'ideventoActual'=>6,
            'vin'=>$_POST["vinEquipamiento"],
            'idestadoEvento'=>1
        ];
        $updateVinEvent=[
            'fechaFin'=>$_POST["fechaLlamadaOnstar"],
            'horaFin'=>$hora,
            'idusuariofinaliza'=>session("idusuario"),
            'idestadoEvento'=>2,
            'comentarios'=>$_POST["comentarioAccesorio"]
        ];
        $updateEvent=$eventoModel->UpdateEvento($filtroUpdateEvento,$updateVinEvent);


        $vinfiltro=[
            'vin'=>$_POST["vinEquipamiento"]
        ];
        $vinUpdate=[
            'fechaOnstar'=>$_POST["fechaLlamadaOnstar"],
            'horaOnstar'=>$hora,
            'onstar'=>2
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