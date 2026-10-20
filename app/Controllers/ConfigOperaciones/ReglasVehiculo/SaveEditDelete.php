<?php
namespace App\Controllers\ConfigOperaciones\ReglasVehiculo;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\CampanhaModel;
use App\Models\EventoModel;
use App\Models\GeneralesModel;
use App\Models\ReglasModel;
use App\Models\SolicitudVinModel;
use App\Models\TrasladoModel;
use App\Models\VinModel;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\IOFactory;

class SaveEditDelete extends BaseController
{
    public function SaveGrupoRegla()
    {
        $reglaModel=New ReglasModel();

        $storageGrupo=[
            'idusuarioCrea'=>session("idusuario"),
            'nombreGrupo'=>$_POST["descripcionGrupo"],
            'idestadoGrupo'=>3,
            'idtipoAplicaGrupoRegla'=>$_POST["tipoAplica"]
        ];

        $idgrupoRegla=$reglaModel->StorageGrupoRegla($storageGrupo);

        if($idgrupoRegla!=''){
            $send=[
                'status'=>'success',
                'title'=>'Operacion Exitosa',
                'message'=>'Se Inserto correctamente el grupo de reglas'
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error en Operacion',
                'message'=>'No se logro almacenar el grupo de reglas'
            ];
            echo json_encode($send);
            exit();
        }

    }
    public function SaveRegla()
    {
        $reglaModel=New ReglasModel();
        $filtro=[
            'idreglaEntrega'=>$_POST["idreglaVehiculo"],
        ];

        if($_POST["tipoRegla"]==2){
            $verifi=$reglaModel->DetailCondicionesRegla($filtro);
            if(!$verifi){
                $send=[
                    'status'=>'danger',
                    'title'=>'Error en Operacion',
                    'message'=>'La Regla no cuenta con condiciones, al ser del tipo secuencial requiere condiciones'
                ];
                echo json_encode($send);
                exit();
            }
        }

        $update=[
            'idestadoRegla'=>1,
            'idcampovehiculo'=>$_POST["campoVehiculo"],
            'idtipoRegla'=>$_POST["tipoRegla"],
        ];

        $stor=$reglaModel->UpdateRegla($filtro,$update);
        if($stor){
            $send=[
                'status'=>'success',
                'title'=>'Operacion Exitosa',
                'message'=>'Se Inserto correctamente el grupo de reglas'
            ];
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error en Operacion',
                'message'=>'No se logro almacenar el grupo de reglas'
            ];
        }
        echo json_encode($send);
        exit();

    }
    public function SaveCondicional()
    {
        $reglaModel=New ReglasModel();

        $storage=[
            'idreglaEntrega'=>$_POST["idreglaEntregaCond"],
            'operador'=>$_POST["operadorRegla"],
            'valor'=>$_POST["condicionRegla"],
            'dias'=>$_POST["diasRegla"],
            'orden'=>null,
            'idevento'=>null,
            'idgrupoEvento'=>null
        ];

        $idoperador=$reglaModel->StorageCondicional($storage);

        if($idoperador!=''){
            $send=[
                'status'=>'success',
                'title'=>'Operacion Exitosa',
                'message'=>'Se Inserto correctamente la condicion de reglas'
            ];
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error en Operacion',
                'message'=>'No se logro almacenar la condicion de reglas'
            ];
        }
        echo json_encode($send);
        exit();
    }

    public function DeleteCondicion()
    {
        $reglaModel=New ReglasModel();

        $storage=[
            'iddetalleReglaEntrega'=>$_POST["idcondicionRegla"],
        ];

        $result=$reglaModel->DestroyCondicion($storage);

        if($result){
            $send=[
                'status'=>'success',
                'title'=>'Operacion Exitosa',
                'message'=>'Se Inserto correctamente la condicion de reglas'
            ];
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error en Operacion',
                'message'=>'No se logro almacenar la condicion de reglas'
            ];
        }
        echo json_encode($send);
        exit();
    }
    public function PlayGrupo()
    {
        $generalModel=New GeneralesModel();
        $reglasModel=New ReglasModel();
        $idgrupoRegla=$_POST["idgrupoRegla"];

        $filtro=[
            'idgrupoRegla'=>$idgrupoRegla
        ];
        $update=[
            'idestadoGrupo'=>1
        ];

        $updateGrupo=$reglasModel->UpdateGrupoRegla($filtro,$update);

        $viewGrupoRegla=$reglasModel->ViewGrupoRegla($filtro);

        $idtipoAplicaGrupoRegla=$viewGrupoRegla[0]["idtipoAplicaGrupoRegla"];

        $result=$this->InicializarTareaGrupo($idgrupoRegla,$idtipoAplicaGrupoRegla);

        if($result->status=='success'){
            $dato=[
                'status'=>'success',
                'title'=>'Reglas aplicadas correctamente',
                'message'=>'El grupo de reglas se aplico a los siguientes vehiculos',
                'detailVehicles'=>$result->datailVehicles,
            ];
            $send=[
                'status'=>'success',
                'message'=>$result->query,
                'info'=>view("Notificacion/success/GrupoReglasAplicado/Index",$dato).view("Notificacion/success/GrupoReglasAplicado/Scripts",$dato)
            ];
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Se detectaron los siguientes errores',
                'message'=>$result->message,
            ];
            /*
            $send=[
                'status'=>'danger',
                'info'=>view("Notificacion/danger/GrupoReglasAplicado/Index").view("Notificacion/danger/GrupoReglasAplicado/Scripts",$dato)
            ];
            */
        }
        echo json_encode($send);
        exit();
    }

    public function InicializarTareaGrupo($idgrupoRegla='',$idtipoAplicaGrupoRegla='')
    {

        $url='localhost/apisGenerales/sincronizaColombia/funcionReglasGestyx.php';

        $datos=[
            'idgrupoRegla'=>$idgrupoRegla,
            'database'=>session("database"),
            'idtipoAplicaGrupoRegla'=>$idtipoAplicaGrupoRegla
        ];

        $ch = curl_init();
// Establecer las opciones de cURL
        curl_setopt($ch, CURLOPT_URL, $url);  // URL de la API
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  // Retorna la respuesta como string
        curl_setopt($ch, CURLOPT_POST, true);  // Usar POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datos));  // Convertir los datos a JSON y enviarlos

// Establecer el encabezado Content-Type para JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',  // Indicar que estamos enviando JSON
            'Accept: application/json'         // Indicar que esperamos recibir JSON como respuesta
        ]);
// Desactivar la verificación SSL (solo para pruebas, no recomendado para producción)
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
// Ejecutar la solicitud cURL
        $response = curl_exec($ch);
        curl_close($ch);
// Decodificar la respuesta JSON

        $result=json_decode($response);
        return $result;

    }

}