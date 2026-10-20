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

class CreateViewEdit extends BaseController
{
    public function CreateCondicion()
    {
        $generalModel=New GeneralesModel();
        $reglasModel=new ReglasModel();

        $filtro=[];

        $filtro+=[
            'idreglaEntrega'=>$_POST["idreglaVehiculo"],
        ];

        $dato=[
            'viewRegla'=>$reglasModel->DetailRegla($filtro),
            'selectCondicones'=>$generalModel->SelectCondiciones(),
            'idreglaVehiculo'=>$_POST["idreglaVehiculo"]
        ];

        $send=[
            'status'=>'success',
            'info'=>view("ConfigOperaciones/ReglasVehiculo/CreateCondicion/Index",$dato).view("ConfigOperaciones/ReglasVehiculo/CreateCondicion/Scripts")
        ];

        echo json_encode($send);
        exit();

    }
    public function CreateGrupo()
    {
        $generalModel=New GeneralesModel();
        $reglasModel=New ReglasModel();

        $dato=[
            'selectAfecta'=>$generalModel->SelectProcesoVehiculo(),
        ];

        $send=[
            'status'=>'success',
            'info'=>view("ConfigOperaciones/ReglasVehiculo/CreateGrupo/Index",$dato).view("ConfigOperaciones/ReglasVehiculo/CreateGrupo/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function Create()
    {
        $generalModel=New GeneralesModel();
        $reglasModel=New ReglasModel();

        $storage=[
            'idgrupoRegla'=>$_POST["idgrupoRegla"],
            'idestadoRegla'=>4,
            'idusuarioCreacion'=>session("idusuario"),
        ];

        $delet=$reglasModel->DestroyReglaEntrega($storage);

        $idreglaEntrega=$reglasModel->StorageReglaEntrega($storage);

        $dato=[
            'camposRegla'=>$generalModel->CamposParaReglaEntregado(''),
            'idreglaEntrega'=>$idreglaEntrega,
        ];

        $send=[
            'status'=>'success',
            'info'=>view("ConfigOperaciones/ReglasVehiculo/Create/Index",$dato).view("ConfigOperaciones/ReglasVehiculo/Create/Scripts")
        ];

        echo json_encode($send);
        exit();

    }

    public function ViewGrupoRegla()
    {
        $idgrupoRegla=$_POST["idgrupoRegla"];
        $reglasModel=New ReglasModel();

        $filtro=[];

        $filtro+=[
            'idgrupoRegla'=>$idgrupoRegla,
        ];

        $dato=[
            'detailRegla'=>$reglasModel->DetailRegla($filtro),
            'viewGrupoRegla'=>$reglasModel->ViewGrupoRegla($filtro),
        ];

        $send=[
            'status'=>'success',
            'info'=>view("ConfigOperaciones/ReglasVehiculo/ViewGrupoRegla/Index",$dato).view("ConfigOperaciones/ReglasVehiculo/ViewGrupoRegla/Scripts"),
            'message'=>''
        ];

        echo json_encode($send);
        exit();

    }

    public function ViewRegla()
    {
        $idregla=$_POST["idreglaVehiculo"];
        $generalModel=New GeneralesModel();
        $reglasModel=New ReglasModel();

        $filtro=[
            'idreglaEntrega'=>$idregla,
        ];

        $dato=[
            'regla'=>$reglasModel->DetailRegla($filtro),
            'idreglaEntrega'=>$_POST["idreglaVehiculo"],
            'camposRegla'=>$generalModel->CamposParaReglaEntregado(''),
            'detailCondiciones'=>$reglasModel->DetailCondicionesRegla($filtro),
        ];

        $send=[
            'status'=>'success',
            'message'=>'',
            'info'=>view("ConfigOperaciones/ReglasVehiculo/ViewRegla/Index",$dato).view("ConfigOperaciones/ReglasVehiculo/Create/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function DetailCondiciones()
    {
        $idregla=$_POST["idreglaVehiculo"];
        $generalModel=New GeneralesModel();
        $reglasModel=New ReglasModel();
        $filtro=[
            'idreglaEntrega'=>$idregla,
        ];
        $dato=[
            'detailCondiciones'=>$reglasModel->DetailCondicionesRegla($filtro),
        ];

        $send=[
            'status'=>'success',
            'info'=>view("ConfigOperaciones/ReglasVehiculo/DetailCondiciones/Index",$dato).view("ConfigOperaciones/ReglasVehiculo/Create/Scripts"),
            'message'=>''
        ];
        echo json_encode($send);
        exit();
    }

    public function DetailRegla()
    {
        $idgrupoRegla=$_POST["idgrupoRegla"];
        $reglasModel=New ReglasModel();
        $filtro=[
            'idgrupoRegla'=>$idgrupoRegla,
        ];

        $dato=[
            'detailRegla'=>$reglasModel->DetailRegla($filtro),
        ];

        $send=[
            'status'=>'success',
            'info'=>view("ConfigOperaciones/ReglasVehiculo/DetailRegla/Index",$dato).view("ConfigOperaciones/ReglasVehiculo/Create/Scripts"),
            'message'=>''
        ];

        echo json_encode($send);
        exit();

    }
}