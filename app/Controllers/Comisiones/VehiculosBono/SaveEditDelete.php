<?php

namespace App\Controllers\Comisiones\VehiculosBono;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ComisionModel;
use App\Models\MarcaModel;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SaveEditDelete extends BaseController
{
    public function SaveBono()
    {
        $BonoVehiculoModel = new ComisionModel();
        date_default_timezone_set("America/Lima");
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");
        $anho = date("Y");
        $db = \Config\Database::connect();
        $ultimoDiaDelMes='';

        if (!empty($_POST["fechaInicio"])) {
            // Obtener el mes y el año de la fecha seleccionada
            $anio = date('Y', strtotime($_POST["fechaInicio"]));
            $mes = date('m', strtotime($_POST["fechaInicio"]));
            // Obtener el último día del mes usando strtotime para crear una fecha del primer día del siguiente mes
            // Luego, ajustamos la fecha al último día del mes anterior
            $ultimoDiaDelMes = date('Y-m-t', strtotime("$anio-$mes-01"));

        }

        // Ruta al archivo Excel
        $bono = [
            'idmarca' => $_POST['marcaCarga'],
            'fechaInicio' => $_POST["fechaInicio"],
            'fechaFin'=>$ultimoDiaDelMes,
            'estado' => 1,
            'mesInicio' => $_POST['mesInicio'],
            'anho' => $anho,
            'mesFin' => $_POST['mesInicio'],
            'idusuario' => session('idusuario')
        ];

        $archivo = $_FILES['resourceExcel']['name'];
        $rutaDestino = '';

        try {
            // Iniciar la transacción
            $db->transBegin();

            if (isset($archivo) && $archivo != "") {
                // Obtener algunos datos necesarios sobre el archivo
                $tipo = $_FILES['resourceExcel']['type'];
                $temp = $_FILES['resourceExcel']['tmp_name'];
                $carpetaDestino = "resource/upload/bonoVehiculo/";

                // Crear el directorio si no existe
                if (!is_dir($carpetaDestino)) {
                    mkdir($carpetaDestino, 0755, true);
                }

                $rutaDestino = $carpetaDestino . $archivo;

                // Mover el archivo desde el directorio temporal a la carpeta de destino
                if (move_uploaded_file($temp, $rutaDestino)) {
                    // Actualizar la información del bono con la ruta del archivo
                    $bono += [
                        'fechaCarga' => $hoy,
                        'horaCarga' => $hora,
                        'idusuario' => session("idusuario"),
                        'tipoCarga' => 'Bonos de Vehiculos',
                        'rutaExcel' => $rutaDestino
                    ];
                } else {
                    throw new \Exception('No se logró cargar el archivo excel de comisiones');
                }

                // Store Bono and retrieve the ID
                $idcircularBono = $BonoVehiculoModel->StorageBono($bono);

                // Verifica que el bono se ha guardado
                if (!$idcircularBono) {
                    throw new \Exception('No se logró almacenar el bono principal');
                }

                // Descripción de la marca
                $descripcionMarca = 'CHEVROLET';

                $file = $rutaDestino;

                // Cargar el archivo Excel
                $spreadsheet = IOFactory::load($file);
                $sheetName = $_POST["marcaCarga"];
                // Obtener la hoja por su nombre
                $sheet = $spreadsheet->getSheetByName($descripcionMarca);

                if ($sheet === null) {
                    throw new \Exception('La Hoja no cuenta con el mismo nombre de marca');
                }

                // Obtener la cantidad de filas
                $totalFilas = $sheet->getHighestRow();

                // Procesar cada fila del archivo Excel
                for ($row = 2; $row <= $totalFilas; $row++) {
                    $marcaEx = $sheet->getCell("A" . $row)->getFormattedValue();
                    $codigoVinEx = $sheet->getCell("B" . $row)->getFormattedValue();
                    $modeloEx = $sheet->getCell("C" . $row)->getFormattedValue();
                    $bonoEx = $sheet->getCell("D" . $row)->getValue();

                    // Validación de la marca
                    if ($descripcionMarca == $marcaEx) {
                        if($bonoEx!=0){
                            //actualiza si existe anteriores del mismo mes para eso utiliza el mes como referencia y el codigo SAP del modelo del carro
                            //ojito!!!!! OjO
                            //mira y aprende Beltri xD

                            $filtroUp=[
                                'idmarca'=>$_POST['marcaCarga'],
                                'codigoModelo'=>$codigoVinEx,
                                'mesInicio' => $_POST['mesInicio'],
                                'mesFin' => $_POST['mesInicio']
                            ];

                            $updateF=[
                                'fechaFin'=>$_POST["fechaInicio"]
                            ];

                            $updateDetailBono=$BonoVehiculoModel->UpdateDetailBonoCircular($filtroUp,$updateF);


                            $detailCircular = [
                                'idmarca'=>$_POST['marcaCarga'],
                                'idcircularBono' => $idcircularBono,
                                'modelo' => $modeloEx,
                                'bono' => $bonoEx,
                                'codigoModelo' => $codigoVinEx,
                                'mesInicio' => $_POST['mesInicio'],
                                'mesFin' => $_POST['mesInicio'],
                                'fechaInicio'=>$_POST["fechaInicio"],
                                'fechaFin'=>$ultimoDiaDelMes,
                                'anho'=>$anho
                            ];

                            // Store Detail Bono
                            $det = $BonoVehiculoModel->StorageDetailBono($detailCircular);
                            if (!$det) {
                                throw new \Exception('No se logró almacenar el detalle del bono');
                            }
                            // Log de depuración (puedes revisar si el detalle está siendo procesado)
                            log_message('debug', 'Detalle Bono almacenado: ' . json_encode($detailCircular));
                        }
                        // Verificar si el detalle se guardó correctamente

                    }
                }

                // Verificar el estado de la transacción
                if ($db->transStatus() === false) {
                    throw new \Exception('La transacción falló');
                }

                // Commit transaction if everything is successful
                $db->transCommit();

                $dato = [
                    'status' => 'success',
                    'title' => 'Proceso Correcto',
                    'message' => 'Se logró almacenar la información correctamente'
                ];
                echo json_encode($dato);

            } else {
                throw new \Exception('No se proporcionó ningún archivo para cargar');
            }
        } catch (\Exception $e) {
            // Rollback the transaction in case of any exception
            $db->transRollback();

            $dato = [
                'status' => 'danger',
                'title' => 'Proceso Errado',
                'message' => 'Error: ' . $e->getMessage()
            ];
            echo json_encode($dato);
        }
    }



    public function SaveBonoOld()
    {
        $BonoVehiculoModel=New ComisionModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $anho=date("Y");
        // Ruta al archivo Excel

        $bono=[
            'idmarca'=>$_POST['marcaCarga'],
            'fechaInicio'=>$hoy,
            'estado'=>1,
            'mesInicio'=>$_POST['mesInicio'],
            'anho'=>$anho,
            'mesFin'=>$_POST['mesInicio'],
            'idusuario'=>session('idusuario')
        ];

        $archivo = $_FILES['resourceExcel']['name'];
        $rutaDestino='';
        if (isset($archivo) && $archivo != "") {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['resourceExcel']['type'];
            $temp = $_FILES['resourceExcel']['tmp_name'];
            $carpetaDestino="resource/upload/bonoVehiculo/";
            $rutaDestino = $carpetaDestino.$archivo;
            // Mover el archivo desde el directorio temporal a la carpeta de destino
            if (move_uploaded_file($temp, $rutaDestino)) {
                $bono+=[
                    'fechaCarga'=>$hoy,
                    'horaCarga'=>$hora,
                    'idusuario'=>session("idusuario"),
                    'tipoCarga'=>'Bonos de Vehiculos',
                    'rutaExcel'=>$rutaDestino
                ];
            } else {
                $dato=[
                    'status'=>'danger',
                    'title'=>'Proceso Errado',
                    'message'=>'No se logro cargar el archivo excel de comisiones'
                ];
                echo json_encode($dato);
                exit();
            }

            $idcircularBono=$BonoVehiculoModel->StorageBono($bono);

            $descripcionMarca='CHEVROLET';


            $file = $rutaDestino;
            // Carga el archivo Excel
            $spreadsheet = IOFactory::load($file);
            // Nombre de la hoja que deseas leer
            $sheetName = $_POST["marcaCarga"];
            // Obtén la hoja por su nombre
            $sheet = $spreadsheet->getSheetByName($sheetName);

            if ($sheet === null) {
                $dato=[
                    'status'=>'danger',
                    'title'=>'Proceso Errado',
                    'message'=>'La Hoja no cuenta con el mismo nombre de marca'
                ];
                echo json_encode($dato);
                exit();
            }
            // Obtén la cantidad de filas
            $totalFilas = $sheet->getHighestRow();
            $contadorDuplicado=0;
            $contadorErrores=0;
            $contadorCorrecto=0;
            for($row=2;$row<=$totalFilas;$row++){
                $marcaEx = $sheet->getCell("A" . $row)->getFormattedValue();
                $codigoVinEx=$sheet->getCell("B" . $row)->getFormattedValue();
                $modeloEx = $sheet->getCell("C" . $row)->getFormattedValue();
                $bonoEx = $sheet->getCell("D" . $row)->getValue();
                //Costos
                if($descripcionMarca==$marcaEx){
                    $detailCircular=[
                        'idbonoCircular'=>$idcircularBono,
                        'modelo'=>$modeloEx,
                        'bono'=>$bonoEx,
                        'codigoVin'=>$codigoVinEx,
                        'mesInicio'=>$_POST['mesInicio'],
                        'mesFin'=>$_POST['mesInicio'],
                    ];
                    $iddetstor=$BonoVehiculoModel->StorageDetailBono($detailCircular);
                }
            }
            $dato=[
                'status'=>'success',
                'title'=>'Proceso Correcto',
                'message'=>'Se logro almacenar la informacion correctamente'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}