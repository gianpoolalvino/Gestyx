<?php

namespace App\Controllers\Inmatriculacion\SinTitulo;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\InmatriculacionModel;

class CreateViewEdit extends BaseController
{
    public function CreateObservacion()
    {
        $inmatriculacionModel=new InmatriculacionModel();

        $dato=[
            'status'=>'success',
            'info'=>view("Inmatriculacion/SinTitulo/CreateObservacion/Index").view("Inmatriculacion/SinTitulo/CreateObservacion/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }
    public function Create()
    {
        $vin=$_POST["vin"];
        $inmatriculacionModel=New InmatriculacionModel();
        $dats=[
            'vin'=>$vin
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Inmatriculacion/SinTitulo/Create/Index",$dats).view("Inmatriculacion/SinTitulo/Create/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }

    public function CreateTacha()
    {
        $inmatriculacionModel=new InmatriculacionModel();

        $dato=[
            'status'=>'success',
            'info'=>view("Inmatriculacion/SinTitulo/CreateTacha/Index").view("Inmatriculacion/SinTitulo/CreateTacha/Scripts")
        ];
        echo json_encode($dato);
        exit();

    }

    public function TitulosVigentes()
    {
        $inmatriculacionModel=new InmatriculacionModel();

        $vin=$_POST["vin"];
        $titulo=$_POST["titulo"];

        $dats=[
            'vins'=>$inmatriculacionModel->SelectVinsTacha($vin,$titulo)
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Inmatriculacion/SinTitulo/Vins/Index",$dats).view("Inmatriculacion/SinTitulo/Vins/Scripts")
        ];

        echo json_encode($dato);
        exit();

    }
}