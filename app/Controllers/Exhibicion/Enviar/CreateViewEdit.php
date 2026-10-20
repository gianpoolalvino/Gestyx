<?php

namespace App\Controllers\Exhibicion\Enviar;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ExhibicionModel;

class CreateViewEdit extends BaseController
{
    public function CreateSend()
    {
        $exhibicionModel=New ExhibicionModel();

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
            'eventos'=>$exhibicionModel->EventosRealizados($filtroVin),
            'equipamiento'=>$exhibicionModel->ViewDetailEquipamiento($filtroEqui),
            'viewExhibicion'=>$exhibicionModel->ViewExhibicion($filtroExhi)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Exhibicion/Enviar/Create/Index",$dato).view("Exhibicion/Enviar/Create/Scripts")
        ];

        echo json_encode($send);
        exit();
    }
}