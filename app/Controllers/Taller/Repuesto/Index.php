<?php

namespace App\Controllers\Taller\Repuesto;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\RepuestoModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();
        $access=json_decode($tokenController->AccessRolUser(19,37,''));


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
        $repuestoModel = new RepuestoModel();
        $limit = 10;
        $start = 0;
        $finish = 10;
        $detail = $repuestoModel->DetailIndex('', '', $limit, $start);
        $co = $repuestoModel->CountDetail('', '');
        $countReg = 0;
        foreach ($detail as $dt) {
            $countReg++;

        }
        $dato = [
            'idgrupoModulo' => 19,
            'idmodulo' => 37,
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $co[0]["contadorTotal"],
            'countReg' => $countReg,

        ];
        echo view("Layouts/Head", $dato);
        echo view("Taller/Repuesto/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Taller/Repuesto/Index/Scripts");
    }

    public function DetailIndex()
    {
        $repuestoModel=New RepuestoModel();
        $idevento=1;
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$repuestoModel->CountDetail($tipoFiltro,$filtro);
        $detail=$repuestoModel->DetailIndex($tipoFiltro,$filtro,$limit,$start);
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
            'tbody'=>view("Taller/Repuesto/DetailIndex/Index",$dats).view("Taller/Repuesto/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();
    }
}