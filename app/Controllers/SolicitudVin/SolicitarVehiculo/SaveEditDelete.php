<?php
namespace App\Controllers\SolicitudVin\SolicitarVehiculo;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EventoModel;
use App\Models\ExhibicionModel;
use App\Models\GeneralesModel;
use App\Models\SolicitudVinModel;
use App\Models\UrgenteModel;
use App\Models\VinModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class SaveEditDelete extends BaseController
{
    public function StorageEstado()
    {
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hor=date("H:i:s");
        $solicitudModel = new SolicitudVinModel();
        $filtroUp = [
            'idsolicitudVehiculo' => $_POST["idsolicitudVehiculo"]
        ];

        $update = [
            'idestadoSolicitud' => $_POST["estadoSolicitud"],
            'comentarioRechazo'=>$_POST["comentario"]
        ];

        $proces = $solicitudModel->UpdateSolicitudVehiculo($filtroUp, $update);

        if ($proces) {
            $send = [
                'status' => 'success',
                'title' => 'Correcto',
                'message' => 'El proceso se realizó correctamente',
            ];

            $this->NotificacionRespuesta($_POST["idsolicitudVehiculo"],$_POST["estadoSolicitud"]);

            $storage=[
                'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"],
                'idestadoSolicitud'=>2,
                'fecha'=>$hoy,
                'idusuario'=>session("idusuario"),
                'hora'=>$hor
            ];

            $str=$solicitudModel->StorageHistory($storage);

        } else {
            $send = [
                'status' => 'danger',
                'title' => 'Error en proceso',
                'message' => 'No se logró completar el proceso',
            ];
        }

        echo json_encode($send);
        exit();

    }
    public function NotificacionRespuesta($idsolicitudTraslado='',$tipoRespuesta=''){
        $solicitudVehicular=New SolicitudVinModel();

        $filtro=[
            'idsolicitudVehiculo'=>$idsolicitudTraslado
        ];

        $dato=[
            'viewSolicitud'=>$solicitudVehicular->DetailIndex($filtro),
            'detailCreate'=>$solicitudVehicular->DetailSolicitudVehiculo($filtro),
        ];
        if($tipoRespuesta==3){
            $message = view('NotificacionCorreo/SolicitudVehicular/ProcesandoSolicitud', $dato);
        }else if($tipoRespuesta==4){
            $message = view('NotificacionCorreo/SolicitudVehicular/RechazoSolicitud', $dato);
        }

        // Configuración de PHPMailer
        $mail = new PHPMailer(true);
        $viewSolicitud=$solicitudVehicular->DetailIndex($filtro);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';                // Especificar el servidor SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = 'german.torres@autoniza.com';           // Tu dirección de correo
            $mail->Password   = 'mkdz gdcr xkkb abqa';                     // Tu contraseña de correo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;                                // Puerto para TLS

            // Remitente y destinatarios
            $mail->setFrom('noreplyautoniza@gmail.com', 'App Logistica');
            $mail->addReplyTo('noreplyautoniza@gmail.com', 'App Logistica');
            $mail->addAddress($viewSolicitud[0]["email"], $viewSolicitud[0]["solicitante"]);  // Agregar un destinatario

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Respuesta Solicitud Traslado Vehicular - '.$idsolicitudTraslado;
            $mail->Body    = $message;  // El contenido HTML de la plantilla
            $mail->AltBody = strip_tags($message);  // Texto alternativo en caso de que no se pueda leer el HTML

            // Enviar el correo
            $mail->send();
            return 'Correo enviado con éxito';
        } catch (Exception $e) {
            return "Error al enviar el correo: {$mail->ErrorInfo}";
        }

    }

    public function StorageSolicitud()
    {
        $solicitudModel = new SolicitudVinModel();
        date_default_timezone_set("America/Lima");
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");

        $filtroUp = [
            'idsolicitudVehiculo' => $_POST["idsolicitudVehiculo"]
        ];

        $viewSol = $solicitudModel->ViewSolicitudFull($filtroUp);
        $dta = $solicitudModel->DetailSolicitudVehiculo($filtroUp);

        $errores = [];

        if (!$dta) {
            $errores[] = 'No ingreso ningun Vehiculo';
        }

        if (is_null($viewSol[0]["nombreRecepciona"])) {
            $errores[] = 'No ingreso los datos de Recepcion';
        }

        if (is_null($viewSol[0]["nombreCustodia"])) {
            $errores[] = 'No ingreso los datos para Custodia';
        }

        if($_POST["tipoSolicitud"]==2){
            if ($_POST["fechaEstimadaRetorno"]=='') {
                $errores[] = 'No ingreso fecha de retorno de unidad';
            }
        }

        if($_POST["tipoSolicitud"]==2){
            if ($_POST["agenciaSolicitud"]=='') {
                $errores[] = 'No ingreso una agencia solicitante';
            }
        }

        if (!empty($errores)) {
            $send = [
                'status' => 'danger',
                'title' => 'Error en proceso',
                'message' => $errores,
            ];
            echo json_encode($send);
            exit();
        }

        $count = $solicitudModel->CountSolicitudes();

        $filtroConfig=[
            'horaInicio<='=>$hora,
            'horaFin>='=>$hora
        ];

        $configSolicitud=$solicitudModel->ConfigSolicitud($filtroConfig);

        $mod_date = strtotime($hoy."+ ".$configSolicitud[0]["diaAnhadido"]." days");

        $fechaAten=date("Y-m-d",$mod_date);


        $contador = $count[0]["contador"];

        $update = [
            'idtipoSolicitud' => $_POST["tipoSolicitud"],
            'fechaSolicitud' => $hoy,
            'horaSolicitud' => $hora,
            'fechaEnvio' => $_POST["fechaEstimadaEnvio"],
            'idcentroCosto' => $_POST["centroCosto"],
            'idestadoSolicitud' => 1,
            'numeroSolicitud' => $contador + 1,
            'idusuario'=>session("idusuario"),
            'idtipoOrigen'=>$_POST["checkUbicacionGeneral"],
            'comentarioSolicitud'=>$_POST["comentarioSolicitud"],
            'fechaAtencion'=>$fechaAten
        ];

        if ($_POST["tipoSolicitud"] == 2) {
            $update += [
                'fechaRetorno' => $_POST["fechaEstimadaRetorno"]
            ];
        }

        if ($_POST["checkUbicacionGeneral"] == 2) {
            $update += [
                'origen' => $_POST["origenVin"],
                'destino' => $_POST["destinoVin"]
            ];
        }

        $proces = $solicitudModel->UpdateSolicitudVehiculo($filtroUp, $update);

        $updatVin=[
            'idestadoSolicitud'=>1
        ];

        $updateEstVin=$solicitudModel->UpdateVins($filtroUp,$updatVin);

        if($_POST["tipoSolicitud"]==2){
            foreach($dta as $dts){
                $vinDetail=$dts["vin"];
                $exhibi=$this->SaveExhibicion($vinDetail,$_POST["agenciaSolicitud"],$_POST["fechaEstimadaEnvio"],$_POST["fechaEstimadaRetorno"],$_POST["comentarioSolicitud"]);
            }
        }

        if ($proces) {
            $send = [
                'status' => 'success',
                'title' => 'Correcto',
                'message' => 'El proceso se realizó correctamente',
            ];

            $storage=[
                'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"],
                'idestadoSolicitud'=>2,
                'fecha'=>$hoy,
                'idusuario'=>session("idusuario"),
                'hora'=>$hora
            ];
            $str=$solicitudModel->StorageHistory($storage);
            $this->NotificacionRegistro($_POST["idsolicitudVehiculo"]);
            $this->NotificacionRegistroPdi($_POST["idsolicitudVehiculo"]);
        } else {
            $send = [
                'status' => 'danger',
                'title' => 'Error en proceso',
                'message' => 'No se logró completar el proceso',
            ];
        }

        echo json_encode($send);
        exit();

    }
    
    public function SaveExhibicion($vin,$agencia,$fechaSolicitud,$fechaRetorno,$comentario)
    {
        $exhibicionModel=New ExhibicionModel();
        $generalModel=New GeneralesModel();
        $vinModel=New VinModel();
        $eventoModel=New EventoModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");

        $filtro=[
            'vin'=>$vin,
            'idestadoExhibicion'=>2
        ];

        $du=$exhibicionModel->RegistroExhibicion($filtro);

        if($du[0]["contador"]>0){
            $dato=[
                'status'=>'danger',
                'title'=>'Error de Duplicado',
                'message'=>'El Vin no puede ser enviado dos veces a exhibicion sin retornar '.$vin
            ];
            return json_encode($dato);
        }

        $idExi='';
        $filtroAgen=[
            'idagencia'=>$agencia
        ];

        $agen=$generalModel->Agencia($filtroAgen);

        $filtro+=[
            'solicitante'=>'Solicitud Vehicular',
            'idagenciaSolicitante'=>$agencia,
            'idestadoExhibicion'=>2,
            'fechaEstimadaEnvioExhibicion'=>$fechaSolicitud,
            'fechaEstimadaRetornoExhibicion'=>$fechaRetorno,
            'comentario'=>$comentario,
            'codigoAgencia'=>$agen[0]["codigoAgencia"],
            'agencia'=>$agen[0]["descripcion"]
        ];
        if($du[0]["contador"]==0){
            $idExi=$exhibicionModel->StorageExhibicion($filtro);
        }

        $filtroOrd=[
            'orden'=>1
        ];
        $odpdi=$eventoModel->OrdenEvento($filtroOrd);

        $filtroUpdateVin=[
            'vin'=>$vin
        ];
        $updateVin=[
            'idestadoVin'=>6,
            'ideventoActual'=>$odpdi[0]["idevento"],
            'eventoActual'=>$odpdi[0]["descripcionOrden"],
            'ideventoAnterior'=>30,
            'eventoAnterior'=>'Inventario',
            'fechaEventoActual'=>$hoy,
            'horaEventoActual'=>$hora,
            'codigoAgencia'=>$agen[0]["codigoAgencia"],
            'agencia'=>$agen[0]["descripcion"]
        ];
        $updateVn=$vinModel->UpdateVin($filtroUpdateVin,$updateVin);
        if($updateVn){
            $eventoActual=[
                'fechaRegistroSistemaInicio'=>$hoy,
                'fechaInicio'=>$hoy,
                'vin'=>$vin,
                'horaInicio'=>$hora,
                'ideventoAnterior'=>30,
                'eventoAnterior'=>'Inventario',
                'ideventoActual'=>$odpdi[0]["idevento"],
                'eventoActual'=>$odpdi[0]["descripcionOrden"],
                'idestadoEvento'=>1
            ];
            $store=$eventoModel->StorageEvento($eventoActual);
        }

        if($idExi!=''){
            $dato=[
                'status'=>'success',
                'title'=>'Guardado Correcto',
                'message'=>'Se almaceno correctamente'
            ];
            return json_encode($dato);
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error de Datos',
                'message'=>'No se logro almacenar correctamente los datos'
            ];
            return json_encode($dato);
        }
    }
    public function NotificacionRegistro($idsolicitudVehicular='')
    {
        $solicitudVehicular=New SolicitudVinModel();

        $filtro=[
            'idsolicitudVehiculo'=>$idsolicitudVehicular
        ];

        $dato=[
            'viewSolicitud'=>$solicitudVehicular->DetailIndex($filtro),
            'detailCreate'=>$solicitudVehicular->DetailSolicitudVehiculo($filtro),
        ];

        $message = view('NotificacionCorreo/SolicitudVehicular/RegistroSolicitud', $dato);
        // Configuración de PHPMailer
        $mail = new PHPMailer(true);
        $viewSolicitud=$solicitudVehicular->DetailIndex($filtro);
        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';                // Especificar el servidor SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = 'german.torres@autoniza.com';           // Tu dirección de correo
            $mail->Password   = 'mkdz gdcr xkkb abqa';                     // Tu contraseña de correo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;                               // Puerto para TLS

            // Remitente y destinatarios
            $mail->setFrom('applogistica@gmail.com', 'App Logistica');
            $mail->addReplyTo('applogistica@gmail.com', 'App Logistica');
            $mail->addAddress($viewSolicitud[0]["email"], $viewSolicitud[0]["solicitante"]);  // Agregar un destinatario

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Registro Solicitud - '.$idsolicitudVehicular;
            $mail->Body    = $message;  // El contenido HTML de la plantilla
            $mail->AltBody = strip_tags($message);  // Texto alternativo en caso de que no se pueda leer el HTML

            // Enviar el correo
            $mail->send();
            return 'Correo enviado con éxito';
        } catch (Exception $e) {
            return "Error al enviar el correo: {$mail->ErrorInfo}";
        }

    }
    public function NotificacionRegistroPdi($idsolicitudVehicular='')
    {
        $solicitudVehicular=New SolicitudVinModel();

        $filtro=[
            'idsolicitudVehiculo'=>$idsolicitudVehicular
        ];

        $dato=[
            'viewSolicitud'=>$solicitudVehicular->DetailIndex($filtro),
            'detailCreate'=>$solicitudVehicular->DetailSolicitudVehiculo($filtro),
        ];

        $message = view('NotificacionCorreo/SolicitudVehicular/RegistroVehicularLogistica', $dato);
        // Configuración de PHPMailer
        $mail = new PHPMailer(true);

        $filterUs=[
            'gestorSolicitudVehiculo'=>1
        ];

        $userGest=$solicitudVehicular->UsuarioGestorSolicitud($filterUs);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';                // Especificar el servidor SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = 'german.torres@autoniza.com';           // Tu dirección de correo
            $mail->Password   = 'mkdz gdcr xkkb abqa';                     // Tu contraseña de correo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;                                 // Puerto para TLS
            // Remitente y destinatarios
            $mail->setFrom('applogistica@gmail.com', 'App Logistica');
            $mail->addReplyTo('applogistica@gmail.com', 'App Logistica');
            foreach($userGest as $us){
                $mail->addAddress($us["email"], $us["nombres"]);  // Agregar un destinatario
            }
            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Registro Solicitud - '.$idsolicitudVehicular;
            $mail->Body    = $message;  // El contenido HTML de la plantilla
            $mail->AltBody = strip_tags($message);  // Texto alternativo en caso de que no se pueda leer el HTML
            // Enviar el correo
            $mail->send();
            return 'Correo enviado con éxito';
        } catch (Exception $e) {
            return "Error al enviar el correo: {$mail->ErrorInfo}";
        }

    }
    public function DeleteVehiculo()
    {
        $solicitudVehiculo=New SolicitudVinModel();

        $filtro=[
            'iddetalleSolicitudVehiculo'=>$_POST["iddetalleSolicitudVehiculo"],
            'vin'=>$_POST["vinSol"]
        ];

        $proces=$solicitudVehiculo->DestroyDetailCreate($filtro);

        if($proces){
            $send=[
                'status'=>'success',
                'title'=>'Correcto',
                'message'=>'El proceso se realizo correctamente',
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error en proceso',
                'message'=>'No se logro completar el proceso',
            ];
            echo json_encode($send);
            exit();
        }
    }
    public function DeleteDetailCreate()
    {
        $solicitudVehiculo=New SolicitudVinModel();

        $filtro=[
            'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"]
        ];

        $proces=$solicitudVehiculo->DestroyDetailCreate($filtro);

        if($proces){
            $send=[
                'status'=>'success',
                'title'=>'Correcto',
                'message'=>'El proceso se realizo correctamente',
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error en proceso',
                'message'=>'No se logro completar el proceso',
            ];
            echo json_encode($send);
            exit();
        }
    }

    public function SaveVehiculo()
    {
        $solicitudVehiculo=New SolicitudVinModel();


        $vin=$_POST["vinSol"];

        $result=$solicitudVehiculo->DetectarVinActual($vin);

        if($result){
            $send=[
                'status'=>'danger',
                'title'=>'Error Vin',
                'message'=>'El Vin Ingresado ya tiene una solicitud',
            ];
            echo json_encode($send);
            exit();
        }

        $filtroDupli=[
            'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"],
            'vin'=>$vin
        ];

        $resultSoli=$solicitudVehiculo->DetectarVehiculoDuplicado($filtroDupli);

        if($resultSoli){
            $send=[
                'status'=>'danger',
                'title'=>'Error Vin',
                'message'=>'El Vin Ingresado ya se encuentra en la solicitud',
            ];
            echo json_encode($send);
            exit();
        }


        $detailSoli=[
            'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"],
            'vin'=>$_POST["vinSol"],
            'idorigen'=>$_POST["origenVinInd"],
            'idtipoOrigen'=>3,
            'destino'=>$_POST["destinoVinInd"]
        ];

        $iddet=$solicitudVehiculo->StorageDetalleSolicitud($detailSoli);

        if($iddet!=''){
            $send=[
                'status'=>'success',
                'title'=>'Correcto',
                'message'=>'Se añadio el vin a la solicitud correctamente',
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Errado',
                'message'=>'Ocurrio un error agregando el vin reintente nuevamente',
            ];
            echo json_encode($send);
            exit();
        }
    }
    public function SaveRecepciona()
    {
        $solicitudVehiculo=New SolicitudVinModel();

        $filtroUp=[
          'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"]
        ];

        $update=[
            'nombreRecepciona'=>$_POST["nombreRecepciona"],
            'cargoRecepciona'=>$_POST["cargoRecepciona"],
            'telefonoRecepciona'=>$_POST["telefonoRecepciona"]
        ];

        $ups=$solicitudVehiculo->UpdateSolicitudVehiculo($filtroUp,$update);

        if($ups){
            $send=[
                'status'=>'success',
                'title'=>'Correcto',
                'message'=>'Se añadio correctamente la recepcion',
                'nombreRecepciona'=>$_POST["nombreRecepciona"],
                'cargoRecepciona'=>$_POST["cargoRecepciona"],
                'telefonoRecepciona'=>$_POST["telefonoRecepciona"]
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Proceso Errado',
                'message'=>'Ocurrio un error al registrar quien recepciona',
                'nombreRecepciona'=>'',
                'cargoRecepciona'=>'',
                'telefonoRecepciona'=>''
            ];
            echo json_encode($send);
            exit();
        }
    }
    public function SaveCustodia()
    {
        $solicitudVehiculo=New SolicitudVinModel();

        $filtroUp=[
            'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"]
        ];

        $update=[
            'nombreCustodia'=>$_POST["nombreCustodia"],
            'cargoCustodia'=>$_POST["cargoCustodia"],
            'telefonoCustodia'=>$_POST["telefonoCustodia"]
        ];

        $ups=$solicitudVehiculo->UpdateSolicitudVehiculo($filtroUp,$update);

        if($ups){
            $send=[
                'status'=>'success',
                'title'=>'Correcto',
                'message'=>'Se añadio correctamente la recepcion',
                'nombreCustodia'=>$_POST["nombreCustodia"],
                'cargoCustodia'=>$_POST["cargoCustodia"],
                'telefonoCustodia'=>$_POST["telefonoCustodia"]
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Proceso Errado',
                'message'=>'Ocurrio un error al registrar quien recepciona',
                'nombreCustodia'=>'',
                'cargoCustodia'=>'',
                'telefonoCustodia'=>''
            ];
            echo json_encode($send);
            exit();
        }
    }
}