<?php

namespace App\Controllers\Administrador\ConfigurarWhatsapp;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EntregadoModel;
use App\Models\ExhibicionModel;
use App\Models\UsuarioModel;
use App\Models\VehiculosVendidosModel;
use App\Models\WhatsappModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class SaveEditDelete extends BaseController
{
    public function StorageWhatsapp()
    {
        $whatsappModel=New WhatsappModel();
        date_default_timezone_set("America/Lima");

        $fecha=date("Y-m-d");
        $hora=date("H:i:s");

        $storage=[
            'numero'=>$_POST["numeroSession"],
            'estado'=>1,
            'fechaEscaneo'=>$fecha,
            'horaEscaneo'=>$hora,
            'idusuario'=>session("idusuario"),
            'token'=>$_POST["tokenSession"],
        ];

        $strg=$whatsappModel->Storage($storage);

        if($strg){
            $send=[
                'status'=>'success',
                'title'=>'Whatsapp Grabado',
                'message'=>'El Numero de Whatsapp se almaceno correctamente'
            ];
            echo json_encode($send);
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Whatsapp Errado',
                'message'=>'No se logro almacenar correctamente el numero'
            ];
            echo json_encode($send);
        }

    }

    public function DeleteAgentWhatsapp()
    {
        $whatsappModel = new WhatsappModel();
        $userModel = new UsuarioModel();

        // Obtener los datos del usuario
        $filt = [
            'idusuario' => $_POST["idusuario"]
        ];

        // Iniciar la transacción
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Eliminar el agente de WhatsApp
            $deleteWspAgent = $whatsappModel->DeleteAgentWhatsapp($filt);

            if ($deleteWspAgent === false) {
                throw new \Exception("Error al eliminar el agente de WhatsApp.");
            }

            // Actualizar el usuario
            $updateUser = [
                'numeroSessionwhatsapp' => null,
                'tokenSeguridad' => null,
                'agenteWhatsapp'=>null
            ];
            $userUp = $userModel->UpdateUsuario($filt, $updateUser);

            if ($userUp === false) {
                throw new \Exception("Error al actualizar el usuario.");
            }

            // Confirmar la transacción
            $db->transCommit();

            // Respuesta exitosa
            $response = [
                'status' => 'success',
                'title' => 'Operación exitosa',
                'message' => 'El agente de WhatsApp ha sido eliminado y el usuario actualizado correctamente.'
            ];
        } catch (\Exception $e) {
            // Si ocurre un error, revertir la transacción
            $db->transRollback();

            // Loguear el error
            log_message('error', 'Error en DeleteAgentWhatsapp: ' . $e->getMessage());

            // Respuesta de error con "danger"
            $response = [
                'status' => 'danger',
                'title' => 'Error en la operación',
                'message' => $e->getMessage()
            ];
        }
        echo json_encode($response);
    }

    public function StorageAgenteWhatsapp()
    {
        $whatsappModel = new WhatsappModel();
        $userModel = new UsuarioModel();

        // Obtener los datos de la solicitud
        $stor = [
            'idusuario' => $_POST["agente"],
            'prioridad' => $_POST["prioridad"],
            'idsessionWhatsapp' => $_POST["idsessionWhatsapp"]
        ];

        $dup = [
            'idusuario' => $_POST["agente"]
        ];

        // Iniciar la transacción
        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            // Verificar si el agente ya está registrado en otra sesión de WhatsApp
            $dupli = $whatsappModel->AgentesWhatsapp($dup);
            if ($dupli) {
                // Si ya existe, devolver respuesta de error
                $send = [
                    'status' => 'danger',
                    'title' => 'Ya Existente',
                    'message' => 'El Agente ya se encuentra registrado en una sesión de WhatsApp'
                ];
                echo json_encode($send);
                return;
            }

            // Almacenar el agente en la base de datos
            $idag = $whatsappModel->StorageAgente($stor);

            // Verificar si el agente fue almacenado correctamente
            if ($idag == '') {
                throw new \Exception('Ocurrió un error al intentar asociar el agente al número de WhatsApp');
            }

            // Obtener detalles de la sesión de WhatsApp
            $filtWs = [
                'idsessionWhatsapp' => $_POST["idsessionWhatsapp"]
            ];
            $viewWsp = $whatsappModel->ViewWhatsapp($filtWs);

            // Actualizar los detalles del usuario
            $filt = [
                'idusuario' => $_POST["agente"]
            ];

            $updateUser = [
                'numeroSessionwhatsapp' => $viewWsp[0]["numero"],
                'tokenSeguridad' => $viewWsp[0]["token"],
                'agenteWhatsapp'=>1
            ];

            $userUp = $userModel->UpdateUsuario($filt, $updateUser);

            // Confirmar la transacción
            $db->transCommit();

            // Respuesta de éxito
            $send = [
                'status' => 'success',
                'title' => 'Grabado Correcto',
                'message' => 'Se almacenó correctamente el agente al WhatsApp'
            ];
            echo json_encode($send);

        } catch (\Exception $e) {
            // Si ocurre un error, revertir la transacción
            $db->transRollback();

            // Loguear el error
            log_message('error', 'Error en StorageAgenteWhatsapp: ' . $e->getMessage());

            // Respuesta de error
            $send = [
                'status' => 'danger',
                'title' => 'Grabado Errado',
                'message' => $e->getMessage()
            ];
            echo json_encode($send);
        }
    }

    public function UpdateWhatsapp()
    {

    }
}