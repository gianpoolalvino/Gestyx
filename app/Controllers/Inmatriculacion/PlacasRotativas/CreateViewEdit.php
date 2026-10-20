<?php

namespace App\Controllers\Inmatriculacion\PlacasRotativas;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\GeneralesModel;
use App\Models\InmatriculacionModel;
use App\Models\TrasladoModel;
use App\Models\UsuarioModel;
use App\Models\VinModel;

class CreateViewEdit extends BaseController
{
    public function Create()
    {
        $generalModel=New GeneralesModel();
        $usuarioModel=New UsuarioModel();

        $dato=[
            'empresa'=>$usuarioModel->SelectEmpresa()
        ];

        $send=[
            'info'=>view('Inmatriculacion/PlacasRotativas/Create/Index',$dato).view('Inmatriculacion/PlacasRotativas/Create/Scripts'),
            'status'=>'success',
            'title'=>'Interface Cargada',
            'message'=>'La interface se cargo correctamente'
        ];

        echo json_encode($send);
        exit();
    }

    public function SelectVin()
    {
        $inmatriculacionModel=new InmatriculacionModel();
        $search=$_POST["query"];

        $selectVin=$inmatriculacionModel->VehiculosSinPlaca($search);


        $principal='';
        foreach($selectVin as $sr){
            $principal.='<div class="result-item" data-vin="'.$sr["vin"].'">' .$sr['vin'].' - '.$sr["marca"].' - '.$sr["modelo"]. '<br>'.$sr["documentoCliente"].' - '.$sr["nombreCliente"].'</div>';
        }

        $send=[
            'info'=>$principal
        ];

        echo json_encode($send);
        exit();
    }

    public function ViewEdit()
    {
        $inmatriculacionModel=new InmatriculacionModel();

        $filtro=[
            'idplacaRotativa'=>$_POST['idplacaRotativa'],
        ];

        $dato=[
            'placa'=>$inmatriculacionModel->ViewPlacaRotativa($filtro)
        ];

        $send=[
            'info'=>view("Inmatriculacion/PlacasRotativas/ViewEdit/Index",$dato).view("Inmatriculacion/PlacasRotativas/ViewEdit/Scripts"),
            'status'=>'success',
            'title'=>'Interface Cargada',
            'message'=>'La interface se cargo correctamente'
        ];
        echo json_encode($send);
        exit();
    }

    public function SelectRegion()
    {
        $GeneralModel=New GeneralesModel();

        $principal='';
        $filtroEmp=[
            'idempresa'=>$_POST["empresa"]
        ];
        $detail=$GeneralModel->SelectGrupoUbicacion($filtroEmp);

        foreach($detail as $dt){
            $principal.='<option value="'.$dt["idgrupoUbicacion"].'">'.$dt["descripcion"].'</option>';
        }
        $send=[
            'info'=>$principal,
            'status'=>'success',
            'title'=>'',
            'message'=>''
        ];

        echo json_encode($send);
        exit();

    }
}