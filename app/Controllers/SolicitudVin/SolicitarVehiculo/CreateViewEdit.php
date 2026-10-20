<?php

namespace App\Controllers\SolicitudVin\SolicitarVehiculo;
use App\Controllers\BaseController;
use App\Models\GeneralesModel;
use App\Models\SolicitudVinModel;
use App\Models\VinModel;

class CreateViewEdit extends BaseController
{

    public function ViewSolicitud()
    {
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hor=date("H:i:s");
        $solicitudModel=New SolicitudVinModel();

        $filtro=[
            'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"]
        ];

        $dato=[
            'viewSolicitud'=>$solicitudModel->DetailIndex($filtro),
            'detailCreate'=>$solicitudModel->DetailSolicitudVehiculo($filtro),
            'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"]
        ];

        $send=[
            'status'=>'success',
            'info'=>view("SolicitudVin/ViewSolicitud/Index",$dato).view("SolicitudVin/ViewSolicitud/Scripts",$dato)
        ];

        echo json_encode($send);
        exit();
    }

    public function View()
    {
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hor=date("H:i:s");
        $solicitudModel=New SolicitudVinModel();

        $filtro=[
            'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"]
        ];

        $update=[
            'idestadoSolicitud'=>2
        ];

        $upd=$solicitudModel->UpdateSolicitudVehiculo($filtro,$update);

        $storage=[
            'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"],
            'idestadoSolicitud'=>2,
            'fecha'=>$hoy,
            'idusuario'=>session("idusuario"),
            'hora'=>$hor
        ];

        $str=$solicitudModel->StorageHistory($storage);

        $dato=[
            'viewSolicitud'=>$solicitudModel->DetailIndex($filtro),
            'detailCreate'=>$solicitudModel->DetailSolicitudVehiculo($filtro),
            'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"]
        ];

        $send=[
            'status'=>'success',
            'info'=>view("SolicitudVin/View/Index",$dato).view("SolicitudVin/View/Scripts",$dato)
        ];

        echo json_encode($send);
        exit();
    }
    public function CreateRecepciona()
    {
        $solicitudModel=New SolicitudVinModel();

        $filtro=[
            'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"]
        ];

        $dato=[
            'viewSolicitud'=>$solicitudModel->ViewSolicitudFull($filtro),
            'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"]
        ];
        $send=[
            'status'=>'success',
            'info'=>view("SolicitudVin/CreateRecepciona/Index",$dato).view("SolicitudVin/CreateRecepciona/Scripts",$dato)
        ];

        echo json_encode($send);
        exit();
    }

    public function CreateVin()
    {
        $vinModel = new VinModel();
        $solicitudModel=New SolicitudVinModel();
        // Obtener valores de $_POST
        $idsolicitudVehiculo = $_POST["idsolicitudVehiculo"] ?? null;
        $checkOrigenDestino = $_POST["checkOrigenDestino"] ?? null;
        $origen = $_POST["origen"] ?? null;
        $destino = $_POST["destino"] ?? null;
        $idtipoSolicitud=$_POST["idtipoSolicitud"] ?? null;
        $vin = $_POST["vin"] ?? null;

        $vinInfo=$vinModel->VinInfo($vin);
        if($idtipoSolicitud==2){
            if($vinInfo[0]['idestadoVin']==2){
                $send = [
                    'status' => 'danger',
                    'title'=>'Error Critico',
                    'message' => 'El Vin se encuentra Facturado y no puede ser enviado a Exhibicion'
                ];
                echo json_encode($send);
                exit();
            }
        }


        $missingFields = [];

        if ($checkOrigenDestino == 1) {
            // Verificar que 'vin' e 'idsolicitudVehiculo' no estén vacíos
            if (empty($vin)) {
                $missingFields[] = 'VIN';
            }

        } else {
            // Verificar que todos los campos estén llenos
            if (empty($origen)) {
                $missingFields[] = 'Origen';
            }
            if (empty($destino)) {
                $missingFields[] = 'Destino';
            }
            if (empty($vin)) {
                $missingFields[] = 'VIN';
            }
        }

        if (!empty($missingFields)) {
            $send = [
                'status' => 'danger',
                'title'=>'Error Critico',
                'message' => 'Los siguientes campos son requeridos: ' . implode(', ', $missingFields)
            ];
            echo json_encode($send);
            exit();
        }

        // Obtener información del VIN
        $dato = [
            'vinView' => $vinModel->VinInfo($vin),
            'idsolicitudVehiculo'=>$idsolicitudVehiculo,
            'origenVin'=>$solicitudModel->OrigenTraslado(),
            'origen'=>$origen,
            'destino'=>$destino,
            'checkOrigenDestino'=>$checkOrigenDestino
        ];

// Preparar la respuesta
        $send = [
            'status' => 'success',
            'info' => view("SolicitudVin/CreateVin/Index", $dato) . view("SolicitudVin/CreateVin/Scripts")
        ];
        echo json_encode($send);
        exit();
    }


    public function DeleteGeneralVehiculo()
    {
        $dato=[
            'vin'=>$_POST["vin"],
            'iddetalleSolicitudVehiculo'=>$_POST["iddetalleSolicitudVehiculo"]
        ];

        $send=[
            'info'=>view("SolicitudVin/DeleteGeneralVehiculo/Index",$dato).view("SolicitudVin/DeleteGeneralVehiculo/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();
    }

    public function DeleteVehiculo()
    {
        $dato=[
            'vin'=>$_POST["vin"],
            'iddetalleSolicitudVehiculo'=>$_POST["iddetalleSolicitudVehiculo"]
        ];

        $send=[
            'info'=>view("SolicitudVin/DeleteVehiculo/Index",$dato).view("SolicitudVin/DeleteVehiculo/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();
    }

    public function DetailCreate()
    {
        $solicitudModel=New SolicitudVinModel();

        $filtro=[
            'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"]
        ];

        $dato=[
            'detailIndex'=>$solicitudModel->DetailSolicitudVehiculo($filtro)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("SolicitudVin/DetailCreate/Index",$dato).view("SolicitudVin/DetailCreate/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function CreateCustodia()
    {
        $solicitudModel=New SolicitudVinModel();

        $filtro=[
            'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"]
        ];

        $dato=[
            'viewSolicitud'=>$solicitudModel->ViewSolicitudFull($filtro),
            'idsolicitudVehiculo'=>$_POST["idsolicitudVehiculo"]
        ];
        $send=[
            'status'=>'success',
            'info'=>view("SolicitudVin/CreateCustodia/Index",$dato).view("SolicitudVin/CreateCustodia/Scripts",$dato)
        ];

        echo json_encode($send);
        exit();
    }

    public function SelectVinPermitido()
    {
        $vinModel=New VinModel();
        $filtro=[];
        if($_POST["checkUbicacionGeneral"]==2){
            $filtro=[
                'idubicacion'=>$_POST["idorigen"]
            ];
        }else{
            $filtro='';
        }
        $vins=$vinModel->VinPermitidosSolicitud($filtro);
        $principal='';
        foreach($vins as $vn){
            $principal.='<option value="'.$vn["vin"].'">'.$vn["vin"] . ' - ' . $vn["marca"] . ' - ' . $vn["modelo"] . ' - ' . $vn["color"].'</option>';
        }


        $send=[
            'status'=>'success',
            'info'=>$principal
        ];
        echo json_encode($send);
        exit();
    }

    public function Create()
    {
        $solicitudModel=New SolicitudVinModel();
        $general=New GeneralesModel();

        $storageSoli=[
            'idusuario'=>session("idusuario")
        ];

        $idsolicitudVehiculo=$solicitudModel->StorageSolicitud($storageSoli);

        $vinModel=New VinModel();
        $dato=[
            'tipoSolicitud'=>$solicitudModel->TipoSolicitud(),
            'origenVin'=>$solicitudModel->OrigenTraslado(),
            'selectVin'=>$vinModel->VinPermitidosSolicitud(''),
            'idsolicitudVehiculo'=>$idsolicitudVehiculo,
            'selectCentroCosto'=>$general->CentroCosto(),
            'selectAgencia'=>$general->SelectAgencia()
        ];

        $send=[
            'status'=>'success',
            'info'=>view("SolicitudVin/Create/Index",$dato).view("SolicitudVin/Create/Scripts",$dato)
        ];

        echo json_encode($send);
        exit();
    }
}