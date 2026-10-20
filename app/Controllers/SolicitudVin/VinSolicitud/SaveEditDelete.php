<?php
namespace App\Controllers\SolicitudVin\VinSolicitud;
use App\Controllers\BaseController;
use App\Models\AccessModel;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\AuditoriaVehicularModel;
use App\Models\ConfigModel;
use App\Models\ControlDemosModel;
use App\Models\SolicitudVinModel;
use App\Models\TrasladoModel;
use App\Models\VinModel;
use CodeIgniter\Controller;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use React\Dns\Config\Config;
use Zxing\QrReader;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\WriterInterface;

use Config\Database;

class SaveEditDelete extends BaseController
{

    public function SaveEnvioSolicitante()
    {
        date_default_timezone_set("America/Lima");

        // Modelos
        $configModel = new ConfigModel();
        $solicitudVin = new SolicitudVinModel();
        $trasladoModel = new TrasladoModel();
        $vinModel = new VinModel();
        $db = \Config\Database::connect();

        try {
            // Datos iniciales
            $vin = $_POST['vinUbicacion'];
            $idsolicitudVin = $_POST['idsolicitudVin'];

            // Consultar configuración de la nueva ubicación
            $filtroubiPro = [
                'idubicacion' => $_POST["ubicacionNueva"],
                'tipo' => 2
            ];
            $cconfigUbi = $configModel->MultipleProcedimiento($filtroubiPro);

            // 🔴 Liberar resultados si MultipleProcedimiento usa CALL
            if ($db->connID->more_results()) {
                $db->connID->next_result();
            }

            // Validar configuración de ubicación
            if (empty($cconfigUbi) || !isset($cconfigUbi[0]["autoRecepcion"])) {
                throw new \Exception('No se encontró configuración de la ubicación de destino');
            }

            // Construir traslado
            $trasladoUbicacion = [
                'vin' => $vin,
                'idubicacionOrigen' => $_POST["ubicacionAnterior"],
                'idubicacionDestino' => $_POST["ubicacionNueva"],
                'idgrupoUbicacionActual' => $_POST["idgrupoUbicacionActual"],
                'idgrupoubicacionOrigen' => $_POST["idgrupoUbicacionActual"],
                'idgrupoUbicacionDestino' => $_POST["grupoNuevo"],
                'fechaTraslado' => date("Y-m-d"),
                'horaTraslado' => date("H:i:s"),
                'idtransportista' => $_POST["transportista"],
                'idtipoTraslado' => 6,
                'idusuarioTraslado' => session("idusuario"),
                'idboxUbicacionOrigen' => !empty($_POST["boxAnterior"]) ? $_POST["boxAnterior"] : null,
                'idboxUbicacionDestino' => null,
                'idestadoTraslado' => $cconfigUbi[0]["autoRecepcion"] == 1 ? 2 : 1
            ];

            if ($cconfigUbi[0]["autoRecepcion"] == 1) {
                $trasladoUbicacion += [
                    'fechaRecepcion' => date("Y-m-d"),
                    'horaRecepcion' => date("H:i:s"),
                ];
            }

            // Iniciar transacción
            $db->transBegin();

            // Guardar traslado
            $idtrasladoVin = $trasladoModel->StorageTraslado($trasladoUbicacion);
            if (!$idtrasladoVin) {
                throw new \Exception('Fallo al realizar el traslado al taller');
            }

            // Construir actualización de VIN
            $vinupdate = [
                'idubicacion' => $_POST["ubicacionNueva"],
                'idboxUbicacionActual' => $_POST["boxNuevo"],
                'fechaTrasladoUbicacion' => date("Y-m-d"),
                'idusuarioTraslado' => session("idusuario"),
                'idubicacionAnterior' => $_POST["ubicacionAnterior"],
                'idboxUbicacionAnterior' => !empty($_POST["boxAnterior"]) ? $_POST["boxAnterior"] : null,
                'idubicacionOrigen' => $_POST["ubicacionAnterior"],
                'idubicacionDestino' => $_POST["ubicacionNueva"],
                'idboxUbicacionOrigen' => !empty($_POST["boxAnterior"]) ? $_POST["boxAnterior"] : null,
                'idboxUbicacionDestino' => $_POST["boxNuevo"],
                'idgrupoUbicacionOrigen' => $_POST["idgrupoUbicacionActual"],
                'idgrupoUbicacionDestino' => $_POST["grupoNuevo"],
                'idestadoTraslado' => $cconfigUbi[0]["autoRecepcion"] == 1 ? 2 : 1,
            ];

            if ($cconfigUbi[0]["autoRecepcion"] == 1) {
                $vinupdate += [
                    'idsolicitudVin' => null
                ];
            } else {
                $vinupdate += [
                    'idtrasladoUbicacion' => $idtrasladoVin,
                    'idsolicitudVin' => $idsolicitudVin,
                ];
            }

            // Actualizar VIN
            $filtroVin = ['vin' => $vin];
            $up = $vinModel->UpdateVin($filtroVin, $vinupdate);
            if (!$up) {
                throw new \Exception('Fallo al actualizar los datos del VIN');
            }

            $filtroVinSolic=[
                'idsolicitudVehiculo' => $idsolicitudVin,
                'vin' => $_POST["vinUbicacion"],
            ];

            $updateSoli=[
                'idestadoSolicitud' => $cconfigUbi[0]["autoRecepcion"] == 1 ? 6 : 5,
            ];

            $updateS=$solicitudVin->UpdateVins($filtroVinSolic, $updateSoli);

            if (!$updateS) {
                throw new \Exception('Fallo al actualizar los datos del VIN');
            }

            // Confirmar transacción
            $db->transCommit();

            echo json_encode([
                'status' => 'success',
                'title' => 'Cambio de Ubicación',
                'message' => 'Se realizó el envío a Taller correctamente.'
            ]);
            exit();

        } catch (\Exception $e) {
            $db->transRollback();
            echo json_encode([
                'status' => 'danger',
                'title' => 'Error en el cambio de ubicación',
                'message' => 'Error: ' . $e->getMessage()
            ]);
            exit();
        }
    }


    public function SaveEnvioTaller()
    {
        // Establecer la zona horaria
        date_default_timezone_set("America/Lima");

        // Cargar los modelos necesarios
        $solicitudVin = new SolicitudVinModel();
        $trasladoModel = new TrasladoModel();
        $vinModel = new VinModel();

        // Obtener los datos del formulario
        $vin = $_POST['vinUbicacion'];
        $idsolicitudVin=$_POST['idsolicitudVin'];
        // Preparar los datos para traslado
        $trasladoUbicacion = [
            'vin' => $vin,
            'idubicacionOrigen' => $_POST["ubicacionAnterior"],
            'idubicacionDestino' => $_POST["ubicacionNueva"],
            'fechaTraslado' => date("Y-m-d"),
            'horaTraslado' => date("H:i:s"),
            'idtipoTraslado' => 5,
            'idestadoTraslado' => 1,
            'idusuarioTraslado' => session("idusuario"),
            'idboxUbicacionOrigen' => ($_POST["boxAnterior"] != '') ? $_POST["boxAnterior"] : null,
            'idboxUbicacionDestino' => null
        ];

        // Iniciar una transacción
        $db = \Config\Database::connect();
        $db->transBegin();  // Iniciar la transacción

        try {
            // Realizar el almacenamiento del traslado
            $idtrasladoVin = $trasladoModel->StorageTraslado($trasladoUbicacion);

            // Verificar si el traslado fue exitoso
            if (!$idtrasladoVin) {
                throw new \Exception('Fallo al realizar el traslado al taller');
            }
            // Insertar la novedad
            $insert = $solicitudVin->NovedadesVinStorage($vin, 1, $idtrasladoVin,$idsolicitudVin);
            // Verificar si la inserción de la novedad fue exitosa
            if (!$insert) {
                throw new \Exception('Fallo al insertar la novedad del VIN ');
            }
            // Actualizar los datos de vin
            $vinupdate = [
                'idubicacion' => $_POST["ubicacionNueva"],
                'idboxUbicacionActual' => $_POST["boxNuevo"],
                'fechaTrasladoUbicacion' => date("Y-m-d"),
                'idestadoTraslado' => 1,
                'idusuarioTraslado' => session("idusuario"),
                'idubicacionAnterior' => $_POST["ubicacionAnterior"],
                'idboxUbicacionAnterior' => ($_POST["boxAnterior"] != '') ? $_POST["boxAnterior"] : null,
                'idubicacionOrigen' => $_POST["ubicacionAnterior"],
                'idubicacionDestino' => $_POST["ubicacionNueva"],
                'idboxUbicacionOrigen' => ($_POST["boxAnterior"] != '') ? $_POST["boxAnterior"] : null,
                'idboxUbicacionDestino' => $_POST["boxNuevo"],
                'idtrasladoUbicacion' => $idtrasladoVin,
                'identradaTaller'=>$idtrasladoVin,
                'idgrupoUbicacionDestino' => null,
            ];

            // Filtro para la actualización del vin
            $filtroVin = [
                'vin' => $vin
            ];

            // Realizar la actualización del vin
            $up = $vinModel->UpdateVin($filtroVin, $vinupdate);

            // Verificar si la actualización fue exitosa
            if (!$up) {
                throw new \Exception('Fallo al actualizar los datos del VIN');
            }

            // Confirmar la transacción
            $db->transCommit();

            // Devolver respuesta exitosa
            $dato = [
                'status' => 'success',
                'title' => 'Cambio de Ubicacion',
                'message' => 'Se realizo el envio a Taller'
            ];
            echo json_encode($dato);
            exit();
        } catch (\Exception $e) {
            // Si algo falla, hacer rollback de la transacción
            $db->transRollback();

            // Devolver mensaje de error
            $dato = [
                'status' => 'danger',
                'title' => 'Cambio de Ubicacion',
                'message' => 'Error: ' . $e->getMessage()
            ];
            echo json_encode($dato);
            exit();
        }
    }


    public function StorageNovedad()
    {
        // Establecer la zona horaria para Lima (hora local)
        date_default_timezone_set('America/Lima');

        // Crear una nueva instancia del modelo SolicitudVinModel
        $solicitudVehiculo = new SolicitudVinModel();

        // Obtener la fecha y la hora actuales
        $hoy = date('Y-m-d');  // Fecha en formato 'YYYY-MM-DD'
        $hora = date('H:i:s'); // Hora en formato 'HH:MM:SS'

        // Preparar los datos que serán enviados a la base de datos
        $storage = [
            'descripcion' => $_POST['descripcion'],       // Descripción de la novedad
            'comentarios' => $_POST['comentarios'],       // Comentarios adicionales
            'fecha' => $hoy,                               // Fecha actual
            'hora' => $hora,                               // Hora actual
            'idestadoNovedad' => 1,                        // ID del estado de la novedad (1 probablemente sea 'pendiente')
            'vin' => $_POST['vin'],                        // VIN del vehículo
            'idsolicitudVehiculo' => $_POST['idsolicitudVin'] // ID de la solicitud de vehículo
        ];

        // Verificar si se ha enviado una imagen (campo 'imagen')
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == 0) {
            // Si existe una imagen, almacenar los datos relacionados con ella
            $rutaImagen = $_FILES['imagen']['tmp_name'];  // Ruta temporal donde se almacena la imagen
            $tipoImagen = $_FILES['imagen']['type'];      // Tipo de imagen (MIME)
            $nombreImagen = $_FILES['imagen']['name'];    // Nombre original de la imagen

            // Añadir estos detalles al arreglo de envío de datos
            $storage['rutaImagen'] = $rutaImagen;       // Ruta de la imagen en el servidor
            $storage['tipoImagen'] = $tipoImagen;       // Tipo MIME de la imagen
            $storage['nombreImagen'] = $nombreImagen;   // Nombre de la imagen
        }

        $idnovedad=$solicitudVehiculo->StorageNovedad($storage);

        if($idnovedad!=''){
            $send = [
                'status' => 'success',
                'title' => 'Correcto',
                'message' => 'El proceso se realizó correctamente',
            ];
        }else{
            $send = [
                'status' => 'danger',
                'title' => 'Error en proceso',
                'message' => 'No se logró completar el proceso',
            ];
        }
        echo json_encode($send);
        exit();
        // Aquí se podría agregar el código para guardar los datos en la base de datos, dependiendo de la lógica de tu aplicación.
        // Por ejemplo: $solicitudVehiculo->save($send);
    }

    public function UpdateGestionVehiculoStop()
    {
        $solicitudVehiculo=New SolicitudVinModel();

        $filtro=[
            'iddetalleSolicitudVehiculo'=>$_POST["iddetalleSolicitudVehiculo"],
            'vin'=>$_POST["vin"]
        ];

        $update=[
            'idestadoSolicitud'=>4
        ];

        $upd=$solicitudVehiculo->UpdateVins($filtro,$update);

        if($upd){
            $send = [
                'status' => 'success',
                'title' => 'Correcto',
                'message' => 'El proceso se realizó correctamente',
            ];
        }else{
            $send = [
                'status' => 'danger',
                'title' => 'Error en proceso',
                'message' => 'No se logró completar el proceso',
            ];
        }
        echo json_encode($send);
        exit();
    }

    public function UpdateGestionVehiculo()
    {
        $solicitudVehiculo=New SolicitudVinModel();

        $filtro=[
            'iddetalleSolicitudVehiculo'=>$_POST["iddetalleSolicitudVehiculo"],
            'vin'=>$_POST["vin"]
        ];

        $update=[
            'idestadoSolicitud'=>3
        ];

        $upd=$solicitudVehiculo->UpdateVins($filtro,$update);

        if($upd){
            $send = [
                'status' => 'success',
                'title' => 'Correcto',
                'message' => 'El proceso se realizó correctamente',
            ];
        }else{
            $send = [
                'status' => 'danger',
                'title' => 'Error en proceso',
                'message' => 'No se logró completar el proceso',
            ];
        }
        echo json_encode($send);
        exit();
    }

    public function StorageCheckNovedad()
    {
        $solicitudVin = new SolicitudVinModel();

        // Set the default timezone
        date_default_timezone_set("America/Lima");

        // Get current date and time
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");

        // Get POST data
        $vin = $_POST["vin"];
        $idcabecera = $_POST["idcabeceraNovedad"];
        $comentario = $_POST["comentarioText"];
        $idnovedad = $_POST["idnovedad"];
        $idtipoNovedad = $_POST["idtipoNovedad"];
        $idestadoNovedad = $_POST["estadoNovedad"];

        // Start transaction
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Update check novedad id in the database
            $updt = $solicitudVin->UpdateCheckNovedadId(
                $idnovedad,
                $idcabecera,
                $comentario,
                $fecha,
                $hora,
                $idestadoNovedad,
                $vin,
                $idtipoNovedad
            );

            // Check if update was successful
            if ($updt) {
                // Commit transaction
                $db->transCommit();
                // Return success response as JSON
                echo json_encode([
                    'status' => 'success',
                    'title'=>'Operacion Correcta',
                    'message' => 'La novedad se actualizo correctamente'
                ]);
            } else {
                // If update fails, rollback the transaction
                $db->transRollback();

                // Return failure response as JSON
                echo json_encode([
                    'status' => 'danger',
                    'title'=>'Error en Operacion',
                    'message' => 'Error al actualizar novedad'
                ]);
            }
        } catch (\Exception $e) {
            // Rollback transaction in case of exception
            $db->transRollback();

            // Return error response as JSON
            echo json_encode([
                'status' => 'danger',
                'title'=>'Error en Operacion',
                'message' => 'Error ocurrido: ' . $e->getMessage()
            ]);
        }
    }


}