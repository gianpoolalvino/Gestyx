<?php

namespace App\Controllers\Inmatriculacion\SinTitulo;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\GeneralesModel;
use App\Models\InmatriculacionModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{

    public function SaveObservacion()
    {
        date_default_timezone_set("America/Lima");
        $hoy = date("Y-m-d");
        $hora = date("H:i:s");

        // Cargar el modelo
        $inmatriculacionModel = new InmatriculacionModel();

        // Preparar datos para almacenar
        $storageObservacion = [
            'vin' => $this->request->getPost("vinSearch"),
            'numeroTitulo' => $this->request->getPost("tituloSearch"),
            'fechaUsuario' => $this->request->getPost("fechaTitulo"),
            'fecha' => $hoy,
            'hora' => $hora,
            'idusuario' => session("idusuario"),
            'descripcion' => $this->request->getPost("tituloObservacion"),
            'comentarios' => $this->request->getPost("comentarioAdv"),
        ];

        // Directorio para la carga del archivo
        $vinSearch = $this->request->getPost("vinSearch");
        $tituloSearch = $this->request->getPost("tituloSearch");
        $uploadDir = "resource/observacionesTitulo/$vinSearch/$tituloSearch/";

        // Crear directorio si no existe
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Configurar la carga de archivos
        $file = $this->request->getFile('resourceDetalleObs');

        // Comenzar transacción
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            // Verificar si el archivo fue subido correctamente
            if (!$file->isValid() || $file->getSize() === 0) {
                throw new \Exception("Error en la carga del archivo: " . $file->getErrorString());
            }
            $nombreOriginal = $file->getClientName();
            // Generar un nombre único para el archivo
            $nombreArchivo = uniqid("archivo_", true) . '.' . $file->getExtension();
            $rutaArchivo = $uploadDir . $nombreArchivo;

            // Mover el archivo al directorio deseado
            $file->move($uploadDir, $nombreArchivo);

            // Agregar información del archivo al array de almacenamiento
            $storageObservacion['tipoArchivo'] = $file->getClientMimeType();
            $storageObservacion['nombreArchivo'] = $nombreOriginal;
            $storageObservacion['rutaArchivo'] = $rutaArchivo;

            // Guardar observación en la base de datos
            $inmatriculacionModel->StorageObservacion($storageObservacion);

            // Completar la transacción
            $db->transComplete();

            if ($db->transStatus() === FALSE) {
                throw new \Exception("La transacción en la base de datos falló.");
            }

            // Mensaje de éxito
            echo json_encode(['status' => 'success','title'=>'Operacion Correcta', 'message' => 'Observación guardada exitosamente.']);

        } catch (\Exception $e) {
            // Deshacer transacción en caso de error
            $db->transRollback();

            // Registrar mensaje de error
            log_message('error', $e->getMessage());

            // Mensaje de error para el usuario
            echo json_encode(['status' => 'danger','title'=>'Operacion Errada', 'message' => $e->getMessage()]);
        }
    }

    public function SaveTacha()
    {
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $inmatriculacionModel=New InmatriculacionModel();
        $vinModel=New VinModel();


        $filtroupd=[
            'ideventoActual'=>12,
            'vin'=>$_POST["vinSearchTacha"],
            'comentarios'=>$_POST["tituloSearchTacha"]
        ];
        $evento=[
            'tachaTitulo'=>1,
            'comentarioTacha'=>$_POST["comentarioAdv"]
        ];
        $idinmatriculacion=$inmatriculacionModel->UpdateTitulo($filtroupd,$evento);

        $filtroVin=[
            'vin'=>$_POST["vinSearchTacha"]
        ];
        $updateVin=[
            'numeroTitulo'=>null
        ];
        $updatevn=$vinModel->UpdateVin($filtroVin,$updateVin);

        if($idinmatriculacion){

            $filtroEventoDelete=[
                'vin'=>$_POST["vinSearchTacha"],
                'ideventoActual'=>14
            ];

            $deltEv=$inmatriculacionModel->DeleteEvento($filtroEventoDelete);

            $tachaEvento=[
                'vin'=>$_POST["vinSearchTacha"],
                'ideventoActual'=>13,
                'fechaInicio'=>$_POST["fechaTitulo"],
                'horaInicio'=>$hora,
                'fechaFin'=>$_POST["fechaTitulo"],
                'horaFin'=>$hora,
                'eventoActual'=>'Tacha Titulo',
                'eventoAnterior'=>'Titulo',
                'ideventoAnterior'=>12,
                'idestadoEvento'=>2,
                'idusuario'=>session("idusuario"),
                'idusuariofinaliza'=>session("idusuario"),
                'comentarios'=>$_POST["tituloSearchTacha"],
                'comentarioAdicional'=>$_POST["comentarioAdv"],
                'fechaRegistroSistemaInicio'=>$hoy,
                'fechaRegistroSistemaFin'=>$hoy,
            ];

            $idExpdTac=$inmatriculacionModel->StorageExpediente($tachaEvento);

            $eventoTitu=[
                'vin'=>$_POST["vinSearchTacha"],
                'ideventoActual'=>12,
                'fechaInicio'=>$_POST["fechaTitulo"],
                'horaInicio'=>$hora,
                'eventoActual'=>'Titulo',
                'idusuario'=>session("idusuario"),
                'idestadoEvento'=>1,
                'eventoAnterior'=>'Tacha Titulo',
                'ideventoAnterior'=>13,
                'fechaRegistroSistemaInicio'=>$hoy
            ];
            $idExpd=$inmatriculacionModel->StorageExpediente($eventoTitu);
            $dato=[
                'status'=>'success',
                'title'=>'Titulo Tachado',
                'message'=>'Se tacho correctamente el titulo '.$_POST["tituloSearchTacha"]
            ];

            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Tacha Errada',
                'message'=>'Ocurrio un error en la Base de Datos'
            ];

            echo json_encode($dato);
            exit();
        }
    }
    public function SaveTitulo()
    {
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $inmatriculacionModel=New InmatriculacionModel();
        $vinModel=New VinModel();

        $filtroDupli=[
            'comentarios'=>$_POST["titulo"]
        ];
        //verificar Duplicados
        $count=$inmatriculacionModel->DuplicateTituloPlaca($filtroDupli);
        $contador=$count[0]["contador"];

        if($contador>0){
            $dato=[
                'status'=>'danger',
                'title'=>'Titulo Duplicado',
                'message'=>'El titulo ya fue ingresado en el sistema '.$_POST["titulo"]
            ];
            echo json_encode($dato);
            exit();
        }

        $filtroupd=[
            'ideventoActual'=>12,
            'vin'=>$_POST["vinExpe"]
        ];

        $evento=[
            'idestadoEvento'=>2,
            'fechaFin'=>$_POST["fechaTitulo"],
            'horaFin'=>$hora,
            'idusuariofinaliza'=>session("idusuario"),
            'comentarios'=>$_POST["titulo"],
            'comentarioAdicional'=>$_POST["comentarioAdv"],
            'fechaRegistroSistemaFin'=>$hoy
        ];
        $idinmatriculacion=$inmatriculacionModel->UpdateTitulo($filtroupd,$evento);

        $filtroVin=[
            'vin'=>$_POST["vinExpe"]
        ];
        $updateVin=[
            'numeroTitulo'=>$_POST["titulo"]
        ];
        $updatevn=$vinModel->UpdateVin($filtroVin,$updateVin);

        if($idinmatriculacion!=''){
            $eventoTitu=[
                'vin'=>$_POST["vinExpe"],
                'ideventoActual'=>14,
                'fechaInicio'=>$_POST["fechaTitulo"],
                'horaInicio'=>$hora,
                'eventoActual'=>'Placa',
                'idestadoEvento'=>1,
                'idusuario'=>session("idusuario"),
                'eventoAnterior'=>'Titulo',
                'ideventoAnterior'=>12,
                'fechaRegistroSistemaInicio'=>$hoy
            ];
            $idExpd=$inmatriculacionModel->StorageExpediente($eventoTitu);
            $dato=[
                'status'=>'success',
                'title'=>'Titulo Ingresado',
                'message'=>'Se ingreso correctamente el titulo '.$_POST["titulo"]
            ];

            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Titulo Errado',
                'message'=>'Ocurrio un error en la Base de Datos'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}