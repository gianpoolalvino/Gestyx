<?php

namespace App\Controllers\ControlDemos\DemosDisponibles;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(15,13,''));


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
        $controlDemos=New ControlDemosModel();
        $idevento = 1;
        $limit = 10;
        $start = 0;
        $finish = 10;
        $detail = $controlDemos->DetailIndex( '', '', $limit, $start);
        $co = $controlDemos->CountRegistro( '', '');
        $countReg = 0;
        foreach ($detail as $dt) {
            $countReg++;
        }
        $dato = [
            'idgrupoModulo' => 15,
            'idmodulo' => 13,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $co[0]["contadorTotal"],
            'countReg' => $countReg
        ];
        echo view("Layouts/Head", $dato);
        echo view("ControlDemos/DemosDisponibles/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("ControlDemos/DemosDisponibles/Index/Scripts");
    }

    public function DetailIndex()
    {
        $controlDemos=New ControlDemosModel();
        $idevento=1;
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$controlDemos->CountRegistro($tipoFiltro,$filtro);
        $detail=$controlDemos->DetailIndex($tipoFiltro,$filtro,$limit,$start);
        $cnt=0;
        foreach($detail as $dt){
            $cnt++;
        }

        $countReg=$cnt+$countRegv2;

        $dats=[
            'detailIndex'=>$detail,
            'countReg'=>$countRegv2,
        ];

        $dato=[
            'tbody'=>view("ControlDemos/DemosDisponibles/DetailIndex/Index",$dats).view("ControlDemos/DemosDisponibles/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();
    }
}