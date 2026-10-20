<?php

namespace App\Controllers\AlistamientoVehicular\Lavado;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;

class CreateViewEdit extends BaseController
{

    public function DetailCreate()
    {
        $alistamientoVehicular=New AlistamientoVehicularModel();
        $vin=$_POST["vin"];

        $filtro=[
            'vin'=>$vin
        ];

        $detail=$alistamientoVehicular->DetailLavadoVin($filtro);

        $dato=[
            'detailLavado'=>$detail
        ];

        $send=[
            'info'=>view("AlistamientoVehicular/Lavado/DetailCreate/Index",$dato).view("AlistamientoVehicular/Lavado/DetailCreate/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($send);
        exit();
    }
    public function CopyFormulario($vin)
    {
        $alistamientoModel=New AlistamientoVehicularModel();

        $detailCampo=$alistamientoModel->TipoCampoLavado();
        foreach($detailCampo as $dcm){
            $insert=[
                'vin'=>$vin,
                'idcampoLavado'=>$dcm["idcampoLavado"],
                'idestadoLavado'=>1
            ];
            $storage=$alistamientoModel->CopyCampoLavado($insert);
        }

    }

    public function CreateLavado()
    {
        $alistamientoVehicular=New AlistamientoVehicularModel();

        $iddetalleLavado=$_POST["iddetalleLavado"];

        $filtro=[
            'iddetalleLavado'=>$iddetalleLavado
        ];

        $lavado=$alistamientoVehicular->DetailLavadoVin($filtro);

        $dato=[
            'iddetalleLavado'=>$iddetalleLavado,
            'vin'=>$lavado[0]["vin"],
            'tipoLavado'=>$lavado[0]["descripcion"]
        ];

        $send=[
            'info'=>view("AlistamientoVehicular/Lavado/CreateLavado/Index",$dato).view("AlistamientoVehicular/Lavado/CreateLavado/Scripts",$dato),
            'status'=>'success'
        ];
        echo json_encode($send);
        exit();
    }

    public function Create()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();
        $agenciaProveedor=new AgenciaProveedorModel();
        $vin=$_POST["vin"];
        $infoGen=$alistamientoVehicular->ViewVin($vin);

        $filtro=[
            'codigoAgencia'=>$infoGen[0]["codigoAgencia"]
        ];

        $filtro=[
            'vin'=>$vin
        ];

        $filtroEvento=[
            'idevento'=>3
        ];

        $event=$alistamientoVehicular->TipoProcesoEvento($filtroEvento);
        $detail=[];
        if($event[0]["idtipoFormulario"]==1){
            $viewLav=$alistamientoVehicular->DetailLavadoVin($filtro);
            if(!$viewLav){
                $stor=$this->CopyFormulario($vin);
            }
            $detail=$alistamientoVehicular->DetailLavadoVin($filtro);
        }

        $dats=[
            'infoVin'=>$alistamientoVehicular->ViewVin($vin),
            'proveedorLavado'=>$alistamientoVehicular->ProveedorLavado(),
            'detailLavado'=>$detail,
            'idtipoFormulario'=>$event[0]["idtipoFormulario"],
            'vin'=>$vin
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/Lavado/Create/Index",$dats).view("AlistamientoVehicular/Lavado/Create/Scripts")
        ];

        echo json_encode($dato);
        exit();
    }
}