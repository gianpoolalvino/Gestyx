<?php

namespace App\Controllers\Agendamiento\Agendados;

use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\CitaModel;
use App\Models\EventoModel;
use App\Models\PlacaModel;
use App\Models\UsuarioModel;
use App\Models\VerificarEventoModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function SaveEntrega()
    {
        date_default_timezone_set("America/Lima");
        $citaModel = new CitaModel();
        $agendamiento = new AgendamientoModel();
        $eventoCritico = new VerificarEventoModel();
        $eventoModel = new EventoModel();
        $vinModel = new VinModel();
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");
        $vin = $_POST["vinProcesoEntrega"];
        $idcita = $_POST["idcitaProcesoEntrega"];
        $vni = $vinModel->VinInfo($vin);
        if ($_POST["estadoEntrega"] == 5) {
            $storageEvent = [
                'vin' => $vin,
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
                'vin' => $vin,
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
                'vin' => $vin
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

            $filtroUpdateCita = [
                'vin' => $vin,
                'idcitaEntrega' => $idcita
            ];

            $citaUpdate= [
                'idestadoEntrega' => $_POST["estadoEntrega"]
            ];
            $upCit = $citaModel->UpdateCita($filtroUpdateCita, $citaUpdate);

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
            $database = session("database");
            $entorno = "";

            if ($database == 'logistica_test') {
                $entorno = 'capacitacion';
            } else {
                $entorno = 'produccion';
            }

            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );
           $rutaExec = '';

            if (session("database")==='logistica_peru') {
                    $marca=$vni[0]["marca"];
                    $sendErp=$this->SendEntregadoERP($vin,$marca);
                    if($sendErp=='success'){
                        $rutaExec='success';
                    }
            }else if(session("database")==='logistica_colombia'){
                $rutaExec='success';
            }

            if ($rutaExec) {

                $filtroUpdateCita = [
                    'vin' => $vin,
                    'idcitaEntrega' => $idcita
                ];

                $citaUpdate = [];

                if ($_POST["estadoEntrega"] != 5) {
                    $citaUpdate += [
                        'fechaEntregaSistema' => $hoy,
                        'horaEntregaSistema' => $hora,
                        'idestadoEntrega' => $_POST["estadoEntrega"]
                    ];
                } else {
                    $citaUpdate += [
                        'idestadoEntrega' => $_POST["estadoEntrega"]
                    ];
                }
                $upCit = $citaModel->UpdateCita($filtroUpdateCita, $citaUpdate);

                $filtroDuplicado = [
                    'vin' => $vin,
                    'ideventoActual' => 18,
                    'idestadoEvento' => 2
                ];

                $contadordup = $eventoCritico->VerificarEventoCritico($filtroDuplicado);

                $contador = $contadordup[0]["contador"];

                if ($contador > 0) {
                    $dato = [
                        'status' => 'success',
                        'title' => 'Entrega Realizada',
                        'message' => 'Se realizo la entrega correctamente del Vin'
                    ];
                    echo json_encode($dato);
                    exit();
                }
                $storageEvent = [
                    'vin' => $vin,
                    'ideventoActual' => 18,
                    'fechaInicio' => $hoy,
                    'horaInicio' => $hora,
                    'ideventoAnterior' => 17,
                    'eventoAnterior' => 'Listo para Entrega',
                    'eventoActual' => 'Entregado',
                    'idestadoEvento' => 2,
                    'idusuario' => session("idusuario"),
                    'fechaFin' => $hoy,
                    'horaFin' => $hora,
                    'idusuarioFinaliza' => session("idusuario"),
                    'comentarios' => 'Entregado por :' . session("nombres") . ' ' . $_POST["observacion"]
                ];
                $str = $eventoModel->StorageEvento($storageEvent);

                //Editar Evento
                $filtroEventUp = [
                    'vin' => $vin,
                    'ideventoActual' => 17
                ];

                $eventUpdate = [
                    'fechaFin' => $hoy,
                    'horaFin' => $hora,
                    'idestadoEvento' => 2,
                    'idusuarioFinaliza' => session("idusuario"),
                    'comentarios' => 'finalizado por ' . session("nombres") . ' ' . $_POST["observacion"]
                ];
                $upp = $eventoModel->UpdateEvento($filtroEventUp, $eventUpdate);

                $filtroHorarioAse = [
                    'idcita' => $idcita,
                    'vin' => $vin
                ];

                $updateHor = [
                    'idestadoEntrega' => $_POST["estadoEntrega"],
                ];
                $updateAse = $agendamiento->UpdateHorarioAsesor($filtroHorarioAse, $updateHor);

                if ($updateAse) {
                    $filtroUpVin = [
                        'vin' => $vin
                    ];

                    $updateVin = [
                        'idestadoVin' => 3,
                        'agendado' => null,
                    ];

                    $upVn = $vinModel->UpdateVin($filtroUpVin, $updateVin);

                    $dato = [
                        'status' => 'success',
                        'title' => 'Entrega Realizada',
                        'message' => 'Se realizo la entrega correctamente del Vin'
                    ];
                    echo json_encode($dato);
                    exit();
                }
            }
        }

    }

    public function SendEntregadoERP($vin='',$marca='')
    {
        date_default_timezone_set('America/Lima');
        $fechaHoy=date("Y/m/d");

        if($marca=='CHEVROLET'){
            $url="http://190.223.25.10:8095/api/Tarjeta";
        }else if($marca=='ISUZU'){
            $url="http://190.223.25.10:8095/api/Tarjeta";
        }else{
            $url = "http://190.223.25.10:8070/api/Tarjeta";
        }
        $cotiCab = [
            "TIPO"=>4,
            "SERIE"=>$vin,
            "U_SYP_FECENTREGA"=>$fechaHoy,
            "U_SYP_OBS"=> "Envio a Entregado"
        ];

        $ch = curl_init();

// Establecer las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $url);  // URL de la API
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Retorna la respuesta como string
        curl_setopt($ch, CURLOPT_POST, true);  // Usar POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($cotiCab));  // Convertir los datos a JSON y enviarlos

// Establecer el encabezado Content-Type para JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Basic emlxRGpyMjNabWRjUHVzVlFDT1k3djN6YUt1eFJod2o5MFdjUWk4d29kYz06K0M1UnYwcTRZcHdoNjJvRkc0bjZ5dz09",
            'Content-Type: application/json',  // Indicar que estamos enviando JSON
            'Accept: application/json'         // Indicar que esperamos recibir JSON como respuesta
        ]);
// Desactivar la verificación SSL (solo para pruebas, no recomendado para producción)
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
// Ejecutar la solicitud cURL
        $response = curl_exec($ch);
        curl_close($ch);
// Decodificar la respuesta JSON

        $result=json_decode($response);

        return 'success';
    }
}