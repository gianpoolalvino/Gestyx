<?php

namespace App\Controllers\Administrador\UsuarioPerfiles;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\EntregadoModel;
use App\Models\ExhibicionModel;
use App\Models\UsuarioModel;
use App\Models\VehiculosVendidosModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(24,55,''));


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
        $usuarioModel=New UsuarioModel();

        $dato=[
            'idgrupoModulo'=>24,
            'idmodulo'=>55,
            'detailIndex'=>$usuarioModel->DetailIndexUsuario('')
        ];
        echo view("Layouts/Head",$dato);
        echo view("Administrador/UsuarioPerfiles/Index/Index",$dato);
        echo view("Layouts/Footer_admin");
        echo view("Administrador/UsuarioPerfiles/Index/Scripts");
    }

    public function DetailIndex()
    {
        $usuarioModel=New UsuarioModel();

        $search=$_POST["filtro"];

        $dato=[
            'detailIndex'=>$usuarioModel->DetailIndexUsuario($search)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/DetailIndex/Index",$dato).view("Administrador/UsuarioPerfiles/DetailIndex/Scripts")
        ];

        echo json_encode($send);
        exit();
    }
}