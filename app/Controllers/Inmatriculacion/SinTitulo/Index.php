<?php

namespace App\Controllers\Inmatriculacion\SinTitulo;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\InmatriculacionModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(7,18,''));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }
        $inmatriculacionModel = new InmatriculacionModel();
        $idevento = 1;
        $limit = 10;
        $start = 0;
        $finish = 10;
        $detail = $inmatriculacionModel->DetailIndexTitulo('', '',2, $limit, $start);
      //  $co = $inmatriculacionModel->CountDetailSinTitulo('', '',2);

        $dato = [
            'idgrupoModulo' => 7,
            'idmodulo' => 18,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => '',
            'countReg' => ''
        ];
        echo view("Layouts/Head", $dato);
        echo view("Inmatriculacion/SinTitulo/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Inmatriculacion/SinTitulo/Index/Scripts");
    }

    public function DetailIndex()
    {
        $inmatriculacionModel = new InmatriculacionModel();
        $idevento=1;
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $estadoVin=$_POST["estadoVin"];
        $start=0;
        $finish=0;
      //  $co=$inmatriculacionModel->CountDetailSinTitulo($tipoFiltro,$filtro,$estadoVin);
        $detail=$inmatriculacionModel->DetailIndexTitulo($tipoFiltro,$filtro,$estadoVin,$limit,$start);

        $dats=[
            'detailIndex'=>$detail
        ];

        $dato=[
            'tbody'=>view("Inmatriculacion/SinTitulo/DetailIndex/Index",$dats).view("Inmatriculacion/SinTitulo/DetailIndex/Scripts"),
            'countReg'=>'',
            'start'=>'',
            'total'=>'',
        ];

        echo json_encode($dato);
        exit();
    }
}