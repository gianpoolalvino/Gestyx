<?php

namespace App\Controllers\Traslado\GuiasTraslados;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\TrasladoModel;


class Index extends BaseController
{
    public function Index()
    {
        $trasladoModel=New TrasladoModel();
        $limit = 10;
        $start = 0;
        $finish = 10;
        $dato = [
            'idgrupoModulo' => 18,
            'idmodulo' => 54,
            'finish' => $start,
        ];
        echo view("Layouts/Head", $dato);
        echo view("Traslado/GuiasTraslados/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Traslado/GuiasTraslados/Index/Scripts");
    }
}