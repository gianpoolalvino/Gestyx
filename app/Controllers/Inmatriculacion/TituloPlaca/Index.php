<?php

namespace App\Controllers\Inmatriculacion\TituloPlaca;
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

        $access=json_decode($tokenController->AccessRolUser(7,20,''));


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
        $inmatriculacionModel = new InmatriculacionModel();
        $idevento = 1;
        $limit = 10;
        $start = 0;
        $fechaOut=date("Y-m-d");
        $fechaIn=date('Y-m-d',strtotime('-1 months', strtotime($fechaOut)));
        $finish = 10;
        $detail = $inmatriculacionModel->DetailIndexTituloPlaca('', '',2,$fechaIn,$fechaOut);
        $co = $inmatriculacionModel->CountIndexTituloPlaca('', '',2,$fechaIn,$fechaOut);
        $countReg = 0;
        foreach ($detail as $dt) {
            $countReg++;
        }
        $dato = [
            'idgrupoModulo' => 7,
            'idmodulo' => 20,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $co[0]["contadorTotal"],
            'countReg' => $countReg
        ];
        echo view("Layouts/Head", $dato);
        echo view("Inmatriculacion/TituloPlaca/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Inmatriculacion/TituloPlaca/Index/Scripts");
    }

    public function DetailIndex()
    {
        $inmatriculacionModel = new InmatriculacionModel();
        $idevento=1;
        $limit=10;
        $countRegv2=$_POST["countReg"];
        $fechaInicio=$_POST["fechaInicio"];
        $fechaFin=$_POST["fechaFin"];
        $filtro=$_POST["filtro"];
        $estadoVin=$_POST["estadoVin"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$inmatriculacionModel->CountIndexTituloPlaca($tipoFiltro,$filtro,$estadoVin,$fechaInicio,$fechaFin);
        $detail=$inmatriculacionModel->DetailIndexTituloPlaca($tipoFiltro,$filtro,$estadoVin,$fechaInicio,$fechaFin);
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
            'tbody'=>view("Inmatriculacion/TituloPlaca/DetailIndex/Index",$dats).view("Inmatriculacion/TituloPlaca/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();
    }
}