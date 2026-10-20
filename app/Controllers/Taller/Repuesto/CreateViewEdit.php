<?php

namespace App\Controllers\Taller\Repuesto;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\MarcaModel;
use App\Models\RepuestoModel;

class CreateViewEdit extends BaseController
{
    public function Create()
    {

        $marcaModel=New MarcaModel();

        $datos=[
            'selectMarca'=>$marcaModel->SelectMarca()
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Taller/Repuesto/Create/Index",$datos).view("Taller/Repuesto/Create/Scripts")
        ];

        echo json_encode($dato);
    }

    public function Delete()
    {
        $repuestoModelo=New RepuestoModel();

        $filtroRsp=[
            'idrepuesto'=>$_POST["idrepuesto"],
        ];
        $datos=[
            'repuesto'=>$repuestoModelo->View($filtroRsp)
        ];
        $dato=[
            'status'=>'success',
            'info'=>view("Taller/Repuesto/Delete/Index",$datos).view("Taller/Repuesto/Delete/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }

    public function ViewEdit()
    {
        $repuestoModelo=New RepuestoModel();
        $marcaModel=New MarcaModel();

        $filtroRsp=[
            'idrepuesto'=>$_POST["idrepuesto"],
        ];

        $datos=[
            'repuesto'=>$repuestoModelo->View($filtroRsp),
            'selectMarca'=>$marcaModel->SelectMarca()
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Taller/Repuesto/ViewEdit/Index",$datos).view("Taller/Repuesto/ViewEdit/Scripts")
        ];

        echo json_encode($dato);
    }
}