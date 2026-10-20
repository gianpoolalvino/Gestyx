<?php

namespace App\Controllers\Administrador\UsuarioPerfiles;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ComisionModel;
use App\Models\EntregadoModel;
use App\Models\ExhibicionModel;
use App\Models\ModuloModel;
use App\Models\SolicitudVinModel;
use App\Models\UsuarioModel;
use App\Models\VehiculosVendidosModel;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class CreateViewEdit extends BaseController
{
    public function SendMailCorreoMasivo()
    {
        $usuarioModel = new UsuarioModel();

        // Obtener todos los usuarios
        $usuarios = $usuarioModel->getAllUsuarios(); // Asegúrate de que esta función devuelva todos los usuarios

        // Configuración de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';                // Especificar el servidor SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = 'info@autoniza.com';    // Tu dirección de correo
            $mail->Password   = 'wqyi xefq ddxi fhxz';                     // Tu contraseña de correo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;                             // Puerto para TLS

            // Remitente y destinatarios
            $mail->setFrom('info@autoniza.com', 'Gestyx');
            $mail->addReplyTo('info@autoniza.com', 'Gestyx');

            // Recorrer todos los usuarios y enviar el correo
            foreach ($usuarios as $user) {
                $message = view('Administrador/UsuarioPerfiles/SendMailUsuario/IndexMasivo', ['us' => $user]); // Crear el contenido dinámico para cada usuario

                // Agregar el destinatario
                $mail->addAddress($user['email'], $user['nombres']);  // Agregar un destinatario

                // Contenido del correo
                $mail->isHTML(true);
                $mail->Subject = 'Envio Credencial';
                $mail->Body    = $message;  // El contenido HTML de la plantilla
                $mail->AltBody = strip_tags($message);  // Texto alternativo en caso de que no se pueda leer el HTML

                // Enviar el correo
                if (!$mail->send()) {
                    throw new Exception('Error al enviar el correo: ' . $mail->ErrorInfo);
                }

                // Limpiar las direcciones antes de enviar el siguiente correo
                $mail->clearAddresses();
            }

            $dato = [
                'status' => 'success',
                'title'  => 'Correos Enviados',
                'message' => 'Los correos se enviaron correctamente a todos los usuarios.'
            ];

        } catch (Exception $e) {
            $dato = [
                'status' => 'danger',
                'title'  => 'Error de Envio',
                'message' => "Hubo un error al enviar los correos: {$e->getMessage()}"
            ];
        }

        echo json_encode($dato);
    }

    public function SendMailCorreo()
    {
        $usuarioModel=New UsuarioModel();
        $idusuario=isset($_POST["idusuario"])?$_POST["idusuario"]:$_GET["idusuario"];

        $filtro=[
            'idusuario'=>$idusuario
        ];

        $dato=[
            'us'=>$usuarioModel->ViewUsuario($filtro)
        ];
        $message = view('Administrador/UsuarioPerfiles/SendMailUsuario/Index', $dato);
        $user=$usuarioModel->ViewUsuario($filtro);
        // Configuración de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';                // Especificar el servidor SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = 'info@autoniza.com';           // Tu dirección de correo
            $mail->Password   = 'wqyi xefq ddxi fhxz';                     // Tu contraseña de correo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port       = 465;                             // Puerto para TLS

            // Remitente y destinatarios
            $mail->setFrom('info@autoniza.com', 'Gestyx');
            $mail->addReplyTo('info@autoniza.com', 'Gestyx');
            $mail->addAddress($user[0]["email"], $user[0]["nombres"]);  // Agregar un destinatario

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Envio Credencial';
            $mail->Body    = $message;  // El contenido HTML de la plantilla
            $mail->AltBody = strip_tags($message);  // Texto alternativo en caso de que no se pueda leer el HTML

            // Enviar el correo
            $mail->send();
           $dato=[
               'status'=>'success',
               'title'=>'Correo Enviado',
               'message'=>'El correo se envio correctamente'
           ];
        } catch (Exception $e) {
            $dato=[
                'status'=>'danger',
                'title'=>'Error de Envio',
                'message'=>"El correo se envio correctamente {$mail->ErrorInfo}"
            ];
        }
        echo json_encode($dato);
    }

    public function CreateUsuario()
    {

        $send=[
            "status"=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/CreateUser/Index").view("Administrador/UsuarioPerfiles/CreateUser/Scripts")
        ];
        echo json_encode($send);
        exit();
    }

    public function EditUsuario()
    {
        $usuarioModel=New UsuarioModel();
        $idusuario=$_POST["idusuario"];

        $filtro=[
            'idusuario'=>$idusuario
        ];

        $user=$usuarioModel->ViewUsuario($filtro);

        $dato=[
            'idusuario'=>$idusuario,
            'viewUser'=>$user
        ];

        $send=[
            "status"=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/EditPerfil/Index",$dato).view("Administrador/UsuarioPerfiles/EditPerfil/Scripts")
        ];
        echo json_encode($send);
        exit();
    }

    public function LogOutRemoto()
    {
        $dato=[
            'idusuario'=>$_POST["idusuario"]
        ];

        $send=[
            "status"=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/LogOutRemoto/Index",$dato).view("Administrador/UsuarioPerfiles/LogOutRemoto/Scripts")
        ];
        echo json_encode($send);
        exit();
    }
    public function AsociarAgencia()
    {
        $idempresa=$_POST["idempresa"];
        $usuarioModel=New UsuarioModel();
        if($idempresa==''){
            $send=[
                'status'=>'warning',
                'title'=>'Campo Obligatorio',
                'message'=>'Debe seleccionar una empresa para ver las sedes disponibles'
            ];
            echo json_encode($send);
            exit();
        }

        $idusuario=$_POST["idusuario"];

        $filtro=[
            'idempresa'=>$idempresa
        ];

        $dato=[
            'agencia'=>$usuarioModel->SelectAgencia($filtro,$idusuario),
            'idusuario'=>$idusuario,
            'idempresa'=>$idempresa
        ];

        $send=[
            'status'=>'success',
            'info'=>view('Administrador/UsuarioPerfiles/AsociarAgencia/Index',$dato).view('Administrador/UsuarioPerfiles/AsociarAgencia/Scripts')
        ];
        echo json_encode($send);
        exit();
    }

    public function AsociarBodega()
    {
        $idempresa=$_POST["idempresa"];
        $usuarioModel=New UsuarioModel();
        if($idempresa==''){
            $send=[
                'status'=>'warning',
                'title'=>'Campo Obligatorio',
                'message'=>'Debe seleccionar una empresa para ver las sedes disponibles'
            ];
            echo json_encode($send);
            exit();
        }

        $idusuario=$_POST["idusuario"];

        $filtro=[
            'idempresa'=>$idempresa
        ];

        $dato=[
            'bodega'=>$usuarioModel->SelectBodega($filtro,$idusuario),
            'idusuario'=>$idusuario,
            'idempresa'=>$idempresa
        ];

        $send=[
            'status'=>'success',
            'info'=>view('Administrador/UsuarioPerfiles/AsociarBodega/Index',$dato).view('Administrador/UsuarioPerfiles/AsociarBodega/Scripts')
        ];
        echo json_encode($send);
        exit();
    }

    public function AsociarUbicacion()
    {
        $idempresa=$_POST["idempresa"];
        $usuarioModel=New UsuarioModel();
        if($idempresa==''){
            $send=[
                'status'=>'warning',
                'title'=>'Campo Obligatorio',
                'message'=>'Debe seleccionar una empresa para ver las ubicaciones disponibles'
            ];
            echo json_encode($send);
            exit();
        }

        $idusuario=$_POST["idusuario"];

        $filtro=[
            'idempresa'=>$idempresa
        ];

        $dato=[
            'grupoUbicacion'=>$usuarioModel->SelectGrupoUbicacion($filtro,$idusuario),
            'idusuario'=>$idusuario,
            'idempresa'=>$idempresa
        ];

        $send=[
            'status'=>'success',
            'info'=>view('Administrador/UsuarioPerfiles/AsociarUbicacion/Index',$dato).view('Administrador/UsuarioPerfiles/AsociarUbicacion/Scripts')
        ];
        echo json_encode($send);
        exit();
    }

    public function DeleteUbicacion()
    {
        $idusuarioGrupoUbicacion=$_POST["idusuarioGrupoUbicacion"];

        $dato=[
            'idusuarioGrupoUbicacion'=>$idusuarioGrupoUbicacion
        ];
        $send=[
            'status'=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/DeleteUbicacion/Index",$dato).view("Administrador/UsuarioPerfiles/DeleteUbicacion/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function DeleteBodega()
    {
        $idusuarioBodega=$_POST["idusuarioBodega"];

        $dato=[
            'idusuarioBodega'=>$idusuarioBodega
        ];
        $send=[
            'status'=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/DeleteBodega/Index",$dato).view("Administrador/UsuarioPerfiles/DeleteBodega/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function DeleteAgencia()
    {
        $idusuarioSede=$_POST["idusuarioSede"];

        $dato=[
            'idusuarioSede'=>$idusuarioSede
        ];
        $send=[
            'status'=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/DeleteAgencia/Index",$dato).view("Administrador/UsuarioPerfiles/DeleteAgencia/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function DeleteRol()
    {
        $idrol=$_POST["idrol"];

        $dato=[
            'idrol'=>$idrol
        ];
        $send=[
            'status'=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/DeleteRol/Index",$dato).view("Administrador/UsuarioPerfiles/DeleteRol/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function SubModulo()
    {
        $idmodulo=$_POST["idmodulo"];
        $moduloModel=New ModuloModel();

        $filt=[
            'idmodulo'=>$idmodulo
        ];

        $idusuario=$_POST["idusuario"];

        $dato=[
            'subModulo'=>$moduloModel->SubModulo($idusuario,$idmodulo),
            'idusuario'=>$_POST["idusuario"]
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/SubModulo/Index",$dato).view("Administrador/UsuarioPerfiles/SubModulo/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function DetailRolUsuario()
    {
        $idusuario=$_POST["idusuario"];
        $idgrupoModulo=$_POST["idgrupoModulo"];
        $usuarioModel=New UsuarioModel();

        $filtro=[
            'idusuario'=>$idusuario,
            'idgrupoModulo'=>$idgrupoModulo
        ];

        $dato=[
            'detailGrupo'=>$usuarioModel->DetailGrupoModulo($filtro),
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/DetailRolUsuario/Index",$dato).view("Administrador/UsuarioPerfiles/DetailRolUsuario/Scripts")
        ];

        echo json_encode($send);
        exit();

    }

    public function DetailUsuarioBodega()
    {
        $idempresa=$_POST["idempresa"];
        $idusuario=$_POST["idusuario"];
        $usuarioModel=New UsuarioModel();

        $filtro=[
            'idempresa'=>$idempresa,
            'idusuario'=>$idusuario
        ];

        $dato=[
            "detailBodega"=>$usuarioModel->BodegaUsuario($filtro)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/DetailBodega/Index",$dato).view("Administrador/UsuarioPerfiles/DetailBodega/Scripts")
        ];

        echo json_encode($send);
        exit();

    }

    public function DetailUsuarioUbicacion()
    {
        $idempresa=$_POST["idempresa"];
        $idusuario=$_POST["idusuario"];
        $usuarioModel=New UsuarioModel();

        $filtro=[
            'idempresa'=>$idempresa,
            'idusuario'=>$idusuario
        ];

        $dato=[
            "detailUbicacion"=>$usuarioModel->UbicacionUsuario($filtro)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/DetailUbicacion/Index",$dato).view("Administrador/UsuarioPerfiles/DetailUbicacion/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function DetailTipoSolicitud()
    {
        $idusuario=$_POST["idusuario"];
        $usuarioModel=New UsuarioModel();

        $filtro=[
            'idusuario'=>$idusuario
        ];

        $dato=[
            "detailTipoSolicitud"=>$usuarioModel->DetailTipoSolicitud($filtro)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/DetailTipoSolicitud/Index",$dato).view("Administrador/UsuarioPerfiles/DetailTipoSolicitud/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function DetailUsuarioAgencia()
    {
        $idempresa=$_POST["idempresa"];
        $idusuario=$_POST["idusuario"];
        $usuarioModel=New UsuarioModel();

        $filtro=[
            'idempresa'=>$idempresa,
            'idusuario'=>$idusuario
        ];

        $dato=[
            "detailAgencia"=>$usuarioModel->AgenciaUsuario($filtro)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/DetailAgencia/Index",$dato).view("Administrador/UsuarioPerfiles/DetailAgencia/Scripts")
        ];

        echo json_encode($send);
        exit();

    }

    public function AsociarModulo()
    {
        $idgrupoModulo=$_POST["idgrupoModulo"];
        $usuarioModel=New UsuarioModel();
        if($idgrupoModulo==''){
            $send=[
                'status'=>'warning',
                'title'=>'Campo Obligatorio',
                'message'=>'Debe seleccionar un grupo de Modulos para ver los modulos disponibles'
            ];
            echo json_encode($send);
            exit();
        }
        $idusuario=$_POST["idusuario"];

        $filter=[
            'idgrupoModulo'=>$idgrupoModulo
        ];

        $grupoMod=$usuarioModel->SelectGrupoModulo($filter);

        if($grupoMod[0]["parent"]!=1){
            $filtro=[
                'gmd.idgrupoModulo'=>$idgrupoModulo,
                'gmd.parent'=>null
            ];
            $selectGm=$usuarioModel->ListGrupoModulo($filtro,$idusuario);
            if($selectGm){
                $dato=[
                    'idtipoGrupoModulo'=>2,
                    'idgrupoModulo'=>$idgrupoModulo,
                    'idusuario'=>$idusuario,
                    'parentGrupo'=>$grupoMod[0]["parent"],
                    'grupoModulo'=>$grupoMod
                ];
                $send=[
                    'info'=>view("Administrador/UsuarioPerfiles/AsociarModulo/Index",$dato).view("Administrador/UsuarioPerfiles/AsociarModulo/Scripts"),
                    'status'=>'success',
                ];
                echo json_encode($send);
                exit();
            }else{
                $send=[
                    'status'=>'warning',
                    'title'=>'Ya existe el rol',
                    'message'=>'El grupo de modulos seleccionado ya se encuentra en sus roles'
                ];
                echo json_encode($send);
                exit();
            }
        }else{
            $filtro=[
                'md.idgrupoModulo'=>$idgrupoModulo
            ];
            $selectMd=$usuarioModel->SelectModulo($filtro,$idusuario);

            $dato=[
                'idtipoGrupoModulo'=>1,
                'idgrupoModulo'=>$idgrupoModulo,
                'modulo'=>$selectMd,
                'idusuario'=>$idusuario,
                'parentGrupo'=>1,
                'grupoModulo'=>$grupoMod
            ];
            $send=[
                'info'=>view("Administrador/UsuarioPerfiles/AsociarModulo/Index",$dato).view("Administrador/UsuarioPerfiles/AsociarModulo/Scripts"),
                'status'=>'success',
            ];
            echo json_encode($send);
            exit();
        }
    }

    public function Access()
    {
        $usuarioModel=New UsuarioModel();

        $filtro=[
            'idusuario'=>$_POST["idusuario"]
        ];

        $dato=[
            'idusuario'=>$_POST["idusuario"],
            'selectUsuario'=>$usuarioModel->DetailIndexUsuario(''),
            'tipoSolicitud'=>$usuarioModel->DetailTipoSolicitud($filtro),
            'grupoModulo'=>$usuarioModel->SelectGrupoModulo(''),
            'selectTipoSoli'=>$usuarioModel->SelectTipoSolicitud(),
            'empresa'=>$usuarioModel->SelectEmpresa(),
            'viewUser'=>$usuarioModel->ViewUserConfig($filtro)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/Access/Index",$dato).view("Administrador/UsuarioPerfiles/Access/Scripts",$dato)
        ];
        echo json_encode($send);
        exit();
    }

    public function Password()
    {
        $usuarioModel=New UsuarioModel();

        $filtro=[
            'idusuario'=>$_POST["idusuario"]
        ];

        $dato=[
            'idusuario'=>$_POST["idusuario"],
            'viewUser'=>$usuarioModel->ViewUserConfig($filtro)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Administrador/UsuarioPerfiles/Password/Index",$dato).view("Administrador/UsuarioPerfiles/Password/Scripts")
        ];
        echo json_encode($send);
        exit();
    }
}