<?php

namespace App\Controllers\Comisiones\PagoComisiones;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\MarcaModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class CreateViewEdit extends BaseController
{
    public function Create()
    {
        $marcaModel=New MarcaModel();
        $dat=[
            'selectMarca'=>$marcaModel->SelectMarca()
        ];
        $dato=[
            'info'=>view("Comisiones/PagoComisiones/Create/Index",$dat).view("Comisiones/PagoComisiones/Create/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($dato);
        exit();
    }
}