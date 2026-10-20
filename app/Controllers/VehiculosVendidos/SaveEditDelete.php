<?php
namespace App\Controllers\VehiculosVendidos;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EventoModel;
use App\Models\UrgenteModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function SaveLiberar()
    {
        $eventoModel=New EventoModel();
        $vinModel=New VinModel();
        $UrgenteModel=New UrgenteModel();
        $vin=$_POST["vinLiberacion"];

        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $insertEvent=[
            'vin'=>$_POST["vinLiberacion"],
            'ideventoActual'=>22,
            'eventoActual'=>'LIBERADO CON OBSERVACIONES',
            'fechaInicio'=>$hoy,
            'horaInicio'=>$hora,
            'idestadoEvento'=>1,
            'idusuario'=>session("idusuario"),
        ];
        $insertime=$eventoModel->StorageEvento($insertEvent);

        if($insertime!=''){
            if($_POST["liberarUnidad"]==2){
                $filtroVin=[
                    'vin'=>$vin
                ];
                $updateVin=[
                    'urgente'=>1,
                    'fechaUrgente'=>$_POST["fechaLiberarVin"]
                ];
                $upd=$vinModel->UpdateVin($filtroVin,$updateVin);

                $urgenteVin=[
                    'vin'=>$vin,
                    'fecha'=>$hoy,
                    'hora'=>$hora
                ];
                $storUrg=$UrgenteModel->StorageUrgente($urgenteVin);
            }

            $datReturn=[
                'status'=>'success',
                'title'=>'Liberacion de Vin',
                'message'=>'Se libero correctamente el Vin'
            ];
            echo json_encode($datReturn);
            exit();
        }else{
            $datReturn=[
                'status'=>'danger',
                'title'=>'Liberacion de Vin',
                'message'=>'Se produjo un error al liberar el Vin'
            ];
            echo json_encode($datReturn);
            exit();
        }
    }

    public function SaveUrgente()
    {
        $vinModel=New VinModel();
        $UrgenteModel=New UrgenteModel();
        $vin=$_POST["vinUrgente"];
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $urgente=[
            'vin'=>$vin,
            'fecha'=>$_POST["fechaUrgenteVin"],
            'hora'=>$hora,
            'idusuarioGenera'=>session("idusuario"),
            'idusuarioUrgente'=>$_POST["solicitante"]
        ];

        $idUrg=$UrgenteModel->StorageUrgente($urgente);
        if($idUrg!=''){
            $vinfiltro=[
                'vin'=>$vin
            ];
            $updateVin=[
                'urgente'=>1,
                'fechaUrgente'=>$_POST["fechaUrgenteVin"],
                'idusuarioSolicitaUrgente'=>$_POST["solicitante"]
            ];
            $upd=$vinModel->UpdateVin($vinfiltro,$updateVin);
            if($upd){
                $datReturn=[
                    'status'=>'success',
                    'title'=>'Vin Urgente',
                    'message'=>'Se marco como prioridad el Vin'
                ];
                echo json_encode($datReturn);
                exit();
            }else{
                $datReturn=[
                    'status'=>'danger',
                    'title'=>'Vin Urgente',
                    'message'=>'Error en B.D'
                ];
                echo json_encode($datReturn);
                exit();
            }
        }else{
            $datReturn=[
                'status'=>'danger',
                'title'=>'Vin Urgente',
                'message'=>'Error en B.D'
            ];
            echo json_encode($datReturn);
            exit();
        }
    }
}