<?php

namespace App\Controllers\TestBateria\RegistroTestBateria;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\BateriaModel;
use App\Models\VehiculosVendidosModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use function PHPUnit\Framework\isNull;

class CreateViewEdit extends BaseController
{
    public function ViewTest()
    {
        $baerialModel=New BateriaModel();
        $vin=$_POST['vin'];
        $idbateriaTest=$_POST['idbateriaTest'];

        $filtro=[
            'vin'=>$vin,
            'idbateriaTest'=>$idbateriaTest
        ];

        $dato=[
            'vin'=>$vin,
            'infoBateria'=>$baerialModel->ViewVinTestBateria($filtro)
        ];

        $send=[
            'info'=>view('TestBateria/RegistroTestBateria/ViewTest/Index',$dato).view('TestBateria/RegistroTestBateria/ViewTest/Scripts'),
            'status'=>'success',
        ];

        echo json_encode($send);
        exit();
    }
}