<?php

namespace App\Controllers\Comisiones\ReglaComision;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ComisionModel;
use App\Models\MarcaModel;
use App\Models\ModeloModel;

class CreateViewEdit extends BaseController
{
    public function DetailIndexCategoria()
    {
        $comisionModel=New ComisionModel();
        $idreglaComisionVentaVehiculo=$_POST["idreglaComisionVentaVehiculo"];

        $filtro=[
            'idreglaComisionVentaVehiculo'=>$idreglaComisionVentaVehiculo
        ];

        $dato=[
            'detailIndex'=>$comisionModel->DetailCategoria($filtro)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Comisiones/ReglaComision/DetailIndexCategoria/Index",$dato).view("Comisiones/ReglaComision/DetailIndexCategoria/Scripts")
        ];

        echo json_encode($send);
    }

    public function Create()
    {
        $comisionModel=new ComisionModel();
        $marcaModel=New MarcaModel();
        $dat=[
            'selectMarca'=>$marcaModel->SelectMarca()
        ];

        $comi=[
            'idusuarioCrea'=>session("idusuario"),
            'estado'=>4
        ];
        $destroy=$comisionModel->DestroyRegla($comi);

        $idregla=$comisionModel->StorageRegla($comi);

        if($idregla){
            $dat+=[
                'idreglaComisionVentaVehiculo'=>$idregla
            ];
            $info=[
                'info'=>view("Comisiones/ReglaComision/Create/Index",$dat).view("Comisiones/ReglaComision/Create/Scripts"),
                'status'=>'success',
            ];
            echo json_encode($info);
            exit();
        }else{
            $info=[
                'status'=>'danger',
                'title'=>'Ocurrio un error',
                'message'=>'Ocurrio un error durante la carga de interface reintente'
            ];
            echo json_encode($info);
            exit();
        }

    }

    public function DetailIndexConcepto()
    {
        $comisionModel=New ComisionModel();
        $idreglaComisionVentaVehiculo=$_POST["idreglaComisionVentaVehiculo"];

        $filtro=[
            'idreglaComisionVentaVehiculo'=>$idreglaComisionVentaVehiculo
        ];

        $dato=[
            'detail'=>$comisionModel->DetailReglaVentaVehiculo($filtro)
        ];

        $send=[
            'info'=>view("Comisiones/ReglaComision/DetailIndexConcepto/Index",$dato).view("Comisiones/ReglaComision/DetailIndexConcepto/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();
    }

    public function CreateConcepto()
    {
        $idreglaComisionVentaVehiculo=$_POST["idreglaComisionVentaVehiculo"];

        $dato=[
            'idreglaComisionVentaVehiculo'=>$idreglaComisionVentaVehiculo
        ];

        $send=[
            'info'=>view("Comisiones/ReglaComision/CreateConcepto/Index",$dato).view("Comisiones/ReglaComision/CreateConcepto/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();
    }
}