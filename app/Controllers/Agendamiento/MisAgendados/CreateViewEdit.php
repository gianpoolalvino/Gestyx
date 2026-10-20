<?php

namespace App\Controllers\Agendamiento\MisAgendados;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\PlacaModel;
use App\Models\UsuarioModel;
use App\Models\VinModel;

class CreateViewEdit extends BaseController
{
    public function StartEntrega()
    {
        $agendamiento=New AgendamientoModel();
        $alistamentoModel=new AlistamientoVehicularModel();
        $vinModel=New VinModel();
        $idcitaEntrega=$_POST["idcitaEntrega"];
        $vin=$_POST["vin"];

        $filtro=[
            'idcitaEntrega'=>$idcitaEntrega
        ];

        $dats=[
            'viewCita'=>$agendamiento->ViewCitaEntrega($filtro),
            'equipamiento'=>$alistamentoModel->EquipamientoVin($vin),
        ];

        $dato=[
            'info'=>view("Agendamiento/MisAgendados/Create/Index",$dats).view("Agendamiento/MisAgendados/Create/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($dato);
        exit();
    }
}