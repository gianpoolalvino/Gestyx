<?php

namespace App\Controllers\Agendamiento\CalendarioCita;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\GeneralesModel;
use App\Models\InmatriculacionModel;
use App\Models\PlacaModel;
use App\Models\UsuarioModel;
use App\Models\VinModel;

class CreateViewEdit extends BaseController
{

    public function PlacaRotativa()
    {
        $agendamiento=New AgendamientoModel();

        $filtros=[
            'idagencia'=>$_POST["idagenciaAgenda"],
            'uso'=>null
        ];

        $placas=$agendamiento->PlacaRotativa($filtros);
        $principal='';
        $principal.='<option value="">Seleccione Placa</option>';
        foreach($placas as $pl) {
            $principal .= '<option value="' .$pl["placa"].'">'.$pl["placa"].'</option>';
        }
        $dato=[
            'placas'=>$principal
        ];

        echo json_encode($dato);
        exit();

    }

    public function VinInfoPlaca()
    {
        $vinModel=New VinModel();
        $agendamiento=New AgendamientoModel();
        $inmatriculacion=New InmatriculacionModel();
        $vin=$_POST["vin"];
        $fecha=$_POST["fechaAgenda"];
        $hora=$_POST["horaAgenda"];

        $dia=date("w", strtotime($fecha));

        $idtipoDia='';

        if($dia==6){
            $idtipoDia=2;
        }else{
            $idtipoDia=1;
        }

        $filtroAse=[
            'fecha'=>$fecha,
            'idasesor'=>$_POST["idasesorAgenda"],
            'idtipoDia'=>$idtipoDia
        ];
        $horario=$agendamiento->HorarioAsesorVer5($filtroAse);

        $filtroAgen=[
            'idusuario'=>$_POST["idasesorAgenda"],
        ];

        $dato=[
            'VinInfo'=>$vinModel->VinInfo($vin),
            'vin'=>$vin,
            'horaAgenda'=>$_POST["horaAgenda"],
            'fechaAgenda'=>$_POST["fechaAgenda"],
            'agencia'=>$agendamiento->AgenciaAsesor($filtroAgen),
            'horario'=>$horario,
        ];

        $dats=[
            'status'=>'success',
            'info'=>view("InfoVin/Placa/Index",$dato).view("InfoVin/Placa/Scripts")
        ];
        echo json_encode($dats);
        exit();
    }

    public function SelectPlacaRotativa()
    {
        $inmatriculacionModel=new InmatriculacionModel();

    }

    public function EditCita()
    {
        $agendamiento=New AgendamientoModel();
        $vinModel=new VinModel();
        $usuarioModel=New UsuarioModel();
        $idagenda=$_POST["idagenda"];
        $idasesor=$_POST["idasesor"];
        $vin=$_POST["vin"];

        $filtroUsuario=[
            'idusuario'=>$_POST["idasesor"]
        ];

        $filtroCita=[
            'idcitaEntrega'=>$_POST["idcita"]
        ];

        $datos=[
            'idcita'=>$_POST["idcita"],
            'usuario'=>$usuarioModel->ViewUsuario($filtroUsuario),
            'viewCita'=>$agendamiento->ViewCitaEntrega($filtroCita),
            'vin'=>$vin,
            'idasesor'=>$_POST["idasesor"]
        ];

        $dats=[
            'info'=>view('Agendamiento/CalendarioCita/EditAgenda/Index',$datos).view('Agendamiento/CalendarioCita/EditAgenda/Scripts'),
            'status'=>'success'
        ];

        echo json_encode($dats);
        exit();
    }

    public function CreateCita()
    {
        $agendamiento=New AgendamientoModel();
        $general=New GeneralesModel();
        $vinModel=new VinModel();
        $usuarioModel=New UsuarioModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $horaAct=date("H:i:s");
        $idagenda=$_POST["idagenda"];
        $fecha=$_POST["fecha"];
        $hora=$_POST["hora"];


        if($fecha<$hoy){
            $send=[
                'status'=>'warning',
                'title'=>'Error en Fecha',
                'message'=>'No se puede agendar Citas con fechas anteriores'
            ];
            echo json_encode($send);
            exit();
        }else if($fecha==$hoy && $horaAct>$hora){
            $send=[
                'status'=>'warning',
                'title'=>'Error en Hora',
                'message'=>'No se puede agendar Citas con horas anteriores'
            ];
            echo json_encode($send);
            exit();
        }

        $filtroUsuario=[
            'idusuario'=>$_POST["idasesor"]
        ];

        $dats=[];

        $datos=[
            'vin'=>$vinModel->VinDisponiblesAgenda(),
            'fecha'=>$fecha,
            'hora'=>$hora,
            'requisitoCartera'=>$general->RequeridoSalida(),
            'usuario'=>$usuarioModel->ViewUsuario($filtroUsuario),
            'idasesor'=>$_POST["idasesor"]
        ];
        $dats=[
            'info'=>view('Agendamiento/CalendarioCita/CreateAgenda/Index',$datos).view('Agendamiento/CalendarioCita/CreateAgenda/Scripts'),
            'status'=>'success'
        ];

        echo json_encode($dats);
        exit();
    }
}