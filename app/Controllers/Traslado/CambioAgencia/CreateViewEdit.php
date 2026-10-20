<?php

namespace App\Controllers\Traslado\CambioAgencia;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\TrasladoModel;
use App\Models\VinModel;

class CreateViewEdit extends BaseController
{

    public function CreateObservacionEnvio()
    {
        $obsRecep=[
            'tokenSend'=>$_POST["tokenSend"],
            'vin'=>$_POST["vin"]
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Traslado/CambioAgencia/CreateDetalleEnvio/Index",$obsRecep).view("Traslado/CambioAgencia/CreateDetalleEnvio/Scripts"),
        ];

        echo json_encode($send);
        exit();
    }

    public function CreateObservacionRecepcion()
    {
        $obsRecep=[
            'idtrasladoVin'=>$_POST["idtrasladoVin"],
            'vin'=>$_POST["vin"]
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Traslado/CambioAgencia/CreateDetalleRecepcion/Index",$obsRecep).view("Traslado/CambioAgencia/CreateDetalleRecepcion/Scripts"),
        ];

        echo json_encode($send);
        exit();

    }

    public function DetalleEnvioVin()
    {
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();

        $filtro=[
            'tokenUnico'=>$_POST["tokenSend"]
        ];

        $dato=[
            'detalleEnvio'=>$trasladoModel->DetalleEnvioTraslado($filtro),
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Traslado/CambioAgencia/DetailEnvioVin/Index",$dato).view("Traslado/CambioAgencia/DetailEnvioVin/Scripts"),
        ];

        echo json_encode($send);
        exit();
    }

    public function DetalleRecepcionVin()
    {
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();

        $filtro=[
            'idtrasladoVin'=>$_POST["idtrasladoVin"]
        ];

        $dato=[
            'detalleRecepcion'=>$trasladoModel->DetalleRecepcion($filtro),
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Traslado/CambioAgencia/DetailRecepcion/Index",$dato).view("Traslado/CambioAgencia/DetailRecepcion/Scripts"),
        ];

        echo json_encode($send);
        exit();
    }

    public function RecepcionAgencia()
    {
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();

        $filtro=[
            'vin'=>$_POST["vin"]
        ];

        $filt=[
            'vin'=>$_POST["vin"],
            'idtrasladoVin'=>$_POST["idtrasladoVin"]
        ];

        $dats=[
            'vin'=>$_POST["vin"],
            'vinInfo'=>$vinModel->VinAgencia($filtro),
            'detalleRecepcion'=>$trasladoModel->DetalleRecepcion($filt),
            'agencia'=>$trasladoModel->SelectAgencia()
        ];

        $dato=[
            'info'=>view("Traslado/CambioAgencia/RecepcionAgencia/Index",$dats).view("Traslado/CambioAgencia/RecepcionAgencia/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($dato);
        exit();
    }
    public function ChangeAgencia()
    {
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();

        $filtro=[
            'vin'=>$_POST["vin"]
        ];

        $dats=[
            'vin'=>$_POST["vin"],
            'vinInfo'=>$vinModel->VinAgencia($filtro),
            'agencia'=>$trasladoModel->SelectAgencia()
        ];

        $dato=[
            'info'=>view("Traslado/CambioAgencia/ChangeAgencia/Index",$dats).view("Traslado/CambioAgencia/ChangeAgencia/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($dato);
        exit();
    }
}