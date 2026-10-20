<?php

namespace App\Controllers\Agendamiento;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\CitaModel;
use App\Models\ControlDemosModel;
use App\Models\GeneralesModel;
use \Dompdf\Dompdf;

class Pdf extends BaseController
{
    public function ActaEntrega()
    {
        $generalModel=New GeneralesModel();
        $agendamiento=New AgendamientoModel();
        $citaModel=New CitaModel();
        $idcitaEntrega=isset($_POST["idcitaEntrega"])?$_POST["idcitaEntrega"]:$_GET["idcitaEntrega"];

        $vin=isset($_POST["vin"])?$_POST["vin"]:$_GET["vin"];
        $controlDemos=New ControlDemosModel();

        $filtro=[
            'idcitaEntrega'=>$idcitaEntrega,
            'vin'=>$vin,
        ];

        $filename='Acta de Entrega '.$idcitaEntrega;

        $opciones_ssl=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $img_path = base_url("resource/img/logoAutoniza.png");
        $extencion = pathinfo($img_path, PATHINFO_EXTENSION);
        $data = file_get_contents("resource/img/logoAutoniza.png", false, stream_context_create($opciones_ssl));
        $img_base_64 = base64_encode($data);
        $path_img = 'data:image/' . $extencion . ';base64,' . $img_base_64;

        $dato=[
            'nombreFile'=>$filename,
            "logo"=>$path_img,
            'viewCitaEntrega'=>$citaModel->ViewCitaEntrega($filtro)
        ];

        $dompdf = new Dompdf(array('enable_remote' => true));
        $dompdf->loadHtml(view("Agendamiento/Pdf/ActaEntrega/Index",$dato));
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream($filename.".pdf",array("Attachment" => 0));
        exit;
    }
}