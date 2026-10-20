<?php

namespace App\Controllers\Inmatriculacion\SinExpediente;
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

        $access=json_decode($tokenController->AccessRolUser(7,17,''));


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
        $detail = $inmatriculacionModel->DetailIndexSinExpediente('', '',2, $limit, $start);
        $co = $inmatriculacionModel->CountDetailSinExpediente('', '',2);
        $countReg = 0;
        foreach ($detail as $dt) {
            $countReg++;
        }
        $dato = [
            'idgrupoModulo' => 7,
            'idmodulo' => 17,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $co[0]["contadorTotal"],
            'countReg' => $countReg
        ];
        echo view("Layouts/Head", $dato);
        echo view("Inmatriculacion/SinExpediente/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Inmatriculacion/SinExpediente/Index/Scripts");
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
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$inmatriculacionModel->CountDetailSinExpediente($tipoFiltro,$filtro,$estadoVin);
        $detail=$inmatriculacionModel->DetailIndexSinExpediente($tipoFiltro,$filtro,$estadoVin,$limit,$start);
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
            'tbody'=>view("Inmatriculacion/SinExpediente/DetailIndex/Index",$dats).view("Inmatriculacion/SinExpediente/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();
    }
}