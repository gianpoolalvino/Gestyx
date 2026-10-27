<?php
namespace App\Controllers\Confirmacion\LlamadaBienvenida;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EventoModel;
use App\Models\VinModel;
use Exception;

class SaveEditDelete extends BaseController
{
        public function SaveLlamada_old()
        {
            $alistamientoVehicular=New AlistamientoVehicularModel();
            $eventoModel=New EventoModel();
            $vin=$_POST["vinLlamada"];
            $infoGen=$alistamientoVehicular->ViewVin($vin);
            date_default_timezone_set("America/Lima");
            $hoy=date("Y-m-d");
            $hora=date("H:i:s");

            $vinfiltro=[
                'vin'=>$vin
            ];

            if($_POST["estadoLlamada"]==3){

            }else{

            }
            $updateVin=[
                'ideventoActual'=>1,
                'eventoActual'=>'Accesorios',
                'ideventoAnterior'=>8,
                'eventoAnterior'=>'Llamada Bienvenida',
                'fechaEventoAnterior'=>$infoGen[0]["fechaEventoActual"],
                'horaEventoAnterior'=>$infoGen[0]["horaEventoActual"],
                'fechaEventoActual'=>$_POST["fechaLlamada"],
                'horaEventoActual'=>$hora
            ];
            $update=$alistamientoVehicular->UpdateVinAccesorio($vinfiltro,$updateVin);
            if($update){
                $filtroEvento=[
                    'vin'=>$vin,
                    'ideventoActual'=>8,
                    'idestadoEvento'=>1
                ];

                $eventoUp=[
                    'fechaRegistroSistemaFin'=>$hoy,
                    'fechaFin'=>$_POST["fechaLlamada"],
                    'horaFin'=>$hora,
                    'idusuariofinaliza'=>session("idusuario"),
                    'comentarios'=>$_POST["comentarioLlamada"],
                    'idestadoEvento'=>2
                ];
                $updt=$eventoModel->UpdateEvento($filtroEvento,$eventoUp);

                $eventoActual=[
                    'fechaRegistroSistemaInicio'=>$hoy,
                    'fechaInicio'=>$hoy,
                    'vin'=>$vin,
                    'horaInicio'=>$hora,
                    'ideventoAnterior'=>8,
                    'eventoAnterior'=>'Llamada Bienvenida',
                    'ideventoActual'=>1,
                    'eventoActual'=>'Accesorios',
                    'idestadoEvento'=>1
                ];
                $store=$eventoModel->StorageEvento($eventoActual);

                $dato=[
                    'title'=>'Registro y cambio',
                    'message'=>'Se realizaron los cambios correspondientes',
                    'status'=>'success'
                ];

                echo json_encode($dato);
                exit();
            }else{
                $dato=[
                    'title'=>'Sin cambios realizados',
                    'message'=>'Error en data',
                    'status'=>'danger'
                ];

                echo json_encode($dato);
                exit();
            }
        }

        public function SaveLlamada()
        {
            // Crear instancias de los modelos
            $alistamientoVehicular = New AlistamientoVehicularModel();
            $eventoModel = New EventoModel();

            // Obtener datos desde el POST
            $vin = $_POST["vinLlamada"];
            $infoGen = $alistamientoVehicular->ViewVin($vin);

            // Configuración de fecha y hora
            date_default_timezone_set("America/Lima");
            $hoy = date("Y-m-d");
            $hora = date("H:i:s");

            // Filtro con VIN
            $vinfiltro = ['vin' => $vin];

            $updateTelf=[
                'telefonoCliente'=>$_POST["telefonoCliente"],
                'correoCliente'=>$_POST["correoCliente"],
                'direccionCliente'=>$_POST["direccionCliente"]
                'documentoCliente'=>$_POST["documentoCliente"]
                'tipoNegocio'=>$_POST["tipoNegocio"]
                'vin'=>$_POST["vin"]
                'modelo'=>$_POST["modelo"]
                'anhoModelo'=>$_POST["anhoModelo"]
                'marca'=>$_POST["marca"]
            ];

            $database = session("database");
            $entorno = "";

            if ($database == 'logistica_test') {
                $entorno = 'capacitacion';
            } else {
                $entorno = 'produccion';
            }
            $documentoCliente=$infoGen[0]["documentoCliente"];
            $arrContextOptions = array(
                "ssl" => array(
                    "verify_peer" => false,
                    "verify_peer_name" => false,
                ),
            );
            $rutaExec = '';
            if ($entorno == 'produccion') {
                if($infoGen[0]["marca"]=='CHEVROLET' || $infoGen[0]["marca"]=='ISUZU') {
                    $rutaExec = file_get_contents("https://api.autoniza.net.pe/apis_old/FACCAR/Vehiculos/MigrationV2/updateCliente.php?documentoCliente=" . $documentoCliente . "&telefonoCliente=" . $_POST["telefonoCliente"] . "&correoCliente=" . $_POST["correoCliente"], false, stream_context_create($arrContextOptions));
                    if (!$rutaExec) {
                        $dato = [
                            'title' => 'Error',
                            'message' => 'La Sincronizacion con el ERP no esta activa ' . $rutaExec,
                            'status' => 'danger'
                        ];
                        echo json_encode($dato);
                        exit();
                    }
                }
            }



            $updateClie=$alistamientoVehicular->UpdateVinAccesorio($vinfiltro,$updateTelf);
            $filtroEvento=[];
            // Verificar si el estadoLlamada es 3
            if ($_POST["estadoLlamada"] == 3) {
                // Si el estadoLlamada es 3, actualizar solo el evento sin UpdateVinAccesorio
                try {
                    $updateVin = [
                        'fechaCotizacion'=>null,
                        'idusuarioCotizacion'=>null,
                        'cotizacion'=>null,
                        'pegatinaComentarioLlamadaBienvenida' => null,
                        'comentarioLlamadaBienvenida'=>null
                    ];

                    // Realizar la actualización del VIN
                    $update = $alistamientoVehicular->UpdateVinAccesorio($vinfiltro, $updateVin);

                    // Actualización del evento con estado 3
                    $filtroEvento = [
                        'vin' => $vin,
                        'ideventoActual' => 8,
                        'idestadoEvento' => 1
                    ];

                    $eventoUp = [
                        'fechaRegistroSistemaFin' => $hoy,
                        'fechaFin' => $_POST["fechaLlamada"],
                        'horaFin' => $hora,
                        'idusuariofinaliza' => session("idusuario"),
                        'comentarios' => $_POST["comentarioLlamada"],
                        'idestadoEvento' => 3  // Estado 3
                    ];

                    // Actualizamos el evento
                    $updt = $eventoModel->UpdateEvento($filtroEvento, $eventoUp);

                    // Crear nuevo evento con estado 3
                    $eventoActual = [
                        'fechaRegistroSistemaInicio' => $hoy,
                        'fechaInicio' => $hoy,
                        'vin' => $vin,
                        'horaInicio' => $hora,
                        'ideventoAnterior' => 8,
                        'eventoAnterior' => 'Llamada Bienvenida',
                        'ideventoActual' => 8,
                        'eventoActual' => 'Llamada Bienvenida',
                        'idestadoEvento' => 1  // Estado 3
                    ];

                    // Almacenamos el nuevo evento con estado 3
                    $store = $eventoModel->StorageEvento($eventoActual);

                    // Sitodo va bien, devolver respuesta de éxito
                    $dato = [
                        'title' => 'Registro y cambio',
                        'message' => 'Se realizaron los cambios correspondientes',
                        'status' => 'success'
                    ];

                    echo json_encode($dato);
                    exit();

                } catch (Exception $e) {
                    // En caso de error, devolver respuesta de fallo
                    $dato = [
                        'title' => 'Error',
                        'message' => 'Hubo un error al procesar la solicitud: ' . $e->getMessage(),
                        'status' => 'danger'
                    ];

                    echo json_encode($dato);
                    exit();
                }

            } else {
                // Si elestadoLlamada no es 3, hacertodo el flujo normal
                try {
                    $filtroOr=[
                        'orden'=>1
                    ];
                    $evN=$eventoModel->OrdenEvento($filtroOr);
                    // Actualización del VIN con evento 'Accesorios'
                    $updateVin = [
                        'ideventoActual' => $evN[0]['idevento'],
                        'eventoActual' => $evN[0]['descripcionOrden'],
                        'ideventoAnterior' => 8,
                        'eventoAnterior' => 'Llamada Bienvenida',
                        'fechaEventoAnterior' => $infoGen[0]["fechaEventoActual"],
                        'horaEventoAnterior' => $infoGen[0]["horaEventoActual"],
                        'fechaEventoActual' => $_POST["fechaLlamada"],
                        'horaEventoActual' => $hora
                    ];

                    if($_POST["estadoLlamada"]==2){
                        $updateVin+=[
                            'pegatinaComentarioLlamadaBienvenida' => 1,
                            'comentarioLlamadaBienvenida'=>$_POST["comentarioLlamada"]
                        ];
                    }

                    // Realizar la actualización del VIN
                    $update = $alistamientoVehicular->UpdateVinAccesorio($vinfiltro, $updateVin);

                    if ($update) {
                        // Actualización del evento anterior
                        $filtroEvento = [
                            'vin' => $vin,
                            'ideventoActual' => 8,
                            'idestadoEvento' => 1
                        ];

                        $eventoUp = [
                            'fechaRegistroSistemaFin' => $hoy,
                            'fechaFin' => $_POST["fechaLlamada"],
                            'horaFin' => $hora,
                            'idusuariofinaliza' => session("idusuario"),
                            'comentarios' => $_POST["comentarioLlamada"],
                            'idestadoEvento' => 2
                        ];

                        if($_POST["estadoLlamada"]==2){
                            $eventoUp+=[
                                'pegatinaComentario' => 1,
                            ];
                        }

                        // Actualizamos el evento anterior
                        $updt = $eventoModel->UpdateEvento($filtroEvento, $eventoUp);

                        // Crear nuevo evento con estado 'Accesorios'
                        $eventoActual = [
                            'fechaRegistroSistemaInicio' => $hoy,
                            'fechaInicio' => $hoy,
                            'vin' => $vin,
                            'horaInicio' => $hora,
                            'ideventoAnterior' => 8,
                            'eventoAnterior' => 'Llamada Bienvenida',
                            'ideventoActual' => $evN[0]['idevento'],
                            'eventoActual' => $evN[0]['descripcionOrden'],
                            'idestadoEvento' => 1
                        ];

                        // Almacenamos el nuevo evento
                        $store = $eventoModel->StorageEvento($eventoActual);

                        // Si todo va bien, devolver respuesta de éxito
                        $dato = [
                            'title' => 'Registro y cambio',
                            'message' => 'Se realizaron los cambios correspondientes',
                            'status' => 'success'
                        ];

                        echo json_encode($dato);
                        exit();

                    } else {
                        // Si la actualización del VIN falla
                        $dato = [
                            'title' => 'Sin cambios realizados',
                            'message' => 'Error en la actualización del VIN',
                            'status' => 'danger'
                        ];

                        echo json_encode($dato);
                        exit();
                    }
                } catch (Exception $e) {
                    // En caso de error, hacer rollback y devolver mensaje de error
                    $dato = [
                        'title' => 'Error',
                        'message' => 'Hubo un error al procesar la solicitud: ' . $e->getMessage(),
                        'status' => 'danger'
                    ];

                    echo json_encode($dato);
                    exit();
                }
            }
        }
}