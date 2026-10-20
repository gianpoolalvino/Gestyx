<?php
namespace App\Controllers\Traslado\CambioAgencia;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EventoModel;
use App\Models\SolicitudVinModel;
use App\Models\TrasladoModel;
use App\Models\VinModel;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class SaveEditDelete extends BaseController
{
    public function DatosCorreo()
    {
        /*
            echo 'Kelly';
            echo 'kellymerinorosales1984@gmail.com';
            echo '969912904';
        */
    }

    public function SaveRecepcion()
    {
        $trasladoModel = new TrasladoModel();
        $vinModel = new VinModel();
        date_default_timezone_set("America/Lima");

        $hoy=date("Y-m-d");
        $hora=date("H:i:s");

        // Inicia la transacción
        $db = \Config\Database::connect();
        $db->transBegin();
        $idtrasladoVin='';
        try {
            $idtrasladoVin=$_POST["idtrasladoVin"];
            $filtro = [
                'vin' => $_POST["vinRecep"],
                'idtrasladoVin' => $idtrasladoVin,
                'idtipoTraslado' => 3
            ];

            $viewTrasl = $trasladoModel->ViewFull($filtro);

            // Verifica si se encontró información en el traslado
            if (empty($viewTrasl)) {
                // Si no se encontró, busca en el segundo modelo
                $filtroSecundario = [
                    'vin' => $_POST["vinRecep"],
                    'idtipoTraslado' => 3 // Solo necesitas este filtro
                ];
                $viewTrasl = $trasladoModel->TrasladoId($filtroSecundario);
                // Verifica si se encontró información en el segundo modelo
                if (empty($viewTrasl)) {
                    throw new \Exception("No se encontró información del traslado.");
                }
                // Obtiene el idtrasladoVin del resultado
                $idtrasladoVin = $viewTrasl[0]["idtrasladoVin"];
                $filtro['idtrasladoVin'] = (int)$idtrasladoVin;
            }

            $filtroVin = [
                'vin' => $_POST["vinRecep"]
            ];

            $vinUpdate = [
                'codigoAgenciaDestino' => null,
                'agenciaDestino' => null,
                'codigoAgenciaOrigen' => null,
                'agenciaOrigen' => null,
                'codigoAgenciaAnterior' => $viewTrasl[0]["codigoAgenciaOrigen"],
                'agenciaAnterior' => $viewTrasl[0]["agenciaOrigen"],
                'codigoAgencia' => $viewTrasl[0]["codigoAgenciaDestino"],
                'agencia' => $viewTrasl[0]["agenciaDestino"],
                'idtrasladoVin'=>null,
                'idestadoTraslado' => null
            ];

            // Actualiza el vin
            $up = $vinModel->UpdateVin($filtroVin, $vinUpdate);

            // Actualiza el traslado
            $updateTras = [
                'idestadoTraslado' => 2,
                'fechaRecepcion'=>$hoy,
                'horaRecepcion'=>$hora,
                'idusuarioRecepcion'=>session('idusuario')
            ];

            $uptras = $trasladoModel->UpdateTraslado($filtro, $updateTras);

            // Verifica si las actualizaciones fueron exitosas
            if (!$up || !$uptras) {
                throw new \Exception("Error al actualizar la base de datos.");
            }

            // Completa la transacción
            $db->transComplete();

            // Verifica si la transacción fue exitosa
            if ($db->transStatus() === false) {
                throw new \Exception("Error en la transacción.");
            }



            // Respuesta exitosa
            echo json_encode([
                'status' => 'success',
                'title' => 'Operación exitosa',
                'message' => 'Recepción guardada correctamente.'
            ]);



        } catch (\Exception $e) {
            // Hace rollback en caso de error
            $db->transRollback();
            // Respuesta de error
            echo json_encode([
                'status' => 'error',
                'title' => 'Error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function DeleteObservacionEnvio()
    {
        $trasladoModel=New TrasladoModel();

        $filtro=[
            'iddetalleEnvioVin'=>$_POST["iddetalleEnvioVin"]
        ];

        $delt=$trasladoModel->DeleteDetalleEnvio($filtro);

        // Manejo de éxito
        $send = [
            'status' => 'success',
            'title' => 'Eliminado Correcto',
            'message' => 'Se Elimino correctamente la observacion'
        ];
        echo json_encode($send);
        exit();
    }

    public function DeleteObservacionRecepcion()
    {
        $trasladoModel=New TrasladoModel();

        $filtro=[
            'iddetalleRecepcionVin'=>$_POST["iddetalleRecepcion"]
        ];

        $delt=$trasladoModel->DeleteDetalleRecepcion($filtro);

        // Manejo de éxito
        $send = [
            'status' => 'success',
            'title' => 'Eliminado Correcto',
            'message' => 'Se Elimino correctamente la observacion'
        ];
        echo json_encode($send);
        exit();
    }

    public function SaveObservacionEnvio()
    {
        $trasladoModel = new TrasladoModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        // Asegúrate de que estás recibiendo todos los campos
        $storageObs = [
            'tokenUnico' => $_POST["tokenSendEnvio"],
            'vin' => $_POST["vinTraslado"],
            'descripcion' => $_POST["tituloObservacion"],
            'detalles' => $_POST["comentarioDetalleTraslado"],
            'fechaObservacion' => $hoy,
            'horaObservacion'=>$hora,
            'idusuario'=>session("idusuario")
        ];

        // Iniciar la transacción
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Inicializar variables para la imagen
            $rutaImagen = null;
            $nombreImagen = null;
            $tipoImagen = null;

            // Procesar la imagen
            if ($this->request->getFile('resourceDetalleTraslado')->isValid()) {
                $imagen = $this->request->getFile('resourceDetalleTraslado');

                // Crear una carpeta basada en vin/idtraslado
                $directorio = "resource/trasladoVin/{$_POST["vinTraslado"]}/{$_POST["tokenSendEnvio"]}";
                if (!is_dir($directorio)) {
                    mkdir($directorio, 0755, true); // Crear el directorio si no existe
                }

                // Generar un nombre único para la imagen
                $nombreImagen = uniqid() . '-' . $imagen->getClientName();
                $rutaImagen = $directorio . $nombreImagen;
                $tipoImagen = $imagen->getClientMimeType(); // Obtener el tipo de imagen

                // Mover la imagen a la carpeta
                if (!$imagen->move($directorio, $nombreImagen)) {
                    throw new \Exception("Error al subir la imagen.");
                }
            } else {
                throw new \Exception("No se ha recibido ninguna imagen.");
            }

            // Agregar información de la imagen al array
            $storageObs['tipoImagen'] = $tipoImagen;
            $storageObs['nombreImagen'] = $imagen->getClientName();
            $storageObs['rutaImagen'] = $directorio."/".$nombreImagen;

            // Guardar la información en la base de datos
            $storage = $trasladoModel->StorageObservacionEnvio($storageObs);

            // Confirmar la transacción
            $db->transComplete();

            // Verificar si la transacción fue exitosa
            if ($db->transStatus() === false) {
                throw new \Exception("Error al guardar la información en la base de datos.");
            }

            // Manejo de éxito
            $send = [
                'status' => 'success',
                'title' => 'Exito en Guardado',
                'message' => 'Observación guardada exitosamente.'
            ];
            echo json_encode($send);
        } catch (\Exception $e) {
            // Manejo de error
            $db->transRollback();

            $send = [
                'status' => 'danger',
                'title' => 'Error de Proceso',
                'message' => $e->getMessage()
            ];
            echo json_encode($send);
        }
    }

    public function SaveObservacionRecepcion()
    {
        $trasladoModel = new TrasladoModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        // Asegúrate de que estás recibiendo todos los campos
        $storageObs = [
            'idtrasladoVin' => $_POST["idtrasladoVin"],
            'vin' => $_POST["vinTraslado"],
            'descripcion' => $_POST["tituloObservacion"],
            'detalles' => $_POST["comentarioDetalleTraslado"],
            'fechaObservacion' => $hoy,
            'horaObservacion'=>$hora,
            'idusuario'=>session("idusuario")
        ];

        // Iniciar la transacción
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Inicializar variables para la imagen
            $rutaImagen = null;
            $nombreImagen = null;
            $tipoImagen = null;

            // Procesar la imagen
            if ($this->request->getFile('resourceDetalleTraslado')->isValid()) {
                $imagen = $this->request->getFile('resourceDetalleTraslado');

                // Crear una carpeta basada en vin/idtraslado
                $directorio = "resource/trasladoVin/{$_POST["vinTraslado"]}/{$_POST["idtrasladoVin"]}";
                if (!is_dir($directorio)) {
                    mkdir($directorio, 0755, true); // Crear el directorio si no existe
                }

                // Generar un nombre único para la imagen
                $nombreImagen = uniqid() . '-' . $imagen->getClientName();
                $rutaImagen = $directorio . $nombreImagen;
                $tipoImagen = $imagen->getClientMimeType(); // Obtener el tipo de imagen

                // Mover la imagen a la carpeta
                if (!$imagen->move($directorio, $nombreImagen)) {
                    throw new \Exception("Error al subir la imagen.");
                }
            } else {
                throw new \Exception("No se ha recibido ninguna imagen.");
            }

            // Agregar información de la imagen al array
            $storageObs['tipoImagen'] = $tipoImagen;
            $storageObs['nombreImagen'] = $imagen->getClientName();
            $storageObs['rutaImagen'] = $directorio."/".$nombreImagen;

            // Guardar la información en la base de datos
            $storage = $trasladoModel->StorageObservacionRecepcion($storageObs);

            // Confirmar la transacción
            $db->transComplete();

            // Verificar si la transacción fue exitosa
            if ($db->transStatus() === false) {
                throw new \Exception("Error al guardar la información en la base de datos.");
            }

            // Manejo de éxito
            $send = [
                'status' => 'success',
                'title' => 'Exito en Guardado',
                'message' => 'Observación guardada exitosamente.'
            ];
            echo json_encode($send);
        } catch (\Exception $e) {
            // Manejo de error
            $db->transRollback();

            $send = [
                'status' => 'danger',
                'title' => 'Error de Proceso',
                'message' => $e->getMessage()
            ];
            echo json_encode($send);
        }
    }

    public function SendMailNotificacion($idtrasladoVin,$vin)
    {
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();

        $filtro=[
            'idtrasladoVin'=>$idtrasladoVin,
            'vin'=>$vin
        ];

        $dato=[
            'traslado'=>$trasladoModel->ViewTrasladoVin($filtro),
            'detailTraslado'=>$trasladoModel->DetalleRecepcion($filtro),
        ];

        $message = view('NotificacionCorreo/RecepcionVehicular/RecepcionConNovedades', $dato);


        // Configuración de PHPMailer
        $mail = new PHPMailer(true);
        $viewSolicitud=$trasladoModel->ViewTrasladoVin($filtro);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';                // Especificar el servidor SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = 'german.torres@autoniza.com';           // Tu dirección de correo
            $mail->Password   = 'Mylu2025!';                // Tu contraseña de correo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;                             // Puerto para TLS

            // Remitente y destinatarios
            $mail->setFrom('noreplyautoniza@gmail.com', 'App Logistica');
            $mail->addReplyTo('noreplyautoniza@gmail.com', 'App Logistica');
            $mail->addAddress($viewSolicitud[0]["email"], $viewSolicitud[0]["nombreUsuarioOrigen"]);  // Agregar un destinatario

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Recepcion de Vehiculo con Observaciones';
            $mail->Body    = $message;  // El contenido HTML de la plantilla
            $mail->AltBody = strip_tags($message);  // Texto alternativo en caso de que no se pueda leer el HTML

            // Enviar el correo
            $mail->send();
            return 'Correo enviado con éxito';
        } catch (Exception $e) {
            return "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    }


    public function SaveAgencia()
    {
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();
        $vin=$_POST["vinAgencia"];
        date_default_timezone_set("America/Lima");
        $trasladoUbicacion=[
            'vin'=>$vin,
            'codigoAgenciaOrigen'=>$_POST["agenciaAnterior"],
            'codigoAgenciaDestino'=>$_POST["agenciaNueva"],
            'fechaTraslado'=>date("Y-m-d"),
            'horaTraslado'=>date("H:i:s"),
            'idtipoTraslado'=>3,
            'idestadoTraslado'=>1,
            'idusuarioTraslado'=>session("idusuario")
        ];

        $stor=$trasladoModel->StorageTraslado($trasladoUbicacion);

        if($stor){
            $filtroAnt=[
                'codigoAgencia'=>$_POST["agenciaAnterior"]
            ];
            $agenAnt=$trasladoModel->AgenciaDatos($filtroAnt);

            $filtroAct=[
                'codigoAgencia'=>$_POST["agenciaNueva"]
            ];
            $agenAct=$trasladoModel->AgenciaDatos($filtroAct);


            $vinupdate=[
                'codigoAgencia'=>null,
                'agencia'=>null,
                'codigoAgenciaOrigen'=>$agenAnt[0]["codigoAgencia"],
                'agenciaOrigen'=>$agenAnt[0]["descripcion"],
                'codigoAgenciaAnterior'=>$agenAnt[0]["codigoAgencia"],
                'agenciaAnterior'=>$agenAnt[0]["descripcion"],
                'fechaTrasladoAgencia'=>date("Y-m-d"),
                'idestadoTraslado'=>1,
                'idusuarioTraslado'=>session("idusuario"),
                'codigoAgenciaDestino'=>$agenAct[0]["codigoAgencia"],
                'agenciaDestino'=>$agenAct[0]["descripcion"],
                'idtrasladoVin'=>$stor
            ];

            $filtroVin=[
                'vin'=>$vin
            ];
            $up=$vinModel->UpdateVin($filtroVin,$vinupdate);

            if($up){
                $dato=[
                    'status'=>'success',
                    'title'=>'Cambio de Agencia',
                    'message'=>'Se realizo el cambio de agencia correctamente'
                ];
                echo json_encode($dato);
                exit();
            }
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Cambio de Agencia',
                'message'=>'Fallo al cambio de agencia'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}