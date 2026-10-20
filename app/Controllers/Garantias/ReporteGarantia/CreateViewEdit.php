<?php

namespace App\Controllers\Garantias\ReporteGarantia;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\GarantiaModel;
use App\Models\InmatriculacionModel;
use App\Models\VinModel;

class CreateViewEdit extends BaseController
{
    public function CreateReporte()
    {
        $vinModel=New VinModel();
        $garantiaModel=New GarantiaModel();

        $vins=$vinModel->VinPermitidos();

        $dats=[
            'vins'=>$vins,
            'tipoReporte'=>$garantiaModel->TipoReporte()
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Garantia/ReporteGarantia/CreateReporte/Index",$dats).view("Garantia/ReporteGarantia/CreateReporte/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }
}