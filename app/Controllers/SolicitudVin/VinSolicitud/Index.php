<?php
namespace App\Controllers\SolicitudVin\VinSolicitud;
use App\Controllers\BaseController;
use App\Models\AccessModel;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\AuditoriaVehicularModel;
use App\Models\ControlDemosModel;
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

class Index extends BaseController
{

    public function Index($vin='',$idsolicitudVehiculo='')
    {

        $vinInfo=New VinModel();
        $auditoriaModel=New AuditoriaVehicularModel();
        $agendamientoVin=New AgendamientoModel();
        $alistamientoVin=New AlistamientoVehicularModel();
        $trasladoVin=New TrasladoModel();
        $solicitudVin=New SolicitudVinModel();

        $filtro=[
            'vin'=>$vin
        ];

        $agend=$agendamientoVin->CitaEntregaVin($vin);
        $trasla=$auditoriaModel->DetailTrasladoAuditoria($filtro);

        $dato=[
            'idgrupoModulo'=>'',
            'vinInfo'=>$vinInfo->VinInfo($vin),
            'idmodulo'=>'',
            'equipamiento'=>$alistamientoVin->EquipamientoVin($vin),
            'vin'=>$vin,
            'novedadesSolicitud'=>$solicitudVin->DetailNovedades($vin,$idsolicitudVehiculo),
            'gestorVin'=>$solicitudVin->GestorVin($vin,$idsolicitudVehiculo),
            'idsolicitudVehiculo'=>$idsolicitudVehiculo,
            'estadoTraslado'=>$trasladoVin->EstadoTrasladoVin($vin),
            'eventos'=>$vinInfo->VinEventosRealizados($vin),
            'novedadesRecepcion'=>$auditoriaModel->VinNovedadRecepcion($vin),
            'novedadesIngreso'=>$auditoriaModel->VinNovedadIngreso($vin),
            'citaEntrega'=>$agend,
            'traslado'=>$trasla
        ];

        echo view("Layouts/Head",$dato);
        echo view("SolicitudVin/VinSolicitud/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("SolicitudVin/VinSolicitud/Index/Scripts",$dato);
    }
}