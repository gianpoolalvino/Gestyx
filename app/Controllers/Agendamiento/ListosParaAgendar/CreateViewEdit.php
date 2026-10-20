<?php

namespace App\Controllers\Agendamiento\ListosParaAgendar;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\PlacaModel;
use App\Models\UsuarioModel;
use App\Models\VinModel;

class CreateViewEdit extends BaseController
{
    public function StorageHorarios($fecha='',$idasesor='')
    {
        $agendamiento=New AgendamientoModel();

        $dia=date("w", strtotime($fecha));

        $idtipoDia=0;
        if($dia==6){
            $idtipoDia=2;
        }else if($dia==0){
            $idtipoDia=3;
        }else{
            $idtipoDia=1;
        }

        $filtroHorarios=[
            'idtipoDia'=>$idtipoDia
        ];

        $horas=$agendamiento->HorarioAgendamiento($filtroHorarios);
        foreach($horas as $hs){
            $storageHora=[
                'idasesor'=>$idasesor,
                'fecha'=>$fecha,
                'columnas'=>1,
                'horaAgenda'=>$hs["hora"]
            ];
            $hoStor=$agendamiento->StorageHorarioGeneralAsesor($storageHora);
        }

    }
    public function HorarioDisponibleAsesor()
    {
        $agendamiento=New AgendamientoModel();
        date_default_timezone_set("America/Lima");
        $tipoHora=$_POST["tipoHora"];
        $hora=date("H:i:s");

        $dia=date("w", strtotime($_POST["fechaCita"]));

        $idtipoDia='';

        if($dia==6){
            $idtipoDia=2;
        }else{
            $idtipoDia=1;
        }

        $filtroHora=[];
        if($tipoHora==1){
            $filtroHora+=[
                'idasesor'=>$_POST["idasesor"],
                'fecha'=>$_POST["fechaCita"],
                'idtipoDia'=>$idtipoDia
            ];
            if(date("Y-m-d")==$_POST["fechaCita"]){
                $filtroHora+=[
                    'horaAgenda'=>$hora
                ];
            }

            $horarioDisponible=$agendamiento->HorarioAsesorVer5($filtroHora);

            $horas='';
            $horas.='<select class="form-select" id="horaInicio" name="horaInicio" aria-label="Hora Inicial">';
            foreach($horarioDisponible as $hod){
                $horas.='<option value="'.$hod["horaAgenda"].'">'.$hod["horaAgenda"].'</option>';
            }
            $horas.='</select>';
            $dato=[
                'status'=>'success',
                'info'=>$horas
            ];
            echo json_encode($dato);
            exit();
        }else{
            $filtroHora+=[
                'idasesor'=>$_POST["idasesor"],
                'fecha'=>$_POST["fechaCita"],
                'idtipoDia'=>$idtipoDia,
                'horaAgenda'=>$_POST["hora"]
            ];

            $horarioDisponible=$agendamiento->HorarioAsesorVer5($filtroHora);

            $horas='';
            $horas.='<select class="form-select" id="horaFin" name="horaFin" aria-label="Hora Inicial">';
            foreach($horarioDisponible as $hod){
                $horas.='<option value="'.$hod["horaAgenda"].'">'.$hod["horaAgenda"].'</option>';
            }
            $horas.='</select>';
            $dato=[
                'status'=>'success',
                'info'=>$horas
            ];
            echo json_encode($dato);
            exit();
        }
    }
    public function AsesorEntrega()
    {
        $agendamiento=New AgendamientoModel();
        $idagencia=$_POST["idagencia"];

        $filtro=[
            'idagencia'=>$idagencia
        ];
        $asesoresEntrega=$agendamiento->AsesorRegionEntrega($filtro);
        $principal='';
        $principal.='<select class="form-select" id="asesores" name="asesores" required aria-label="Seleccione un Asesor de Entrega">';
        $principal.='<option value="">Seleccione una Agencia</option>';
        foreach($asesoresEntrega as $ase){
            $principal.='<option value="'.$ase["idusuario"].'">'.$ase["nombreAsesor"].'</option>';
        }
        $principal.='</select>';

        $dato=[
            'status'=>'success',
            'info'=>$principal
        ];

        echo json_encode($dato);
        exit();
    }
    public function CreateCita()
    {
        $agendamiento=New AgendamientoModel();
        $vinModel=New VinModel();

        $vin=$_POST["vin"];
        $asesores=$agendamiento->AsesorEntrega();
        $dats=[
            'vin'=>$vin,
            'VinInfo'=>$vinModel->VinInfo($vin),
            'asesores'=>$asesores,
            'agencia'=>$agendamiento->SelectAgencia(),
        ];

        $dato=[
            'info'=>view('Agendamiento/ListosParaAgendar/CreateCita/Index',$dats).view('Agendamiento/ListosParaAgendar/CreateCita/Scripts'),
            'status'=>'success'
        ];

        echo json_encode($dato);
        exit();
    }
}