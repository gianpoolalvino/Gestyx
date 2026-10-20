<?php

namespace App\Controllers\Inmatriculacion\SinPlaca;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\InmatriculacionModel;

class CreateViewEdit extends BaseController
{
    public function Create()
    {
        $vin = $_POST["vin"];
        $inmatriculacionModel = new InmatriculacionModel();
        $dats = [
            'vin' => $vin
        ];

        $dato = [
            'status' => 'success',
            'info' => view("Inmatriculacion/SinPlaca/Create/Index", $dats) . view("Inmatriculacion/SinPlaca/Create/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }
}