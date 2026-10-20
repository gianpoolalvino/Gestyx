<?php
namespace App\Controllers\AlistamientoVehicular\Pdi;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EventoModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{

    public function StorageCheckPdi()
    {
        $alistamientoVehicular=New AlistamientoVehicularModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $filtroCheck=[
            'idresultadoFormularioPdi'=>$_POST["idresultadoCheckListPdi"]
        ];

        $checkListPdi=[
            'idestadoResultado'=>$_POST["estadoCheckPdi"],
            'observaciones'=>$_POST["comentariocheckPdi"],
            'fecha'=>$_POST["fechaRevision"],
            'fechaRegistro'=>$hoy,
            'horaRegistro'=>$hora
        ];

        $viewPdi=$alistamientoVehicular->UpdateCheckListPdi($filtroCheck,$checkListPdi);

        if($viewPdi){
            $dato=[
                'status'=>'success',
                'title'=>'CheckList Correcto',
                'message'=>'Se Registro Correctamente el Check de Pdi'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'PDI Errado',
                'message'=>'Ocurrio un error y no se logro finalizar el Check List'
            ];
            echo json_encode($dato);
            exit();
        }

    }
    public function SavePdi()
    {
        $vinModel=New VinModel();
        $alistamientoVin=New AlistamientoVehicularModel();
        $eventoModel=New EventoModel();
        date_default_timezone_set("America/Lima");
        $vin=$_POST["vinPdi"];
        $vinInfo=$vinModel->VinInfo($vin);
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");

        $filtroEvnt=[
            'idevento'=>2
        ];

        $evn=$eventoModel->ViewEvento($filtroEvnt);

        if($evn[0]["idtipoFormulario"]==1){
            $filtroProce=[
                'idprocesoPdi'=>$_POST["procesoPdiForm"]
            ];
            $updateProce=[
                'voltageBateria'=>$_POST["nivelGasolina"],
                'cantidadCombustible'=>$_POST["nivelGasolina"],
                'idusuario'=>session("idusuario"),
                'fecha'=>$_POST["fechaValidacionOns"],
                'fechaRegistro'=>$hoy
            ];

            if (isset($_POST['inlineRadioOptions'])) {
                $selectedValue = $_POST['inlineRadioOptions'];
                $updateProce+=[
                    'idestadoBateria'=>$selectedValue,
                ];

                $detailPdi=$alistamientoVin->DetailProcedimientoPdi($filtroProce);
                $contadorTotal=0;
                $contadorRealizado=0;
                foreach($detailPdi as $chkd){
                    $contadorTotal++;
                    if(!is_null($chkd["idestadoResultado"])){
                        $contadorRealizado++;
                    }
                }

                if($contadorRealizado==$contadorTotal){
                    $upProc=$alistamientoVin->UpdateProcesoPdi($filtroProce,$updateProce);
                }else{
                    $send=[
                        'status'=>'warning',
                        'title'=>'Checks Pendientes',
                        'message'=>'Tiene Checks pendientes de realizar en el proceso de Pdi Mecanico'
                    ];

                    echo json_encode($send);
                    exit();
                }

            } else {
                $send=[
                    'status'=>'warning',
                    'title'=>'Campo Sin Marcar',
                    'message'=>'El campo estado de bateria es obligatorio marquelo'
                ];

                echo json_encode($send);
                exit();
            }
        }
        $filtroOrd=[
            'idevento'=>2
        ];
        $odpdi=$eventoModel->OrdenEvento($filtroOrd);
        $ordenNuevoEvent=$odpdi[0]['orden']+1;

        $filtrOn=[
            'orden'=>$ordenNuevoEvent
        ];
        $odnuEv=$eventoModel->OrdenEvento($filtrOn);

        $update=[
            'ideventoAnterior'=>2,
            'eventoAnterior'=>'PDI',
            'fechaEventoActual'=>$_POST["fechaValidacionOns"],
            'horaEventoActual'=>$hora,
            'fechaEventoAnterior'=>$vinInfo[0]["fechaEventoActual"],
            'horaEventoAnterior'=>$vinInfo[0]["horaEventoActual"],
            'ideventoActual'=>$odnuEv[0]["idevento"],
            'eventoActual'=>$odnuEv[0]["descripcionOrden"]
        ];

        if($_POST["estadoOnstar"]==1){
            $update+=[
                'onstar'=>1,
            ];
        }

        $filtroVin=[
            'vin'=>$vin
        ];

        $updateV=$alistamientoVin->UpdateVinAccesorio($filtroVin,$update);

        if($updateV){
            $filtroEvento=[
                'vin'=>$vin,
                'ideventoActual'=>2,
                'idestadoEvento'=>1
            ];
            $updateEvento=[
                'fechaFin'=>$_POST["fechaValidacionOns"],
                'fechaRegistroSistemaFin'=>$hoy,
                'horaFin'=>$hora,
                'idestadoEvento'=>2,
                'idusuariofinaliza'=>session("idusuario"),
                'comentarios'=>$_POST["comentarioPdi"]
            ];
            $updev=$eventoModel->UpdateEvento($filtroEvento,$updateEvento);
            if($updev){
                $eventInsert=[
                    'ideventoAnterior'=>2,
                    'eventoAnterior'=>'PDI',
                    'vin'=>$_POST["vinPdi"],
                    'ideventoActual'=>$odnuEv[0]["idevento"],
                    'eventoActual'=>$odnuEv[0]["descripcionOrden"],
                    'fechaInicio'=>$_POST["fechaValidacionOns"],
                    'horaInicio'=>$hora,
                    'idestadoEvento'=>1,
                    'idusuario'=>session("idusuario")
                ];
                $insrt=$eventoModel->StorageEvento($eventInsert);

                if($_POST["estadoOnstar"]==1){
                    $eventInsertOs=[
                        'ideventoAnterior'=>2,
                        'eventoAnterior'=>'PDI',
                        'vin'=>$_POST["vinPdi"],
                        'ideventoActual'=>6,
                        'eventoActual'=>'Onstar',
                        'fechaInicio'=>$_POST["fechaValidacionOns"],
                        'horaInicio'=>$hora,
                        'idestadoEvento'=>1,
                        'idusuario'=>session("idusuario")
                    ];
                    $insrtO=$eventoModel->StorageEvento($eventInsertOs);
                }
            }

            $dato=[
                'status'=>'success',
                'title'=>'PDI Correcto',
                'message'=>'Se finalizo correctamente el PDI'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'PDI Errado',
                'message'=>'Ocurrio un error y no se logro finalizar el PDI'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}