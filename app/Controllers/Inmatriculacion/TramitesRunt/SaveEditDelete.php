<?php

namespace App\Controllers\Inmatriculacion\TramitesRunt;

use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\InmatriculacionModel;

class SaveEditDelete extends BaseController
{
    public function UpdatePaso1()
    {
        $db = \Config\Database::connect();
        $db->transBegin(); // Inicia la transacción

        try {
            $InmatriculacionModel = new InmatriculacionModel();

            $filtro = [
                'idtramite' => $_POST['idtramite'],
            ];

            $update = [
                'idtramiteSolicitado' => $_POST["idtipoTramite"],
                'idtipoVehiculoTramite' => $_POST["tipoVehiculoTramite"],
                'placa' => $_POST["placa"],
                'idclaseVehiculo' => $_POST["claseVehiculo"],
            ];

            $updateTramite = $InmatriculacionModel->UpdateTramite($filtro, $update);

            if (!$updateTramite) {
                // Lanza excepción manual si la actualización falla
                throw new \Exception("No se pudo actualizar el trámite.");
            }

            $db->transCommit(); // Confirma la transacción

            echo json_encode([
                'status' => 'success',
                'title' => 'Actualización Exitosa',
                'message' => 'El trámite fue actualizado correctamente.'
            ]);
        } catch (\Throwable $e) {
            $db->transRollback(); // Revierte la transacción en caso de error

            echo json_encode([
                'status' => 'error',
                'title' => 'Error al Actualizar',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function UpdatePaso2()
    {
        $db = \Config\Database::connect();
        $db->transBegin(); // Inicia la transacción

        try {
            $InmatriculacionModel = new InmatriculacionModel();

            $filtro = [
                'idtramite' => $_POST['idtramite'],
            ];

            $update = [
                'marca' => $_POST["marca"],
                'linea' => $_POST["linea"],
                'idtipoCombustible' => $_POST["combustible"],
                'color' => $_POST["colores"],
                'modelo' => $_POST["modelo"],
                'cilindrada' => $_POST["cilindrada"],
                'capacidadCargaPersona'=>$_POST["capacidad"],
                'blindaje'=>$_POST["blindaje"],
                'resolucionBlindaje'=>$_POST["resolucionBlindaje"],
                'fechaResolucionBlindaje'=>$_POST["fechaBlindaje"],
                'desmonteBlindaje'=>$_POST["desmonteBlindaje"],
                'resolucionDesmonteBlindaje'=>$_POST["resolucionDesmonte"],
                'fechaResoluconDesmonteBlindaje'=>$_POST["fechaResolucionDesmonte"],
                'potenciaHp'=>$_POST["potencia"],
                'idtipoCarroceria'=>$_POST["codigoCarroceria"],
            ];

            $updateTramite = $InmatriculacionModel->UpdateTramite($filtro, $update);

            if (!$updateTramite) {
                // Lanza excepción manual si la actualización falla
                throw new \Exception("No se pudo actualizar el trámite.");
            }

            $db->transCommit(); // Confirma la transacción

            echo json_encode([
                'status' => 'success',
                'title' => 'Actualización Exitosa',
                'message' => 'El trámite fue actualizado correctamente.'
            ]);
        } catch (\Throwable $e) {
            $db->transRollback(); // Revierte la transacción en caso de error

            echo json_encode([
                'status' => 'error',
                'title' => 'Error al Actualizar',
                'message' => $e->getMessage()
            ]);
        }
    }

}
