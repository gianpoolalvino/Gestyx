<?php

namespace App\Controllers\Exhibicion\RetornarInventario;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlCalidadModel;
use App\Models\EventoModel;
use App\Models\ExhibicionModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function SaveRetorno()
    {
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $exhibicionModel=New ExhibicionModel();
        $alistamientoVin=New AlistamientoVehicularModel();
        $controlCalidadModel=New ControlCalidadModel();
        $eventoModel=New EventoModel();
        $vinModel=New VinModel();
        $idexhibicionVin=$_POST["idexhibicionVin"];
        $vin=$_POST["vin"];

        $filtroUpdate=[
            'idexhibicionVin'=>$idexhibicionVin,
            'vin'=>$vin
        ];
        $update=[
            'idestadoExhibicion'=>4,
            'fechaRetorno'=>$_POST["fechaRetorno"],
            'comentarioRetorno'=>$_POST["comentarioRetorno"]
        ];
        $stor=$exhibicionModel->UpdateExhibicion($filtroUpdate,$update);
        if($stor){
            $filtroUpdateVin=[
                'vin'=>$_POST["vin"]
            ];
            $updateVin=[
                'idestadoVin'=>1,
                'ideventoActual'=>30,
                'eventoActual'=>'Inventario',
                'ideventoAnterior'=>32,
                'eventoAnterior'=>'En Exhibicion',
                'fechaEventoActual'=>null,
                'horaEventoActual'=>null
            ];
            $updateVn=$vinModel->UpdateVin($filtroUpdateVin,$updateVin);
            if($updateVn){
                $eventoActual=[
                    'fechaRegistroSistemaInicio'=>$hoy,
                    'fechaInicio'=>$hoy,
                    'vin'=>$_POST["vin"],
                    'horaInicio'=>$hora,
                    'ideventoAnterior'=>32,
                    'eventoAnterior'=>'En Exhibicion',
                    'ideventoActual'=>30,
                    'eventoActual'=>'Inventario',
                    'idestadoEvento'=>2,
                    'idusuario'=>session("idusuario"),
                    'comentarios'=>$_POST["comentarioRetorno"]
                ];
                $storeEvent=$eventoModel->StorageEvento($eventoActual);

                $filtroVinEq=[
                    'vin'=>$vin
                ];
                $updateEquipamiento=[
                    'eliminado'=>1
                ];
                $updateV=$alistamientoVin->UpdateEquipamiento($filtroVinEq,$updateEquipamiento);

                $vinFiltroCC=[
                    'vin'=>$vin,
                    'idestadoProceso!='=>4
                ];
                $updateReporteCalidad=[
                    'idestadoProceso'=>4
                ];
                $control=$controlCalidadModel->UpdateReporteCalidad($vinFiltroCC,$updateReporteCalidad);

                if($storeEvent){
                    $filtroUpdateEvento=[
                        'ideventoActual'=>32,
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