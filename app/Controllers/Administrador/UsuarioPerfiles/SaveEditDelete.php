<?php

namespace App\Controllers\Administrador\UsuarioPerfiles;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EntregadoModel;
use App\Models\ExhibicionModel;
use App\Models\ModuloModel;
use App\Models\UsuarioModel;
use App\Models\VehiculosVendidosModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\SessionModel;

class SaveEditDelete extends BaseController
{

    public function DeleteTipoSolicitudUsuario()
    {
        $usuarioModel=New UsuarioModel();

        $filtro=[
            'idtipoSolicitudUsuario'=>$_POST["idtipoSolicitudUsuario"]
        ];

        $delete=$usuarioModel->DestroyTipoSolicitud($filtro);

        if($delete!=''){
            $send=[
                'status'=>'success',
                'title'=>'Se Elimino correctamente',
                'message'=>'Se Actualizo correctamente los datos el usuario'
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error en Proceso',
                'message'=>'Ocurrio un error al realizar la actualizacion de permisos'
            ];
            echo json_encode($send);
            exit();
        }
    }
    public function SaveTipoSolicitud()
    {
        $usuarioModel=New UsuarioModel();

        $create=[
            'idtipoSolicitud'=>$_POST["idtipoSolicitud"],
            'idusuario'=>$_POST["idusuario"]
        ];

        $dupli=$usuarioModel->DuplicateSolicitud($create);

        if($dupli){
            $send=[
                'status'=>'danger',
                'title'=>'Registro Existente',
                'message'=>'Ya Existe el tipo de solicitud asociado al Usuario'
            ];
            echo json_encode($send);
            exit();
        }

        $idstorage=$usuarioModel->StorageTipoSolicitud($create);

        if($idstorage!=''){
            $send=[
                'status'=>'success',
                'title'=>'Actualizacion Correcta',
                'message'=>'Se Actualizo correctamente los datos el usuario'
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error en Proceso',
                'message'=>'Ocurrio un error al realizar la actualizacion de permisos'
            ];
            echo json_encode($send);
            exit();
        }
    }

    public function CheckSubModulo()
    {
        $moduloModel=New ModuloModel();
        $idusuario=$_POST["idusuario"];
        $idsubModulo=$_POST["idsubModulo"];

        $filtro=[
            'idusuario'=>$idusuario,
            'idsubModuloPrincipal'=>$idsubModulo
        ];

        if($_POST["checkSubMod"]==1){
            $insert=$moduloModel->SaveSubModuloUsuario($filtro);
        }else{
            $dest=$moduloModel->DestroySubModuloUsuario($filtro);
        }

        $send=[
            'status'=>'success',
            'title'=>'Actualizacion Correcta',
            'message'=>'Se Actualizo correctamente los datos el usuario'
        ];
        echo json_encode($send);
        exit();
    }
    public function DuplicarPerfiles()
    {
        $usuarioModel = New UsuarioModel();
        $idusuarioOr = $_POST["idusuarioOrigen"];
        $idusuarioDe = $_POST["idusuarioDestino"];

        // Inicio de la transacción
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Duplicar roles
            $filtro = ['idusuario' => $idusuarioOr];
            $filtroRecep = ['idusuario' => $idusuarioDe];

            // Eliminar roles existentes
            $deletRol = $usuarioModel->DestroyRol($filtroRecep);
            // Duplicar roles
            $dupliRol = $usuarioModel->DupliRol($filtro);
            foreach ($dupliRol as $rl) {
                $storRol = [
                    'crear' => $rl["crear"],
                    'editar' => $rl["editar"],
                    'eliminar' => $rl["eliminar"],
                    'ver' => $rl["ver"],
                    'idmodulo' => $rl["idmodulo"],
                    'idgrupoModulo' => $rl["idgrupoModulo"],
                    'idusuario' => $idusuarioDe
                ];
                $idusR = $usuarioModel->StorageRol($storRol);
            }

            // Duplicar agencias
            $deletSd = $usuarioModel->DestroyAgencia($filtroRecep);
            $dupliAgen = $usuarioModel->DupliSedeUsuario($filtro);
            foreach ($dupliAgen as $ag) {
                $storAg = [
                    'idusuario' => $idusuarioDe,
                    'idagencia' => $ag["idagencia"],
                    'idempresa' => $ag["idempresa"],
                ];
                $idusA = $usuarioModel->StorageAgencia($storAg);
            }

            // Duplicar bodegas
            $deletBg = $usuarioModel->DestroyBodega($filtroRecep);
            $dupliBg = $usuarioModel->DupliBodega($filtro);
            foreach ($dupliBg as $bg) {
                $storBg = [
                    'idusuario' => $idusuarioDe,
                    'idbodega' => $bg["idbodega"],
                    'idempresa' => $bg["idempresa"],
                ];
                $idbg = $usuarioModel->StorageBodega($storBg);
            }

            // Duplicar ubicaciones
            $deleteGru = $usuarioModel->DestroyUbicacion($filtroRecep);
            $dupliGru = $usuarioModel->DupliGrupUbi($filtro);
            foreach ($dupliGru as $gru) {
                $storGru = [
                    'idusuario' => $idusuarioDe,
                    'idgrupoUbicacion' => $gru["idgrupoUbicacion"],
                    'idempresa' => $gru["idempresa"],
                ];
                $idgru = $usuarioModel->StorageUbicacion($storGru);
            }

            $viewUsuario=$usuarioModel->ViewUsuario($filtro);

            $updateUsd=[
                'urlPredefinida'=>$viewUsuario[0]["urlPredefinida"],
                'asesorEntrega'=>$viewUsuario[0]["asesorEntrega"],
                'gestorSolicitudVehiculo'=>$viewUsuario[0]["gestorSolicitudVehiculo"],
                'permitirRetornarEvento'=>$viewUsuario[0]["permitirRetornarEvento"],
            ];

            $updt=$usuarioModel->UpdateUsuario($filtroRecep,$updateUsd);

            // Si todo fue correcto, hacer commit
            if ($db->transStatus() === false) {
                // Si alguna parte falló, hacer rollback
                $db->transRollback();
                $send = [
                    'title' => 'Operacion Fallida',
                    'message' => 'Hubo un problema al duplicar los perfiles',
                    'status' => 'error'
                ];
            } else {
                // Confirmar la transacción
                $db->transCommit();
                $send = [
                    'title' => 'Operacion Correcta',
                    'message' => 'Se duplicaron correctamente los perfiles',
                    'status' => 'success'
                ];
            }

        } catch (\Exception $e) {
            // Si ocurre una excepción, hacer rollback
            $db->transRollback();
            $send = [
                'title' => 'Error en la operación',
                'message' => 'Hubo un error al duplicar los perfiles: ' . $e->getMessage(),
                'status' => 'error'
            ];
        }

        echo json_encode($send);
        exit();
    }

    public function CreatePerfil()
    {
        $usuarioModel=New UsuarioModel();

        $filtroUs=[
            'email'=>$_POST["correoElectronico"]
        ];
        $user=$usuarioModel->ViewUsuario($filtroUs);

        if($user){
            $send=[
                'status'=>'danger',
                'title'=>'Error Duplicidad',
                'message'=>'Existe un usuario con el mismo correo '.$user[0]["nombres"]
            ];
            echo json_encode($send);
            exit();
        }

        if($_POST["newPassword"]!=$_POST["newPassword2"]){
            $send=[
                'status'=>'danger',
                'title'=>'Error Contraseña',
                'message'=>'La contraseñas no son iguales'
            ];
            echo json_encode($send);
            exit();
        }

        $usuario=[
            'nombres'=>$_POST["nombres"],
            'primerApellido'=>$_POST["primerApellido"],
            'segundoApellido'=>$_POST["segundoApellido"],
            'idestadoUsuario'=>1,
            'estadoUsuario'=>1,
            'email'=>$_POST["correoElectronico"],
            'password'=>$_POST["newPassword"],
            'telefono'=>$_POST["telefono"],
            'informacionBasica'=>$_POST["info"],
            'imagen'=>'resource/img/usuario/logoDemo.png'
        ];

        $stor=$usuarioModel->StorageUsuario($usuario);

        if($stor!=''){
            $send=[
                'status'=>'success',
                'title'=>'Generacion Correcta',
                'message'=>'Se genero correctamente el usuario'
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error Proceso',
                'message'=>'No se logro generar el usuario'
            ];
            echo json_encode($send);
            exit();
        }
    }

    public function CheckAuditoriaUsuario()
    {
        $usuarioModel=New UsuarioModel();
        $idusuario=$_POST["idusuario"];

        $filtro=[
            'idusuario'=>$idusuario
        ];

        if($_POST["checkAudit"]==1){
            $usuario=[
                'gestorAuditoria'=>1,
            ];
        }else{
            $usuario=[
                'gestorAuditoria'=>null,
            ];
        }

        $updt=$usuarioModel->UpdateUsuario($filtro,$usuario);
        $send=[
            'status'=>'success',
            'title'=>'Actualizacion Correcta',
            'message'=>'Se Actualizo correctamente los datos el usuario'
        ];
        echo json_encode($send);
        exit();
    }

    public function CheckGestorSolicitud()
    {
        $usuarioModel=New UsuarioModel();
        $idusuario=$_POST["idusuario"];

        $filtro=[
            'idusuario'=>$idusuario
        ];

        if($_POST["checkSolicitud"]==1){
            $usuario=[
                'gestorSolicitudVehiculo'=>1,
            ];
        }else{
            $usuario=[
                'gestorSolicitudVehiculo'=>null,
            ];
        }

        $updt=$usuarioModel->UpdateUsuario($filtro,$usuario);
        $send=[
            'status'=>'success',
            'title'=>'Actualizacion Correcta',
            'message'=>'Se Actualizo correctamente los datos el usuario'
        ];
        echo json_encode($send);
        exit();
    }
    public function CheckAsesorEntrega()
    {
        $usuarioModel=New UsuarioModel();
        $idusuario=$_POST["idusuario"];

        $filtro=[
            'idusuario'=>$idusuario
        ];

        if($_POST["checkAsesor"]==1){
            $usuario=[
                'asesorEntrega'=>1,
            ];
        }else{
            $usuario=[
                'asesorEntrega'=>null,
            ];
        }

        $updt=$usuarioModel->UpdateUsuario($filtro,$usuario);
        $send=[
            'status'=>'success',
            'title'=>'Actualizacion Correcta',
            'message'=>'Se Actualizo correctamente los datos el usuario'
        ];
        echo json_encode($send);
        exit();
    }

    public function UpdatePerfil()
    {
        $usuarioModel=New UsuarioModel();
        $idusuario=$_POST["idusuario"];
        $usuario=[
            'nombres'=>$_POST["nombres"],
            'primerApellido'=>$_POST["primerApellido"],
            'segundoApellido'=>$_POST["segundoApellido"],
            'telefono'=>$_POST["telefono"],
            'informacionBasica'=>$_POST["info"]
        ];

        if($_POST["oldPassword"]!=''){
            $filtroUs=[
                'idusuario'=>$idusuario
            ];
            $user=$usuarioModel->ViewUsuario($filtroUs);
            if($user[0]["password"]==$_POST["oldPassword"]){
                if($_POST["newPassword"]==$_POST["newPassword2"]){
                    $usuario+=[
                        'password'=>$_POST["newPassword"]
                    ];
                }else{
                    $send=[
                        'status'=>'danger',
                        'title'=>'Error Contraseña',
                        'message'=>'La contraseñas no son iguales'
                    ];

                    echo json_encode($send);
                    exit();
                }
            }else{
                $send=[
                    'status'=>'danger',
                    'title'=>'Error Contraseña',
                    'message'=>'La contraseña ingresada no es igual a su contraseña actual'
                ];
                echo json_encode($send);
                exit();
            }
        }

        $filtro=[
            'idusuario'=>$idusuario
        ];

        $updt=$usuarioModel->UpdateUsuario($filtro,$usuario);

        $send=[
            'status'=>'success',
            'title'=>'Actualizacion Correcta',
            'message'=>'Se Actualizo correctamente los datos el usuario'
        ];

        echo json_encode($send);
        exit();
    }

    public function SaveUbicacion()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $usuarioModel=New UsuarioModel();

            $insert=[
                'idusuario'=>$_POST["idusuario"],
                'idempresa'=>$_POST["idempresa"],
                'idgrupoUbicacion'=>$_POST["idgrupoUbicacion"]
            ];

            $idasociado=$usuarioModel->StorageUbicacion($insert);
            // Sitodo es correcto, confirma la transacción
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al intentar asociar el usuario con la ubicacion"
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title" => "Acceso Generado",
                    "message" => "Se asocio el usuario con la ubicacion"
                ]);
            }
        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }
    }
    public function SaveBodega()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $usuarioModel=New UsuarioModel();

            if($_POST["idbodega"]=='-1'){
                $idusuario=$_POST['idusuario'];
                $filtro=[
                    'idempresa'=>$_POST['idempresa']
                ];
                $agenGeneral=$usuarioModel->SelectBodega($filtro,$idusuario);
                foreach($agenGeneral as $ag){
                    $insert=[
                        'idusuario'=>$_POST["idusuario"],
                        'idempresa'=>$_POST["idempresa"],
                        'idbodega'=>$ag["idbodega"]
                    ];
                    $idasociado=$usuarioModel->StorageBodega($insert);
                }
            }else{
                $insert=[
                    'idusuario'=>$_POST["idusuario"],
                    'idempresa'=>$_POST["idempresa"],
                    'idbodega'=>$_POST["idbodega"]
                ];
                $idasociado=$usuarioModel->StorageBodega($insert);
            }


            // Sitodo es correcto, confirma la transacción
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al intentar asociar el usuario con la bodega"
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title" => "Acceso Generado",
                    "message" => "Se asocio el usuario con la bodega"
                ]);
            }
        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }
    }
    public function SaveAgencia()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $usuarioModel=New UsuarioModel();

            if($_POST["idagencia"]=='-1'){
                $idusuario=$_POST['idusuario'];

                $filtro=[
                    'idempresa'=>$_POST['idempresa']
                ];

                $agenGeneral=$usuarioModel->SelectAgencia($filtro,$idusuario);

                foreach($agenGeneral as $ag){
                    $insert=[
                        'idusuario'=>$_POST["idusuario"],
                        'idempresa'=>$_POST["idempresa"],
                        'idagencia'=>$ag["idagencia"]
                    ];
                    $idasociado=$usuarioModel->StorageAgencia($insert);
                }
            }else{
                $insert=[
                    'idusuario'=>$_POST["idusuario"],
                    'idempresa'=>$_POST["idempresa"],
                    'idagencia'=>$_POST["idagencia"]
                ];

                $idasociado=$usuarioModel->StorageAgencia($insert);
            }

            // Sitodo es correcto, confirma la transacción
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al intentar asociar el usuario con la agencia"
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title" => "Acceso Generado",
                    "message" => "Se asocio el usuario con la agencia"
                ]);
            }
        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function DeleteUbicacion()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $usuarioModel=New UsuarioModel();

            $delete=[
                'idusuarioGrupoUbicacion'=>$_POST["idusuarioGrupoUbicacion"],
            ];

            $usuarioModel->DestroyUbicacion($delete);
            // Sitodo es correcto, confirma la transacción
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al intentar eliminar el acceso"
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title" => "Acceso Eliminado",
                    "message" => "Se elimino el acceso a la ubicacion"
                ]);
            }
        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function DeleteBodega()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $usuarioModel=New UsuarioModel();

            $delete=[
                'idusuarioBodega'=>$_POST["idusuarioBodega"],
            ];

            $usuarioModel->DestroyBodega($delete);
            // Sitodo es correcto, confirma la transacción
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al intentar eliminar el acceso"
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title" => "Acceso Eliminado",
                    "message" => "Se elimino el acceso a la bodega"
                ]);
            }
        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function LogOutSession()
    {
        // Cargar el modelo
        $sessionModel = new SessionModel();

        // Comenzar una transacción
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            if (!isset($_POST["idusuario"])) {
                throw new Exception('ID de usuario no proporcionado.');
            }

            $idusuario = $_POST["idusuario"];
            $filtroUs = [
                'idusuario' => $idusuario
            ];

            $viewUser = $sessionModel->ViewSessionUser($filtroUs);

            if (!$viewUser) {
                throw new Exception('La sesión ya se encuentra finalizada.');
            }

            $idsession = $viewUser[0]["idsessions"];
            $filtroDest = [
                'idsessions' => $idsession
            ];

            $sessionPath = WRITEPATH . 'sessions\\'; // Ruta de los archivos de sesión
            $sessionFile = $sessionPath . $idsession;

            $fileDeleted = false;

            if (file_exists($sessionFile)) {
                if (unlink($sessionFile)) {
                    $fileDeleted = true;
                } else {
                    throw new Exception('No se pudo eliminar el archivo de sesión.');
                }
            } else {
                $fileDeleted = true; // Consideramos que si el archivo no existe, esto no es un problema crítico para la transacción.
            }

            // Intentar destruir la sesión en la base de datos
            $destroyUs = $sessionModel->DestroySessions($filtroDest);

            if (!$destroyUs) {
                throw new Exception('No se pudo registrar la finalización de la sesión en el modelo.');
            }

            // Confirmar la transacción si todo fue exitoso
            $db->transCommit();

            $send = [
                'status' => 'success',
                'title' => 'Sesión Finalizada',
                'message' => 'La sesión del usuario se finalizó correctamente',
                'idusuario' => $idusuario
            ];

        } catch (Exception $e) {
            // Hacer rollback de la transacción en caso de error
            $db->transRollback();

            $send = [
                'status' => 'error',
                'title' => 'Error',
                'message' => $e->getMessage()
            ];
        }

        echo json_encode($send);
        exit();
    }

    public function DeshabilitarUsuario()
    {
        $usuarioModel=New UsuarioModel();
        $idusuario=$_POST['idusuario'];

        $filtro=[
            'idusuario'=>$idusuario
        ];

        $update=[
            'idestadoUsuario'=>2,
            'estadoUsuario'=>2
        ];

        $uppdateUsuario=$usuarioModel->UpdateUsuario($filtro,$update);
        if(!$uppdateUsuario){
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => 'No se logro actualizar el usuario'
            ]);
            exit();
        }else{
            echo json_encode([
                "status" => "success",
                "title" => "Actualizacion Correcta",
                "message" =>'Se deshabilito el usuario en Gestyx'
            ]);
            exit();
        }
    }

    public function DeleteAgencia()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $usuarioModel=New UsuarioModel();

            $delete=[
                'idusuarioSede'=>$_POST["idusuarioSede"],
            ];

            $usuarioModel->DestroyAgencia($delete);
            // Sitodo es correcto, confirma la transacción
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al intentar eliminar el acceso"
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title" => "Acceso Eliminado",
                    "message" => "Se elimino el acceso a la agencia"
                ]);
            }
        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function SaveGrupoModulo()
    {
        $idmodulo='';
        if($_POST["idmodulo"]=='-1' && $_POST["idmodulo"]!=''){
            $idmodulo=null;
        }else if($_POST["idmodulo"]!='-1' && $_POST["idmodulo"]!=''){
            $idmodulo=$_POST["idmodulo"];
        }else{
            $send=[
                'status'=>'warning',
                'title'=>'Campo Obligatorio',
                'message'=>'El campo de modulo es requerido para almacenar la informacion'
            ];
            echo json_encode($send);
            exit();
        }
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $usuarioModel=New UsuarioModel();

            $insert=[
                'idusuario'=>$_POST["idusuario"],
                'idgrupoModulo'=>$_POST["idgrupoModulo"],
                'idmodulo'=>$idmodulo,
                'crear'=>1,
                'ver'=>1
            ];

            $idasociado=$usuarioModel->StorageRol($insert);

            if(isset($_POST["checkModuloIn"]) && $_POST["checkModuloIn"]==1){
                $tipoModulo='';
                $filtroMd=[];
                if($_POST["idmodulo"]=='-1'){
                    $filtroMd+=[
                        'idgrupoModulo'=>$_POST["idgrupoModulo"]
                    ];
                }else{
                    $filtroMd+=[
                        'idgrupoModulo'=>$_POST["idgrupoModulo"],
                        'idmodulo'=>$idmodulo
                    ];
                }

                $modgp=$usuarioModel->GrupoModulo($filtroMd);
                $urlPreferida=$modgp[0]["url"];
                $filtroUs=[
                    'idusuario'=>$_POST["idusuario"]
                ];
                $updateUs=[
                    'urlPredefinida'=>$urlPreferida
                ];
                $up=$usuarioModel->UpdateUsuario($filtroUs,$updateUs);
            }

            // Sitodo es correcto, confirma la transacción
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al intentar asociar el usuario con el modulo"
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title" => "Acceso Generado",
                    "message" => "Se asocio el usuario con el modulo"
                ]);
            }
        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function DeleteGrupoModulo()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $usuarioModel=New UsuarioModel();
            $delete=[
                'idrol'=>$_POST["idrol"],
            ];

            $usuarioModel->DestroyRol($delete);
            // Sitodo es correcto, confirma la transacción
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al intentar eliminar el acceso"
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title" => "Acceso Eliminado",
                    "message" => "Se elimino el acceso a la agencia"
                ]);
            }
        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function logoutUser($userId)
    {
        $sessionModel = new SessionModel();

        // Obtén todas las sesiones
        $sessions = $sessionModel->findAll();

        foreach ($sessions as $session) {
            $sessionData = unserialize($session['data']);
            // Supón que el ID del usuario está almacenado en la sesión
            if (isset($sessionData['user_id']) && $sessionData['user_id'] == $userId) {
                // Elimina la sesión del usuario
                $sessionModel->delete($session['id']);
            }
        }

        echo "usuario desconectado";
    }
}