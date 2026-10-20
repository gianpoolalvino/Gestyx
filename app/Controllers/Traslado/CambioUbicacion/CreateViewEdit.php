<?php

namespace App\Controllers\Traslado\CambioUbicacion;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\GeneralesModel;
use App\Models\TrasladoModel;
use App\Models\VinModel;

class CreateViewEdit extends BaseController
{
    public function Transportista()
    {
        $trasladoModel=New TrasladoModel();
        $datos=[
            'detailTransporte'=>$trasladoModel->DetailTransportista()
        ];
        $send=[
            'info'=>view("Traslado/CambioUbicacion/Transportista/Index/Index",$datos).view("Traslado/CambioUbicacion/Transportista/Index/Scripts"),
            'status'=>'success',
            'title'=>'',
            'message'=>''
        ];
        echo json_encode($send);
        exit();
    }

    public function VerificarDisponibilidad()
    {
        $trasladoModel=New TrasladoModel();
        $idboxUbicacion=$_POST["idboxUbicacion"];

        $resultado=$trasladoModel->BoxOcupado($idboxUbicacion);

        if($resultado){
            $send=[
                'status'=>'danger',
                'message'=>'<i class="far fa-sad-tear text-danger"></i>&nbsp;'.$resultado[0]["descripcion"].' tiene el siguiente Vin Asignado '.$resultado[0]["vin"]
            ];
        }else{
            $send=[
                'status'=>'success',
                'message'=>'<i class="far fa-smile-beam text-primary"></i>&nbsp;El box esta libre :)'
            ];
        }
        echo json_encode($send);
        exit();
    }

    public function DetailIndexTransportista()
    {
        $trasladoModel=New TrasladoModel();
        $datos=[
            'detailTransporte'=>$trasladoModel->DetailTransportista()
        ];
        $send=[
            'status'=>'success',
            'title'=>'',
            'message'=>'',
            'info'=>view("Traslado/CambioUbicacion/Transportista/DetailIndex/Index",$datos).view("Traslado/CambioUbicacion/Transportista/DetailIndex/Scripts"),
        ];
        echo json_encode($send);
        exit();
    }

    public function CreateTransportista()
    {
        $dato=[
            'info'=>view("Traslado/CambioUbicacion/Transportista/CreateTransportista/Index").view("Traslado/CambioUbicacion/Transportista/CreateTransportista/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($dato);
        exit();
    }

    public function CreateTrasladoBox()
    {
        $vinModel=New VinModel();
        $trasladoModel=New TrasladoModel();
        $filtro=[
            'vin'=>$_POST["vin"]
        ];
        $vininfo=$vinModel->VinUbicacion($filtro);

        $filtroBox=[
            'idubicacion'=>$vininfo[0]["idubicacionActual"]
        ];

        $dats=[
            'vinInfo'=>$vininfo,
            'vin'=>$_POST["vin"],
            'ubicacion'=>$trasladoModel->SelectUbicacion(),
            'boxUbicacion'=>$trasladoModel->BoxUbicacion($filtroBox)
        ];

        $dato=[
            'info'=>view("Traslado/CambioUbicacion/ChangeBox/Index",$dats).view("Traslado/CambioUbicacion/ChangeBox/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($dato);
        exit();
    }
    public function CreateTraslado()
    {
        $vinModel=New VinModel();
        $trasladoModel=New TrasladoModel();
        $dats=[
            'selectVin'=>$trasladoModel->SelectVin(''),
            'ubicacion'=>$trasladoModel->SelectUbicacion()
        ];

        $dato=[
            'info'=>view("Traslado/CambioUbicacion/CreateTraslado/Index",$dats).view("Traslado/CambioUbicacion/CreateTraslado/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($dato);
        exit();
    }

    public function CheckNovedad()
    {
        $trasladoModel=New TrasladoModel();

        $idtipoNovedad=$_POST["idtipoNovedad"];
        $vin=$_POST["vin"];
        $idtraslado=$_POST["idtrasladoVin"];
        $iddetalleTaller=$_POST["iddetalleTaller"];

        $viewNovedad=$trasladoModel->ObtenerNovedadPorTipo($idtipoNovedad,$vin,$idtraslado,$iddetalleTaller);

        $dato=[
            'viewNovedad'=>$viewNovedad,
            'idtipoNovedad'=>$idtipoNovedad,
            'iddetalleTaller'=>$iddetalleTaller,
            'idtraslado'=>$idtraslado,
            'vin'=>$vin
        ];

        $send=[
            'info'=>view("Traslado/CambioUbicacion/CheckNovedad/Index",$dato).view("Traslado/CambioUbicacion/CheckNovedad/Scripts"),
            'status'=>'success',
            'title'=>'',
            'message'=>''
        ];

        echo json_encode($send);
        exit();
    }

    public function VinSelect()
    {
        $trasladoModel=New TrasladoModel();

        $filtro=[
            'vin'=>$_POST["vin"]
        ];

        $sein=$trasladoModel->SelectVin($filtro);

        $send=[
            'ubicacionActual'=>$sein[0]["ubicacion"],
            'box'=>$sein[0]["box"],
            'idubicacionActual'=>$sein[0]["idubicacion"],
            'idboxUbicacionActual'=>$sein[0]["idboxUbicacionActual"],
        ];

        echo json_encode($send);
        exit();
    }

    public function ChangeGrupoUbicacion()
    {
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();
        $generalModel=New GeneralesModel();

        $filtro=[
            'vin'=>$_POST["vin"]
        ];
        $vininfo=$vinModel->VinUbicacion($filtro);

        $filter=[
            'idubicacion'=>$vininfo[0]["idubicacionActual"],
          //  'idempresa'=>$vininfo[0]["idempresa"],
        ];
        $grupoUbi=$generalModel->SelectUbicacionGrupo($filter);
        $dats=[
            'vin'=>$_POST["vin"],
            'vinInfo'=>$vininfo,
            'transportista'=>$trasladoModel->DetailTransportista(),
            'idgrupoUbicacion'=>$vininfo[0]["idgrupoUbicacionActual"],
            'grupoUbicacion'=>$trasladoModel->SelectGrupoUbicacion(),
        ];

        $dato=[
            'info'=>view("Traslado/CambioUbicacion/ChangeGrupoUbicacion/Index",$dats).view("Traslado/CambioUbicacion/ChangeGrupoUbicacion/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($dato);
        exit();
    }

    public function DetailNovedadTaller()
    {
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();
        $generalModel=New GeneralesModel();

        $dats=[
            'vin'=>$_POST["vin"],
            'identradaTaller'=>$_POST["identradaTaller"],
            'detalleTaller'=>$trasladoModel->DetalleNovedadesTaller($_POST["vin"],null,$_POST["identradaTaller"])
        ];

        $dato=[
            'info'=>view("Traslado/CambioUbicacion/DetailCheckNovedad/Index",$dats).view("Traslado/CambioUbicacion/DetailCheckNovedad/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($dato);
        exit();
    }

    public function ChangeUbicacion()
    {
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();
        $generalModel=New GeneralesModel();

        $filtro=[
            'vin'=>$_POST["vin"],
        ];
        $vininfo=$vinModel->VinUbicacion($filtro);

        $filt=[
            'vin'=>$_POST["vin"],
            'idtrasladoVin'=>$vininfo[0]["idtrasladoUbicacion"]
        ];

        $filter=[
            'idubicacion'=>$vininfo[0]["idubicacionActual"],
          //  'idempresa'=>$vininfo[0]["idempresa"],
        ];
        $grupoUbi=$generalModel->SelectUbicacionGrupo($filter);
        $general=$vinModel->VinInfo($_POST["vin"]);

        $dats=[
            'vin'=>$_POST["vin"],
            'vinGeneral'=>$vinModel->VinInfo($_POST["vin"]),
            'idtrasladoVin'=>$vininfo[0]["idtrasladoUbicacion"],
            'vinInfo'=>$vininfo,
            'selectTransporte'=>$trasladoModel->DetailTransportista(),
            'detalleRecepcion'=>$trasladoModel->DetalleRecepcion($filt),
            'idgrupoUbicacion'=>$vininfo[0]["idgrupoUbicacionActual"],
            'idgrupoUbicacionDestino'=>$vininfo[0]["idgrupoUbicacionDestino"],
            'grupoUbicacion'=>$trasladoModel->SelectGrupoUbicacion(),
            'ubicacion'=>$trasladoModel->SelectUbicacion(),
            'trasladoDatos'=>$trasladoModel->TrasladoVin($filt)
        ];

        if($general[0]["retornoDeTaller"]==1){
            $dats+=[
                'detalleTaller'=>$trasladoModel->DetalleNovedadesTaller($_POST["vin"],null,$general[0]['identradaTaller'])
            ];
        }else{
            $dats+=[
                'detalleTaller'=>[]
            ];
        }

        if(is_null($vininfo[0]["idtrasladoUbicacion"])){
            $dato=[
                'info'=>view("Traslado/CambioUbicacion/ChangeUbicacion/Index",$dats).view("Traslado/CambioUbicacion/ChangeUbicacion/Scripts"),
                'status'=>'success'
            ];
        }else{
            $dato=[
                'info'=>view("Traslado/CambioUbicacion/ChangeUbicacion/Index_recep",$dats).view("Traslado/CambioUbicacion/ChangeUbicacion/Scripts",$dats),
                'status'=>'success'
            ];
        }

        echo json_encode($dato);
        exit();
    }

    public function CreateUbicacionBoxMasivo()
    {
        $trasladoModel=New TrasladoModel();

        $dats=[
            'ubicacion'=>$trasladoModel->SelectUbicacion()
        ];

        $send=[
            'info'=>view("Traslado/CambioUbicacion/ChangeUbicacionMasivo/Index",$dats).view("Traslado/CambioUbicacion/ChangeUbicacionMasivo/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();
    }

    public function Box()
    {
        try {
            // Verificar si 'idubicacion' está presente en la solicitud
            if (!isset($_POST["idubicacion"]) || empty($_POST["idubicacion"])) {
                throw new Exception("El parámetro 'idubicacion' es requerido.");
            }

            $idubicacion = $_POST["idubicacion"];
            $trasladoModel = new TrasladoModel();

            $filtro = [
                'idubicacion' => $idubicacion
            ];

            // Intentar obtener los datos del modelo
            $boxFor = $trasladoModel->BoxUbicacion($filtro);

            // Verificar si se obtuvieron resultados
            if ($boxFor === false) {
                throw new Exception("Error al consultar la ubicación de los boxes.");
            }

            $box = '<option value="">Seleccione Box</option>';
            foreach ($boxFor as $bx) {
                $box .= '<option value="' . htmlspecialchars($bx["idboxUbicacion"], ENT_QUOTES, 'UTF-8') . '">' .
                    htmlspecialchars($bx["descripcion"], ENT_QUOTES, 'UTF-8') . '</option>';
            }

            $send = [
                'status' => 'success',
                'info' => $box
            ];
        } catch (Exception $e) {
            // Manejo de errores y envío de respuesta adecuada
            $send = [
                'status' => 'danger',
                'message' => $e->getMessage()
            ];
        }
        // Enviar respuesta en formato JSON
        echo json_encode($send);
        exit();
    }
}