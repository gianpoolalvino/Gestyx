<?php

namespace App\Controllers\Agendamiento\CalendarioAsesor;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(5,63,''));


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
        date_default_timezone_set("America/Lima");
        $agendamiento=New AgendamientoModel();
        $idasesor=session("idusuario");

        $diaReferencia = (!isset($_GET["fecha"]))?date("Y-m-d"):$_GET["fecha"]; // Puedes poner cualquier fecha válida
        // Crear un objeto DateTime a partir del día de referencia
        $fecha = new \DateTime($diaReferencia);
        // Crear un array para almacenar los días de la semana
        $diasDeLaSemana = [];
        // Obtener el primer día de la semana (lunes)
        $fecha->modify('monday this week');
       // Fecha de ejemplo (puedes usar cualquier fecha)
        $primerDiaSemana = $fecha->format('Y-m-d');
// Obtener el último día de la semana (domingo)
        $fecha->modify('sunday this week');
        $ultimoDiaSemana = $fecha->format('Y-m-d');
        // Inicializar la fecha con el primer día de la semana
        $fecha = new \DateTime($primerDiaSemana);
// Llenar el array con los días entre el primer y último día de la semana
        setlocale(LC_TIME, 'es_ES.UTF-8');

        // Array con los días de la semana en inglés
        $diasSemanaIngles = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
// Array con los días de la semana en español
        $diasSemanaEspanhol = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        while ($fecha->format('Y-m-d') <= $ultimoDiaSemana) {
            // Nombre del día en inglés
            // Si deseas en español, puedes usar la función setlocale
            $nombreDiaIngles = $fecha->format('l');  // 'l' devuelve el nombre del día en inglés
            // Traducir el nombre del día al español utilizando el array de traducción
            $indiceDia = array_search($nombreDiaIngles, $diasSemanaIngles);
            $nombreDiaEspanhol = $diasSemanaEspanhol[$indiceDia];

            $diasDeLaSemana[] = [
                'nombreDia' => $nombreDiaEspanhol, // Nombre del día en español
                'fecha' => $fecha->format('Y-m-d') // Fecha en formato 'Y-m-d'
            ];

            // Avanzar al siguiente día
            $fecha->modify('+1 day');
        }
// Mostrar los días de la semana

        $filtroHorarios=[
            'idtipoDia'=>1
        ];

        $filtro=[
            'fecha>='=>$primerDiaSemana,
            'fecha<='=>$ultimoDiaSemana,
            'idasesor'=>$idasesor
        ];

        $dato=[
            'idgrupoModulo'=>5,
            'idmodulo'=>63,
            'fecha'=>$diaReferencia,
            'diasSemana'=>$diasDeLaSemana,
            'primerDia'=>$primerDiaSemana,
            'ultimoDia'=>$ultimoDiaSemana,
            'horario'=>$agendamiento->HorarioAgendamiento($filtroHorarios),
            'horariosOcupado'=>$agendamiento->HorariosOcupados($filtro)
        ];

        echo view("Layouts/Head",$dato);
        echo view("Agendamiento/CalendarioAsesor/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("Agendamiento/CalendarioCita/Index/Scripts",$dato);
    }
}