<?php

namespace App\Controllers\Inmatriculacion\SinPlaca;
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

        $access=json_decode($tokenController->AccessRolUser(7,19,''));


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
        $detail = $inmatriculacionModel->DetailIndexSinPlaca('', '',2, $limit, $start);

        $dato = [
            'idgrupoModulo' => 7,
            'idmodulo' => 19,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => 0,
            'countReg' => 0
        ];
        echo view("Layouts/Head", $dato);
        echo view("Inmatriculacion/SinPlaca/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Inmatriculacion/SinPlaca/Index/Scripts");
    }

    public function DetailIndex()
    {
        $inmatriculacionModel = new InmatriculacionModel();
        $idevento=1;
        $limit=10;
        $countRegv2=$_POST["countReg"];
        $estadoVin=$_POST["estadoVin"];
        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;

        $detail=$inmatriculacionModel->DetailIndexSinPlaca($tipoFiltro,$filtro,$estadoVin,$limit,$start);
        $cnt=0;


        $countReg=$cnt+$countRegv2;

        $dats=[
            'detailIndex'=>$detail,
            'countReg'=>$countRegv2,
        ];

        $dato=[
            'tbody'=>view("Inmatriculacion/SinPlaca/DetailIndex/Index",$dats).view("Inmatriculacion/SinPlaca/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>0,
        ];

        echo json_encode($dato);
        exit();
    }
}