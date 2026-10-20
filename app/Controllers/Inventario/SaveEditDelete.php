<?php
namespace App\Controllers\Inventario;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\BateriaModel;
use App\Models\EventoModel;
use App\Models\ExhibicionModel;
use App\Models\GeneralesModel;
use App\Models\TrasladoModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{

    public function DeleteEquipamiento()
    {
        $alistamientoModel=New AlistamientoVehicularModel();

        $filtroUpdate=[
            'idequipamientoVin'=>$_POST["idequipamientoVinExhi"]
        ];
        $equipamiento=[
            'eliminado'=>1
        ];

        $delt=$alistamientoModel->UpdateEquipamiento($filtroUpdate,$equipamiento);

        if($delt){
            $dato=[
                'status'=>'success',
                'title'=>'Eliminado Correctamente',
                'message'=>'Se retiro el equipamiento del Vehiculo'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error en Grabado',
                'message'=>'Ocurrio un error inesperado, que impide eliminar el equipamiento'
            ];
            echo json_encode($dato);
            exit();
        }
    }

    public function SaveExhibicion()
    {
        $exhibicionModel=New ExhibicionModel();
        $generalModel=New GeneralesModel();
        $vinModel=New VinModel();
        $eventoModel=New EventoModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");

        $filtroUpdate=[
            'idexhibicionVin'=>$_POST["idexhibicionVin"],
            'vin'=>$_POST["vinExhibicion"]
        ];

        $filtroAgen=[
            'idagencia'=>$_POST["agenciaExhibicion"]
        ];

        $agen=$generalModel->Agencia($filtroAgen);

        $updateEq=[
            'solicitante'=>$_POST["solicitante"],
            'idagenciaSolicitante'=>$_POST["agenciaExhibicion"],
            'idestadoExhibicion'=>$_POST["estadoExhibicion"],
            'fechaEstimadaEnvioExhibicion'=>$_POST["fechaEstimadaEnvio"],
            'fechaEstimadaRetornoExhibicion'=>$_POST["fechaEstimadaRetorno"],
            'comentario'=>$_POST["comentario"],
            'codigoAgencia'=>$agen[0]["codigoAgencia"],
            'agencia'=>$agen[0]["descripcion"]
        ];

        $retorn=$exhibicionModel->UpdateExhibicion($filtroUpdate,$updateEq);

        if($_POST["estadoExhibicion"]!=1){

            $filtroOrd=[
                'orden'=>1
            ];
            $odpdi=$eventoModel->OrdenEvento($filtroOrd);

            $filtroUpdateVin=[
                'vin'=>$_POST["vinExhibicion"]
            ];
            $updateVin=[
                'idestadoVin'=>6,
                'ideventoActual'=>$odpdi[0]["idevento"],
                'eventoActual'=>$odpdi[0]["descripcionOrden"],
                'ideventoAnterior'=>30,
                'eventoAnterior'=>'Inventario',
                'fechaEventoActual'=>$hoy,
                'horaEventoActual'=>$hora,
                'codigoAgencia'=>$agen[0]["codigoAgencia"],
                'agencia'=>$agen[0]["descripcion"]
            ];
            $updateVn=$vinModel->UpdateVin($filtroUpdateVin,$updateVin);
            if($updateVn){
                $eventoActual=[
                    'fechaRegistroSistemaInicio'=>$hoy,
                    'fechaInicio'=>$hoy,
                    'vin'=>$_POST["vinExhibicion"],
                    'horaInicio'=>$hora,
                    'ideventoAnterior'=>30,
                    'eventoAnterior'=>'Inventario',
                    'ideventoActual'=>$odpdi[0]["idevento"],
                    'eventoActual'=>$odpdi[0]["descripcionOrden"],
                    'idestadoEvento'=>1
                ];
                $store=$eventoModel->StorageEvento($eventoActual);
            }
        }

        if($retorn){
            $dato=[
                'status'=>'success',
                'title'=>'Guardado Correcto',
                'message'=>'Se almaceno correctamente'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error de Datos',
                'message'=>'No se logro almacenar correctamente los datos'
            ];
            echo json_encode($dato);
            exit();
        }
    }

    public function SaveEquipamientoExhibicion()
    {
        $exhibicionModel=New ExhibicionModel();

        $equipamiento=[
            'vin'=>$_POST["vinExhibicion"],
            'idexhibicionVin'=>$_POST["idexhibicionVin"],
            'codigoEquipamiento'=>$_POST["codigoEquipamiento"],
            'cantidad'=>$_POST["cantidadEquipamiento"],
            'equipamiento'=>$_POST["equipamiento"],
            'idtipoEquipamiento'=>1,
            'idestadoEquipamiento'=>1
        ];

        $ideqp=$exhibicionModel->StorageEquipamientoExhibicion($equipamiento);

        if($ideqp!=''){
            $dato=[
                'status'=>'success',
                'title'=>'Equipamiento Agregado',
                'message'=>'Se Agrego el equipamiento correctamente'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error de Datos',
                'message'=>'Se Agrego el equipamiento correctamente'
            ];
            echo json_encode($dato);
            exit();
        }
    }
    public function SaveBateria_old()
    {
        $bateriaModel=New BateriaModel();
        date_default_timezone_set("America/Lima");
        $hora=date("H:i:s");
        $bateriaTest=[
            'vin'=>$_POST["vinBateria"],
            'fechaTest'=>$_POST["fechaTest"],
            'horaTest'=>$hora,
            'estadoBateria'=>$_POST["estadoBateria"],
            'notasAdicionales'=>$_POST["observacion"],
            'idusuario'=>session("idusuario"),
            'idestadoTestBateria'=>1
        ];
        $fechaProximo='';

        $result=$bateriaModel->CalcularProximoTest($_POST["vinBateria"],$_POST["fechaTest"]);

        $bateriaTest+=[
            'fechaProximoTest'=>$result[0]["fechaSiguiente"]
        ];

        $filtroUpdateBat=[
            'vin'=>$_POST["vinBateria"],
            'idestadoTestBateria'=>1
        ];
        $updateBat=[
            'idestadoTestBateria'=>2
        ];

        $updateBatSql=$bateriaModel->UpdateBateria($filtroUpdateBat,$updateBat);

        $idstorage=$bateriaModel->StorageBateria($bateriaTest);

        if($idstorage!=''){
            $dato=[
                'status'=>'success',
                'title'=>'Operacion Correcta',
                'message'=>'Se logro realizar el test de bateria correctamente'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'warning',
                'title'=>'Error en Proceso',
                'message'=>'El test de bateria no se logro realizar correctamente'
            ];
            echo json_encode($dato);
            exit();
        }

    }

    public function SaveBateria()
    {
        $db = \Config\Database::connect(); // Obtener la conexión de la base de datos
        $bateriaModel = New BateriaModel();
        date_default_timezone_set("America/Lima");
        $hora = date("H:i:s");

        // Comenzamos una transacción
        $db->transBegin();

        try {
            $bateriaTest = [
                'vin' => $_POST["vinBateria"],
                'fechaTest' => $_POST["fechaTest"],
                'fechaRealTest'=>$_POST["fechaTestReal"],
                'horaTest' => $hora,
                'estadoBateria' => $_POST["estadoBateria"],
                'notasAdicionales' => $_POST["observacion"],
                'idusuario' => session("idusuario"),
                'idestadoTestBateria' => 1
            ];

            $fechaProximo = '';

            $result = $bateriaModel->CalcularProximoTest($_POST["vinBateria"], $_POST["fechaTest"]);
            $bateriaTest += [
                'fechaProximoTest' => $result[0]["fechaSiguiente"]
            ];

            // Comprobar si hay una imagen
            if (isset($_FILES['resourceDetalleBat']) && $_FILES['resourceDetalleBat']['error'] == 0) {
                // Obtener información de la imagen
                $imagenTmp = $_FILES['resourceDetalleBat']['tmp_name'];
                $imagenNombreOriginal = $_FILES['resourceDetalleBat']['name'];
                $imagenTipo = $_FILES['resourceDetalleBat']['type'];

                // Generar un nombre único para la imagen
                $extension = pathinfo($imagenNombreOriginal, PATHINFO_EXTENSION); // Obtener la extensión del archivo
                $nombreUnico = uniqid("bateria_", true) . "." . $extension; // Generar un nombre único


                $carpetaDestino = "resource/testBateria/".$_POST["vinBateria"]."/";  // Define la carpeta donde guardarás las imágenes
                $imagenRuta = $carpetaDestino . $nombreUnico; // Ruta completa del archivo con el nuevo nombre

                if (!is_dir($carpetaDestino)) {
                    mkdir($carpetaDestino, 0755, true); // Crear el directorio si no existe
                }

                // Mover el archivo a la carpeta destino
                if (move_uploaded_file($imagenTmp, $imagenRuta)) {
                    // Si la imagen se guardó correctamente, añadimos la información al array
                    $bateriaTest += [
                        'rutaImagen' => $imagenRuta,
                        'nombreImagen' => $nombreUnico,
                        'tipoImagen' => $imagenTipo
                    ];


                } else {
                    throw new \Exception("Hubo un problema al guardar la imagen.");
                }
            }



            // Actualizamos el estado de la batería
            $filtroUpdateBat = [
                'vin' => $_POST["vinBateria"],
                'idestadoTestBateria' => 1
            ];
            $updateBat = [
                'idestadoTestBateria' => 2
            ];

            $updateBatSql = $bateriaModel->UpdateBateria($filtroUpdateBat, $updateBat);
            if (!$updateBatSql) {
                throw new \Exception("Error al actualizar el estado de la batería.");
            }

            // Guardamos el test de batería
            $idstorage = $bateriaModel->StorageBateria($bateriaTest);
            if (!$idstorage) {
                throw new \Exception("Error al almacenar los datos del test de batería.");
            }

            $db->transCommit();

            // Respuesta de éxito
            $dato = [
                'status' => 'success',
                'title' => 'Operacion Correcta',
                'message' => 'Se logró realizar el test de batería correctamente.'
            ];
            echo json_encode($dato);
            exit();

        } catch (\Exception $e) {
            // Si hay un error, hacemos rollback de la transacción
            $db->transRollback();

            // Respuesta de error
            $dato = [
                'status' => 'warning',
                'title' => 'Error en Proceso',
                'message' => $e->getMessage()
            ];
            echo json_encode($dato);
            exit();
        }
    }

    public function SaveGas()
    {
        $alistamientoVehicular=New AlistamientoVehicularModel();
        $eventoModel=New EventoModel();
        $vinModel=New VinModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $provGas=explode("-",$_POST["proveedorGas"]);
        $idproveedorGas=$provGas[0];
        $idproveedorGasRegion=$provGas[1];


        $equipamientoGas=[
            'vin'=>$_POST["vinGas"],
            'codigoEquipamiento'=>'GAS',
            'cantidad'=>1,
            'idtipoEquipamiento'=>9,
            'equipamiento'=>$_POST["modeloGas"],
            'fechaInicio'=>$_POST["fechaInstalacionGas"],
            'fechaInstalacion'=>$_POST["fechaInstalacionGas"],
            'fechaRegistro'=>$hoy,
            'idusuarioFinal'=>session("idusuario"),
            'idproveedorGas'=>$idproveedorGas,
            'idproveedorGasRegion'=>$idproveedorGasRegion
        ];

        $inser=$alistamientoVehicular->InsertEquipamiento($equipamientoGas);

        $vinUpdate=[
            'gas'=>1,
            'modeloGas'=>$_POST["modeloGas"]
        ];

        $filtroVin=[
            'vin'=>$_POST['vinGas']
        ];

        if($inser!=''){
            $vinP=$vinModel->UpdateVin($filtroVin,$vinUpdate);
        }else{
            $dato=[
                'status'=>'warning',
                'title'=>'Error de procesamiento',
                'message'=>'no se lograron efectuar los cambios'
            ];
            echo json_encode($dato);
            exit();
        }

        $insertEventoGas=[
            'ideventoAnterior'=>1,
            'eventoAnterior'=>'Accesorios',
            'vin'=>$_POST["vinGas"],
            'ideventoActual'=>10,
            'eventoActual'=>'Conversion Gas',
            'fechaInicio'=>$_POST["fechaInstalacionGas"],
            'horaInicio'=>$hora,
            'fechaFin'=>$_POST["fechaInstalacionGas"],
            'horaFin'=>$hora,
            'idusuario'=>session("idusuario"),
            'idusuariofinaliza'=>session("idusuario"),
            'idestadoEvento'=>2,
            'comentarios'=>$_POST["observacion"]
        ];

        if($vinP){
            $insertimeGs=$eventoModel->StorageEvento($insertEventoGas);
            if($insertimeGs){
                $dato=[
                    'status'=>'success',
                    'title'=>'Operacion Correcta',
                    'message'=>'Se convirtio correctamente la unidad'
                ];
                echo json_encode($dato);
                exit();
            }
        }

    }
}