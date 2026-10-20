<?php

namespace App\Controllers;

use App\Models\AccessModel;
use App\Models\SessionModel;
use App\Models\UsuarioModel;
use Ratchet\Client\WebSocket;
use Ratchet\Client\Connector;
use React\EventLoop\Factory;
use React\Socket\Connector as ReactConnector;
use Ratchet\RFC6455\Messaging\MessageInterface;

class Index extends BaseController
{
    public function Index()
    {

        if (session("login") == true) {
            $urlRedireccion = session("urlRedireccion");
            return redirect()->to($urlRedireccion);
        }

        echo view('Login/Index/Head');
        if (isset($_GET["loginVersion"])) {
            echo view('Login/Index/IndexV3');
        } else {
            echo view('Login/Index/IndexV3');
        }

        echo view("Layouts/RigthMenu");
        echo view('Login/Index/Footer');
    }
    public function SelectOperacion()
    {
        $session = \Config\Services::session();
        if (isset($_POST["operacionLogistica"])) {
            $session->set("database", $_POST["operacionLogistica"]);
            $operacion = '';
            if ($_POST["operacionLogistica"] == 'logistica_colombia') {
                $operacion = "Colombia";
            } else {
                $operacion = "Peru";
            }


            $dato = [
                'status' => 'success',
                'title' => 'Operacion Seleccionada ' . $operacion,
                'message' => 'Ingrese su usuario y contraseña'
            ];

            echo json_encode($dato);
            exit();
        }
    }

    private function BuscarIpValida($username,$database) {
        // Verifica si la IP está en las cabeceras
        $usuarioModel=New UsuarioModel();
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        // Verifica si la IP está en las cabeceras X-Forwarded-For (en caso de estar detrás de un proxy)
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $filtro=[
            'email'=>$username,
            'ipaddress'=>$ip
        ];

        $resultado=$usuarioModel->SearchIpValida($filtro);
        if (!$resultado) {
            $send=[
                'status'=>'danger',
                'title'=>'Intento de Sesion',
                'message'=>'La IP publica no es conocida, se envio un token de acceso para registrarla a su correo registrado en Gestyx'
            ];
            return json_encode($send);
        }else{
            $send=[
                'status'=>'success',
                'title'=>'',
                'message'=>''
            ];
            return json_encode($send);
        }

    }


    public function Access()
    {
        $session = \Config\Services::session();
        $request = \Config\Services::request();
        $accessModel = new AccessModel();
        $usuarioModel=New UsuarioModel();
        $clientIp = $request->getIPAddress();
        $filterExist = [
            'email' => $_POST["email"]
        ];

        if (isset($_POST["database"])) {
            $session->set("database", $_POST["database"]);
        }

        $userExist = $accessModel->UserExist($filterExist);

        if (!$userExist) {
            $dato = [
                'status' => 'danger',
                'message' => 'El usuario no existe en la Base de Datos',
                'title' => 'No Existe'
            ];
            echo json_encode($dato);
            exit();
        }

        if ($userExist[0]["password"] != $_POST["password"]) {
            $dato = [
                'status' => 'danger',
                'message' => 'La contraseña del usuario es incorrecta',
                'title' => 'Contraseña Errada'
            ];
            echo json_encode($dato);
            exit();
        }

        if ($userExist[0]["idestadoUsuario"] != 1) {
            $dato = [
                'status' => 'danger',
                'message' => 'La cuenta se encuentra suspendida',
                'title' => 'Usuario suspendido'
            ];
            echo json_encode($dato);
            exit();
        }
        $database=$_POST["database"];
        $username=$_POST["email"];

        /*
        $resultIp=json_decode($this->BuscarIpValida($username,$database));
        if($resultIp->status=='danger'){
            $dato = [
                'status' => $resultIp->status,
                'message' => $resultIp->message,
                'title' => $resultIp->title
            ];
            echo json_encode($dato);
            exit();
        }
        */

        if(is_null($userExist[0]["urlPredefinida"])){
            $dato = [
                'status' => 'danger',
                'message' => 'No tiene url de inicio',
                'title' => 'Usuario sin Url'
            ];
            echo json_encode($dato);
            exit();
        }

        $url = ($userExist[0]["ultimaUrl"] != '') ? $userExist[0]["ultimaUrl"] : $userExist[0]["urlPredefinida"];
        $idusuario = $userExist[0]["idusuario"];
        $navbarGrp = $accessModel->NavBarRol($idusuario,1);
        $navbarMd = $accessModel->NavBarRol($idusuario,2);
        $navbarSmd = $accessModel->NavBarRol($idusuario,3);
        $labelGmd = $accessModel->NavBarRol($idusuario,4);

        $filtroUsr = [
            'idusuario' => $idusuario
        ];

        $cod = $accessModel->AgenciaRolNew($filtroUsr);
        $marc = $accessModel->MarcaRol($filtroUsr);
        $cdbg = $accessModel->BodegaRolNew($filtroUsr);
        $ubisc=$accessModel->GrupoUbicacionRol($filtroUsr);
        $solis=$usuarioModel->DetailTipoSolicitud($filtroUsr);
        $codigoAgencias = [];
        $codigoBodega = [];
        $codigoGrupoUbicacion=[];
        $idmarca = [];
        $idtipoSoli=[];

        foreach($solis as $ssl){
            $idtipoSoli[]=$ssl["idtipoSolicitud"];
        }

        foreach($ubisc as $ub){
            $codigoGrupoUbicacion[]=$ub["idgrupoUbicacion"];
        }

        foreach ($marc as $mrs) {
            $idmarca[] = $mrs["idmarca"];
        }

        foreach ($cod as $cd) {
            $codigoAgencias[] = $cd["codigoAgencia"];
        }

        foreach ($cdbg as $bg) {
            $codigoBodega[] = $bg["codigoBodega"];
        }
        $loop = Factory::create();
        $connector = new Connector($loop);
        $usuario=$userExist[0]["nombres"]." ".$userExist[0]["apellidos"];
        $connector('ws://localhost:8080/chat')
            ->then(function (WebSocket $conn) use ($usuario) {
                // Aquí puedes enviar directamente el mensaje sin necesidad de la variable $vehiculosTodos
                $conn->send(json_encode([
                    "type" => "InicioSession",
                    "usuario"=>$usuario,
                    "database"=>session("database"),
                    "title"=>'Inicio Sesion',
                    "message"=>'Se Realizo el inicio de sesion del usuario '.$usuario
                ]));
                // Cierra la conexión después de enviar el mensaje
                $conn->close();
            }, function (Exception $e) {
                echo "No se pudo conectar: {$e->getMessage()}\n";
            });

        $loop->run();

        $userSession = [
            'nombres' => $userExist[0]["userName"],
            'nombresWebService' => $userExist[0]["nombres"],
            'apellidosWebService' => $userExist[0]["apellidos"],
            'codigoDocumentoColombia' => $userExist[0]["codigoDocumentoColombia"],
            'codigoDocumentoPeru' => $userExist[0]["codigoDocumentoPeru"],
            'cargo' => $userExist[0]["cargo"],
            'area' => $userExist[0]["area"],
            'correoUsuario' => $userExist[0]["email"],
            'documento' => $userExist[0]["documento"],
            'codigoVerificacionDocumento' => $userExist[0]["codigoVerificacionDocumento"],
            'notificacionCorreo' => $userExist[0]["notificacionCorreo"],
            'imagenUsuario' => $userExist[0]["imagen"],
            'idusuario' => $userExist[0]['idusuario'],
            'codigoGrupoUbicacion'=>$codigoGrupoUbicacion,
            'urlApis' => 'localhost',
            'codigoAgencia' => $codigoAgencias,
            'codigoBodega' => $codigoBodega,
            'idmarca' => $idmarca,
            'gestorSolicitudVehiculo'=>$userExist[0]["gestorSolicitudVehiculo"],
            'permitirRetornarEvento' => $userExist[0]["permitirRetornarEvento"],
            'urlRedireccion' => base_url($url),
            'grupoModulo' => $navbarGrp,
            'modulo'=>$navbarMd,
            'subModulo'=>$navbarSmd,
            'enviarExibicion'=>$userExist[0]["enviarExibicion"],
            'login' => true,
            'descargarPowerBi'=>$userExist[0]["descargarPowerBi"],
            'idsession' => 'ci_session' . $session->session_id,
            'numeroSessionWhatsapp'=>$userExist[0]["numeroSessionWhatsapp"],
            'tokenSeguridad'=>$userExist[0]["tokenSeguridad"],
            'agenteWhatsapp'=>$userExist[0]["agenteWhatsapp"],
            'idtipoSolicitud'=>$idtipoSoli,
            'labelGrupoModulo'=>$labelGmd,
            'gestorAuditoria'=>$userExist[0]["gestorAuditoria"]
        ];
        $session->set($userSession);
        $sessionId = $session->session_id;

        $sessionModel = new SessionModel();

        $filtroDest = [
            'idusuario' => $idusuario
        ];
        $detroyUs = $sessionModel->DestroySessions($filtroDest);

        $insertsSession = [
            'idusuario' => $idusuario,
            'ip_address' => $clientIp,
            'idsessions' => "ci_session" . $sessionId
        ];
        $storg = $sessionModel->SaveSessions($insertsSession);


        $dato = [
            'status' => 'success',
            'message' => 'Cargando los modulos de Sistema',
            'title' => 'Iniciando Sesion',
        ];

        echo json_encode($dato);
        exit();
    }
    public function DestroySession()
    {
        $sessionModel = new SessionModel();
        $idsession = session("idsession");
        $session = session();

        if (!$idsession) {
            // Redirigir a la página base si no existe `idsession`
            return redirect()->to(base_url('/'));
        }

        $filtroDest = [
            'idsessions' => $idsession
        ];
        $sessionPath = WRITEPATH . 'sessions\\'; // Ruta de los archivos de sesión
        $sessionFile = $sessionPath . $idsession;

        if (file_exists($sessionFile)) {
            if (unlink($sessionFile)) {
                $detroyUs = $sessionModel->DestroySessions($filtroDest);
            }
        }
        $session->destroy();
        return redirect()->to(base_url('/'));

    }
    public function ByeSession()
    {
        $sessionModel = new SessionModel();
        $idsession = $_GET["idsession"];

        $filtroDest = [
            'idsessions' => $idsession
        ];
        $sessionPath = WRITEPATH . 'sessions\\'; // Ruta de los archivos de sesión
        $sessionFile = $sessionPath . $idsession;

        if (file_exists($sessionFile)) {
            if (unlink($sessionFile)) {
                $detroyUs = $sessionModel->DestroySessions($filtroDest);
                echo "pruebas";
            }
        }
    }
}
