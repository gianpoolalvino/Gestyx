<?php

namespace App\Controllers\Administrador\ConfigurarWhatsapp;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EntregadoModel;
use App\Models\ExhibicionModel;
use App\Models\UsuarioModel;
use App\Models\VehiculosVendidosModel;
use App\Models\WhatsappModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CreateViewEdit extends BaseController
{
    public function Create()
    {
        $send=[
            'status'=>'success',
            'info'=>view("Administrador/ConfigurarWhatsapp/Create/Index").view("Administrador/ConfigurarWhatsapp/Create/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function DetailAgente()
    {
        $whatsappModel=New WhatsappModel();
        $filtro=[
            'idsessionWhatsapp'=>$_POST["idsessionWhatsapp"]
        ];

        $dato=[
            'agentes'=>$whatsappModel->AgentesWhatsapp($filtro),
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Administrador/ConfigurarWhatsapp/DetailAgente/Index",$dato).view("Administrador/ConfigurarWhatsapp/DetailAgente/Scripts")
        ];

        echo json_encode($send);

    }

    public function AsociarAgente()
    {
        $whatsappModel=New WhatsappModel();

        $filtro=[
            'idsessionWhatsapp'=>$_POST["idsessionWhatsapp"]
        ];

        $dato=[
            'selectAgentes'=>$whatsappModel->AgentesLibres(),
            'whatsapp'=>$whatsappModel->ViewWhatsapp($filtro),
            'agentes'=>$whatsappModel->AgentesWhatsapp($filtro),
            'idsessionWhatsapp'=>$_POST["idsessionWhatsapp"]
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Administrador/ConfigurarWhatsapp/AsociarAgente/Index",$dato).view("Administrador/ConfigurarWhatsapp/AsociarAgente/Scripts")
        ];

        echo json_encode($send);
    }

    public function ViewQr()
    {
        $whatsappModel=New WhatsappModel();

        $filtro=[
          'idsessionWhatsapp'=>$_POST["idsessionWhatsapp"]
        ];

        $dato=[
            'whatsapp'=>$whatsappModel->ViewWhatsapp($filtro)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Administrador/ConfigurarWhatsapp/ViewQr/Index",$dato).view("Administrador/ConfigurarWhatsapp/ViewQr/Scripts")
        ];

        echo json_encode($send);
        exit();
    }
}