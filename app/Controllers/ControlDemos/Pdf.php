<?php

namespace App\Controllers\ControlDemos;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\GeneralesModel;
use \Dompdf\Dompdf;

class Pdf extends BaseController
{
    public function EntregaDemo()
    {
        $generalModel=New GeneralesModel();
        $idasignarDemo=isset($_POST["idasignarDemo"])?$_POST["idasignarDemo"]:$_GET["idasignarDemo"];

        $vin=isset($_POST["vin"])?$_POST["vin"]:$_GET["vin"];
        $controlDemos=New ControlDemosModel();

        $filtro=[
            'idasignarDemo'=>$idasignarDemo,
            'vin'=>$vin
        ];

        $filename='COMODATO '.$idasignarDemo;

        $dato=[
            'nombreFile'=>$filename,
            'infoAsignarDemo'=>$controlDemos->ViewDemoAsignadoPdf($filtro),
            'mes'=>$generalModel->Mes()
        ];

        $dompdf = new Dompdf(array('enable_remote' => true));
        $dompdf->loadHtml(view("ControlDemos/Pdf/ComoDato/Index",$dato));
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream($filename.".pdf",array("Attachment" => 0));
        exit;
    }

    public function CheckListRetorno()
    {
        $controlDemos=New ControlDemosModel();
        $generalModel=New GeneralesModel();
        $idasignarDemo=isset($_POST["idasignarDemo"])?$_POST["idasignarDemo"]:$_GET["idasignarDemo"];
        $vin=isset($_POST["vin"])?$_POST["vin"]:$_GET["vin"];

        $filtroCheckList=[
            'vin'=>$vin,
            'idasignarDemo'=>$idasignarDemo,
            'idtipoCheckListDemo'=>2
        ];

        $checkList=$controlDemos->CheckListDemo($filtroCheckList);


        $idcheckList=$checkList[0]["idcheckListDemo"];

        $filename="Acta Retorno Check List ".$idcheckList;

        $filtroDetail=[
            'idcheckListDemo'=>$idcheckList
        ];

        $dato=[
            'checkList'=>$checkList,
            'nombreFile'=>$filename,
            'servicioSugerido'=>$controlDemos->DetailServicioSugeridoCheck($idcheckList),
            'detailCheckList'=>$controlDemos->DetailCheckListDemo($filtroDetail)
        ];

        $dompdf = new Dompdf(array('enable_remote' => true));
        $dompdf->loadHtml(view("ControlDemos/Pdf/CheckListRetorno/Index",$dato));
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream($filename.".pdf",array("Attachment" => 0));
        exit;
    }

    public function CheckListEntrega()
    {
        $controlDemos=New ControlDemosModel();
        $generalModel=New GeneralesModel();
        $idasignarDemo=isset($_POST["idasignarDemo"])?$_POST["idasignarDemo"]:$_GET["idasignarDemo"];
        $vin=isset($_POST["vin"])?$_POST["vin"]:$_GET["vin"];

        $filtroCheckList=[
            'vin'=>$vin,
            'idasignarDemo'=>$idasignarDemo,
            'idtipoCheckListDemo'=>1
        ];

        $checkList=$controlDemos->CheckListDemo($filtroCheckList);


        $idcheckList=$checkList[0]["idcheckListDemo"];

        $filename="Acta Entrega Check List ".$idcheckList;

        $filtroDetail=[
            'idcheckListDemo'=>$idcheckList
        ];

        $dato=[
            'checkList'=>$checkList,
            'nombreFile'=>$filename,
            'detailCheckList'=>$controlDemos->DetailCheckListDemo($filtroDetail)
        ];

        $dompdf = new Dompdf(array('enable_remote' => true));
        $dompdf->loadHtml(view("ControlDemos/Pdf/CheckListEntrega/Index",$dato));
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream($filename.".pdf",array("Attachment" => 0));
        exit;
    }
}