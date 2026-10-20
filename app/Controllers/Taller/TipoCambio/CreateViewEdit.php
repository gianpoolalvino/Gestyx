<?php

namespace App\Controllers\Taller\TipoCambio;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\MarcaModel;
use App\Models\ModeloModel;
use App\Models\RepuestoModel;

class CreateViewEdit extends BaseController
{
    public function Create()
    {

        $send=[
            'status'=>'success',
            'info'=>view("Taller/TipoCambio/Create/Index").view("Taller/TipoCambio/Create/Scripts")
        ];

        echo json_encode($send);
        exit();
    }
}