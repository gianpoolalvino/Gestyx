<?php

namespace App\Controllers\CampanhaVehicular\RevisionCampanha;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\CampanhaModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(16,23,''));


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
        $alistamientoVehicular = new CampanhaModel();
        $idevento = 3;
        $limit = 10;
        $start = 0;
        $finish = 10;
        $detail = $alistamientoVehicular->DetailIndexRevision( '','', '', $limit, $start);
        $co = $alistamientoVehicular->CountDetailRevision( '','', '');
        $countReg = 0;
        foreach ($detail as $dt) {
            $countReg++;
        }
        $dato = [
            'idgrupoModulo' => 16,
            'idmodulo' => 23,
            'detailIndex' => $detail,
            'finish' => $start,
            'selectCampanha'=>$alistamientoVehicular->Campanhas(),
            'count' => $co[0]["contadorTotal"],
            'countReg' => $countReg
        ];
        echo view("Layouts/Head", $dato);
        echo view("CampanhaVehicular/RevisionCampanha/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("CampanhaVehicular/RevisionCampanha/Index/Scripts");
    }

    public function DetailIndexFiltro()
    {
        $alistamientoVehicular=new CampanhaModel();
        $limit=10;
        $countRegv2=$_POST["countReg"];
        $campanha=$_POST["campanha"];
        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$alistamientoVehicular->CountDetailRevision($campanha,$tipoFiltro,$filtro);
        $detail=$alistamientoVehicular->DetailIndexRevisionFiltro($campanha,$tipoFiltro,$filtro,$limit,$start);
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
            'tbody'=>view("CampanhaVehicular/RevisionCampanha/DetailIndex/Index",$dats).view("CampanhaVehicular/RevisionCampanha/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();
    }

    public function DetailIndex()
    {
        $alistamientoVehicular=new CampanhaModel();
        $limit=10;
        $countRegv2=$_POST["countReg"];
        $campanha=$_POST["campanha"];
        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$alistamientoVehicular->CountDetailRevision($campanha,$tipoFiltro,$filtro);
        $detail=$alistamientoVehicular->DetailIndexRevision($campanha,$tipoFiltro,$filtro,$limit,$start);
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
            'tbody'=>view("CampanhaVehicular/RevisionCampanha/DetailIndex/Index",$dats).view("CampanhaVehicular/RevisionCampanha/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();
    }
}