<?php

namespace App\Controllers\Taller\Modelo;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\CargaMasivaModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\MarcaModel;
use App\Models\ModeloModel;
use App\Models\RepuestoModel;

class CreateViewEdit extends BaseController
{
    public function CreateModeloMasivo()
    {
        $marcaModel=New MarcaModel();

        $datos=[
            'selectMarca'=>$marcaModel->SelectMarca()
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Taller/Modelo/ProcesoMasivo/Index",$datos).view("Taller/Modelo/ProcesoMasivo/Scripts")
        ];

        echo json_encode($dato);
    }


    public function CargaMasivaPlanesMto()
    {
        $modeloModel=New ModeloModel();
        $marcaModel=New MarcaModel();

        $datos=[
            'selectMarca'=>$marcaModel->SelectMarca()
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Taller/Modelo/CargaMasiva/Index",$datos).view("Taller/Modelo/CargaMasiva/Scripts")
        ];

        echo json_encode($dato);
    }

    public function Delete()
    {
        $modeloModel=New ModeloModel();

        $filtroRsp=[
            'idmodelo'=>$_POST["idmodelo"],
        ];
        $datos=[
            'idmodelo'=>$_POST["idmodelo"],
            'modelo'=>$modeloModel->ViewModelo($filtroRsp)
        ];
        $dato=[
            'status'=>'success',
            'info'=>view("Taller/Modelo/Delete/Index",$datos).view("Taller/Modelo/Delete/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }

    public function Create()
    {
        $marcaModel=New MarcaModel();

        $datos=[
            'selectMarca'=>$marcaModel->SelectMarca()
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Taller/Modelo/Create/Index",$datos).view("Taller/Modelo/Create/Scripts")
        ];

        echo json_encode($dato);
    }
}