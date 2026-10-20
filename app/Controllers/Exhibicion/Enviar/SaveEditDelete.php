<?php

namespace App\Controllers\Exhibicion\Enviar;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EventoModel;
use App\Models\ExhibicionModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function SaveSend()
    {
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $exhibicionModel=New ExhibicionModel();
        $eventoModel=New EventoModel();
        $vinModel=New VinModel();
        $idexhibicionVin=$_POST["idexhibicionVin"];
        $vin=$_POST["vin"];

        $filtroUpdate=[
            'idexhibicionVin'=>$idexhibicionVin,
            'vin'=>$vin
        ];
        $update=[
            'idestadoExhibicion'=>3,
            'fechaEnvio'=>$_POST["fechaEnvio"],
            'comentarioEnvio'=>$_POST["comentarioEnvio"]
        ];
        $stor=$exhibicionModel->UpdateExhibicion($filtroUpdate,$update);
        if($stor){
            $filtroUpdateVin=[
                'vin'=>$_POST["vin"]
            ];
            $updateVin=[
                'ideventoActual'=>32,
                'eventoActual'=>'En Exhibicion',
                'ideventoAnterior'=>31,
                'eventoAnterior'=>'Listo para Exhibicion',
                'fechaEventoActual'=>$_POST["fechaEnvio"],
                'horaEventoActual'=>$hora
            ];
            $updateVn=$vinModel->UpdateVin($filtroUpdateVin,$updateVin);
            if($updateVn){
                $eventoActual=[
                    'fechaRegistroSistemaInicio'=>$hoy,
                    'fechaInicio'=>$hoy,
                    'vin'=>$_POST["vin"],
                    'horaInicio'=>$hora,
                    'ideventoAnterior'=>31,
                    'eventoAnterior'=>'Listo para Exhibicion',
                    'ideventoActual'=>32,
                    'eventoActual'=>'En Exhibicion',
                    'idestadoEvento'=>1,
                    'idusuario'=>session("idusuario"),
                    'comentarios'=>$_POST["comentarioEnvio"]
                ];
                $storeEvent=$eventoModel->StorageEvento($eventoActual);
                if($storeEvent){
                    $filtroUpdateEvento=[
                        'ideventoActual'=>31,
                        'vin'=>$vin,
                        'idestadoEvento'=>1
                    ];
                    $updateVinEvent=[
                        'fechaFin'=>$hoy,
                        'horaFin'=>$hora,
                        'idusuariofinaliza'=>session("idusuario"),
                        'idestadoEvento'=>2,
                    ];

                    $updateEvent=$eventoModel->UpdateEvento($filtroUpdateEvento,$updateVinEvent);
                }
            }
            $dato=[
                'status'=>'success',
                'title'=>'Enviado',
                'message'=>'Se Envio correctamente a exhibicion'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error de Envio',
                'message'=>'No se logro enviar el Vehiculo'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}

