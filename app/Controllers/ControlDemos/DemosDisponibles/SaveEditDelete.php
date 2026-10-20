<?php
namespace App\Controllers\ControlDemos\DemosDisponibles;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\EventoModel;
use App\Models\TrasladoModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function SaveLiberacion()
    {
        $controlDemos=New ControlDemosModel();
        $alistamientoVin=New AlistamientoVehicularModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $fechaLiberacion=$_POST["fechaActivar"];
        $fechaFinaliza=date("Y-m-d",strtotime($fechaLiberacion."+ 6 month"));

        $liberacion=[
            'vin'=>$_POST["vinDisponible"],
            'fechaActivacion'=>$fechaLiberacion,
            'fechaFinaliza'=>$fechaFinaliza,
            'idusuarioLibera'=>session("idusuario"),
            'fechaRegistro'=>$hoy,
            'horaRegistro'=>$hora,
            'idtipoDemo'=>$_POST["tipoDemo"],
            'comentario'=>$_POST["comentarioLiberado"],
            'idestadoLiberacion'=>1
        ];

        $libe=$controlDemos->StorageControlDemo($liberacion);

        if($libe!=''){
            $vinFiltro=[
                'vin'=>$_POST["vinDisponible"]
            ];
            $vinUpdate=[
                "idtipoDemo"=>$_POST["tipoDemo"],
                'idliberacionDemo'=>$libe,
                'liberacionDemo'=>1
            ];
            $upd=$alistamientoVin->UpdateVinAccesorio($vinFiltro,$vinUpdate);

            if($upd){
                $dato=[
                    'status'=>'success',
                    'title'=>'Proceso Correcto',
                    'message'=>'Se libero el vin correctamente verifique en el Modulo Demos Liberados'
                ];
                echo json_encode($dato);
                exit();
            }
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error en Proceso',
                'message'=>'Ocurrio un error inesperado y el proceso no se completo correctamente'
            ];
            echo json_encode($dato);
            exit();
        }
    }

    public function SaveSendSeminuevo()
    {
        $controlDemos=New ControlDemosModel();
        $alistamientoVin=New AlistamientoVehicularModel();
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $fechaEnvio=$_POST["fechaEnvio"];
        $comentario=$_POST["comentarioSeminuevo"];
        $vin=$_POST["vinSeminuevo"];
        $vinInfo=$vinModel->VinInfo($vin);

        $vinSeminuevo=[
            'vin'=>$vinInfo[0]["vin"],
            'codigoMarca'=>$vinInfo[0]["codigoMarca"],
            'marca'=>$vinInfo[0]["marca"],
            'placa'=>$vinInfo[0]["placa"],
            'codigoFamilia'=>$vinInfo[0]["codigoFamilia"],
            'familia'=>$vinInfo[0]["familia"],
            'codigoModelo'=>$vinInfo[0]["codigoModelo"],
            'modelo'=>$vinInfo[0]["modelo"],
            'anhoFabricacion'=>$vinInfo[0]["anhoFabricacion"],
            'anhoModelo'=>$vinInfo[0]["anhoModelo"],
            'kilometraje'=>$vinInfo[0]["kilometraje"],
            'codigoColor'=>$vinInfo[0]["codigoColor"],
            'color'=>$vinInfo[0]["color"],
            'idtipoVin'=>2,
            'idestadoVin'=>1,
            'fechaCompra'=>$vinInfo[0]["fechaCompra"],
            'codigoBodega'=>'0201',
            'bodega'=>'COMERCIAL USADOS(SEMINUEVOS)'
        ];

        $idstor=$vinModel->StorageSeminuevo($vinSeminuevo);

        if($idstor!=''){
            $vinFiltro=[
                'vin'=>$vin
            ];
            $updateVin=[
                'idtipoVin'=>2,
                'idestadoVin'=>1,
                'codigoBodega'=>'0201',
                'bodega'=>'COMERCIAL USADOS(SEMINUEVOS)'
            ];

            $updVin=$vinModel->UpdateVin($vinFiltro,$updateVin);

            if($updVin){
                $trasladoUbicacion=[
                    'vin'=>$vin,
                    'codigoBodegaOrigen'=>$vinInfo[0]["codigoBodega"],
                    'codigoBodegaDestino'=>'0201',
                    'fechaTraslado'=>date("Y-m-d"),
                    'horaTraslado'=>date("H:i:s"),
                    'idtipoTraslado'=>2,
                    'idestadoTraslado'=>1,
                    'idusuarioTraslado'=>session("idusuario"),
                    'comentarios'=>$_POST["comentarioSeminuevo"]
                ];
                $stor=$trasladoModel->StorageTraslado($trasladoUbicacion);
            }

            if(isset($_POST["idliberacionDemo"])){
                $filtroUpdate=[
                    'idliberacionDemo'=>$_POST["idliberacionDemo"],
                    'vin'=>$vin,
                    'idestadoLiberacion'=>1
                ];
                $update=[
                    'idestadoLiberacion'=>4
                ];
                $upd=$controlDemos->UpdateLiberacionDemo($filtroUpdate,$update);
            }
            $dato=[
                'status'=>'success',
                'title'=>'Pase a Seminuevos Realizado',
                'message'=>'Se realizo el traslado a seminuevos correctamente'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Pase a Seminuevos',
                'message'=>'Fallo al intentar realizar el traslado a Seminuevos'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}