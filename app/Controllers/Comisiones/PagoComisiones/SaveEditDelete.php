<?php

namespace App\Controllers\Comisiones\PagoComisiones;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ComisionModel;
use App\Models\LogModel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class SaveEditDelete extends BaseController
{
    public function ReadExcel()
    {
        $comisionModel=New ComisionModel();
        $logModel=New LogModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        // Ruta al archivo Excel
        $archivo = $_FILES['resourceExcel']['name'];
        if (isset($archivo) && $archivo != "") {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['resourceExcel']['type'];
            $temp = $_FILES['resourceExcel']['tmp_name'];
            $carpetaDestino="resource/upload/comision/";
            $rutaDestino = $carpetaDestino.$archivo;
            // Mover el archivo desde el directorio temporal a la carpeta de destino
            if (move_uploaded_file($temp, $rutaDestino)) {
                $storageLogs=[
                    'fechaCarga'=>$hoy,
                    'horaCarga'=>$hora,
                    'idusuario'=>session("idusuario"),
                    'tipoCarga'=>'Comision Vendedores',
                    'rutaArchivo'=>$rutaDestino
                ];
                $storage=$logModel->Savelog($storageLogs);
            } else {
                $dato=[
                    'status'=>'danger',
                    'title'=>'Proceso Errado',
                    'message'=>'No se logro cargar el archivo excel de comisiones'
                ];
                echo json_encode($dato);
                exit();
            }
        }


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
            $vin = $sheet->getCell("B" . $row)->getFormattedValue();
            $vendedor = $sheet->getCell("K" . $row)->getFormattedValue();
            $marca = $sheet->getCell("C" . $row)->getValue();
            //Costos
            $tipoCambio=$sheet->getCell("R" . $row)->getFormattedValue();
            $bonoDolar=$sheet->getCell("S" . $row)->getFormattedValue();
            $bonoSol=$sheet->getCell("T" . $row)->getFormattedValue();
            $obsequios=$sheet->getCell("U" . $row)->getFormattedValue();
            $margenVehiculo=$sheet->getCell("V" . $row)->getFormattedValue();
            $porcentajeMargen=$sheet->getCell("W" . $row)->getFormattedValue();

            $subTotalComision=$sheet->getCell("AA" . $row)->getFormattedValue();
            $digital=$sheet->getCell("AB" . $row)->getFormattedValue();
            $descuento=$sheet->getCell("AC" . $row)->getFormattedValue();
            $totalComision = $sheet->getCell("AD" . $row)->getFormattedValue();
            $observaciones=$sheet->getCell("AE" . $row)->getFormattedValue();

            if($marca==$sheetName){
                $storage=[
                    'vin'=>$vin,
                    'vendedor'=>$vendedor,
                    'tipoCambio'=>$tipoCambio,
                    'bonoDolar'=>$bonoDolar,
                    'bonoSol'=>$bonoSol,
                    'obsequio'=>$obsequios,
                    'margen'=>$margenVehiculo,
                    'porcentajeMargen'=>$porcentajeMargen,
                    'subTotalComision'=>$subTotalComision,
                    'digital'=>$digital,
                    'descuento'=>$descuento,
                    'totalComision'=>$totalComision,
                    'observaciones'=>$observaciones
                ];

                $filtroDuplica=[
                    'vin'=>$vin
                ];

                $viewComi=$comisionModel->ViewComision($filtroDuplica);
                if(!$viewComi){
                    $idstor=$comisionModel->SaveVin($storage);
                    if($idstor!=''){
                        $filtro=[
                            'vin'=>$vin
                        ];
                        $update=[
                            'comisionPagada'=>1
                        ];
                        $vinup=$comisionModel->UpdateVin($filtro,$update);
                        $contadorCorrecto++;
                    }else{
                        $contadorErrores++;
                    }
                }else{
                    $contadorDuplicado++;
                }
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

