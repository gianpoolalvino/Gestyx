<?php

namespace App\Controllers\EquipamientoAdicional\ConversionGas;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\EquipamientoAdicionalModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(14,21,''));


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
        $equipamientoAdicional=new EquipamientoAdicionalModel();
        $idevento=10;
        $limit=10;
        $start=0;
        $finish=10;
        $detail=$equipamientoAdicional->DetailIndex($idevento,'','',$limit,$start);
        $co=$equipamientoAdicional->CountRegistro($idevento,'','');
        $countReg=0;
        foreach($detail as $dt){
            $countReg++;
        }
        $dato=[
            'idgrupoModulo'=>14,
            'idmodulo'=>21,
            'detailIndex'=>$detail,
            'finish'=>$start,
            'count'=>$co[0]["contadorTotal"],
            'countReg'=>$countReg
        ];
        echo view("Layouts/Head",$dato);
        echo view("EquipamientoAdicional/ConversionGas/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("EquipamientoAdicional/ConversionGas/Index/Scripts");
    }

    public function DetailIndex()
    {
        $equipamientoAdicional=new EquipamientoAdicionalModel();
        $idevento=10;
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$equipamientoAdicional->CountRegistro($idevento,$tipoFiltro,$filtro);
        $detail=$equipamientoAdicional->DetailIndex($idevento,$tipoFiltro,$filtro,$limit,$start);
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
            'tbody'=>view("EquipamientoAdicional/ConversionGas/DetailIndex/Index",$dats).view("EquipamientoAdicional/ConversionGas/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();

    }
}
