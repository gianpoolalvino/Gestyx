<?php

namespace App\Controllers\Agendamiento\CalendarioCita;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(5,25,''));


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
        $agendamiento=New AgendamientoModel();
        date_default_timezone_set("America/Lima");

        $fecha=isset($_POST["fechaCalendario"])?$_POST["fechaCalendario"]:date("Y-m-d");

        $dia=date("w", strtotime($fecha));

        $filtro=[
            'fecha'=>$fecha
        ];
        $idtipoDia='';

        if($dia==6){
            $idtipoDia=2;
        }else{
            $idtipoDia=1;
        }


        $filtroHorarios=[
            'idtipoDia'=>$idtipoDia
        ];
        $asesores=$agendamiento->AsesorEntregaNew();
        $aseso=[];
        $dato=[
            'idgrupoModulo'=>5,
            'idmodulo'=>25,
            'asesorEntrega'=>$asesores,
            'fecha'=>$fecha,
            'horario'=>$agendamiento->HorarioAgendamiento($filtroHorarios),
            'horariosOcupado'=>$agendamiento->HorariosOcupados($filtro)
        ];

        echo view("Layouts/Head",$dato);
        echo view("Agendamiento/CalendarioCita/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("Agendamiento/CalendarioCita/Index/Scripts",$dato);
    }
}