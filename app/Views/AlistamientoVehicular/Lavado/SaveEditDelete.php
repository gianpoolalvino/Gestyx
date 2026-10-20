<?php
namespace App\Controllers\AlistamientoVehicular\Lavado;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EventoModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{

    public function SaveLavadoDet()
    {
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $alistamientoVehicular=New AlistamientoVehicularModel();
        $filtro=[
            'iddetalleLavado'=>$_POST["iddetalleLavado"]
        ];
        $updateVin=[
            'fechaLavado'=>$_POST["fechaLavado"],
            'observacion'=>$_POST["comentarioLavado"],
            'idestadoLavado'=>$_POST["estadoLavado"]
        ];


        $archivo = $_FILES['resourceUploadImg']['tmp_name'];
        if (isset($_FILES['resourceUploadImg']) && $_FILES['resourceUploadImg']['error'] == UPLOAD_ERR_OK) {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['resourceUploadImg']['type'];
            $temp = $_FILES['resourceUploadImg']['name'];
            $tps = explode('/', $_FILES['resourceUploadImg']['type']);
            $typo = $tps[1];
            $extensionPermitidas=['pdf','jpeg','jpg','png'];
            $tipoMime=explode("/",$tipo)[1]??'';
            //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
            if (!in_array($tipoMime, $extensionPermitidas)) {
                $send = [
                    "status" => "warning",
                    "title" => "Error de extension",
                    "message" => "El tipo de imagen no es admitido en PDI"
                ];
                echo json_encode($send);
                exit();
            } else {

                $directorio = 'resource/lavado/'.$_POST["vinLavado"]."/";

                // Verifica si el directorio existe, si no, lo crea
                if (!is_dir($directorio)) {
                    mkdir($directorio, 0755, true);
                }
                $hashNombre = hash('sha256', $temp . time()) . '.' . pathinfo($temp, PATHINFO_EXTENSION);

                // Ruta completa del archivo destino
                $rutaDestino = $directorio . $hashNombre;
                // Mover el archivo subido al directorio de destino
                if (move_uploaded_file($archivo, $rutaDestino)) {
                    $path = $archivo;
                    $type = pathinfo($path, PATHINFO_EXTENSION);
                    $data = $archivo;
                    $updateVin+=[
                        'rutaImagen' => $rutaDestino,
                        'nombreImagen' => $temp,
                        'tipoImagen' => $typo,
                        'fechaCarga' => $hoy,
                        'horaCarga' => $hora
                    ];
                } else {
                    $send = [
                        "status" => "danger",
                        "title" => "Error de Carga",
                        "message" => "Error al mover el archivo ".$temp
                    ];
                    echo json_encode($send);
                    exit();
                }
            }

        }

        $upst=$alistamientoVehicular->UpdateLavadoVin($filtro,$updateVin);
        if($upst){
            $dato=[
                'status'=>'success',
                'title'=>'Proceso Completado',
                'message'=>'Se Realizo correctamente el proceso de Lavado'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Proceso Errado',
                'message'=>'Error en el proceso de Lavado'
            ];
            echo json_encode($dato);
            exit();
        }
    }
    public function SaveLavado()
    {
        $vinModel=New VinModel();
        $alistamientoVin=New AlistamientoVehicularModel();
        $eventoModel=New EventoModel();
        date_default_timezone_set("America/Lima");
        $vin=$_POST["vinLavado"];
        $vinInfo=$vinModel->VinInfo($vin);
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");

        $filtroEvent=[
            'idevento'=>3
        ];

        $tipoForm=$alistamientoVin->TipoProcesoEvento($filtroEvent);

        if($tipoForm[0]["idtipoFormulario"]==1){
            $filtroVin=[
                'vin'=>$vin
            ];
            $detail=$alistamientoVin->DetailLavadoVin($filtroVin);
            $pendientes=0;
            foreach($detail as $di){
                if($di["idestadoLavado"]==1){
                    $pendientes++;
                }
            }
            if($pendientes>0){
                $dato=[
                    'status'=>'danger',
                    'title'=>'Error en Proceso',
                    'message'=>'Tiene Lavados pendientes de procesar'
                ];
                echo json_encode($dato);
                exit();
            }
        }

        $filtroOrd=[
            'idevento'=>3
        ];
        $odpdi=$eventoModel->OrdenEvento($filtroOrd);
        $ordenNuevoEvent=$odpdi[0]['orden']+1;

        $filtrOn=[
            'orden'=>$ordenNuevoEvent
        ];
        $odnuEv=$eventoModel->OrdenEvento($filtrOn);


        $updateVin=[
            'ideventoActual'=>$odnuEv[0]['idevento'],
            'eventoActual'=>$odnuEv[0]['descripcionOrden'],
            'ideventoAnterior'=>3,
            'eventoAnterior'=>'Lavado',
            'fechaEventoActual'=>$_POST["fechaLavadoVin"],
            'horaEventoActual'=>$hora,
            'fechaEventoAnterior'=>$vinInfo[0]["fechaEventoActual"],
            'horaEventoAnterior'=>$vinInfo[0]["horaEventoActual"],
            'idproveedorLavado'=>$_POST["proveedorLavado"]
        ];

        $filtroVin=[
            'vin'=>$vin
        ];

        $updateV=$alistamientoVin->UpdateVinAccesorio($filtroVin,$updateVin);

        if($updateV) {
            $filtroEvento = [
                'vin' => $vin,
                'ideventoActual' => 3,
                'idestadoEvento'=>1
            ];
            $updateEvento = [
                'fechaFin' => $_POST["fechaLavadoVin"],
                'fechaRegistroSistemaFin' => $hoy,
                'horaFin' => $hora,
                'idestadoEvento' => 2,
                'idusuariofinaliza' => session("idusuario"),
                'comentarios' => $_POST["comentarioLavado"]
            ];
            $updev = $eventoModel->UpdateEvento($filtroEvento, $updateEvento);

            $eventInsert=[
                'ideventoAnterior'=>3,
                'eventoAnterior'=>'Lavado',
                'vin'=>$vin,
                'ideventoActual'=>$odnuEv[0]['idevento'],
                'eventoActual'=>$odnuEv[0]['descripcionOrden'],
                'fechaInicio'=>$_POST["fechaLavadoVin"],
                'horaInicio'=>$hora,
                'idestadoEvento'=>1,
                'idusuario'=>session("idusuario")
            ];
            $insrt=$eventoModel->StorageEvento($eventInsert);

            if($insrt){
                $dato=[
                    'status'=>'success',
                    'title'=>'Proceso Completado',
                    'message'=>'Se Realizo correctamente el proceso de Lavado'
                ];

                echo json_encode($dato);
                exit();
            }
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Proceso Errado',
                'message'=>'Error en el proceso de Lavado'
            ];

            echo json_encode($dato);
            exit();
        }
    }
}