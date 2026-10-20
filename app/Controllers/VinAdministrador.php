<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\AccessModel;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\AuditoriaVehicularModel;
use App\Models\ControlDemosModel;
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

class VinAdministrador extends BaseController
{
    public function ScannerQrVin()
    {
        $send=[
            'info'=>view('VinAdministrador/ScannerQrVin/Index').view('VinAdministrador/ScannerQrVin/Scripts')
        ];
        echo json_encode($send);
        exit();
    }

    public function Operaciones()
    {
        if(!session('idusuario')){
            header('Location: '.base_url());
            exit;
        }
        $vinInfo=New VinModel();
        $auditoriaModel=New AuditoriaVehicularModel();
        $agendamientoVin=New AgendamientoModel();
        $trasladoVin=New TrasladoModel();
        $vin=isset($_POST['vin'])?$_POST['vin']:$_GET['vin'];

        $filtro=[
            'vin'=>$vin
        ];

        $agend=$agendamientoVin->CitaEntregaVin($vin);
        $trasla=$auditoriaModel->DetailTrasladoAuditoria($filtro);

        $dato=[
            'idgrupoModulo'=>'',
            'vinInfo'=>$vinInfo->VinInfo($vin),
            'idmodulo'=>'',
            'vin'=>$vin,
            'estadoTraslado'=>$trasladoVin->EstadoTrasladoVin($vin),
            'eventos'=>$vinInfo->VinEventosRealizados($vin),
            'citaEntrega'=>$agend,
            'traslado'=>$trasla
        ];

        echo view("Layouts/Head",$dato);
        echo view("VinAdministrador/Operaciones/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("VinAdministrador/Operaciones/Index/Scripts",$dato);
    }
}