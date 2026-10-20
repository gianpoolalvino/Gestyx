<?php

namespace App\Controllers\Agendamiento\Agendados;
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

        $access=json_decode($tokenController->AccessRolUser(5,27,''));


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
        $asesores=$agendamiento->AsesorEntrega();
        $generalModel=New GeneralesModel();
        $limit=10;
        $start=0;
        $finish=10;

        $tipC=$generalModel->RequeridoSalida();
        $tipoCartera=$tipC[0]["requeridoEntrega"];

        $detail=$agendamiento->DetailCitaAgendado('','',$limit,$start);

        $dato=[
            'idgrupoModulo'=>5,
            'idmodulo'=>27,
            'requeridoEntrega'=>$tipoCartera,
            'asesorEntrega'=>$asesores,
            'detailIndex'=>$detail,
            'finish'=>$start,
            'count'=>0,
            'countReg'=>0
        ];

        echo view("Layouts/Head",$dato);
        echo view("Agendamiento/Agendados/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("Agendamiento/Agendados/Index/Scripts",$dato);
    }

    public function DetailIndex()
    {
        $agendamiento=New AgendamientoModel();
        $generalModel=New GeneralesModel();
        $idevento=1;
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $tipC=$generalModel->RequeridoSalida();
        $tipoCartera=$tipC[0]["requeridoEntrega"];

        $detail=$agendamiento->DetailCitaAgendado($tipoFiltro,$filtro,$limit,$start);


        $dats=[
            'requeridoEntrega'=>$tipoCartera,
            'detailIndex'=>$detail,
            'countReg'=>0,
        ];

        $dato=[
            'tbody'=>view("Agendamiento/Agendados/DetailIndex/Index",$dats).view("Agendamiento/Agendados/DetailIndex/Scripts"),
            'countReg'=>0,
            'start'=>$finish,
            'total'=>0,
        ];

        echo json_encode($dato);
        exit();

    }
}