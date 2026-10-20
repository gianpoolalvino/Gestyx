<?php

namespace App\Controllers\Taller\Repuesto;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\InventarioModel;
use App\Models\MarcaModel;
use App\Models\RepuestoModel;

class SaveEditDelete extends BaseController
{

    public function DeleteRespuesto()
    {
        $repuestoModel=New RepuestoModel();
        $idrepuesto=$_POST["idrepuesto"];
        $uprepuesto=[
            'idestado'=>2
        ];

        $filtroRsp=[
            'idrepuesto'=>$idrepuesto
        ];

        $result=$repuestoModel->UpgradeRepuesto($filtroRsp,$uprepuesto);

        if($result){
            $dato=[
                'status'=>'success',
                'title'=>'Operacion Correcta',
                'message'=>'Se logro eliminar el Repuesto'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Operacion Errada',
                'message'=>'Ocurrio un error al intentar eliminar el repuesto'
            ];
            echo json_encode($dato);
            exit();
        }
    }

    public function UpdateRepuesto()
    {
        $repuestoModel=New RepuestoModel();
        $idrepuesto=$_POST["idrepuesto"];
        $uprepuesto=[
            'precioDolares'=>$_POST["precioDolares"],
            'precioSoles'=>$_POST["precioSoles"],
        ];

        $filtroRsp=[
            'idrepuesto'=>$idrepuesto
        ];

        $result=$repuestoModel->UpgradeRepuesto($filtroRsp,$uprepuesto);

        if($result){
            $dato=[
                'status'=>'success',
                'title'=>'Operacion Correcta',
                'message'=>'Se logro Actualizar el Repuesto'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Operacion Errada',
                'message'=>'Ocurrio un error al intentar actualizar el repuesto'
            ];
            echo json_encode($dato);
            exit();
        }

    }
    public function SaveRepuesto()
    {
        $repuestoModel=New RepuestoModel();

        $repuesto=[
            'codigo'=>$_POST["codigoRepuesto"],
            'descripcion'=>$_POST["descripcionRepuesto"],
            'precioDolares'=>$_POST["precioDolares"],
            'precioSoles'=>$_POST["precioSoles"],
            'idmarcaAfectada'=>$_POST["marca"]
        ];

        $idrepuesto=$repuestoModel->StorageRepuesto($repuesto);

        if($idrepuesto!=''){
            $dato=[
                'status'=>'success',
                'title'=>'Operacion Correcta',
                'message'=>'Se logro almacenar el Repuesto'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Operacion Errada',
                'message'=>'Ocurrio un error al intentar almacenar el repuesto'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}