<?php

namespace App\Controllers\Agendamiento\NuevaAgenda;
use App\Controllers\BaseController;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\GeneralesModel;

class Index extends BaseController
{
    public function Index()
    {
        $dato=[
            'idgrupoModulo'=>5,
            'idmodulo'=>76
        ];

        echo view("Layouts/Head",$dato);
        echo view("Agendamiento/NuevaAgenda/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("Agendamiento/NuevaAgenda/Index/Scripts",$dato);
    }
}