<?php

namespace App\Controllers\Comisiones\ReglaComision;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ComisionModel;
use App\Models\MarcaModel;
use App\Models\ModeloModel;

class SaveEditDelete extends BaseController
{

    public function SaveRegla()
    {
        $comisionModel=New ComisionModel();
        $idreglaComisionVentaVehiculo=$_POST["idreglaComision"];

        $body=[
            'idmarca'=>$_POST["marcaCarga"],
            'estado'=>1
        ];

        $up=$comisionModel->UpdateReglaComisionVenta($idreglaComisionVentaVehiculo,$body);

        if($up){
            $send=[
                'status'=>'success',
                'title'=>'Se Registro',
                'message'=>'Se Registro correctamente la regla'
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error inesperado',
                'message'=>'Ocurrio un error al intentar grabar la regla'
            ];
            echo json_encode($send);
            exit();
        }

    }
    public function SaveCategoria()
    {
        $comisionModel=New ComisionModel();
        $save=[
            'categoria'=>$_POST["categoriaRegla"],
            'condicion'=>$_POST["condicionCategoria"],
            'porcentaje'=>$_POST["porcentajeCategoria"],
            'idreglaComisionVentaVehiculo'=>$_POST["idreglaComisionCategoria"]
        ];

        $save=$comisionModel->StorageCategoria($save);

        if($save){
            $send=[
                'status'=>'success',
                'title'=>'Se Registro',
                'message'=>'Se Registro correctamente la categoria'
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error',
                'message'=>'Ocurrio un error inesperado'
            ];
            echo json_encode($send);
            exit();
        }
    }

    public function DeleteCategoria()
    {
        $comisionModel=New ComisionModel();

        $filtro=[
            'idcategoriaBono'=>$_POST["idcategoriaBono"]
        ];

        $destroy=$comisionModel->DestroyCategoria($filtro);

        if($destroy){
            $send=[
                'status'=>'success',
                'title'=>'Se Elimino Correctamente',
                'message'=>'Categoria eliminada'
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error',
                'message'=>'Ocurrio un error inesperado'
            ];
            echo json_encode($send);
            exit();
        }
    }
    public function DeleteConcepto()
    {
        $comisionModel=New ComisionModel();

        $filtro=[
            'iddetalleReglaComisionVentaVehiculo'=>$_POST["idconceptoRegla"]
        ];

        $destroy=$comisionModel->DestroyConcepto($filtro);

        if($destroy){
            $send=[
                'status'=>'success',
                'title'=>'Se Elimino Correctamente',
                'message'=>'Concepto elimnado'
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error',
                'message'=>'Ocurrio un error inesperado'
            ];
            echo json_encode($send);
            exit();
        }

    }
    public function SaveConcepto()
    {
        $comisionModel=New ComisionModel();

        $filtro=[
            'idreglaComisionVentaVehiculo'=>$_POST["idreglaComisionVenta"],
        ];
        $cnpt=$comisionModel->SumaPorcentajeRegla($filtro);

        $total=$cnpt[0]["sumaTotal"]+$_POST["pesoConcepto"];

        if($total>100){
            $send=[
                'status'=>'danger',
                'title'=>'Exedido',
                'message'=>'la Suma de Conceptos no puede ser mayor al 100%'
            ];
            echo json_encode($send);
            exit();
        }

        $concepto=[
            'idreglaComisionVentaVehiculo'=>$_POST["idreglaComisionVenta"],
            'concepto'=>$_POST["nombreConcepto"],
            'meta'=>$_POST["metaConcepto"],
            'peso'=>$_POST["pesoConcepto"]
        ];

        $stor=$comisionModel->StorageConceptoRegla($concepto);

        if($stor!=''){
            $send=[
                'status'=>'success',
                'title'=>'Se Registro',
                'message'=>'Se Registro correctamente en concepto'
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error de Almacenado',
                'message'=>'No se logro almacenar correctamente el concepto'
            ];
            echo json_encode($send);
            exit();
        }
    }
}