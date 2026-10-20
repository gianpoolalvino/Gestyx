<?php

namespace App\Controllers\Administrador\ConfigurarWhatsapp;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\EntregadoModel;
use App\Models\ExhibicionModel;
use App\Models\UsuarioModel;
use App\Models\VehiculosVendidosModel;
use App\Models\WhatsappModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(24,64,''));


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
        $whatsappModel=New WhatsappModel();
        $dato=[
            'idgrupoModulo'=>24,
            'idmodulo'=>64,
            'detailIndex'=>$whatsappModel->DetainIndex('')
        ];
        echo view("Layouts/Head",$dato);
        echo view("Administrador/ConfigurarWhatsapp/Index/Index",$dato);
        echo view("Layouts/Footer_admin");
        echo view("Administrador/ConfigurarWhatsapp/Index/Scripts");
    }
}