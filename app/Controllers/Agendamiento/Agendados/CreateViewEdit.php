<?php

namespace App\Controllers\Agendamiento\Agendados;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\CitaModel;
use App\Models\PlacaModel;
use App\Models\UsuarioModel;
use App\Models\VinModel;

class CreateViewEdit extends BaseController
{

    public function IniciarProceso()
    {
        $agendamiento=New AgendamientoModel();
        $citaModel=New CitaModel();
        $idcitaEntrega=$_POST["idcitaEntrega"];
        $vin=$_POST["vin"];

        $filtroCitaUp=[
            'idcitaEntrega'=>$idcitaEntrega
        ];

        $updateCita=[
            'idestadoEntrega'=>3
        ];

        $up=$citaModel->UpdateCita($filtroCitaUp,$updateCita);

        $dats=[
            'vin'=>$vin,
            'idcitaEntrega'=>$idcitaEntrega
        ];

        $dato=[
            'info'=>view("Agendamiento/Agendados/ProcesoEntrega/Index",$dats).view("Agendamiento/Agendados/ProcesoEntrega/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($dato);
        exit();
    }
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
            'idcitaEntrega'=>$idcitaEntrega,
            'vin'=>$vin,
            'viewCita'=>$agendamiento->ViewCitaEntrega($filtro),
            'equipamiento'=>$alistamentoModel->EquipamientoVin($vin),
        ];

        $dato=[
            'info'=>view("Agendamiento/Agendados/Create/Index",$dats).view("Agendamiento/Agendados/Create/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($dato);
        exit();
    }
}