<?php
namespace App\Controllers\SolicitudVin\VinSolicitud;
use App\Controllers\BaseController;
use App\Models\AccessModel;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\AuditoriaVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\GeneralesModel;
use App\Models\SolicitudVinModel;
use App\Models\TrasladoModel;
use App\Models\VinModel;
use CodeIgniter\Controller;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Zxing\QrReader;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\WriterInterface;

use Config\Database;

class CreateViewEdit extends BaseController
{

    public function CreateTrasladoSolicitante()
    {
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();
        $generalModel=New GeneralesModel();

        $filtro=[
            'vin'=>$_POST["vin"]
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
        $dats=[
            'vin'=>$_POST["vin"],
            'transportista'=>$trasladoModel->DetailTransportista(),
            'idtrasladoVin'=>$vininfo[0]["idtrasladoUbicacion"],
            'vinInfo'=>$vininfo,
            'idsolicitudVin'=>$_POST["idsolicitudVin"],
            'detalleRecepcion'=>$trasladoModel->DetalleRecepcion($filt),
            'idgrupoUbicacion'=>$vininfo[0]["idgrupoUbicacionActual"],
            'idgrupoUbicacionDestino'=>$vininfo[0]["idgrupoUbicacionDestino"],
            'grupoUbicacion'=>$trasladoModel->SelectGrupoUbicacion(),
            'ubicacion'=>$trasladoModel->SelectUbicacion(),
            'idsolicitudVehiculo'=>$_POST["idsolicitudVin"]
        ];

        if(is_null($vininfo[0]["idtrasladoUbicacion"])){
            $dato=[
                'info'=>view("Traslado/CambioSolicitante/Create/Index",$dats).view("Traslado/CambioSolicitante/Create/Scripts"),
                'status'=>'success'
            ];
        }
        echo json_encode($dato);
        exit();
    }

    public function SelectUbicacion()
    {
        $trasladoModel=New TrasladoModel();
        $idgrupoUbicacion=$_POST["idgrupoUbicacion"];

        $filtro=[
            'idgrupoUbicacion'=>$idgrupoUbicacion
        ];

        $ubicaciones=$trasladoModel->SelectUbicacionGrupo($filtro);

        $princip='';
        foreach($ubicaciones as $ubi){
            $princip.='<option value="'.$ubi["idubicacion"].'">'.$ubi["descripcion"].'</option>';
        }

        echo json_encode([
            'status'=>'success',
            'title'=>'',
            'message'=>'',
            'info'=>$princip
        ]);
        exit();


    }
    public function CreateTrasladoTaller()
    {
        $trasladoModel=New TrasladoModel();
        $vinModel=New VinModel();
        $generalModel=New GeneralesModel();

        $filtro=[
            'vin'=>$_POST["vin"]
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
        $dats=[
            'vin'=>$_POST["vin"],
            'idtrasladoVin'=>$vininfo[0]["idtrasladoUbicacion"],
            'vinInfo'=>$vininfo,
            'idsolicitudVin'=>$_POST["idsolicitudVin"],
            'detalleRecepcion'=>$trasladoModel->DetalleRecepcion($filt),
            'idgrupoUbicacion'=>$vininfo[0]["idgrupoUbicacionActual"],
            'idgrupoUbicacionDestino'=>$vininfo[0]["idgrupoUbicacionDestino"],
            'grupoUbicacion'=>$trasladoModel->SelectGrupoUbicacion(),
            'ubicacion'=>$trasladoModel->SelectUbicacion()
        ];

        if(is_null($vininfo[0]["idtrasladoUbicacion"])){
            $dato=[
                'info'=>view("Traslado/CambioTaller/Create/Index",$dats).view("Traslado/CambioTaller/Create/Scripts"),
                'status'=>'success'
            ];
        }
        echo json_encode($dato);
        exit();
    }
    public function CreateNovedad()
    {
        $dato=[
            'vin'=>$_POST['vin'],
            'idsolicitudVin'=>$_POST['idsolicitudVin']
        ];
        $send=[
            'info'=>view('SolicitudVin/VinSolicitud/CreateNovedad/Index',$dato).view('SolicitudVin/VinSolicitud/CreateNovedad/Scripts',$dato)
        ];
        echo json_encode($send);
        exit();
    }
    public function CheckNovedad()
    {
        $solicitudVehiculo=New SolicitudVinModel();
        $idtipoNovedad=$_POST["idtipoNovedad"];
        $idcabecera=$_POST["idcabeceraNovedad"];
        $idnovedad=$_POST["idnovedad"];
        $vin=$_POST["vin"];

        $dato=[
            'idtipoNovedad'=>$idtipoNovedad,
            'vin'=>$vin,
            'idnovedad'=>$idnovedad,
            'idcabeceraNovedad'=>$idcabecera,
            'viewNovedad'=>$solicitudVehiculo->CheckNovedadId($vin,$idcabecera,$idnovedad,$idtipoNovedad)
        ];

        $send=[
            'status'=>'success',
            'title'=>'',
            'message'=>'',
            'info'=>view('SolicitudVin/VinSolicitud/CheckNovedad/Index',$dato).view('SolicitudVin/VinSolicitud/CheckNovedad/Scripts')
        ];

        echo json_encode($send);
        exit();

    }
}