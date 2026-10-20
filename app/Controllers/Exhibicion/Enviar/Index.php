<?php

namespace App\Controllers\Exhibicion\Enviar;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ExhibicionModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(20,46,''));


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
        $exhibicionModel=new ExhibicionModel();
        $idevento=1;
        $limit=10;
        $start=0;
        $finish=10;
        $detail=$exhibicionModel->DetailIndex('','');
        $countReg=0;
        foreach($detail as $dt){
            $countReg++;
        }
        $dato=[
            'idgrupoModulo'=>20,
            'idmodulo'=>46,
            'detailIndex'=>$detail,
            'count'=>$countReg,
        ];
        echo view("Layouts/Head",$dato);
        echo view("Exhibicion/Enviar/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("Exhibicion/Enviar/Index/Scripts");
    }

    public function DetailIndex()
    {
        $exhibicionModel=new ExhibicionModel();
        $tipoFiltro=$_POST["tipoFiltro"];
        $filtro=$_POST["filtro"];
        $detail=$exhibicionModel->DetailIndex($tipoFiltro,$filtro);
        $countReg=0;
        foreach($detail as $dt){
            $countReg++;
        }

        $dato=[
            'detailIndex'=>$detail
        ];

        $send=[
            'status'=>'success',
            'totalRegistros'=>$countReg,
            'info'=>view("Exhibicion/Enviar/DetailIndex/Index",$dato).("Exhibicion/Enviar/DetailIndex/Scripts")
        ];
        echo json_encode($send);
        exit();
    }
}