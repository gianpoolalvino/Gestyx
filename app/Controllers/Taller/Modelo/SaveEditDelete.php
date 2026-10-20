<?php

namespace App\Controllers\Taller\Modelo;

use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\CargaMasivaModel;
use Exception;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\MarcaModel;
use App\Models\ModeloModel;
use App\Models\RepuestoModel;
use App\Models\VinModel;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class SaveEditDelete extends BaseController
{
    public function UploadCargaExcel()
    {
        $marcaModel = new MarcaModel();

        $filtro = [
            'idmarca' => $_POST["marca"]
        ];

        $mr = $marcaModel->ViewMarca($filtro);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Verificar si se subió un archivo
            if (isset($_FILES['resourceExcel']) && $_FILES['resourceExcel']['error'] === UPLOAD_ERR_OK) {

                $rutaTemporal = $_FILES['resourceExcel']['tmp_name'];
                $nombreArchivo = basename($_FILES['resourceExcel']['name']);
                $directorioDestino = 'resource/files/'; // Asegúrate de que esta carpeta exista y tenga permisos de escritura

                // Crear la carpeta si no existe
                if (!is_dir($directorioDestino)) {
                    mkdir($directorioDestino, 0755, true);
                }

                // Verificar si el archivo ya existe y crear un nuevo nombre si es necesario
                $rutaDestino = $directorioDestino . $nombreArchivo;
                $contador = 1;
                $nombreArchivoSinExt='';
                $extension='';
                while (file_exists($rutaDestino)) {
                    // Cambiar el nombre del archivo añadiendo un sufijo numérico
                    $nombreArchivoSinExt = pathinfo($nombreArchivo, PATHINFO_FILENAME);
                    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
                    $rutaDestino = $directorioDestino . $nombreArchivoSinExt . '_' . $contador . '.' . $extension;
                    $contador++;
                }

                // Mover el archivo a la carpeta de destino
                if (move_uploaded_file($rutaTemporal, $rutaDestino)) {

                    // Leer el archivo Excel
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                    $spreadsheet = $reader->load($rutaDestino);

                    // Obtener las hojas
                    $hojas = $spreadsheet->getAllSheets();
                    $principal = '';

                    $principal .= '<option value="">Seleccione Modelo a Cargar</option>';
                    foreach ($hojas as $hoja) {
                        $principal .= '<option value="' . $hoja->getTitle() . '">' . $hoja->getTitle() . '</option>';
                    }

                    $send = [
                        'status' => 'success',
                        'idmarca' => $mr[0]["idmarca"],
                        'nombreExcel' => $nombreArchivoSinExt . '_' . ($contador-1) . '.' . $extension,
                        'title' => 'Carga Correcta',
                        'message' => 'Seleccione la pestaña del excel a cargar ' . htmlspecialchars($nombreArchivo),
                        'info' => $principal
                    ];

                    echo json_encode($send);
                    exit();

                } else {
                    $send = [
                        'status' => 'danger',
                        'title' => 'Error en Proceso',
                        'message' => "Error al mover el archivo subido.",
                    ];

                    echo json_encode($send);
                    exit();
                }
            } else {
                $send = [
                    'status' => 'danger',
                    'title' => 'Error en Proceso',
                    'message' => "Error al subir el archivo.",
                ];
                echo json_encode($send);
                exit();
            }
        } else {
            $send = [
                'status' => 'danger',
                'title' => 'Error en Proceso',
                'message' => "Método de solicitud no permitido.",
            ];
            echo json_encode($send);
            exit();
        }
    }

    public function ProcesarModeloMasivo()
    {
        $cargaMasiva = new CargaMasivaModel();
        $modeloModel = new ModeloModel();
        $filtroCarga = [
            'idmarca' => $_POST["marcaAfectada"]
        ];
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            // Iniciar la transacción

            // Seleccionar modelos
            $detail = $cargaMasiva->SelectModeloCargaMasiva($filtroCarga);

            // Verificar si hay resultados
            if (empty($detail)) {
                throw new Exception('No se encontraron modelos para la marca especificada.');
            }

            foreach ($detail as $det) {
                $storageMod = [
                    'idmarca' => $det["idmarca"],
                    'descripcion' => $det["modeloVersion"],
                    'estado' => 1
                ];

                // Almacenar el modelo
                $stor = $modeloModel->StorageModelo($storageMod);

                // Verificar si el almacenamiento fue exitoso
                if (!$stor) {
                    throw new Exception('Error al almacenar el modelo: ' . $det["modeloVersion"]);
                }
            }

            // Confirmar la transacción si todo fue exitoso
            $db->transCommit();

            // Mensaje de éxito
            $response = [
                'status' => 'success',
                'title' => 'Carga Completa',
                'message' => 'Los modelos se han almacenado correctamente.'
            ];

        } catch (Exception $e) {
            // Hacer rollback en caso de error
            $db->transRollback();

            // Manejar errores y excepciones
            $response = [
                'status' => 'danger',
                'title' => 'Error',
                'message' => 'Ha ocurrido un error: ' . $e->getMessage(),
            ];
        }

// Devolver la respuesta como JSON
        echo json_encode($response);
        exit();
    }

    public function CargaMasivaPlanesExcelMysql()
    {
        $vinModel = new VinModel();
        $cargaMasivaModel = new CargaMasivaModel();
        $alistamientoModel = new AlistamientoVehicularModel();
        date_default_timezone_set("America/Lima");
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");
        set_time_limit(0); // Ajusta a un límite razonable

        $file = 'resource/files/' . $_POST["rutaExcel"];
        $idmarca = $_POST["idmarcaAfectada"];
        $pestanha = $_POST["selectPestanha"];

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
            $sheet = $spreadsheet->getSheetByName($pestanha);

            if ($sheet === null) {
                throw new Exception('La hoja no cuenta con el mismo nombre de modelo.');
            }

            $totalFilas = $sheet->getHighestRow();
            $rowAlmacened = [];

            for ($row = 2; $row <= $totalFilas; $row++) {
                $marca = $sheet->getCell("A" . $row)->getFormattedValue();
                $modelo = $sheet->getCell("B" . $row)->getFormattedValue();
                $kilometro = $sheet->getCell("C" . $row)->getFormattedValue(); // Cambié la columna
                $codigo = $sheet->getCell("D" . $row)->getFormattedValue(); // Cambié la columna
                $cantidad = $sheet->getCell("E" . $row)->getFormattedValue(); // Cambié la columna

                if ($marca != '' && $modelo != '' && $kilometro != '' && $codigo != '' && $cantidad != '') {
                    // Crear una clave única para marca y modelo
                    $claveUnica = $marca . '|' . $modelo;
                    // Si no existe, agregar al array de registros únicos
                    if (!isset($registrosUnicos[$claveUnica])) {
                        $registrosUnicos[$claveUnica] = [
                            'marca' => $marca,
                            'modelo' => $modelo,
                        ];
                    }
                    $recorrido = [
                        'marca' => $marca,
                        'modelo' => $modelo,
                        'kilometro' => $kilometro,
                        'codigo' => $codigo,
                        'cantidad' => $cantidad
                    ];
                    array_push($rowAlmacened, $recorrido);
                    $contadorCorrecto++;
                }
            }

            foreach ($registrosUnicos as $ross) {
                $filtroDelet = [
                    'marca' => $ross["marca"],
                    'modeloVersion' => $ross["modelo"]
                ];
                $dele = $cargaMasivaModel->DeleteCargaMasivaPlanes($filtroDelet);
            }

            foreach ($rowAlmacened as $ros) {

                $storageData = [
                    'marca' => $ros["marca"],
                    'kilometraje' => $ros["kilometro"],
                    'codigoRepuesto' => $ros["codigo"],
                    'cantidad' => $ros["cantidad"],
                    'modeloVersion' => $ros["modelo"]
                ];

                $stor = $cargaMasivaModel->StorageCargaMasivaPlanMto($storageData);

            }

            // Mensaje de éxito
            $dato = [
                'status' => 'success',
                'title' => 'Carga Completa',
                'message' => "Se han procesado correctamente {$contadorCorrecto} registros.",
            ];

        } catch (Exception $e) {
            // Manejar errores generales y excepciones
            $dato = [
                'status' => 'danger',
                'title' => 'Error',
                'message' => 'Ha ocurrido un error: ' . $e->getMessage(),
            ];
        }

// Devolver la respuesta como JSON
        echo json_encode($dato);
        exit();
    }

    public function UploadModelo()
    {
        $modeloModel = new ModeloModel();
        $rutaExcel = "resource/files/modelosVehiculos.xlsx";
        $reader = new Xlsx();
        $spreedsheet = $reader->load($rutaExcel);
        $sheet = $spreedsheet->getActiveSheet();
        $worksheetInfo = $reader->listWorksheetInfo($rutaExcel);
        $totalRows = $worksheetInfo[0]["totalRows"];
        $idcount = 0;

        for ($row = 2; $row <= $totalRows; $row++) {
            $modelo = $sheet->getCell("A" . $row)->getValue();
            $marca = $sheet->getCell("B" . $row)->getValue();
            $codigoModelo = (string)$sheet->getCell("C" . $row)->getValue();
            $version = $sheet->getCell("D" . $row)->getValue();


            $modelo = [
                'idmarca' => $marca,
                'codigo' => $codigoModelo,
                'descripcion' => $modelo,
                'version' => $version,
            ];

            $exist = $modeloModel->ViewModelo($modelo);

            if (!$exist) {
                $stor = $modeloModel->StorageModelo($modelo);

            }
        }
    }

    public function DeleteModelo()
    {
        $modeloModel = new ModeloModel();
        $idmodelo = $_POST["idmodelo"];
        $upmodelo = [
            'estado' => 2
        ];

        $filtroRsp = [
            'idmodelo' => $idmodelo
        ];

        $result = $modeloModel->UpgradeModelo($filtroRsp, $upmodelo);

        if ($result) {
            $dato = [
                'status' => 'success',
                'title' => 'Operacion Correcta',
                'message' => 'Se logro eliminar el Modelo'
            ];
            echo json_encode($dato);
            exit();
        } else {
            $dato = [
                'status' => 'danger',
                'title' => 'Operacion Errada',
                'message' => 'Ocurrio un error al intentar eliminar el Modelo'
            ];
            echo json_encode($dato);
            exit();
        }
    }

    public function SaveModelo()
    {
        $modeloModel = new ModeloModel();

        $modelo = [
            'idmarca' => $_POST["marca"],
            'codigo' => $_POST["codigoModelo"],
            'descripcion' => $_POST["descripcionModelo"],
            'version' => $_POST["versionModelo"],
            'anho' => $_POST["anhoModelo"]
        ];

        $stor = $modeloModel->StorageModelo($modelo);

        if ($stor != '') {
            $dato = [
                'status' => 'success',
                'title' => 'Operacion Correcta',
                'message' => 'Se logro almacenar el Modelo'
            ];
            echo json_encode($dato);
            exit();
        } else {
            $dato = [
                'status' => 'danger',
                'title' => 'Operacion Errada',
                'message' => 'Ocurrio un error al intentar almacenar el modelo'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}