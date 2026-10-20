<?php

namespace App\Controllers\Inventario;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\BateriaModel;
use App\Models\ControlDemosModel;
use App\Models\ExhibicionModel;
use App\Models\GarantiaModel;
use App\Models\GeneralesModel;
use App\Models\InmatriculacionModel;
use App\Models\InventarioModel;
use App\Models\VinModel;

class CreateViewEdit extends BaseController
{
    public function Create()
    {
        $vinModel=new VinModel();
        $vin=$_POST["vin"];

        $dats=[
            'vinInfo'=>$vinModel->VinInfo($vin),
            'vin'=>$vin
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Inventario/Create/Index",$dats).view("Inventario/Create/Scripts")
        ];
        echo json_encode($dato);
        exit();

    }

    public function CreateExhibicion()
    {
        $exhibicionModel=New ExhibicionModel();
        $generalModel=New GeneralesModel();

        $filtro=[
            'vin'=>$_POST["vin"],
            'idestadoExhibicion'=>1
        ];

        $du=$exhibicionModel->RegistroExhibicion($filtro);

        if($du[0]["contador"]==0){
            $idExi=$exhibicionModel->StorageExhibicion($filtro);
        }

        $view=$exhibicionModel->ViewExhibicion($filtro);

        $filtrodet=[
            'idexhibicionVin'=>$view[0]["idexhibicionVin"],
            'eliminado'=>null
        ];

        $detView=$exhibicionModel->ViewDetailEquipamiento($filtrodet);

        $send=[
            'viewExhibicion'=>$view,
            'detailExhibicion'=>$detView,
            'vin'=>$_POST["vin"],
            'selectAgencia'=>$generalModel->SelectAgencia()
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Inventario/CreateExhibicion/Index",$send).view("Inventario/CreateExhibicion/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }

    public function DetailCreateExhibicion()
    {
        $exhibicionModel=New ExhibicionModel();
        $filtro=[
            'idexhibicionVin'=>$_POST["idexhibicionVin"],
            'eliminado'=>null
        ];

        $detView=$exhibicionModel->ViewDetailEquipamiento($filtro);

        $send=[
            'detailExhibicion'=>$detView
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Inventario/DetailCreateExhibicion/Index",$send).view("Inventario/DetailCreateExhibicion/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }

    public function CreateEquipamiento()
    {
        $idexhibicionVin=$_POST["idexhibicionVin"];
        $vin=$_POST["vinExhibicion"];

        $dato=[
            'idexhibicionVin'=>$idexhibicionVin,
            'vin'=>$vin
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Inventario/CreateEquipamiento/Index",$dato).view("Inventario/CreateEquipamiento/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function DeleteEquipamiento()
    {
        $exhibicionModel=New ExhibicionModel();
        $idequipamiento=$_POST["idequipamientoVin"];

        $filtroEq=[
            'idequipamientoVin'=>$idequipamiento
        ];

        $dato=[
            'idequipamientoVin'=>$idequipamiento,
            'viewEquipamiento'=>$exhibicionModel->ViewDetailEquipamiento($filtroEq)
        ];
        $send=[
            'status'=>'success',
            'info'=>view("Inventario/DeleteEquipamiento/Index",$dato).view("Inventario/DeleteEquipamiento/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function CreateGas()
    {
        $vinModel=New VinModel();
        $agenciaProveedorModel=New AgenciaProveedorModel();
        $vin=$_POST["vin"];
        $vinInfo=$vinModel->VinInfo($vin);
        $proveedoresGas=$agenciaProveedorModel->ProveedorGas();
        $dats=[
            'vinInfo'=>$vinInfo,
            'vin'=>$vin,
            'proveedorGas'=>$proveedoresGas,
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Inventario/CreateGas/Index",$dats).view("Inventario/CreateGas/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }

    public function CreateBateria()
    {
        $vinModel=New VinModel();
        $inventarioModelo=New InventarioModel();
        $bateriaModel=New BateriaModel();
        $vin=$_POST["vin"];
        $vinInfo=$vinModel->VinInfo($vin);

        $filtroVin=[
            'vin'=>$_POST["vin"]
        ];

        $dats=[
            'vinInfo'=>$vinInfo,
            'vin'=>$vin,
            'vinBatIng'=>$bateriaModel->ViewEstado($filtroVin),
            'viewVin'=>$inventarioModelo->ViewInfoVin($filtroVin),
            'testBateria'=>$bateriaModel->VerificarTest($filtroVin),
            'infoBateria'=>$bateriaModel->ViewTestBateria($filtroVin)
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("Inventario/CreateBateria/Index",$dats).view("Inventario/CreateBateria/Scripts")
        ];
        echo json_encode($dato);
        exit();
    }
}