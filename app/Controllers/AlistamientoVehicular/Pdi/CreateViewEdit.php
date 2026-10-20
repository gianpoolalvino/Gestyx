<?php

namespace App\Controllers\AlistamientoVehicular\Pdi;
use App\Controllers\BaseController;
use App\Models\AgenciaProveedorModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\EventoModel;

class CreateViewEdit extends BaseController
{
    public function ViewCamera()
    {
        $alistamientoModel=new AlistamientoVehicularModel();

        $filtro=[
            "idresultadoFormularioPdi"=>$_POST["idresultadoFormularioPdi"],
        ];

        $estado=$alistamientoModel->ViewProcesoPdi($filtro);

        if(is_null($estado[0]["idestadoResultado"]))
        {
            $send=[
                'status'=>'danger',
                'title'=>'No Procesable',
                'message'=>'Primero debe generar el estado del Item para cargar Imagenes'
            ];

            echo json_encode($send);
            exit();
        }

        $dato=[
            "idresultadoFormularioPdi"=>$_POST["idresultadoFormularioPdi"],
            "vin"=>$_POST["vin"],
            "idprocesoPdi"=>$_POST["idprocesoPdi"],
            "idgrupoCheckListFormularioPdi"=>$_POST["idgrupoCheckListFormularioPdi"],
            "viewResultadoPdi"=>$alistamientoModel->ViewProcesoPdi($filtro),
        ];



        $send=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/Pdi/ViewCamera/Index",$dato).view("AlistamientoVehicular/Pdi/ViewCamera/Scripts"),
        ];
        echo json_encode($send);
        exit();
    }
    public function Create()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();
        $eventoModel=New EventoModel();
        $filtro=[
            'idevento'=>2
        ];
        $evento=$eventoModel->ViewEvento($filtro);
        $result=[];
        $vin=$_POST["vin"];
        if($evento[0]["idtipoFormulario"]==1){
            $formulario=$this->GenerateFormulario($vin);
            $result=json_decode($formulario);
        }

        $agenciaProveedor=new AgenciaProveedorModel();

        $infoGen=$alistamientoVehicular->ViewVin($vin);

        $filtro=[
            'codigoAgencia'=>$infoGen[0]["codigoAgencia"]
        ];

        $dats=[
            'infoVin'=>$alistamientoVehicular->ViewVin($vin),
            'idtipoFormulario'=>$evento[0]["idtipoFormulario"],
            'vin'=>$vin
        ];

        if($evento[0]["idtipoFormulario"]==1){

            $filtroPdi=[
                'idprocesoPdi'=>$result->idprocesoPdi,
                'idgrupoCheckListFormularioPdi'=>1
            ];

            $dats+=[
                'checkListPdi'=>$alistamientoVehicular->DetailProcedimientoPdi($filtroPdi),
                'grupoCheckList'=>$alistamientoVehicular->GrupoCheckListPdi(),
                'idprocesoPdi'=>$result->idprocesoPdi,
                'nivelGasolina'=>$alistamientoVehicular->NivelCombustible()
            ];
        }

        $dato=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/Pdi/Create/Index",$dats).view("AlistamientoVehicular/Pdi/Create/Scripts",$dats)
        ];

        echo json_encode($dato);
        exit();
    }

    public function ViewCheckPdi()
    {
        $alistamientoVehicular=New AlistamientoVehicularModel();

        $filtroProceso=[
            'idresultadoFormularioPdi'=>$_POST["idresultadoFormularioPdi"]
        ];

        $dats=[
            'idprocesoPdi'=>$_POST["idprocesoPdi"],
            'idgrupoCheckListFormularioPdi'=>$_POST["idgrupoCheckListFormularioPdi"],
            'idresultadoFormularioPdi'=>$_POST["idresultadoFormularioPdi"],
            'vin'=>$_POST["vin"],
            'viewCheck'=>$alistamientoVehicular->DetailProcedimientoPdi($filtroProceso)
        ];

        $dato=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/Pdi/ViewCheck/Index",$dats).view("AlistamientoVehicular/Pdi/ViewCheck/Scripts",$dats)
        ];

        echo json_encode($dato);
        exit();
    }

    public function DetailCheckPdi()
    {
        $alistamientoVehicular=new AlistamientoVehicularModel();

        $filtroPdi=[
            'idprocesoPdi'=>$_POST["idprocesoPdi"],
            'vin'=>$_POST["vin"],
            'idgrupoCheckListFormularioPdi'=>$_POST["idgrupoCheckList"]
        ];

        $dats=[
            'vin'=>$_POST["vin"],
            'checkListPdi'=>$alistamientoVehicular->DetailProcedimientoPdi($filtroPdi),
        ];

        $send=[
            'status'=>'success',
            'info'=>view("AlistamientoVehicular/Pdi/DetailCreate/Index",$dats).view("AlistamientoVehicular/Pdi/DetailCreate/Scripts")
        ];

        echo json_encode($send);
        exit();
    }
    private function GenerateFormulario($vin)
    {
        $eventoModel=New EventoModel();
        $alistamientoVehicular=new AlistamientoVehicularModel();

        $filtroProceso=[
            'vin'=>$vin,
            'eliminado'=>null
        ];

        $viewProces=$alistamientoVehicular->ViewProcedimientoPdi($filtroProceso);

        if($viewProces){
            $send=[
                'status'=>'success',
                'idprocesoPdi'=>$viewProces[0]["idprocesoPdi"]
            ];
            return json_encode($send);
            exit();
        }else{
            $storage=[
                'vin'=>$vin
            ];
            $idprocesoPdi=$alistamientoVehicular->StorageProcedimientoPdi($storage);
            $formPdi=$alistamientoVehicular->FormularioPdi();
            if($idprocesoPdi!=''){
                foreach($formPdi as $pd){
                    $storageForm=[
                        'idprocesoPdi'=>$idprocesoPdi,
                        'idgrupoCheckListFormularioPdi'=>$pd["idgrupoCheckListFormularioPdi"],
                        'idcheckListFormularioPdi'=>$pd["idcheckListFormularioPdi"]
                    ];
                    $storgaDetPdi=$alistamientoVehicular->StorageDetalleProcesoPdi($storageForm);
                }
                $send=[
                    'status'=>'success',
                    'idprocesoPdi'=>$idprocesoPdi,
                ];
                return json_encode($send);
                exit();
            }
        }
    }
}