<?php
namespace App\Controllers\ConfigOperaciones\GrupoUbicacion;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\CampanhaModel;
use App\Models\ConfigModel;
use App\Models\EventoModel;
use App\Models\GeneralesModel;
use App\Models\ReglasModel;
use App\Models\SolicitudVinModel;
use App\Models\TrasladoModel;
use App\Models\VinModel;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\IOFactory;

class CreateViewEdit extends BaseController
{

    public function EditGrupoUbicacion()
    {
        $configModel=new ConfigModel();
        $generalModel=New GeneralesModel();

        $filtro=[
            'idgrupoUbicacion'=>$_POST["idgrupoUbicacion"]
        ];

        $dato=[
            'empresa'=>$generalModel->SelectEmpresa(),
            'idgrupoUbicacion'=>$_POST["idgrupoUbicacion"],
            'grupoUbicacion'=>$configModel->ViewGrupoUbicacion($filtro)
        ];

        $send=[
            'status'=>'success',
            'title'=>'',
            'message'=>'',
            'info'=>view("ConfigOperaciones/GrupoUbicacion/EditGrupoUbicacion/Index",$dato).view("ConfigOperaciones/GrupoUbicacion/EditGrupoUbicacion/Scripts",$dato),
        ];

        echo json_encode($send);
        exit();
    }

    public function CreateGrupoUbicacion()
    {
        $generalModel=New GeneralesModel();

        $dato=[
            'empresa'=>$generalModel->SelectEmpresa(),
        ];

        $send=[
            'status'=>'success',
            'title'=>'',
            'message'=>'',
            'info'=>view("ConfigOperaciones/GrupoUbicacion/CreateGrupoUbicacion/Index",$dato).view("ConfigOperaciones/GrupoUbicacion/CreateGrupoUbicacion/Scripts",$dato),
        ];

        echo json_encode($send);
        exit();
    }

    public function CreateBoxUbicacion()
    {
        $configModel=new ConfigModel();
        $idgrupoUbicacion=$_POST["idgrupoUbicacion"];

        $filtro=[
            'tipo'=>2,
            'idgrupoUbicacion'=>$idgrupoUbicacion
        ];

        $dato=[
            'ubicacion'=>$configModel->MultipleProcedimiento($filtro)
        ];

        $send=[
            'status'=>'success',
            'message'=>'',
            'info'=>view("ConfigOperaciones/GrupoUbicacion/CreateBoxUbicacion/Index",$dato).view("ConfigOperaciones/GrupoUbicacion/CreateBoxUbicacion/Scripts")
        ];
        echo json_encode($send);
        exit();

    }
    public function CreateUbicacion()
    {

        $configModel=new ConfigModel();
        $trasladoModel=New TrasladoModel();
        $idgrupoUbicacion=$_POST["idgrupoUbicacion"];
        $filtroGru='';

        $dato=[
            'idgrupoUbicacion'=>$idgrupoUbicacion,
            'grupoUbicacion'=>$trasladoModel->DetailGrupoUbicacion($filtroGru)
        ];

        $send=[
            'status'=>'success',
            'message'=>'',
            'info'=>view("ConfigOperaciones/GrupoUbicacion/CreateUbicacion/Index",$dato).view("ConfigOperaciones/GrupoUbicacion/CreateUbicacion/Scripts")
        ];
        echo json_encode($send);
        exit();

    }
    public function ViewGrupoUbicacion()
    {
        $configModel=new ConfigModel();
        $idgrupoUbicacion=$_POST["idgrupoUbicacion"];

        $filtro=[
          'tipo'=>2,
          'idgrupoUbicacion'=>$idgrupoUbicacion
        ];

        $dato=[
            'idgrupoUbicacion'=>$idgrupoUbicacion,
            'detailIndex'=>$configModel->MultipleProcedimiento($filtro)
        ];

        $send=[
            'info'=>view("ConfigOperaciones/GrupoUbicacion/ViewGrupoUbicacion/Index",$dato).view('ConfigOperaciones/GrupoUbicacion/ViewGrupoUbicacion/Scripts'),
            'status'=>'success',
            'message'=>''
        ];

        echo json_encode($send);
        exit();

    }

    public function DetailIndexUbicacion()
    {
        $configModel=new ConfigModel();
        $idgrupoUbicacion=$_POST["idgrupoUbicacion"];

        $filtro=[
            'tipo'=>2,
            'idgrupoUbicacion'=>$idgrupoUbicacion
        ];

        $dato=[
            'detailIndex'=>$configModel->MultipleProcedimiento($filtro)
        ];

        $send=[
            'info'=>view("ConfigOperaciones/GrupoUbicacion/DetailIndexUbicacion/Index",$dato).view('ConfigOperaciones/GrupoUbicacion/DetailIndexUbicacion/Scripts'),
            'status'=>'success',
            'message'=>''
        ];

        echo json_encode($send);
        exit();

    }

    public function ViewUbicacion()
    {
        $configModel=new ConfigModel();
        $idubicacion=$_POST["idubicacion"];

        $filtro=[
            'tipo'=>3,
            'idubicacion'=>$idubicacion
        ];

        $dato=[
            'detailIndex'=>$configModel->MultipleProcedimiento($filtro)
        ];

        $send=[
            'info'=>view("ConfigOperaciones/GrupoUbicacion/DetailIndexBox/Index",$dato).view('ConfigOperaciones/GrupoUbicacion/DetailIndexBox/Scripts'),
            'status'=>'success',
            'message'=>''
        ];

        echo json_encode($send);
        exit();
    }
    public function EditUbicacion()
    {
        $configModel=new ConfigModel();
        $trasladoModel=New TrasladoModel();
        $idubicacion=$_POST["idubicacion"];
        $filtroGru='';
        $filtro=[
            'tipo'=>2,
            'idubicacion'=>$idubicacion,

        ];

        $dato=[
            'ubicacion'=>$configModel->MultipleProcedimiento($filtro),
            'grupoUbicacion'=>$trasladoModel->DetailGrupoUbicacion($filtroGru)
        ];

        $send=[
            'status'=>'success',
            'message'=>'',
            'info'=>view("ConfigOperaciones/GrupoUbicacion/EditUbicacion/Index",$dato).view("ConfigOperaciones/GrupoUbicacion/EditUbicacion/Scripts")
        ];
        echo json_encode($send);
        exit();
    }

    public function EditBoxUbicacion()
    {
        $configModel=new ConfigModel();
        $trasladoModel=New TrasladoModel();
        $idboxUbicacion=$_POST["idboxUbicacion"];
        $filtroGru='';
        $filtro=[
            'tipo'=>3,
            'idboxUbicacion'=>$idboxUbicacion,

        ];

        $dato=[
            'boxUbicacion'=>$configModel->MultipleProcedimiento($filtro),
        ];

        $send=[
            'status'=>'success',
            'message'=>'',
            'info'=>view("ConfigOperaciones/GrupoUbicacion/EditBoxUbicacion/Index",$dato).view("ConfigOperaciones/GrupoUbicacion/EditBoxUbicacion/Scripts")
        ];
        echo json_encode($send);
        exit();
    }
}