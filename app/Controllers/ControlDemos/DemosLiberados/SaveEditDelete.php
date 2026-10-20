<?php

namespace App\Controllers\ControlDemos\DemosLiberados;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\GeneralesModel;

class SaveEditDelete extends BaseController
{
    public function SaveAsignacion()
    {
        $controlDemo= New ControlDemosModel();
        $generalModel=New GeneralesModel();
        $idliberacionDemo=$_POST["idliberacionVin"];
        $vin=$_POST["vinDisponible"];

        $filtroRes=[
            'documento'=>$_POST["documentoExterno"]
        ];

        $search=$generalModel->SearchResponsable($filtroRes);

        if(!$search){
                $responsable=[
                    'documento'=>$_POST["documentoExterno"],
                    'nombre'=>$_POST["nombreExterno"],
                    'direccion'=>$_POST["direccionExterno"],
                    'telefono'=>$_POST["telefonoExterno"],
                ];
                $stora=$generalModel->StorageResponsable($responsable);
        }


        $asignacion=[
            'idliberacionDemo'=>$_POST["idliberacionVin"],
            'vin'=>$_POST["vinDisponible"],
            'fechaEntrega'=>$_POST["fechaEntrega"],
            'horaEntrega'=>$_POST["horaEntrega"],
            'fechaRetorno'=>$_POST["fechaRecepcion"],
            'horaRetorno'=>$_POST["horaRecepcion"],
            'documentoResponsable'=>$_POST["documentoExterno"],
            'nombreResponsable'=>$_POST["nombreExterno"],
            'direccionResponsable'=>$_POST["direccionExterno"],
            'telefonoResponsable'=>$_POST["telefonoExterno"],
            'idusuarioAsignacion'=>session("idusuario"),
            'comentario'=>$_POST["comentarioAdicional"],
            'idestadoAsignacionDemo'=>1
        ];

        $saveAsig=$controlDemo->StorageAsignacionDemo($asignacion);

        if($saveAsig!=''){
            $filtroUpdate=[
                'idliberacionDemo'=>$idliberacionDemo,
                'vin'=>$vin,
                'idestadoLiberacion'=>1
            ];

            $update=[
                'idestadoLiberacion'=>3
            ];

            $upd=$controlDemo->UpdateLiberacionDemo($filtroUpdate,$update);
            if($upd){
                $dato=[
                    'status'=>'success',
                    'title'=>'Vin Asignado',
                    'message'=>'El vin se asigno correctamente'
                ];
                echo json_encode($dato);
                exit();
            }
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error en sistema',
                'message'=>'El vin no se logro asignar'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}