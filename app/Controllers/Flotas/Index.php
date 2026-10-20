<?php

namespace App\Controllers\Flotas;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EntregadoModel;
use App\Models\ExhibicionModel;
use App\Models\VehiculosVendidosModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Index extends BaseController
{
    public function Index()
    {

        $dato=[
            'idgrupoModulo'=>11,
            'idmodulo'=>0,
        ];
        echo view("Layouts/Head",$dato);
        echo view("Flotas/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("Flotas/Index/Scripts");
    }
}