<?php

namespace App\Controllers\Taller\Modelo;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\MarcaModel;
use App\Models\ModeloModel;
use App\Models\RepuestoModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();
        $access=json_decode($tokenController->AccessRolUser(19,38,''));


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

        $marcaModel=new MarcaModel();
        $modeloModel=new ModeloModel();
        $limit = 10;
        $start = 0;
        $finish = 10;
        $detail = $modeloModel->DetailIndex('', '', $limit, $start);
        $co = $modeloModel->CountDetail('', '');
        $countReg = 0;
        foreach ($detail as $dt) {
            $countReg++;
        }

        $dato = [
            'idgrupoModulo' => 19,
            'idmodulo' => 38,
            'selectMarca'=>$marcaModel->SelectMarca(),
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $co[0]["contadorTotal"],
            'countReg' => $countReg,
        ];
        echo view("Layouts/Head", $dato);
        echo view("Taller/Modelo/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Taller/Modelo/Index/Scripts");
    }

    public function DetailIndex()
    {
        $modeloModel=new ModeloModel();
        $idevento=1;
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;

        $co=$modeloModel->CountDetail($tipoFiltro,$filtro);
        $detail=$modeloModel->DetailIndex($tipoFiltro,$filtro,$limit,$start);
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
            'tbody'=>view("Taller/Modelo/DetailIndex/Index",$dats).view("Taller/Modelo/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();
    }
}