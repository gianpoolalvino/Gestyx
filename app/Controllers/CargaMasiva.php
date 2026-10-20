<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\AccessModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\CargaMasivaModel;
use App\Models\SessionModel;
use App\Models\TimeLineModel;
use App\Models\VinModel;

class CargaMasiva extends BaseController
{
    public function VehiculosComprados()
    {
        $vinModel = new VinModel();
        $cargaMasivaModel = new CargaMasivaModel();
        $alistamientoModel = new AlistamientoVehicularModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora = date("H:i:s");
        set_time_limit(0); // Ajusta a un límite razonable


        $file = 'resource/upload/traslado.xlsx';

        // Inicializar contadores y arrays para errores
        $contadorErrores = 0;
        $contadorCorrecto = 0;
        $erroresDetalles = [];

        try {
            // Verificar si el archivo existe
            if (!file_exists($file)) {
                throw new Exception('El archivo de Excel no existe en la ruta especificada.');
            }

            // Cargar el archivo Excel
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);

            // Obtener la hoja por su nombre
            $sheet = $spreadsheet->getSheetByName("general");

            if ($sheet === null) {
                throw new Exception('La hoja no cuenta con el mismo nombre de marca.');
            }

            $totalFilas = $sheet->getHighestRow();

            $cargaMasivaStor=[
                'fechaCarga'=>$hoy,
                'idusuario'=>session("idusuario"),
                'tipoCarga'=>'General',
                'idempresa'=>2
            ];

            $idcargaMasiva=$cargaMasivaModel->StorageCargaMasiva($cargaMasivaStor);

            for ($row = 2; $row <= $totalFilas; $row++) {
                try {
                    $vin = $sheet->getCell("A" . $row)->getFormattedValue();

                    if ($vin != '') {
                        // Verificar si el VIN existe en la base de datos
                        $tipoEvento = $sheet->getCell("B" . $row)->getFormattedValue();
                        $fechaEvent = $sheet->getCell("D" . $row)->getValue();
                        $fechaEvento = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($fechaEvent)->format('Y-m-d');

                        $opcion=$sheet->getCell("E" . $row)->getValue();

                        $notas=$sheet->getCell("F" . $row)->getValue();

                        $notasdos=$sheet->getCell("G" . $row)->getValue();

                        $usuario=$sheet->getCell("H" . $row)->getValue();

                        $detailStor=[
                            'idcargaMasiva'=>$idcargaMasiva,
                            'vin'=>$vin,
                            'tipoEvento'=>$tipoEvento,
                            'fechaRegistro'=>$fechaEvento,
                            'fechaFinalizado'=>$fechaEvento,
                            'opcion'=>$opcion,
                            'nota1'=>$notas,
                            'nota2'=>$notasdos,
                            'usuario'=>$usuario
                        ];

                        $det=$cargaMasivaModel->StorageDetailCargaMasiva($detailStor);
                        $contadorCorrecto++;
                    }
                } catch (Exception $e) {
                    $erroresDetalles[] = "Error en la fila $row: " . $e->getMessage();
                    $contadorErrores++;
                }
            }

            // Mensaje de éxito si no hubo errores
            $dato = [
                'status' => $contadorErrores === 0 ? 'success' : 'warning',
                'title' => $contadorErrores === 0 ? 'Proceso Completado' : 'Proceso con Advertencias',
                'message' => $contadorErrores === 0
                    ? 'Los vehículos se procesaron correctamente.'
                    : 'El proceso se completó con algunos errores.',
                'cantidadErrores' => $contadorErrores,
                'cantidadCorrectos' => $contadorCorrecto,
                'erroresDetalles' => $erroresDetalles
            ];

        } catch (Exception $e) {
            // Manejar errores generales y excepciones
            $dato = [
                'status' => 'danger',
                'title' => 'Error',
                'message' => 'Ha ocurrido un error: ' . $e->getMessage(),
                'cantidadErrores' => $contadorErrores,
                'cantidadCorrectos' => $contadorCorrecto,
                'erroresDetalles' => $erroresDetalles
            ];
        }

        echo "<pre>";
        var_dump($dato);

        exit();
    }
}