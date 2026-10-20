<?php

namespace App\Controllers\ControlDemos\DemosPorEntregar;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\GeneralesModel;

class SaveEditDelete extends BaseController
{
    public function SaveEntrega()
    {
        $controlDemo=New ControlDemosModel();
        $idasignarDemo=$_POST["idasignarDemo"];
        $vin=$_POST["vinDisponible"];

        $filtroAsignacion=[
            'vin'=>$vin,
            'idasignarDemo'=>$idasignarDemo
        ];

        $asignarUp=[
            'idestadoAsignacionDemo'=>2,
            'fechaEntregaReal'=>$_POST["fechaEntrega"],
            'horaEntregaReal'=>$_POST["horaEntrega"],
            'comentarioEntrega'=>$_POST["comentarioEntrega"],
            'checkListEntrega'=>1
        ];
        $upd=$controlDemo->UpdateAsignacionDemo($filtroAsignacion,$asignarUp);

        if($upd){
            $checkList=[
                'idasignarDemo'=>$idasignarDemo,
                'fecha'=>$_POST["fechaEntrega"],
                'hora'=>$_POST["horaEntrega"],
                'idinspector'=>session("idusuario"),
                'kilometrajeEntrega'=>$_POST["kilometraje"],
                'gasolinaEntrega'=>$_POST["gasolina"],
                'observaciones'=>$_POST["comentarioEntrega"],
                'idtipoCheckListDemo'=>1,
                'idestadoCheckListDemo'=>1
            ];

            $idcheckListDemo=$controlDemo->StorageCheckList($checkList);

            $checkListRetorn=[
                'idasignarDemo'=>$idasignarDemo,
                'idtipoCheckListDemo'=>2,
                'idestadoCheckListDemo'=>2
            ];

            $idcheckListDemoRet=$controlDemo->StorageCheckList($checkListRetorn);

            $countDet=0;
            while ($countDet < count($_POST["idinventarioDemo"])) {
                $idinventarioDemo=$_POST["idinventarioDemo"][$countDet];

                $equipado=[
                    'idcheckListDemo'=>$idcheckListDemo,
                    'idinventarioDemo'=>$idinventarioDemo,
                    'cantidad'=>$_POST["cantidadEq"][$countDet],
                    'estadoEquipamiento'=>$_POST["equipadoDemo"][$countDet]

                ];
                $ideq=$controlDemo->StorageDetailCheckList($equipado);
                $equipado=[];
                $countDet=$countDet+1;
            }

            $dato=[
                'status'=>'success',
                'title'=>'Proceso Correcto',
                'message'=>'Se Generaron correctamente los PDF',
                'idasignarDemo'=>$idasignarDemo,
                'vin'=>$vin
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Proceso Errado',
                'message'=>'No se lograron generar los pdf'
            ];
            echo json_encode($dato);
            exit();
        }

    }
}