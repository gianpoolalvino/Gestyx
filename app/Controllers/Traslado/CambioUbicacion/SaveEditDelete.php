<?php
namespace App\Controllers\Traslado\CambioUbicacion;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EventoModel;
use App\Models\SolicitudVinModel;
use App\Models\TrasladoModel;
use App\Models\VinModel;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SaveEditDelete extends BaseController
{

    public function SaveBox()
    {
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();
        date_default_timezone_set('America/Lima');
        $fecha=date('Y-m-d');
        $hora=date('H:i:s');


        $filtroVer=[
            'idubicacion'=>$_POST["ubicacionNueva"],
            'idboxUbicacion'=>$_POST["boxNuevo"],
        ];

        $bxUb=$trasladoModel->VerificationBox($filtroVer);
        $storBx='';
        if(!$bxUb){
            $filtroDupli=[
                'idubicacion'=>$_POST["ubicacionNueva"],
                'descripcion'=>$_POST["boxNuevo"],

            ];
            $bxdD=$trasladoModel->VerificationBox($filtroDupli);
            if($bxdD){
                $dato=[
                    'status'=>'danger',
                    'title'=>'Ya Existe',
                    'message'=>'El Box que intentas generar ya existe y se encuentra ocupado'
                ];
                echo json_encode($dato);
                exit();
            }
            $storageBox=[
                'idubicacion'=>$_POST["ubicacionNueva"],
                'descripcion'=>$_POST["boxNuevo"],
                'tipoBox'=>1,
            ];
            $storBx=$trasladoModel->StorageBoxUbicacion($storageBox);
        }else{
            $storBx=$_POST["boxNuevo"];
        }



        $storageTraslado=[
            'vin'=>$_POST["vinUbicacion"],
            'fechaTraslado'=>$fecha,
            'horaTraslado'=>$hora,
            'idestadoTraslado'=>2,
            'idubicacionOrigen'=>$_POST["ubicacionAnterior"],
            'idubicacionDestino'=>$_POST["ubicacionNueva"],
            'idtipoTraslado'=>4,
            'idusuarioTraslado'=>session('idusuario'),
            'comentarios'=>$_POST["comentariosTraslado"],
            'idboxUbicacionOrigen'=>$_POST["boxAnterior"],
            'idboxUbicacionDestino'=>$storBx,
            'fechaRecepcion'=>$fecha,
            'horaRecepcion'=>$hora,
            'idusuarioRecepcion'=>session('idusuario'),
            'idgrupoUbicacionDestino'=>$_POST["idgrupoUbicacionActual"]
        ];

        $stor=$trasladoModel->StorageTraslado($storageTraslado);

        $filtroVin=[
            'vin'=>$_POST["vinUbicacion"]
        ];

        $update=[
            'idboxUbicacionAnterior'=>$_POST["boxAnterior"],
            'idboxUbicacionActual'=>$storBx
        ];

        $up=$vinModel->UpdateVin($filtroVin,$update);

        if($up){
            $dato=[
                'status'=>'success',
                'title'=>'Cambio de Box',
                'message'=>'Se realizo el cambio de ubicacion correctamente'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Cambio de Box',
                'message'=>'Fallo al cambio de ubicacion'
            ];
            echo json_encode($dato);
            exit();
        }

    }

    public function DeleteTransportista(){
        $trasladoModel=New TrasladoModel();

        $filtroTransportista=[
            'idtransportista'=>$_POST["idtransportista"]
        ];

        $delete=$trasladoModel->DestroyTransportista($filtroTransportista);

        if($delete){
            $send=[
                'status'=>'success',
                'title'=>'Eliminado Correctamente',
                'message'=>'Se elimino correctamente el transportista'
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Eliminado Errado',
                'message'=>'No se elimino el transportista'
            ];
            echo json_encode($send);
            exit();
        }
    }
    public function SaveTransportista()
    {
        $trasladoModel=New TrasladoModel();

        $storageTransportista=[
            'documento'=>$_POST["documento"],
            'razonSocial'=>$_POST["razonSocial"],
            'comentario'=>$_POST["comentarios"]
        ];

        $stor=$trasladoModel->StorageTransportista($storageTransportista);

        if($stor!=''){
           $dato=[
               'status'=>'success',
               'title'=>'Grabado con exito',
               'message'=>'Se grabo correctamente'
           ];
           echo json_encode($dato);
           exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error Critico',
                'message'=>'Fallo al grabar'
            ];
            echo json_encode($dato);
            exit();
        }
    }
    public function SaveGrupoUbicacion()
    {
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();
        $vin=$_POST["vinUbicacion"];


        $trasladoUbicacion=[
            'vin'=>$vin,
            'fechaTraslado'=>date("Y-m-d"),
            'horaTraslado'=>date("H:i:s"),
            'idtipoTraslado'=>1,
            'idtransportista'=>$_POST["transportista"],
            'conductor'=>$_POST["conductor"],
            'placaVehiculoTransportista'=>$_POST["placaVehiculo"],
            'idestadoTraslado'=>1,
            'idusuarioTraslado'=>session("idusuario"),
            'idgrupoUbicacionOrigen'=>($_POST["idgrupoUbicacionOrigen"]!='')?$_POST["idgrupoUbicacionOrigen"]:null,
            'idgrupoUbicacionDestino'=>$_POST["idgrupoUbicacionDestino"],
            'idgrupoUbicacionActual'=>$_POST["idgrupoUbicacionDestino"],
        ];

        $stor=$trasladoModel->StorageTraslado($trasladoUbicacion);


        $vinUpdate=[
            'idgrupoUbicacionOrigen'=>($_POST["idgrupoUbicacionOrigen"]!='')?$_POST["idgrupoUbicacionOrigen"]:null,
            'idgrupoUbicacionDestino'=>$_POST["idgrupoUbicacionDestino"],
            'idgrupoUbicacionActual'=>$_POST["idgrupoUbicacionDestino"],
            'idtrasladoUbicacion'=>$stor
        ];

        $filtroVin=[
            'vin'=>$vin
        ];
        $up=$vinModel->UpdateVin($filtroVin,$vinUpdate);

        if($up){
            $dato=[
                'status'=>'success',
                'title'=>'Cambio de Ubicacion',
                'message'=>'Se realizo el cambio de ubicacion correctamente'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Cambio de Ubicacion',
                'message'=>'Fallo al cambio de ubicacion'
            ];
            echo json_encode($dato);
            exit();
        }

    }
    public function StorageCheckNovedad()
    {
        // Establece la zona horaria
        date_default_timezone_set("America/Lima");

        // Crea una instancia del modelo
        $trasladoModel = new TrasladoModel();

        // Obtiene los valores del formulario
        $fecha = date("Y-m-d");
        $hora = date("H:i:s");
        $idtipoNovedad = $_POST["idtipoNovedad"];
        $comentario = $_POST["comentarioText"];
        $iddetalleEnvioTaller = $_POST["iddetalleEnvioTaller"];
        $idestadoNovedad = $_POST['estadoNovedad'];

        // Inicia una transacción
        $db = \Config\Database::connect();
        $db->transBegin();  // Comienza la transacción

        try {
            // Llama al modelo para realizar el almacenamiento de la novedad
            $update = $trasladoModel->StorageNovedadCheck($iddetalleEnvioTaller, $idtipoNovedad, $comentario, $fecha, $hora, $idestadoNovedad);

            // Si la actualización fue exitosa, confirma la transacción
            if ($update) {
                $db->transCommit();  // Confirma la transacción
                echo json_encode([
                    'status' => 'success',
                    'title' => 'Operación exitosa',
                    'message' => 'Novedad recepcionada correctamente.'
                ]);
            } else {
                // Si la actualización no fue exitosa, realiza un rollback
                $db->transRollback();  // Revierte la transacción
                echo json_encode([
                    'status' => 'danger',
                    'title' => 'Error',
                    'message' => 'Hubo un problema al registrar la novedad.'
                ]);
            }
        } catch (\Exception $e) {
            // Si ocurre una excepción, realiza un rollback y muestra el mensaje de error
            $db->transRollback();  // Revierte la transacción
            echo json_encode([
                'status' => 'danger',
                'title' => 'Error',
                'message' => 'Ocurrió un error en el proceso: ' . $e->getMessage()
            ]);
        }
    }
    public function SaveRecepcionUbicacion()
    {
        date_default_timezone_set("America/Lima");
        $trasladoModel=New TrasladoModel();
        $solicitudVin=New SolicitudVinModel();
        $vinModel=New VinModel();

        $hoy=date("Y-m-d");
        $hora=date("H:i:s");

        // Inicia la transacción
        $db = \Config\Database::connect();
        $db->transBegin();
        $idtrasladoVin='';

        try {
            $idtrasladoVin=$_POST["idtrasladoVin"];
            $filtro = [
                'vin' => $_POST["vinUbicacion"],
                'idtrasladoVin' => $idtrasladoVin,
               // 'idtipoTraslado' => 1
            ];

            if($_POST["retornoTaller"]==1){
                $identradaTaller=$_POST["identradaTaller"];
                $detNov=count($trasladoModel->DetalleNovedadesTaller($_POST["vinUbicacion"],1,$identradaTaller));
                if($detNov>0){
                    echo json_encode([
                        'status' => 'danger',
                        'title' => 'Recepcion con '.$detNov.' Novedades ',
                        'message' => 'La unidad esta retornando de taller, debe veirifcar las solucion de novedades'
                    ]);
                    exit();
                }
            }

            if($_POST["envioSolicitante"]==1){
                $filtSol=[
                    'vin'=>$_POST["vinUbicacion"],
                    'idsolicitudVehiculo'=>$_POST["idsolitiudVin"]
                ];

                $updateSol=[
                    'idestadoSolicitud'=>6,
                    'fechaRecepcion'=>$hoy,
                    'horaRecepcion'=>$hora
                ];
                $updtvin=$solicitudVin->UpdateVins($filtSol,$updateSol);

            }

            $viewTrasl = $trasladoModel->ViewFullTrUbicacion($filtro);

            // Verifica si se encontró información en el traslado
            if (empty($viewTrasl)) {
                // Si no se encontró, busca en el segundo modelo
                $filtroSecundario = [
                    'vin' => $_POST["vinUbicacion"],
                    //'idtipoTraslado' => 1 // Solo necesitas este filtro
                ];
                $viewTrasl = $trasladoModel->TrasladoFullIdUbi($filtroSecundario);
                // Verifica si se encontró información en el segundo modelo
                if (empty($viewTrasl)) {
                    throw new \Exception("No se encontró información del traslado.");
                }
                // Obtiene el idtrasladoVin del resultado
                $idtrasladoVin = $viewTrasl[0]["idtrasladoVin"];
                $filtro['idtrasladoVin'] = (int)$idtrasladoVin;
            }

            $filtroVin = [
                'vin' => $_POST["vinUbicacion"]
            ];

            $vinUpdate=[
                'idubicacion'=>$_POST["ubicacionNueva"],
                'idboxUbicacionActual'=>$_POST["boxNuevo"],
                'fechaTrasladoUbicacion'=>date("Y-m-d"),
                'idestadoTraslado'=>2,
                'idusuarioTraslado'=>session("idusuario"),
                'idtrasladoVinUbicacion'=>null,
                'idtrasladoUbicacion'=>null,
                'idgrupoUbicacionDestino'=>null,
            ];

            if($_POST["retornoTaller"]==1){
                $vinUpdate+=[
                    'retornoDeTaller'=>null,
                    'identradaTaller'=>null
                ];
            }

            if($_POST["idtipoTraslado"]==5){
                $vinUpdate+=[
                    'enTaller'=>1
                ];
            }

            if($_POST["envioSolicitante"]==1){
                $vinUpdate+=[
                    'envioSolicitante'=>null,
                    'idsolicitudVin'=>null
                ];
            }

            // Actualiza el vin
            $up = $vinModel->UpdateVin($filtroVin, $vinUpdate);

            // Actualiza el traslado
            $updateTras = [
                'idestadoTraslado' => 2,
                'fechaRecepcion'=>$hoy,
                'horaRecepcion'=>$hora,
                'idusuarioRecepcion'=>session('idusuario'),
                'idubicacionDestino'=>$_POST["ubicacionNueva"],
                'idboxUbicacionDestino'=>$_POST["boxNuevo"],
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


            $filtObs=[
                'idtrasladoVin'=>$_POST["idtrasladoVin"]
            ];

            $countObs=$trasladoModel->CountObsRecep($filtObs);
            $contador=$countObs[0]["contador"];
            $send='';
            if($contador>=1){
                $send=$this->SendMailNotificacion($_POST["idtrasladoVin"],$_POST["vinUbicacion"]);
            }

            $sendErpUbi=$this->IntegrateErpUbicacion($_POST["vinUbicacion"]);

            // Respuesta exitosa
            echo json_encode([
                'status' => 'success',
                'title' => 'Operación exitosa '.$contador,
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

    public function RegularizarVin()
    {
        set_time_limit(0);
        $vinModel=New VinModel();

        $resulta=$vinModel->RegularizaVin();

        foreach($resulta as $rst){
            $vin=$rst["vin"];
            $result=$this->IntegrateErpUbicacionDMSinIngreso($vin);
            var_dump($result);
        }
    }

    public function IntegrateErpUbicacionDMSinIngreso($vin='')
    {
        $vinModel=New VinModel();
        $ubi=$vinModel->RegularizaVin($vin);

        $url = "https://api.autoniza.net.pe/sincronizaColombia/SendUbicacionERP.php";
// Los parámetros a enviar
        $data = [
            'vin' => $vin,
            'codigoBodega' => $ubi[0]['codigoBodega'],
            'bodega' => $ubi[0]['bodega'],
            'idubicacionOrigen'=>$ubi[0]['idubicacionOrigen'],
            'idubicacionDestino'=>$ubi[0]['idubicacionDestino'],
            'ubicacionOrigen'=>$ubi[0]['ubicacionOrigen'],
            'ubicacionDestino'=>$ubi[0]['ubicacionDestino'],
        ];
// Inicializar cURL
        $ch = curl_init();

// Establecer las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $url);  // URL de la API
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Retorna la respuesta como string
        curl_setopt($ch, CURLOPT_POST, true);  // Usar POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  // Agregar los datos al cuerpo de la solicitud

// Desactivar la verificación SSL (solo para pruebas, no recomendado para producción)
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

// Ejecutar la solicitud cURL
        $response = curl_exec($ch);
        return json_decode($response);
        curl_close($ch);
    }


    public function UpdateUbicacionMasivoERP()
    {
        set_time_limit(0);
        $vinModel=New VinModel();

        $resulta=$vinModel->VinCompleto();

        foreach($resulta as $rst){
            $vin=$rst["vin"];
            $result=$this->IntegrateErpUbicacionDMS($vin);
            echo '<pre>';
            var_dump($result);
        }

    }

    public function UpdateUbicacionSendMas($ubicacion='')
    {
        set_time_limit(0);
        $vinModel=New VinModel();

        $resulta=$vinModel->VinPermitidos($ubicacion);

        foreach($resulta as $rst){
            $vin=$rst["vin"];
            $result=$this->IntegrateErpUbicacionDMS($vin);
            echo '<pre>';
            var_dump($result);
            echo $rst["vin"];
        }

    }

    public function IntegrateErpUbicacionDMS($vin='')
    {
        $trasladoModel=New TrasladoModel();
        $ubi=$trasladoModel->ObtenerUltimaUbicacion($vin);

        $url = "https://api.autoniza.net.pe/sincronizaColombia/SendUbicacionERP.php";
// Los parámetros a enviar
        $data = [
            'vin' => $vin,
            'codigoBodega' => $ubi[0]['codigoBodega'],
            'bodega' => $ubi[0]['bodega'],
            'idubicacionOrigen'=>$ubi[0]['idubicacionOrigen'],
            'idubicacionDestino'=>$ubi[0]['idubicacionDestino'],
            'ubicacionOrigen'=>$ubi[0]['ubicacionOrigen'],
            'ubicacionDestino'=>$ubi[0]['ubicacionDestino'],
        ];
// Inicializar cURL
        $ch = curl_init();

// Establecer las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $url);  // URL de la API
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Retorna la respuesta como string
        curl_setopt($ch, CURLOPT_POST, true);  // Usar POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  // Agregar los datos al cuerpo de la solicitud

// Desactivar la verificación SSL (solo para pruebas, no recomendado para producción)
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

// Ejecutar la solicitud cURL
        $response = curl_exec($ch);
        return json_decode($response);
        curl_close($ch);
    }



    public function IntegrateErpUbicacion($vin='')
    {
        $trasladoModel=New TrasladoModel();
        $ubi=$trasladoModel->ObtenerUltimaUbicacion($vin);

        $url = "https://api.autoniza.net.pe/sincronizaColombia/SendUbicacionERP.php";
// Los parámetros a enviar
        $data = [
            'vin' => $vin,
            'codigoBodega' => $ubi[0]['codigoBodega'],
            'bodega' => $ubi[0]['bodega'],
            'idubicacionOrigen'=>$ubi[0]['idubicacionOrigen'],
            'idubicacionDestino'=>$ubi[0]['idubicacionDestino'],
            'ubicacionOrigen'=>$ubi[0]['ubicacionOrigen'],
            'ubicacionDestino'=>$ubi[0]['ubicacionDestino'],
        ];
// Inicializar cURL
        $ch = curl_init();

// Establecer las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $url);  // URL de la API
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Retorna la respuesta como string
        curl_setopt($ch, CURLOPT_POST, true);  // Usar POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));  // Agregar los datos al cuerpo de la solicitud

// Desactivar la verificación SSL (solo para pruebas, no recomendado para producción)
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

// Ejecutar la solicitud cURL
        $response = curl_exec($ch);

        return json_decode($response);
        curl_close($ch);
    }


    public function SendMailNotificacion($idtrasladoVin,$vin)
    {
        $trasladoModel=New TrasladoModel();
        $solicitudVehicular=New SolicitudVinModel();
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
            $mail->Password   = 'mkdz gdcr xkkb abqa';                     // Tu contraseña de correo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;                          // Puerto para TLS

            // Remitente y destinatarios
            $mail->setFrom('noreplyautoniza@gmail.com', 'App Logistica');
            $mail->addReplyTo('noreplyautoniza@gmail.com', 'App Logistica');
            $mail->addAddress($viewSolicitud[0]["email"], $viewSolicitud[0]["nombreUsuarioOrigen"]);  // Agregar un destinatario

            $filterUs=[
                'gestorSolicitudVehiculo'=>1
            ];

            $userGest=$solicitudVehicular->UsuarioGestorSolicitud($filterUs);
            foreach($userGest as $us){
                $mail->addAddress($us["email"], $us["nombres"]);  // Agregar un destinatario
            }
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


    public function SaveUbicacion()
    {
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();
        
        if(!isset($_POST["vinUbicacion"])){
            $dato=[
                'status'=>'danger',
                'title'=>'Error en Proceso',
                'message'=>'No se logro realizar el cambio por error en el Vin reintente nuevamente'
            ];
            echo json_encode($dato);
            exit();
        }

        $vin=$_POST["vinUbicacion"];


        date_default_timezone_set("America/Lima");

        if($_POST["ubicacionAnterior"]==$_POST["ubicacionNueva"]){
            $dato=[
                'status'=>'danger',
                'title'=>'Error en Proceso',
                'message'=>'La ubicacion de origen y destino no pueden ser iguales'
            ];
            echo json_encode($dato);
            exit();
        }

        $trasladoUbicacion=[
            'vin'=>$vin,
            'idubicacionOrigen'=>$_POST["ubicacionAnterior"],
            'idubicacionDestino'=>$_POST["ubicacionNueva"],
            'fechaTraslado'=>date("Y-m-d"),
            'horaTraslado'=>date("H:i:s"),
            'idtipoTraslado'=>1,
            'idestadoTraslado'=>1,
            'conductor'=>$_POST["conductor"],
            'placaVehiculoTransportista'=>$_POST["placaVehiculo"],
            'idusuarioTraslado'=>session("idusuario"),
            'idboxUbicacionOrigen'=>($_POST["boxAnterior"]!='')?$_POST["boxAnterior"]:null,
            'idboxUbicacionDestino'=>$_POST["boxNuevo"],
            'idtransportista'=>$_POST["transportista"],
             'otros'=>$_POST["otros"]
        ];

        $stor=$trasladoModel->StorageTraslado($trasladoUbicacion);

        if($stor!=''){
            $vinupdate=[
                'idubicacion'=>$_POST["ubicacionNueva"],
                'idboxUbicacionActual'=>$_POST["boxNuevo"],
                'fechaTrasladoUbicacion'=>date("Y-m-d"),
                'idestadoTraslado'=>1,
                'idusuarioTraslado'=>session("idusuario"),
                'idubicacionAnterior'=>$_POST["ubicacionAnterior"],
                'idboxUbicacionAnterior'=>($_POST["boxAnterior"]!='')?$_POST["boxAnterior"]:null,
                'idubicacionOrigen'=>$_POST["ubicacionAnterior"],
                'idubicacionDestino'=>$_POST["ubicacionNueva"],
                'idboxUbicacionOrigen'=>($_POST["boxAnterior"]!='')?$_POST["boxAnterior"]:null,
                'idboxUbicacionDestino'=>$_POST["boxNuevo"],
                'idtrasladoUbicacion'=>$stor,
                'idgrupoUbicacionDestino'=>null,
                'enTaller'=>null,
                'retornoDeTaller'=>1
            ];

            $filtroVin=[
                'vin'=>$vin
            ];
            $up=$vinModel->UpdateVin($filtroVin,$vinupdate);

            if($up){
                $dato=[
                    'status'=>'success',
                    'title'=>'Cambio de Ubicacion',
                    'message'=>'Se realizo el cambio de ubicacion correctamente'
                ];
                echo json_encode($dato);
                exit();
            }
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Cambio de Ubicacion',
                'message'=>'Fallo al cambio de ubicacion'
            ];
            echo json_encode($dato);
            exit();
        }
    }

    public function UpdateUbicacionBoxMasivo()
    {
        $trasladoModel = new TrasladoModel();
        $vinModel = new VinModel();

        $idubicacion = $_GET["idubicacion"];
        $sheetName = $_GET["nombreHoja"];
        $file = 'resource/upload/ubicacionBox.xlsx';

        // Inicializar contadores y arrays para errores
        $contadorErrores = 0;
        $contadorCorrecto = 0;
        $erroresDetalles = [];

        try {
            // Cargar el archivo Excel
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
            // Obtener la hoja por su nombre
            $sheet = $spreadsheet->getSheetByName($sheetName);

            if ($sheet === null) {
                throw new Exception('La hoja no cuenta con el mismo nombre de marca');
            }

            $totalFilas = $sheet->getHighestRow();

            for ($row = 2; $row <= $totalFilas; $row++) {
                $vin = $sheet->getCell("A" . $row)->getFormattedValue();
                if ($vin != '') {
                    $box = $sheet->getCell("D" . $row)->getFormattedValue();
                    $filtroBox = [
                        'idubicacion' => $idubicacion,
                        'descripcion' => $box
                    ];
                    // Obtener idboxUbicacion
                    $boxUbicacion = $trasladoModel->BoxUbicacion($filtroBox);

                    if (empty($boxUbicacion)) {
                        // Si el box no existe, solo registrar el VIN con idubicacion
                        $boxUbicacion = [
                            ["idboxUbicacion" => null]
                        ];
                    } else {
                        $idboxUbicacion = $boxUbicacion[0]["idboxUbicacion"];
                    }

                    $idboxUbicacion = $boxUbicacion[0]["idboxUbicacion"] ?? null;

                    // Verificar si el VIN existe
                    $vinExistente = $vinModel->VinInfo($vin); // Implementar el método GetVinByVin en VinModel

                    if (empty($vinExistente)) {
                        $contadorErrores++;
                        $erroresDetalles[] = "VIN no encontrado en la base de datos: {$vin} en la fila {$row}.";
                        continue;
                    }

                    $trasladoUbicacion = [
                        'vin' => $vin,
                        'idubicacionDestino' => $idubicacion,
                        'fechaTraslado' => date("Y-m-d"),
                        'horaTraslado' => date("H:i:s"),
                        'idtipoTraslado' => 1,
                        'idestadoTraslado' => 1,
                        'idusuarioTraslado' => session("idusuario"),
                        'idboxUbicacionDestino' => $idboxUbicacion
                    ];

                    // Almacenar traslado
                    $stor = $trasladoModel->StorageTraslado($trasladoUbicacion);
                    if (!$stor) {
                        $contadorErrores++;
                        $erroresDetalles[] = "Error al almacenar traslado para VIN: {$vin} en la fila {$row}.";
                        continue;
                    }

                    $vinupdate = [
                        'idubicacion' => $idubicacion,
                        'fechaTrasladoUbicacion' => date("Y-m-d"),
                        'idestadoTraslado' => 1,
                        'idusuarioTraslado' => session("idusuario"),
                        'idboxUbicacionActual' => $idboxUbicacion,
                    ];

                    $filtroVin = [
                        'vin' => $vin
                    ];

                    // Actualizar VIN
                    $up = $vinModel->UpdateVin($filtroVin, $vinupdate);
                    if (!$up) {
                        $contadorErrores++;
                        $erroresDetalles[] = "Error al actualizar VIN: {$vin} en la fila {$row}.";
                        continue;
                    }

                    $contadorCorrecto++;
                } else {
                    $contadorErrores++;
                    $erroresDetalles[] = "VIN vacío en la fila {$row}.";
                }
            }

            $dato = [
                'status' => 'success',
                'title' => 'Proceso Completado',
                'message' => 'Proceso de actualización de ubicación completado. Registros correctos: ' . $contadorCorrecto . ', Registros con errores: ' . $contadorErrores,
                'erroresDetalles' => $erroresDetalles // Incluir detalles de los errores en la respuesta
            ];

        } catch (Exception $e) {
            // Manejar errores y excepciones
            $dato = [
                'status' => 'danger',
                'title' => 'Error',
                'message' => 'Ha ocurrido un error: ' . $e->getMessage(),
                'erroresDetalles' => [] // Vacío ya que se captura un error genérico
            ];
        }

    }
}