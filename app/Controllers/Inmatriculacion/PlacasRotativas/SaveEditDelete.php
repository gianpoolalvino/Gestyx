<?php

namespace App\Controllers\Inmatriculacion\PlacasRotativas;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\GeneralesModel;
use App\Models\InmatriculacionModel;
use App\Models\TrasladoModel;
use App\Models\UsuarioModel;


class SaveEditDelete extends BaseController
{
    public function SavePlaca()
    {
        $inmatriculacionModel = New InmatriculacionModel(); // Crea una instancia del modelo para interactuar con la base de datos


        if(strlen($_POST["placaRotativa"])>6){
            $response = [
                'status' => 'warning',
                'title' => 'Cantidad de Digitos',
                'message' => 'La placa rotativa no puede tener mas de 6 digitos'
            ];
            echo json_encode($response);
            exit();
        }

        $filtro=[
            'placa'=>$_POST["placaRotativa"]
        ];

        $countDuplicate=$inmatriculacionModel->DuplicatePlacaRotativa($filtro);

        if($countDuplicate[0]["contador"]>0){
            $response = [
                'status' => 'warning',
                'title' => 'Placa Duplicada',
                'message' => 'La Placa ya se encuentra registrada en el Sistema'
            ];
            echo json_encode($response);
            exit();
        }

        // Inicia una transacción
        $db = \Config\Database::connect(); // Conecta a la base de datos
        $db->transBegin(); // Inicia la transacción
        try {
            // Prepara los datos que se van a almacenar en la base de datos
            $storage = [
                'fechaCreacion' => $_POST["fechaInicio"],
                'fechaVencimiento' => $_POST["fechaVencimiento"],
                'placa' => $_POST["placaRotativa"],
                'idempresa' => $_POST["empresa"],
                'idregion' => $_POST["region"],
                'idgrupoUbicacion' => $_POST["region"],
                'idestadoPlaca' => 1, // Estado activo de la placa
                'uso' => 0, // No está en uso inicialmente
                'idusuarioCreacion' => session("idusuario") // ID del usuario que crea la placa
            ];

            $result = $inmatriculacionModel->StoragePlacaRotativa($storage);
            // Verifica si la operación fue exitosa
            if (!$result) {
                throw new \Exception("Error al guardar la placa rotativa.");
            }

            $db->transCommit(); // Realiza el commit de la transacción
            // Respuesta de éxito en formato JSON
            $response = [
                'status' => 'success',
                'title' => 'Operación exitosa',
                'message' => 'La placa rotativa fue guardada correctamente.'
            ];
            echo json_encode($response); // Devuelve el JSON como respuesta utilizando echo
        } catch (\Exception $e) {
            // Si ocurre un error, se hace rollback de la transacción
            $db->transRollback(); // Revertir cambios en la base de datos
            // Loguea el error para un seguimiento adecuado
            log_message('error', 'Error en SavePlaca: ' . $e->getMessage());
            // Respuesta de error en formato JSON
            $response = [
                'status' => 'error',
                'title' => 'Error en la operación',
                'message' => 'Ocurrió un error al guardar la placa rotativa: ' . $e->getMessage()
            ];
            echo json_encode($response); // Devuelve el JSON como respuesta utilizando echo
        }
    }

}