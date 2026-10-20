<?php

namespace App\Controllers\ControlDemos\DemosPorEntregar;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;

class CreateViewEdit extends BaseController
{
    public function Create()
    {
        $vin=$_POST["vin"];
        $idliberacionDemo=$_POST["idliberacionDemo"];
        $idasignarDemo=$_POST["idasignarDemo"];
        $controlDemos=New ControlDemosModel();

        $filtro=[
            'idasignarDemo'=>$idasignarDemo,
            'vin'=>$vin
        ];

        $dats=[
            'vin'=>$vin,
            'tipoDemo'=>$controlDemos->TipoDemo(),
            'inventarioDemo'=>$controlDemos->InventarioDemo(),
            'infoAsignarDemo'=>$controlDemos->ViewDemoAsignadoPdf($filtro),
            'idasignarDemo'=>$idasignarDemo,
            'idliberacionDemo'=>$idliberacionDemo,
            'hora'=>$controlDemos->Hora(),
            'infoLiberacion'=>$controlDemos->ViewDemoLiberado($idliberacionDemo)
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("ControlDemos/DemosPorEntregar/Create/Index",$dats).view("ControlDemos/DemosPorEntregar/Create/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }
}