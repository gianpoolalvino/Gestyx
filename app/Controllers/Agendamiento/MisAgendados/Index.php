<?php

namespace App\Controllers\Agendamiento\MisAgendados;
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

        $access=json_decode($tokenController->AccessRolUser(5,28,''));


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
        $idasesor=session("idusuario");
        $tipC=$generalModel->RequeridoSalida();
        $tipoCartera=$tipC[0]["requeridoEntrega"];
        $detail=$agendamiento->DetailCitaMisAgendados('','',$limit,$start,$idasesor);

        $dato=[
            'idgrupoModulo'=>5,
            'idmodulo'=>28,
            'asesorEntrega'=>$asesores,
            'requeridoEntrega'=>$tipoCartera,
            'detailIndex'=>$detail,
            'finish'=>$start,
            'count'=>0,
            'countReg'=>0
        ];

        echo view("Layouts/Head",$dato);
        echo view("Agendamiento/MisAgendados/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("Agendamiento/MisAgendados/Index/Scripts",$dato);
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
        $idasesor=session("idusuario");
        $tipC=$generalModel->RequeridoSalida();
        $tipoCartera=$tipC[0]["requeridoEntrega"];
        $detail=$agendamiento->DetailCitaMisAgendados($tipoFiltro,$filtro,$limit,$start,$idasesor);


        $dats=[
            'detailIndex'=>$detail,
            'countReg'=>$countRegv2,
            'requeridoEntrega'=>$tipoCartera,
        ];

        $dato=[
            'tbody'=>view("Agendamiento/MisAgendados/DetailIndex/Index",$dats).view("Agendamiento/MisAgendados/DetailIndex/Scripts"),
            'countReg'=>0,
            'start'=>$finish,
            'total'=>0,
        ];

        echo json_encode($dato);
        exit();

    }
}