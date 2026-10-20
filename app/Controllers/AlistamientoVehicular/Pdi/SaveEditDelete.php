<?php
namespace App\Controllers\AlistamientoVehicular\Pdi;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EventoModel;
use App\Models\VinModel;
use Ratchet\Client\WebSocket;
use Ratchet\Client\Connector;
use React\EventLoop\Factory;
use Ratchet\RFC6455\Messaging\MessageInterface;

class SaveEditDelete extends BaseController
{

    public function UploadImagenPdi()
    {
        $db = \Config\Database::connect();
        $alistamientoVehicular = new AlistamientoVehicularModel();

        $vin = $this->request->getPost("vinPdi");
        $idresultadoCheckListPdi = $this->request->getPost("idresultadoCheckListPdi");

        $base64Image = $this->request->getPost("capturedImage") ?? null;
        $rutaImagen = null;
        $nombreImagen = null;
        $tipoImagen = null;

        try {
            $db->transStart(); // Inicia la transacción

            if ($base64Image && preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $data = substr($base64Image, strpos($base64Image, ',') + 1);
                $tipoImagen = $type[1];
                $data = base64_decode($data);

                if ($data === false) {
                    throw new \Exception("Error al decodificar la imagen base64.");
                }

                // 📂 Crear carpeta si no existe
                $vinFolder = FCPATH . 'resource/img/pdi/' . session("database") . '/' . $vin . '/';
                if (!is_dir($vinFolder)) {
                    if (!mkdir($vinFolder, 0755, true)) {
                        throw new \Exception("No se pudo crear el directorio: $vinFolder");
                    }
                }

                $nombreImagen = uniqid('foto_') . '.' . $tipoImagen;
                $rutaCompleta = $vinFolder . $nombreImagen;

                if (file_put_contents($rutaCompleta, $data) === false) {
                    throw new \Exception("No se pudo guardar la imagen en el servidor.");
                }

                // Ruta relativa para la base de datos
                $rutaImagen = 'resource/img/pdi/' . session("database") . '/' . $vin . '/' . $nombreImagen;
            }

            // Actualizar base de datos
            $filtroupdate = [
                'idresultadoFormularioPdi' => $idresultadoCheckListPdi,
            ];

            $update = [
                'rutaImagen'   => $rutaImagen,
                'nombreImagen' => $nombreImagen,
                'tipoImagen'   => $tipoImagen
            ];

            $alistamientoVehicular->UpdateCheckListPdi($filtroupdate, $update);

            $db->transComplete(); // Cierra la transacción

            if ($db->transStatus() === false) {
                throw new \Exception("Error al guardar en la base de datos.");
            }

            echo json_encode([
                'status' => 'success',
                'title'=>'Imagen Cargada',
                'message' => 'La Imagen se cargo correctamente a Gestyx',
                'ruta' => $rutaImagen
            ]);

        } catch (\Throwable $e) {
            $db->transRollback(); // Revierte la transacción en caso de error

            echo json_encode([
                'status' => 'danger',
                'title'=>'Error',
                'message' => 'Error al subir imagen: ' . $e->getMessage()
            ]);
        }
    }
    public function UploadResourcePdi()
    {
        $alistamientoVehicular=New AlistamientoVehicularModel();
        date_default_timezone_set("America/Lima");
        $files = $_FILES['resourcePdi'] ?? null;
        $result = [];
        if ($files && is_array($files['name'])) {
            foreach ($files['name'] as $id => $filename) {
                if ($files['error'][$id] === UPLOAD_ERR_OK) {
                    $tmpName = $files['tmp_name'][$id];
                    $destination = WRITEPATH . 'uploads/pdi/' . basename($filename);
                    move_uploaded_file($tmpName, $destination);
                    // Aquí puedes registrar en DB si deseas
                    $result[] = [
                        'id' => $id,
                        'archivo' => $filename
                    ];
                }
            }
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Carga exitosa',
                'data' => $result
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No se encontraron archivos válidos'
            ]);
        }
    }
    public function StorageCheckPdi()
    {
        $alistamientoVehicular=New AlistamientoVehicularModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $filtroCheck=[
            'idresultadoFormularioPdi'=>$_POST["idresultadoCheckListPdi"]
        ];

        $fechaRealiza=isset($_POST["fechaRevision"])?$_POST["fechaRevision"]:$hoy;
        $observacion=isset($_POST["comentariocheckPdi"])?$_POST["comentariocheckPdi"]:'';

        $checkListPdi=[
            'idestadoResultado'=>$_POST["estadoCheckPdi"],
            'observaciones'=>$observacion,
            'fecha'=>$fechaRealiza,
            'fechaRegistro'=>$hoy,
            'horaRegistro'=>$hora
        ];

        $viewPdi=$alistamientoVehicular->UpdateCheckListPdi($filtroCheck,$checkListPdi);

        if($viewPdi){
            $dato=[
                'status'=>'success',
                'title'=>'CheckList Correcto',
                'message'=>'Se Registro Correctamente el Check de Pdi'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'PDI Errado',
                'message'=>'Ocurrio un error y no se logro finalizar el Check List'
            ];
            echo json_encode($dato);
            exit();
        }

    }
    public function SavePdi()
    {
        $vinModel=New VinModel();
        $alistamientoVin=New AlistamientoVehicularModel();
        $eventoModel=New EventoModel();
        date_default_timezone_set("America/Lima");
        $vin=$_POST["vinPdi"];
        $vinInfo=$vinModel->VinInfo($vin);
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");

        $filtroEvnt=[
            'idevento'=>2
        ];

        $loop = Factory::create();
        $connector = new Connector($loop);

        $evn=$eventoModel->ViewEvento($filtroEvnt);

        if($evn[0]["idtipoFormulario"]==1){
            $filtroProce=[
                'idprocesoPdi'=>$_POST["procesoPdiForm"]
            ];
            $updateProce=[
                'voltageBateria'=>$_POST["nivelGasolina"],
                'cantidadCombustible'=>$_POST["nivelGasolina"],
                'idusuario'=>session("idusuario"),
                'fecha'=>$_POST["fechaValidacionOns"],
                'fechaRegistro'=>$hoy
            ];

            if (isset($_POST['inlineRadioOptions'])) {
                $selectedValue = $_POST['inlineRadioOptions'];
                $updateProce+=[
                    'idestadoBateria'=>$selectedValue,
                ];

                $detailPdi=$alistamientoVin->DetailProcedimientoPdi($filtroProce);
                $contadorTotal=0;
                $contadorRealizado=0;
                foreach($detailPdi as $chkd){
                    $contadorTotal++;
                    if(!is_null($chkd["idestadoResultado"])){
                        $contadorRealizado++;
                    }
                }

                if($contadorRealizado==$contadorTotal){
                    $upProc=$alistamientoVin->UpdateProcesoPdi($filtroProce,$updateProce);
                }else{
                    $send=[
                        'status'=>'warning',
                        'title'=>'Checks Pendientes',
                        'message'=>'Tiene Checks pendientes de realizar en el proceso de Pdi Mecanico'
                    ];

                    echo json_encode($send);
                    exit();
                }

            } else {
                $send=[
                    'status'=>'warning',
                    'title'=>'Campo Sin Marcar',
                    'message'=>'El campo estado de bateria es obligatorio marquelo'
                ];

                echo json_encode($send);
                exit();
            }
        }
        $filtroOrd=[
            'idevento'=>2
        ];
        $odpdi=$eventoModel->OrdenEvento($filtroOrd);
        $ordenNuevoEvent=$odpdi[0]['orden']+1;

        $filtrOn=[
            'orden'=>$ordenNuevoEvent
        ];
        $odnuEv=$eventoModel->OrdenEvento($filtrOn);

        $update=[
            'ideventoAnterior'=>2,
            'eventoAnterior'=>'PDI',
            'fechaEventoActual'=>$_POST["fechaValidacionOns"],
            'horaEventoActual'=>$hora,
            'fechaEventoAnterior'=>$vinInfo[0]["fechaEventoActual"],
            'horaEventoAnterior'=>$vinInfo[0]["horaEventoActual"],
            'ideventoActual'=>$odnuEv[0]["idevento"],
            'eventoActual'=>$odnuEv[0]["descripcionOrden"]
        ];

        if($_POST["estadoOnstar"]==1){
            $update+=[
                'onstar'=>1,
            ];
        }

        $filtroVin=[
            'vin'=>$vin
        ];

        $updateV=$alistamientoVin->UpdateVinAccesorio($filtroVin,$update);

        if($updateV){
            $filtroEvento=[
                'vin'=>$vin,
                'ideventoActual'=>2,
                'idestadoEvento'=>1
            ];
            $updateEvento=[
                'fechaFin'=>$_POST["fechaValidacionOns"],
                'fechaRegistroSistemaFin'=>$hoy,
                'horaFin'=>$hora,
                'idestadoEvento'=>2,
                'idusuariofinaliza'=>session("idusuario"),
                'comentarios'=>$_POST["comentarioPdi"]
            ];
            $updev=$eventoModel->UpdateEvento($filtroEvento,$updateEvento);
            if($updev){
                $eventInsert=[
                    'ideventoAnterior'=>2,
                    'eventoAnterior'=>'PDI',
                    'vin'=>$_POST["vinPdi"],
                    'ideventoActual'=>$odnuEv[0]["idevento"],
                    'eventoActual'=>$odnuEv[0]["descripcionOrden"],
                    'fechaInicio'=>$_POST["fechaValidacionOns"],
                    'horaInicio'=>$hora,
                    'idestadoEvento'=>1,
                    'idusuario'=>session("idusuario")
                ];
                $insrt=$eventoModel->StorageEvento($eventInsert);

                if($_POST["estadoOnstar"]==1){
                    $eventInsertOs=[
                        'ideventoAnterior'=>2,
                        'eventoAnterior'=>'PDI',
                        'vin'=>$_POST["vinPdi"],
                        'ideventoActual'=>6,
                        'eventoActual'=>'Onstar',
                        'fechaInicio'=>$_POST["fechaValidacionOns"],
                        'horaInicio'=>$hora,
                        'idestadoEvento'=>1,
                        'idusuario'=>session("idusuario")
                    ];
                    $insrtO=$eventoModel->StorageEvento($eventInsertOs);
                }
            }

            $loop = Factory::create();
            $connector = new Connector($loop);
            $eventoAnterior="PDI";
            $eventoActual=$odnuEv[0]["descripcionOrden"];
            $connector('ws://localhost:8080/chat')
                ->then(function (WebSocket $conn) use ($vin,$eventoAnterior,$eventoActual) {
                    // Aquí puedes enviar directamente el mensaje sin necesidad de la variable $vehiculosTodos
                    $conn->send(json_encode([
                        "type" => "SendEvento",
                        "eventoAnterior"=>$eventoAnterior,
                        "eventoActual"=>$eventoActual,
                        "database" => session("database"),
                        "message"=>"El vin ".$vin." ingreso al evento",
                        "vin"=>$vin,
                    ]));
                    // Cierra la conexión después de enviar el mensaje
                    $conn->close();
                }, function (Exception $e) {
                    echo "No se pudo conectar: {$e->getMessage()}\n";
                });

            $loop->run();


            $dato=[
                'status'=>'success',
                'title'=>'PDI Correcto',
                'message'=>'Se finalizo correctamente el PDI'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'PDI Errado',
                'message'=>'Ocurrio un error y no se logro finalizar el PDI'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}