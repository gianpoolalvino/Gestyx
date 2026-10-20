<?php

namespace App\Controllers\Taller\TipoCambio;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\MarcaModel;
use App\Models\ModeloModel;
use App\Models\RepuestoModel;
use App\Models\TipoCambioModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class SaveEditDelete extends BaseController
{
    public function SaveTipoCambio()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $tipoCambioModel=New TipoCambioModel();
            date_default_timezone_set("America/Lima");
            $hoy=date("Y-m-d");
            $tc=[
                'idmoneda'=>1,
                'precioCompra'=>$_POST["compra"],
                'precioVenta'=>$_POST["venta"],
                'fecha'=>$hoy,
                'idusuario'=>session("idusuario"),
                'idmonedaSol'=>2
            ];

            $stor=$tipoCambioModel->StorageTipoCambio($tc);
            // Sitodo es correcto, confirma la transacción
            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                echo json_encode([
                    "status" => "danger",
                    "title" => "Error en la transacción",
                    "message" => "Hubo un problema al guardar el tipo de cambio. Por favor, intente nuevamente."
                ]);
            } else {
                $db->transCommit();
                echo json_encode([
                    "status" => "success",
                    "title" => "Tipo de cambio Registrado",
                    "message" => "El tipo de cambio fue ingresado correctamente"
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
}

