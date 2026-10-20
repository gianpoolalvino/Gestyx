<?php

namespace App\Controllers\Exhibicion\RetornarInventario;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ExhibicionModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(20,47,''));


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
        $exhibicionModel=New ExhibicionModel();
        $detail=$exhibicionModel->DetailIndexExhibicion('','');
        $countReg=0;
        foreach($detail as $dt){
            $countReg++;
        }
        $dato=[
            'idgrupoModulo'=>20,
            'idmodulo'=>47,
            'detailIndex'=>$detail,
            'count'=>$countReg,
        ];
        echo view("Layouts/Head",$dato);
        echo view("Exhibicion/RetornarInventario/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("Exhibicion/RetornarInventario/Index/Scripts");
    }

    public function DetailIndex()
    {
        $exhibicionModel=New ExhibicionModel();
        $tipoFiltro=$_POST["tipoFiltro"];
        $filtro=$_POST["filtro"];
        $detail=$exhibicionModel->DetailIndexExhibicion($tipoFiltro,$filtro);
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
            'info'=>view("Exhibicion/RetornarInventario/DetailIndex/Index",$dato).view("Exhibicion/RetornarInventario/DetailIndex/Scripts")
        ];

        echo json_encode($send);
        exit();
    }
}