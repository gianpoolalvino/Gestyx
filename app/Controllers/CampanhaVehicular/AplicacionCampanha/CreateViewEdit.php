<?php

namespace App\Controllers\CampanhaVehicular\AplicacionCampanha;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\CampanhaModel;

class CreateViewEdit extends BaseController
{
    public function AplicarCampanha()
    {
        $CampanhaModel=New CampanhaModel();
        $dats=[
            'selectCampanha'=>$CampanhaModel->Campanhas(),
            'selectEstado'=>$CampanhaModel->EstadoCampanha(),
            'vin'=>$_POST["vin"],
            'idcampanha'=>$_POST["idcampanha"],
            'idvinCampanha'=>$_POST["idvinCampanha"]
        ];
        $dato=[
            'info'=>view("CampanhaVehicular/AplicacionCampanha/AplicarCampanha/Index",$dats).view("CampanhaVehicular/AplicacionCampanha/AplicarCampanha/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($dato);
        exit();
    }
    public function CreateCampanha()
    {

        $dato=[
            'info'=>view("CampanhaVehicular/AplicacionCampanha/Campanha/Create/Index").view("CampanhaVehicular/AplicacionCampanha/Campanha/Create/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($dato);
        exit();
    }

    public function CreateAplicarCampanha()
    {
        $CampanhaModel=New CampanhaModel();
        $dats=[
            'selectCampanha'=>$CampanhaModel->Campanhas(),
            'selectEstado'=>$CampanhaModel->EstadoCampanha(),
            'vin'=>$_POST["vin"]
        ];
        $dato=[
            'info'=>view("CampanhaVehicular/AplicacionCampanha/Create/Index",$dats).view("CampanhaVehicular/AplicacionCampanha/Create/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($dato);
        exit();
    }
}