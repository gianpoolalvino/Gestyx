<?php

namespace App\Controllers\Exhibicion\Preparando;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ExhibicionModel;
use App\Models\VinModel;

class CreateViewEdit extends BaseController
{
    public function CreateRetorno()
    {
        $exhibicionModel=New ExhibicionModel();
        $vinModel=New VinModel();

        $idexhibicionVin=$_POST["idexhibicionVin"];
        $vin=$_POST["vin"];

        $filtroExhi=[
            'vin'=>$vin,
            'idexhibicionVin'=>$idexhibicionVin
        ];

        $filtroVin=[
            'vin'=>$vin
        ];

        $filtroEqui=[
            'vin'=>$vin,
            'idexhibicionVin'=>$idexhibicionVin,
            'eliminado'=>null
        ];

        $dato=[
            'idexhibicionVin'=>$idexhibicionVin,
            'vin'=>$vin,
            'vinInfo'=>$vinModel->VinInfo($vin),
            'eventos'=>$exhibicionModel->EventosRealizados($filtroVin),
            'equipamiento'=>$exhibicionModel->ViewDetailEquipamiento($filtroEqui),
            'viewExhibicion'=>$exhibicionModel->ViewExhibicion($filtroExhi)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Exhibicion/Preparando/Create/Index",$dato).view("Exhibicion/Preparando/Create/Scripts")
        ];

        echo json_encode($send);
        exit();
    }
}