<?php

namespace App\Controllers\Comisiones\ReglaComision;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ComisionModel;
use App\Models\MarcaModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(21,65,''));


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
        $marcaModel=New MarcaModel();
        $dato = [
            'idgrupoModulo' => 21,
            'idmodulo' => 65,
            'selectMarca'=>$marcaModel->SelectMarca()
        ];
        echo view("Layouts/Head", $dato);
        echo view("Comisiones/ReglaComision/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Comisiones/ReglaComision/Index/Scripts");
    }

    public function DetailIndex()
    {
        $comisionModel=New ComisionModel();

        $filtro=[
            'idmarca'=>$_POST["idmarca"]
        ];

        $dato=[
            'detailIndex'=>$comisionModel->DetailIndexReglaComision($filtro)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Comisiones/ReglaComision/DetailIndex/Index",$dato).view("Comisiones/ReglaComision/DetailIndex/Scripts")
        ];

        echo json_encode($send);
        exit();
    }
}