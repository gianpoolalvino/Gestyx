<?php

namespace App\Controllers\Agendamiento\ListosParaAgendar;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\GeneralesModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(5,31,''));


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
        $agendamiento=New AgendamientoModel();
        $generalModel=New GeneralesModel();
        $limit=10;
        $start=0;
        $finish=10;

        $tipC=$generalModel->RequeridoSalida();
        $tipoCartera=$tipC[0]["requeridoAgendamiento"];
        $detail=$agendamiento->DetailListosParaAgendar('','',$limit,$start,$tipoCartera);
        $co=$agendamiento->CountRegListosParaAgendar('','',$tipoCartera);
        $countReg=0;
        foreach($detail as $dt){
            $countReg++;
        }
        $dato=[
            'idgrupoModulo'=>5,
            'idmodulo'=>31,
            'detailIndex'=>$detail,
            'finish'=>$start,
            'count'=>$co[0]["contadorTotal"],
            'countReg'=>$countReg
        ];
        echo view("Layouts/Head",$dato);
        echo view("Agendamiento/ListosParaAgendar/Index/Index");
        echo view("Layouts/Footer");
        echo view("Agendamiento/ListosParaAgendar/Index/Scripts");
    }

    public function DetailIndex()
    {
        $agendamiento=new AgendamientoModel();
        $generalModel=New GeneralesModel();
        $idevento=1;
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $tipC=$generalModel->RequeridoSalida();
        $tipoCartera=$tipC[0]["requeridoAgendamiento"];
        $detail=$agendamiento->DetailListosParaAgendar($tipoFiltro,$filtro,$limit,$start,$tipoCartera);
        $co=$agendamiento->CountRegListosParaAgendar($tipoFiltro,$filtro,$tipoCartera);
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
            'tbody'=>view("Agendamiento/ListosParaAgendar/DetailIndex/Index",$dats).view("Agendamiento/ListosParaAgendar/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();
    }
}