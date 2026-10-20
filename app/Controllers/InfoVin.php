<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\VinModel;


class InfoVin extends BaseController
{

    public function UpdateCliente()
    {
        $alistamientoVehicular=New AlistamientoVehicularModel();

        $vinFiltro=[
            'vin'=>$_POST["vinCliUpd"]
        ];

        $vin = $_POST["vinCliUpd"];
        $infoGen = $alistamientoVehicular->ViewVin($vin);

        $updateTelf=[
            'telefonoCliente'=>$_POST["telefonoCliUp"],
            'correoCliente'=>$_POST["correoCliUp"],
            'direccionCliente'=>$_POST["direccionCliUp"]
        ];

        $database = session("database");
        $entorno = "";

        if ($database == 'logistica_test') {
            $entorno = 'capacitacion';
        } else {
            $entorno = 'produccion';
        }
        $documentoCliente=$_POST["documentoCliUp"];
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $rutaExec = '';
        if (session('database') === 'logistica_peru') {
            if($infoGen[0]["marca"]=='CHEVROLET' || $infoGen[0]["marca"]=='ISUZU') {
                $rutaExec = file_get_contents("https://api.autoniza.net.pe/apis_old/FACCAR/Vehiculos/MigrationV2/updateCliente.php?documentoCliente=" . $documentoCliente . "&telefonoCliente=" . $_POST["telefonoCliUp"] . "&correoCliente=" . $_POST["correoCliUp"], false, stream_context_create($arrContextOptions));
                if (!$rutaExec) {
                    $dato = [
                        'title' => 'Error',
                        'message' => 'La Sincronizacion con el ERP no esta activa ' . $rutaExec,
                        'status' => 'danger'
                    ];
                    echo json_encode($dato);
                    exit();
                }
            }
        }

        $updateClie=$alistamientoVehicular->UpdateVinAccesorio($vinFiltro,$updateTelf);

        if($updateClie){
            $send=[
                'status'=>'success',
                'title'=>'Actualizacion Correcta',
                'message'=>'La Actualizacion de Cliente se realizo correctamente'
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Actualizacion Errada',
                'message'=>'No se logro actualizar los datos del cliente'
            ];
            echo json_encode($send);
            exit();
        }
    }


    public function Index()
    {
        $vinModel=new VinModel();
        $alistamentoModel=new AlistamientoVehicularModel();
        $vin=$_POST["vin"];
        $alistamiento=[];
        $alis=$alistamentoModel->EquipamientoVin($vin);
        if($alis){
            $alistamiento=$alis;
        }else{
            $alistamiento=[];
        }

        $dato=[
            'vinInfo'=>$vinModel->VinInfo($vin),
            'equipamiento'=>$alistamiento,
        ];

        $returnData=[
            'info'=>view("InfoVin/Index/Index",$dato).view("InfoVin/Index/Scripts")
        ];

        echo json_encode($returnData);
        exit();
    }

    public function DemoVin()
    {
        $vinModel=new VinModel();
        $alistamentoModel=new AlistamientoVehicularModel();
        $vin=$_POST["vin"];

        $dato=[
            'vinInfo'=>$vinModel->VinInfo($vin),
        ];

        $returnData=[
            'info'=>view("InfoVin/DemoInfo/Index",$dato).view("InfoVin/DemoInfo/Scripts")
        ];

        echo json_encode($returnData);
        exit();
    }

    public function InfoDemo()
    {
        $controlDemo= New ControlDemosModel();
        $vin=$_POST["vin"];
        $idliberacionDemo=$_POST["idliberacionDemo"];

        $dato=[
            'vinInfo'=>$controlDemo->ViewDemoLiberado($idliberacionDemo)
        ];

        $returnData=[
            'info'=>view("InfoVin/Demo/Index",$dato).view("InfoVin/Demo/Scripts")
        ];

        echo json_encode($returnData);
        exit();
    }
}