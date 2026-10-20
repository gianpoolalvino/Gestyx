<?php

namespace App\Controllers\Agendamiento\CalendarioCita;

use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\CitaModel;
use App\Models\EventoModel;
use App\Models\PlacaModel;
use App\Models\UsuarioModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function SaveCancelar()
    {
        $citaModel = new CitaModel();
        $agendamiento = new AgendamientoModel();
        $eventoModel = new EventoModel();
        $vinModel = new VinModel();
        date_default_timezone_set("America/Lima");
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");
        $idcita = $_POST["idcitaCancel"];
        $vin = $_POST["vinCancel"];
        $filtroCita = [
            'idcitaEntrega' => $idcita
        ];

        $updateCita = [
            'idestadoEntrega' => 5
        ];

        $upCit = $citaModel->UpdateCita($filtroCita, $updateCita);

        if ($upCit) {

            $vni = $vinModel->VinInfo($vin);

            $storageEvent = [
                'vin' => $_POST["vinCancel"],
                'ideventoActual' => 16,
                'fechaInicio' => $hoy,
                'horaInicio' => $hora,
                'ideventoAnterior' => 17,
                'eventoAnterior' => 'Agendado',
                'eventoActual' => 'Listo para Entrega',
                'idestadoEvento' => 1,
                'idusuario' => session("idusuario")
            ];
            $str = $eventoModel->StorageEvento($storageEvent);

            //Editar Evento
            $filtroEventUp = [
                'vin' => $_POST["vinCancel"],
                'ideventoActual' => 17
            ];

            $eventUpdate = [
                'fechaFin' => $hoy,
                'horaFin' => $hora,
                'idestadoEvento' => 2,
                'idusuarioFinaliza' => session("idusuario"),
                'comentarios' => 'Cancelado por ' . session("nombres")
            ];
            $upp = $eventoModel->UpdateEvento($filtroEventUp, $eventUpdate);

            $filtroHorarioAse = [
                'idcita' => $idcita,
                'vin' => $_POST["vinCancel"]
            ];

            $updateHor = [
                'idcita' => null,
                'vin' => null,
                'columnas' => 1,
                'idestadoEntrega' => null,
                'horaFinaliza' => null,
                'idhorarioInicio' => null
            ];

            $updateAse = $agendamiento->UpdateHorarioAsesor($filtroHorarioAse, $updateHor);

            if ($vni[0]["idtipoPlaca"] == 1) {
                $filtroPlaca = [
                    'placa' => $vni[0]["placa"]
                ];
                $updatePlaca = [
                    'uso' => null
                ];
                $updtPla = $agendamiento->UpdatePlacaRotativa($filtroPlaca, $updatePlaca);
            }

            $filtVin = [
                'vin' => $vin
            ];
            $upVin = [];
            $upVin += [
                'agendado' => null
            ];
            if ($vni[0]["idtipoPlaca"] != 2) {
                $upVin += [
                    'idtipoPlaca' => null,
                    'placa' => null
                ];
            }

            $updvn = $vinModel->UpdateVin($filtVin, $upVin);

            if ($updateAse) {
                $dato = [
                    'status' => 'success',
                    'title' => 'Agendamiento Cancelado',
                    'message' => 'Se cancelo con exito la cita de entrega'
                ];

                echo json_encode($dato);
                exit();
            } else {
                $dato = [
                    'status' => 'danger',
                    'title' => 'Error de Procesamiento',
                    'message' => 'No se logro cancelar correctamente la cita'
                ];

                echo json_encode($dato);
                exit();
            }
        } else {
            $dato = [
                'status' => 'danger',
                'title' => 'Error de Procesamiento',
                'message' => 'No se logro cancelar correctamente la cita'
            ];

            echo json_encode($dato);
            exit();
        }

    }

    public function SaveAgenda()
    {

        $citaModel = new CitaModel();
        $agendamiento = new AgendamientoModel();
        $eventoModel = new EventoModel();
        $vinModel = new VinModel();
        date_default_timezone_set("America/Lima");
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");
        $citaEntrega = [
            'horaAgendaInicio' => $_POST["horaAgendaInicio"],
            'horaAgendaFin' => $_POST["horaAgendaFin"],
            'idtipoPlaca' => $_POST["checkTipoPlaca"],
            'placaAsignada' => $_POST["placa"],
            'comentarioEntrega' => $_POST["comentarioEntrega"],
            'idestadoEntrega' => 1,
            'vin' => $_POST["vinAgendado"],
            'fecha' => $_POST["fechaAgenda"],
            'horaEntrega' => $hora,
            'idasesor' => $_POST["idasesorAgenda"],
            'idagenciaEntrega' => $_POST["agenciaAgenda"]
        ];
        $idcita = $citaModel->SaveCita($citaEntrega);

        //Editar Evento
        $filtroEventUp = [
            'vin' => $_POST["vinAgendado"],
            'ideventoActual' => 16
        ];

        $eventUpdate = [
            'fechaFin' => $hoy,
            'horaFin' => $hora,
            'idestadoEvento' => 2,
            'idusuarioFinaliza' => session("idusuario"),
            'comentarios' => 'Agendado por ' . session("nombres")
        ];
        $upp = $eventoModel->UpdateEvento($filtroEventUp, $eventUpdate);

        $storageEvent = [
            'vin' => $_POST["vinAgendado"],
            'ideventoActual' => 17,
            'fechaInicio' => $hoy,
            'horaInicio' => $hora,
            'ideventoAnterior' => 16,
            'eventoAnterior' => 'Listo para Entrega',
            'eventoActual' => 'Agendado',
            'idestadoEvento' => 1,
            'idusuario' => session("idusuario")
        ];

        $str = $eventoModel->StorageEvento($storageEvent);

        // Definir el rango de tiempo
        $start = new \DateTime($_POST["horaAgendaInicio"]);
        $end = new \DateTime($_POST["horaAgendaFin"]);
        // Inicializar contador
        $count = 0;
        // Calcular el intervalo de 30 minutos
        $interval = new \DateInterval('PT30M');
        // Crear un objeto de periodo
        $period = new \DatePeriod($start, $interval, $end);
        // Contar los intervalos
        foreach ($period as $dtg) {
            $dtg->format('H:i:s');
            $count++;
        }
        $cnt=0;
        foreach ($period as $dt) {
            $cnt++;
            $horas=$dt->format('H:i:s');
            // Solo grabar en la base de datos para el primer intervalo
            if ($cnt === 1) {
                $storage = [
                    'idestadoEntrega' => 1,
                    'horaAgenda'=>$horas,
                    'idasesor'=>$_POST["idasesorAgenda"],
                    'horaFinaliza' => $_POST["horaAgendaFin"],
                    'idcita' => $idcita,
                    'vin' => $_POST["vinAgendado"],
                    'columnas' => $count,
                    'fecha'=>$_POST["fechaAgenda"]
                ];
            }else{
                $storage = [
                    'idestadoEntrega' => 1,
                    'horaAgenda'=>$horas,
                    'idasesor'=>$_POST["idasesorAgenda"],
                    'horaFinaliza' => $_POST["horaAgendaFin"],
                    'idcita' => $idcita,
                    'vin' => $_POST["vinAgendado"],
                    'fecha'=>$_POST["fechaAgenda"]
                ];
            }
            $agendamiento->StorageHorarioGeneralAsesor($storage);
        }

        $filtroVin = [
            'vin' => $_POST["vinAgendado"]
        ];

        $updateVin = [
            'idtipoPlaca' => $_POST["checkTipoPlaca"],
            'placa' => $_POST["placa"],
            'agendado' => 1
        ];

        $updt = $vinModel->UpdateVin($filtroVin, $updateVin);

        if ($_POST["checkTipoPlaca"] == 1) {
            $filtroPlaca = [
                'placa' => $_POST["placa"]
            ];
            $updatePlaca = [
                'uso' => 1
            ];
            $updtPla = $agendamiento->UpdatePlacaRotativa($filtroPlaca, $updatePlaca);
        }

        $resutlado = [
            'status' => 'success',
            'title' => 'Agendamiento realizado',
            'message' => 'Se realizo correctamente el agendamiento de la unidad'
        ];

        echo json_encode($resutlado);
        exit();

    }

    public function SaveAgenda_old()
    {
        $citaModel = new CitaModel();
        $agendamiento = new AgendamientoModel();
        $eventoModel = new EventoModel();
        $vinModel = new VinModel();
        date_default_timezone_set("America/Lima");
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");
        $citaEntrega = [
            'horaAgendaInicio' => $_POST["horaAgendaInicio"],
            'horaAgendaFin' => $_POST["horaAgendaFin"],
            'idtipoPlaca' => $_POST["checkTipoPlaca"],
            'placaAsignada' => $_POST["placa"],
            'comentarioEntrega' => $_POST["comentarioEntrega"],
            'idestadoEntrega' => 1,
            'vin' => $_POST["vinAgendado"],
            'fecha' => $_POST["fechaAgenda"],
            'horaEntrega' => $hora,
            'idasesor' => $_POST["idasesorAgenda"],
            'idagenciaEntrega' => $_POST["agenciaAgenda"]
        ];
        $idcita = $citaModel->SaveCita($citaEntrega);

        //Editar Evento
        $filtroEventUp = [
            'vin' => $_POST["vinAgendado"],
            'ideventoActual' => 16
        ];

        $eventUpdate = [
            'fechaFin' => $hoy,
            'horaFin' => $hora,
            'idestadoEvento' => 2,
            'idusuarioFinaliza' => session("idusuario"),
            'comentarios' => 'Agendado por ' . session("nombres")
        ];
        $upp = $eventoModel->UpdateEvento($filtroEventUp, $eventUpdate);

        $storageEvent = [
            'vin' => $_POST["vinAgendado"],
            'ideventoActual' => 17,
            'fechaInicio' => $hoy,
            'horaInicio' => $hora,
            'ideventoAnterior' => 16,
            'eventoAnterior' => 'Listo para Entrega',
            'eventoActual' => 'Agendado',
            'idestadoEvento' => 1,
            'idusuario' => session("idusuario")
        ];

        $str = $eventoModel->StorageEvento($storageEvent);
        //

        $filtroAsesor = [
            'fecha' => $_POST["fechaAgenda"],
            'horaAgenda>=' => $_POST["horaAgendaInicio"],
            'horaAgenda<' => $_POST["horaAgendaFin"],
            'idasesor' => $_POST["idasesorAgenda"],
            'idestadoEntrega' => null
        ];

        $horas = $agendamiento->HorarioAsesor($filtroAsesor);
        $count = $agendamiento->CountHorarioAsesor($filtroAsesor);
        $contadorGe = $count[0]["contador"];
        $contadorHor = 0;
        $idhorarioPrincipal = '';
        foreach ($horas as $hsr) {
            $contadorHor++;
            if ($contadorHor == 1) {
                $idhorarioPrincipal = $hsr["idhorarioAsesor"];
            }
            $idhorario = $hsr["idhorarioAsesor"];
            $filtroHorarioEdit = [
                'idhorarioAsesor' => $idhorario
            ];
            $update = [
                'idestadoEntrega' => 1,
                'horaFinaliza' => $_POST["horaAgendaFin"],
                'idcita' => $idcita,
                'vin' => $_POST["vinAgendado"],
                'columnas' => $contadorGe
            ];
            if ($contadorHor > 1) {
                $update += [
                    'idhorarioInicio' => $idhorarioPrincipal
                ];
            }
            $updateAse = $agendamiento->UpdateHorarioAsesor($filtroHorarioEdit, $update);
        }

        $filtroVin = [
            'vin' => $_POST["vinAgendado"]
        ];

        $updateVin = [
            'idtipoPlaca' => $_POST["checkTipoPlaca"],
            'placa' => $_POST["placa"],
            'agendado' => 1
        ];

        $updt = $vinModel->UpdateVin($filtroVin, $updateVin);

        if ($_POST["checkTipoPlaca"] == 1) {
            $filtroPlaca = [
                'placa' => $_POST["placa"]
            ];
            $updatePlaca = [
                'uso' => 1
            ];
            $updtPla = $agendamiento->UpdatePlacaRotativa($filtroPlaca, $updatePlaca);
        }

        $resutlado = [
            'status' => 'success',
            'title' => 'Agendamiento realizado',
            'message' => 'Se realizo correctamente el agendamiento de la unidad'
        ];

        echo json_encode($resutlado);
        exit();
    }
}

