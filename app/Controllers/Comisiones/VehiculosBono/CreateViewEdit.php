<?php

namespace App\Controllers\Comisiones\VehiculosBono;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ComisionModel;
use App\Models\MarcaModel;

class CreateViewEdit extends BaseController
{
    public function CargaExcelBono()
    {
        $marcaModel=New MarcaModel();

        $dato=[
            'selectMarca'=>$marcaModel->SelectMarca()
        ];
        $send=[
            'status'=>'success',
            'info'=>view('Comisiones/VehiculosBono/CargaExcelBono/Index',$dato).view('Comisiones/VehiculosBono/CargaExcelBono/Scripts')
        ];

        echo json_encode($send);
    }
}