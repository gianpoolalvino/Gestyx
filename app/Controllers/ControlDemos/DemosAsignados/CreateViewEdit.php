<?php

namespace App\Controllers\ControlDemos\DemosAsignados;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;

class CreateViewEdit extends BaseController
{

    public function CreateDiagrama()
    {

        $dats=[
            'idcheckListRetorno'=>$_POST["idcheckListRetorno"],
            'idasignarDemo'=>$_POST["idasignarDemo"],
            'idliberacionDemo'=>$_POST["idliberacionDemo"]
        ];

        $dato=[
            'status'=>'success',
            'info'=>view('ControlDemos/DemosAsignados/CreateDiagrama/Index',$dats).view('ControlDemos/DemosAsignados/CreateDiagrama/Scripts')
        ];

        echo json_encode($dato);
        exit();
    }
    public function DeleteResource()
    {
        $idresourceAsignacionDemo=$_POST["idresourceAsignacionDemo"];
        $controlDemos=New ControlDemosModel();

        $delfiltro=[
            'idresourceAsignacionDemo'=>$idresourceAsignacionDemo
        ];

        $delt=$controlDemos->DeleteResource($delfiltro);

        if($delt){
            $dato=[
                'status'=>'success',
                'title'=>'Borrado con exito',
                'message'=>'Se elimino correctamente el archivo de imagen'
            ];

            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error de proceso',
                'message'=>'Se detecto un error en el sistema'
            ];

            echo json_encode($dato);
            exit();
        }

    }

    public function UploadResource()
    {
        $idliberacionDemo=$_POST["idliberacionDemo"];
        $idasignarDemo=$_POST["idasignarDemo"];


        $dats=[
            'idasignarDemo'=>$idasignarDemo,
            'idcheckListRetorno'=>isset($_POST["idcheckListRetorno"])?$_POST["idcheckListRetorno"]:'',
            'idliberacionDemo'=>$idliberacionDemo,
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("ControlDemos/DemosAsignados/UploadResource/Index",$dats).view("ControlDemos/DemosAsignados/UploadResource/Scripts")
        ];
        echo json_encode($dato);
        exit();


    }

    public function Create()
    {
        $vin=$_POST["vin"];
        $idliberacionDemo=$_POST["idliberacionDemo"];
        $idasignarDemo=$_POST["idasignarDemo"];
        $controlDemos=New ControlDemosModel();

        $filtro=[
            'idasignarDemo'=>$idasignarDemo,
            'vin'=>$vin
        ];

        $filtroCheck=[
            'idasignarDemo'=>$idasignarDemo,
            'idestadoCheckListDemo'=>2,
            'idtipoCheckListDemo'=>2
        ];

        $checkList=$controlDemos->CheckListRetorno($filtroCheck);
        $detalleResour=[];
        if($checkList){
            $idcheckListRetorn=$checkList[0]["idcheckListDemo"];
            $filtroResource=[
                'idcheckListDemo'=>$idcheckListRetorn,
                'idasignarDemo'=>$idasignarDemo
            ];
            $detalleResour=$controlDemos->DetailResourceDemo($filtroResource);
        }else{
            $retornDemo=[
                'idasignarDemo'=>$idasignarDemo,
                'idtipoCheckListDemo'=>2,
                'idestadoCheckListDemo'=>2
            ];
            $idcheckListRetorn=$controlDemos->StorageCheckList($retornDemo);
        }




        $dats=[
            'vin'=>$vin,
            'tipoDemo'=>$controlDemos->TipoDemo(),
            'checkListRetorno'=>$controlDemos->CheckListRetorno($filtroCheck),
            'infoAsignarDemo'=>$controlDemos->ViewDemoAsignadoPdf($filtro),
            'servicioSugerido'=>$controlDemos->ServicioSugerido(),
            'detalleResource'=>$detalleResour,
            'idasignarDemo'=>$idasignarDemo,
            'inventarioDemo'=>$controlDemos->InventarioDemo(),
            'idliberacionDemo'=>$idliberacionDemo,
            'hora'=>$controlDemos->Hora(),
            'infoLiberacion'=>$controlDemos->ViewDemoLiberado($idliberacionDemo)
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("ControlDemos/DemosAsignados/Create/Index",$dats).view("ControlDemos/DemosAsignados/Create/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }

    public function DetailImageCheckList()
    {
        $idcheckListDemo=$_POST["idcheckListDemo"];
        $idasignarDemo=$_POST["idasignarDemo"];
        $controlDemos=New ControlDemosModel();
        $filtroResource=[
            'idcheckListDemo'=>$idcheckListDemo,
            'idasignarDemo'=>$idasignarDemo
        ];

        $detalleResour=$controlDemos->DetailResourceDemo($filtroResource);

        $dats=[
            'detalleResource'=>$detalleResour,
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("ControlDemos/DemosAsignados/DetailImage/Index",$dats).view("ControlDemos/DemosAsignados/DetailImage/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }
}