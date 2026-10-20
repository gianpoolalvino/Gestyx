<?php

namespace App\Controllers\Traslado\CambioAgencia;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\TrasladoModel;


class Index extends BaseController
{
    public function Index()
    {

        $tokenController=New Tokens();
        $access=json_decode($tokenController->AccessRolUser(18,32,''));


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

        $trasladoModel=New TrasladoModel();
        $limit = 10;
        $start = 0;
        $finish = 10;
        $detail = $trasladoModel->DetailCambioAgencia('', '', $limit, $start);
        $co = $trasladoModel->CountCambioAgencia('', '');
        $countReg = 0;
        foreach ($detail as $dt) {
            $countReg++;

        }
        $dato = [
            'idgrupoModulo' => 18,
            'idmodulo' => 32,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $co[0]["contadorTotal"],
            'countReg' => $countReg
        ];
        echo view("Layouts/Head", $dato);
        echo view("Traslado/CambioAgencia/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Traslado/CambioAgencia/Index/Scripts");
    }

    public function DetailIndex()
    {
        $trasladoModel=New TrasladoModel();
        $idevento=1;
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$trasladoModel->CountCambioAgencia($tipoFiltro,$filtro);
        $detail=$trasladoModel->DetailCambioAgencia($tipoFiltro,$filtro,$limit,$start);
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
            'tbody'=>view("Traslado/CambioAgencia/DetailIndex/Index",$dats).view("Traslado/CambioAgencia/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();
    }
}