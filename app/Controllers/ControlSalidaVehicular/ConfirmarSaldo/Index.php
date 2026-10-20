<?php

namespace App\Controllers\ControlSalidaVehicular\ConfirmarSaldo;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlSalidaVehicular;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(9,10,''));


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
        $controlVehicular=new ControlSalidaVehicular();
        $limit=10;
        $start=0;
        $finish=10;
        $detail=$controlVehicular->DetailIndex('','',$limit,$start);
        $co=$controlVehicular->CountRegistro('','');
        $countReg=0;
        foreach($detail as $dt){
            $countReg++;

        }
        $dato=[
            'idgrupoModulo'=>9,
            'idmodulo'=>10,
            'detailIndex'=>$detail,
            'finish'=>$start,
            'count'=>$co[0]["contadorTotal"],
            'countReg'=>$countReg
        ];
        echo view("Layouts/Head",$dato);
        echo view("ControlSalidaVehicular/ConfirmarSaldo/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("ControlSalidaVehicular/ConfirmarSaldo/Index/Scripts");
    }

    public function DetailIndex()
    {
        $controlVehicular=new ControlSalidaVehicular();
        $idevento=1;
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$controlVehicular->CountRegistro($tipoFiltro,$filtro);
        $detail=$controlVehicular->DetailIndex($tipoFiltro,$filtro,$limit,$start);
        $cnt=0;
        foreach($detail as $dt){
            $cnt=$cnt+1;
        }
        $countReg=$cnt+$countRegv2;

        $dats=[
            'detailIndex'=>$detail,
            'countReg'=>$countRegv2,
        ];

        $dato=[
            'tbody'=>view("ControlSalidaVehicular/ConfirmarSaldo/DetailIndex/Index",$dats).view("ControlSalidaVehicular/ConfirmarSaldo/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();

    }
}