<?php

namespace App\Controllers\ControlSalidaVehicular\ReporteLiberado;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlSalidaVehicular;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(9,11,''));


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
        date_default_timezone_set("America/Lima");
        $fechaInicio=date("Y-m-d");
        $fechaFin=date("Y-m-d");
        $controlVehicular = new ControlSalidaVehicular();
        $idevento = 1;
        $limit = 10;
        $start = 0;
        $finish = 10;
        $detail = $controlVehicular->DetailIndexReport('', '',$fechaInicio,$fechaFin,$limit, $start);
        $co = $controlVehicular->CountRegistroReport('', '',$fechaInicio,$fechaFin);
        $countReg=0;
        foreach($detail as $dt){
            $countReg++;
        }
        $dato = [
            'idgrupoModulo' => 9,
            'idmodulo' => 11,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $co[0]["contadorTotal"],
            'countReg' => $countReg
        ];
        echo view("Layouts/Head", $dato);
        echo view("ControlSalidaVehicular/ReporteLiberado/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("ControlSalidaVehicular/ReporteLiberado/Index/Scripts");
    }

    public function DetailIndex()
    {
        $controlVehicular=new ControlSalidaVehicular();
        $idevento=1;
        $limit=10;
        $countRegv2=$_POST["countReg"];
        $fechaInicio=$_POST["fechaInicio"];
        $fechaFin=$_POST["fechaFin"];
        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$controlVehicular->CountRegistroReport($tipoFiltro,$filtro,$fechaInicio,$fechaFin);
        $detail=$controlVehicular->DetailIndexReport($tipoFiltro,$filtro,$fechaInicio,$fechaFin,$limit,$start);
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
            'tbody'=>view("ControlSalidaVehicular/ReporteLiberado/DetailIndex/Index",$dats).view("ControlSalidaVehicular/ReporteLiberado/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();
    }
}