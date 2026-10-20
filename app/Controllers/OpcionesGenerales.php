<?php

namespace App\Controllers;

use App\Models\AccessModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlCalidadModel;
use App\Models\EventoModel;
use App\Models\GeneralesModel;
use App\Models\OpcionesGeneralesModel;
use App\Models\VinModel;

class OpcionesGenerales extends BaseController
{

    public function ViewHistorySincronizacion()
    {
        $generalModel=New GeneralesModel();
        date_default_timezone_set("America/Lima");
        $fecha=date("Y-m-d");
        $filtro=[
            'fecha'=>$fecha
        ];
        $dato=[
            'detailIndex'=>$generalModel->DetailIndexHistorySincronizacion($filtro),
        ];
        $send=[
            'status'=>'success',
            'title'=>'Historico ded Sincronizaciones',
            'message'=>'',
            'info'=>view("OpcionesGenerales/ViewHistorySincronizacion/Index/Index",$dato).view('OpcionesGenerales/ViewHistorySincronizacion/Index/Scripts'),
        ];
        echo json_encode($send);
        exit();
    }

    public function DetailIndexSincronizacion()
    {
        $generalModel=New GeneralesModel();
        date_default_timezone_set("America/Lima");
        $fecha=date("Y-m-d");
        $filtro=[
            'fecha'=>$fecha
        ];
        $dato=[
            'detailIndex'=>$generalModel->DetailIndexHistorySincronizacion($filtro),
        ];
        $send=[
            'status'=>'success',
            'title'=>'Historico ded Sincronizaciones',
            'message'=>'',
            'info'=>view("OpcionesGenerales/ViewHistorySincronizacion/DetailIndex/Index",$dato).view('OpcionesGenerales/ViewHistorySincronizacion/DetailIndex/Scripts'),
        ];
        echo json_encode($send);
        exit();
    }
    public function RetornarEvento()
    {
        $dato=[
            'info'=>view('OpcionesGenerales/RetornarEvento/Create/Index').view('OpcionesGenerales/RetornarEvento/Create/Scripts'),
            'status'=>'success'
        ];

        echo json_encode($dato);
    }

    public function EventosRealizados()
    {
        $opcionesGenerales=New OpcionesGeneralesModel();
        $vinModel=New VinModel();
        $vin=$_POST["vin"];

        $filtro=[
            'vin'=>$vin
        ];

        $filtros=[
            'vin'=>$vin,
            'idtipoEquipamiento'=>1
        ];

        $dato=[
            'badgeEvento'=>$opcionesGenerales->EventosAnteriores($filtro),
            'vinInfo'=>$vinModel->VinInfo($vin),
            'selectEvento'=>$opcionesGenerales->EventosAnteriores($filtro),
            'equipamientoContador'=>$opcionesGenerales->EquipamientoInstalado($filtros)
        ];

        $result=[
            'info'=>view("OpcionesGenerales/RetornarEvento/PanelEvento/Index",$dato).view("OpcionesGenerales/RetornarEvento/PanelEvento/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($result);

    }

    public function ProcesarRetornoEvento()
    {
        $opcionesGenerales=new OpcionesGeneralesModel();
        $alistamientoVin=New AlistamientoVehicularModel();
        $controlCalidadModel=New ControlCalidadModel();
        $eventoModel=New EventoModel();
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        date_default_timezone_set("America/Lima");
        $vin=$_POST["vinRetorno"];
        $ideventoRetorno=$_POST["ideventoRetorno"];

        if($ideventoRetorno==27){
            $filtro=[
                'vin'=>$vin
            ];
            $filtroEvento=[8,1,2,3,5,6,7];

            $update=[
                'idestadoEvento'=>3
            ];

            $filtroEquipamiento=[
                'vin'=>$vin
            ];

            $updateEquipamiento=[
                'eliminado'=>1
            ];

            $restEvent=$opcionesGenerales->EventoUpdate($filtro,$filtroEvento,$update);

            if($restEvent){

                $update=[
                    'ideventoAnterior'=>28,
                    'eventoAnterior'=>'Retorno de Eventos',
                    'fechaEventoActual'=>$hoy,
                    'horaEventoActual'=>$hora,
                    'fechaEventoAnterior'=>$hoy,
                    'horaEventoAnterior'=>$hora,
                    'ideventoActual'=>8,
                    'eventoActual'=>'Llamada Bienvenida',
                    'cotizacion'=>null
                ];

                $filtroVin=[
                    'vin'=>$vin
                ];

                $vinFiltroCC=[
                    'vin'=>$vin,
                    'idestadoProceso!='=>4
                ];
                $updateReporteCalidad=[
                    'idestadoProceso'=>4
                ];
                $control=$controlCalidadModel->UpdateReporteCalidad($vinFiltroCC,$updateReporteCalidad);

                $updateV=$alistamientoVin->UpdateVinAccesorio($filtroVin,$update);

                $eventoActual=[
                    'fechaRegistroSistemaInicio'=>$hoy,
                    'fechaInicio'=>$hoy,
                    'vin'=>$vin,
                    'horaInicio'=>$hora,
                    'ideventoActual'=>8,
                    'eventoActual'=>'Llamada Bienvenida',
                    'eventoAnterior'=>'Retorno de Eventos',
                    'ideventoAnterior'=>28,
                    'idestadoEvento'=>1
                ];
                $store=$eventoModel->StorageEvento($eventoActual);


                $restEqui=$opcionesGenerales->DesactivarEquipamiento($filtroEquipamiento,$updateEquipamiento);
                if($restEqui){
                    $dato=[
                        'status'=>'success',
                        'title'=>'Eventos Reseteados',
                        'message'=>'Se Restablecio al Evento sin cotizacion nuevamente, esto elimina los equipamientos excepto la conversion a gas'
                    ];
                    echo json_encode($dato);
                    exit();
                }
            }

        }else if($ideventoRetorno==8){
            //Llamada de bienvenida
            $filtro=[
                'vin'=>$vin
            ];
            $filtroEvento=[8,1,2,3,5,6,7];

            $update=[
                'idestadoEvento'=>3
            ];

            $filtroEquipamiento=[
                'vin'=>$vin
            ];

            $updateEquipamiento=[
                'idestadoEquipamiento'=>1,
                'validacionControlCalidad'=>null
            ];

            $restEvent=$opcionesGenerales->EventoUpdate($filtro,$filtroEvento,$update);

            if($restEvent){
                $updatev2=[
                    'ideventoAnterior'=>28,
                    'eventoAnterior'=>'Retorno de Eventos',
                    'fechaEventoActual'=>$hoy,
                    'horaEventoActual'=>$hora,
                    'fechaEventoAnterior'=>$hoy,
                    'horaEventoAnterior'=>$hora,
                    'ideventoActual'=>8,
                    'eventoActual'=>'Llamada Bienvenida'
                ];
                $filtroVin=[
                    'vin'=>$vin
                ];

                $updateVin=[
                    'ideventoActual'=>8,
                    'eventoActual'=>'Llamada Bienvenida'
                ];

                $vinFiltroCC=[
                    'vin'=>$vin,
                    'idestadoProceso!='=>4
                ];
                $updateReporteCalidad=[
                    'idestadoProceso'=>4
                ];
                $control=$controlCalidadModel->UpdateReporteCalidad($vinFiltroCC,$updateReporteCalidad);

                $updateV=$alistamientoVin->UpdateVinAccesorio($filtroVin,$updatev2);

                $eventoActual=[
                    'fechaRegistroSistemaInicio'=>$hoy,
                    'fechaInicio'=>$hoy,
                    'vin'=>$vin,
                    'horaInicio'=>$hora,
                    'ideventoActual'=>8,
                    'eventoActual'=>'Llamada Bienvenida',
                    'eventoAnterior'=>'Retorno de Eventos',
                    'ideventoAnterior'=>28,
                    'idestadoEvento'=>1
                ];
                $store=$eventoModel->StorageEvento($eventoActual);
                $restEqui=$opcionesGenerales->DesactivarEquipamiento($filtroEquipamiento,$updateEquipamiento);
                if($restEqui){
                    $dato=[
                        'status'=>'success',
                        'title'=>'Eventos Reseteados',
                        'message'=>'Se Restablecio al Evento sin llamada de bienvenida, esto desactiva los equipamientos excepto la conversion a gas'
                    ];
                    echo json_encode($dato);
                    exit();
                }
            }
        }else if($ideventoRetorno==1){
            //Accesorios
            $filtro=[
                'vin'=>$vin
            ];
            $filtroEvento=[1,2,3,5,6,7];

            $update=[
                'idestadoEvento'=>3
            ];

            $filtroEquipamiento=[
                'vin'=>$vin
            ];

            $updateEquipamiento=[
                'idestadoEquipamiento'=>1,
                'validacionControlCalidad'=>null
            ];

            $restEvent=$opcionesGenerales->EventoUpdate($filtro,$filtroEvento,$update);

            if($restEvent){

                $updatev2=[
                    'ideventoAnterior'=>28,
                    'eventoAnterior'=>'Retorno de Eventos',
                    'fechaEventoActual'=>$hoy,
                    'horaEventoActual'=>$hora,
                    'fechaEventoAnterior'=>$hoy,
                    'horaEventoAnterior'=>$hora,
                    'ideventoActual'=>1,
                    'eventoActual'=>'Accesorios'
                ];
                $filtroVin=[
                    'vin'=>$vin
                ];
                $updateVin=[
                    'ideventoActual'=>1,
                    'eventoActual'=>'Accesorios'
                ];

                $vinFiltroCC=[
                    'vin'=>$vin,
                    'idestadoProceso!='=>4
                ];
                $updateReporteCalidad=[
                    'idestadoProceso'=>4
                ];
                $control=$controlCalidadModel->UpdateReporteCalidad($vinFiltroCC,$updateReporteCalidad);

                $updateV=$alistamientoVin->UpdateVinAccesorio($filtroVin,$updatev2);

                $eventoActual=[
                    'fechaRegistroSistemaInicio'=>$hoy,
                    'fechaInicio'=>$hoy,
                    'vin'=>$vin,
                    'horaInicio'=>$hora,
                    'ideventoActual'=>1,
                    'eventoActual'=>'Accesorios',
                    'eventoAnterior'=>'Retorno de Eventos',
                    'ideventoAnterior'=>28,
                    'idestadoEvento'=>1
                ];
                $store=$eventoModel->StorageEvento($eventoActual);
                $restEqui=$opcionesGenerales->DesactivarEquipamiento($filtroEquipamiento,$updateEquipamiento);
                if($restEqui){
                    $dato=[
                        'status'=>'success',
                        'title'=>'Eventos Reseteados',
                        'message'=>'Se Restablecio al Evento a Accesorios, esto desactiva los equipamientos excepto la conversion a gas'
                    ];
                    echo json_encode($dato);
                    exit();
                }
            }
        }else if($ideventoRetorno==2){
            //PDI
            $filtro=[
                'vin'=>$vin
            ];
            $filtroEvento=[2,3,6,7];

            $update=[
                'idestadoEvento'=>3
            ];

            $filtroEquipamiento=[
                'vin'=>$vin
            ];

            $updateEquipamiento=[
                'validacionControlCalidad'=>null
            ];

            $restEqui=$opcionesGenerales->DesactivarEquipamiento($filtroEquipamiento,$updateEquipamiento);

            $restEvent=$opcionesGenerales->EventoUpdate($filtro,$filtroEvento,$update);

            if($restEvent){

                $updatev2=[
                    'ideventoAnterior'=>28,
                    'eventoAnterior'=>'Retorno de Eventos',
                    'fechaEventoActual'=>$hoy,
                    'horaEventoActual'=>$hora,
                    'fechaEventoAnterior'=>$hoy,
                    'horaEventoAnterior'=>$hora,
                    'ideventoActual'=>2,
                    'eventoActual'=>'PDI'
                ];
                $filtroVin=[
                    'vin'=>$vin
                ];
                $updateVin=[
                    'ideventoActual'=>2,
                    'eventoActual'=>'Accesorios'
                ];

                $vinFiltroCC=[
                    'vin'=>$vin,
                    'idestadoProceso!='=>4
                ];
                $updateReporteCalidad=[
                    'idestadoProceso'=>4
                ];
                $control=$controlCalidadModel->UpdateReporteCalidad($vinFiltroCC,$updateReporteCalidad);

                $updateV=$alistamientoVin->UpdateVinAccesorio($filtroVin,$updatev2);

                $eventoActual=[
                    'fechaRegistroSistemaInicio'=>$hoy,
                    'fechaInicio'=>$hoy,
                    'vin'=>$vin,
                    'horaInicio'=>$hora,
                    'ideventoActual'=>2,
                    'eventoActual'=>'PDI',
                    'eventoAnterior'=>'Retorno de Eventos',
                    'ideventoAnterior'=>28,
                    'idestadoEvento'=>1
                ];
                $store=$eventoModel->StorageEvento($eventoActual);
                $dato=[
                    'status'=>'success',
                    'title'=>'Eventos Reseteados',
                    'message'=>'Se Restablecio al Evento a PDI, esto restablece todo incluido el evento Onstar'
                ];
                echo json_encode($dato);
                exit();

            }
        }else if($ideventoRetorno==3){
            //Lavado
            $filtro=[
                'vin'=>$vin
            ];
            $filtroEvento=[3,7];

            $update=[
                'idestadoEvento'=>3
            ];

            $filtroEquipamiento=[
                'vin'=>$vin
            ];

            $updateEquipamiento=[
                'validacionControlCalidad'=>null
            ];

            $restEqui=$opcionesGenerales->DesactivarEquipamiento($filtroEquipamiento,$updateEquipamiento);

            $restEvent=$opcionesGenerales->EventoUpdate($filtro,$filtroEvento,$update);

            if($restEvent){

                $updatev2=[
                    'ideventoAnterior'=>28,
                    'eventoAnterior'=>'Retorno de Eventos',
                    'fechaEventoActual'=>$hoy,
                    'horaEventoActual'=>$hora,
                    'fechaEventoAnterior'=>$hoy,
                    'horaEventoAnterior'=>$hora,
                    'ideventoActual'=>3,
                    'eventoActual'=>'Lavado'
                ];
                $filtroVin=[
                    'vin'=>$vin
                ];


                $updateV=$alistamientoVin->UpdateVinAccesorio($filtroVin,$updatev2);

                $vinFiltroCC=[
                    'vin'=>$vin,
                    'idestadoProceso!='=>4
                ];
                $updateReporteCalidad=[
                    'idestadoProceso'=>4
                ];
                $control=$controlCalidadModel->UpdateReporteCalidad($vinFiltroCC,$updateReporteCalidad);

                $eventoActual=[
                    'fechaRegistroSistemaInicio'=>$hoy,
                    'fechaInicio'=>$hoy,
                    'vin'=>$vin,
                    'horaInicio'=>$hora,
                    'ideventoActual'=>3,
                    'eventoActual'=>'Lavado',
                    'eventoAnterior'=>'Retorno de Eventos',
                    'ideventoAnterior'=>28,
                    'idestadoEvento'=>1
                ];
                $store=$eventoModel->StorageEvento($eventoActual);
                $dato=[
                    'status'=>'success',
                    'title'=>'Eventos Reseteados',
                    'message'=>'Se Restablecio al Evento a Lavado, esto restablece todo incluido el evento Onstar'
                ];
                echo json_encode($dato);
                exit();

            }
        }else if($ideventoRetorno==7){
            //Lavado
            $filtro=[
                'vin'=>$vin
            ];
            $filtroEvento=[7];

            $update=[
                'idestadoEvento'=>3
            ];

            $filtroEquipamiento=[
                'idtipoEquipamiento'=>1,
                'vin'=>$vin
            ];

            $updateEquipamiento=[
                'idestadoEquipamiento'=>1
            ];

            $restEvent=$opcionesGenerales->EventoUpdate($filtro,$filtroEvento,$update);

            if($restEvent){

                $updatev2=[
                    'ideventoAnterior'=>28,
                    'eventoAnterior'=>'Retorno de Eventos',
                    'fechaEventoActual'=>$hoy,
                    'horaEventoActual'=>$hora,
                    'fechaEventoAnterior'=>$hoy,
                    'horaEventoAnterior'=>$hora,
                    'ideventoActual'=>7,
                    'eventoActual'=>'Control Calidad'
                ];
                $filtroVin=[
                    'vin'=>$vin
                ];

                $updateV=$alistamientoVin->UpdateVinAccesorio($filtroVin,$updatev2);

                $filtroEquipamiento=[
                    'vin'=>$vin,
                ];

                $updateEquipamiento=[
                    'validacionControlCalidad'=>null
                ];
                $restEqui=$opcionesGenerales->DesactivarEquipamiento($filtroEquipamiento,$updateEquipamiento);


                $vinFiltroCC=[
                    'vin'=>$vin,
                    'idestadoProceso!='=>4
                ];
                $updateReporteCalidad=[
                    'idestadoProceso'=>4
                ];
                $control=$controlCalidadModel->UpdateReporteCalidad($vinFiltroCC,$updateReporteCalidad);


                $eventoActual=[
                    'fechaRegistroSistemaInicio'=>$hoy,
                    'fechaInicio'=>$hoy,
                    'vin'=>$vin,
                    'horaInicio'=>$hora,
                    'ideventoActual'=>7,
                    'eventoActual'=>'Control Calidad',
                    'eventoAnterior'=>'Retorno de Eventos',
                    'ideventoAnterior'=>28,
                    'idestadoEvento'=>1
                ];
                $store=$eventoModel->StorageEvento($eventoActual);
                $dato=[
                    'status'=>'success',
                    'title'=>'Eventos Reseteados',
                    'message'=>'Se Restablecio al Evento a Lavado, esto restablece todo incluido el evento Onstar'
                ];
                echo json_encode($dato);
                exit();

            }
        }

    }

    public function ConsultaResponsable()
    {
        $GeneralesModel=New GeneralesModel();
        $documentoResponsable=isset($_POST["documento"])?$_POST["documento"]:$_GET["documento"];

        $filtro=[
            'documento'=>$documentoResponsable
        ];

        $responsable=$GeneralesModel->SearchResponsable($filtro);

        if($responsable){
            $dato=[
                'status'=>'success',
                'documento'=>$responsable[0]["documento"],
                'nombre'=>$responsable[0]["nombre"],
                'direccion'=>$responsable[0]["direccion"],
                'telefono'=>$responsable[0]["telefono"],
            ];

            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'No existe Datos',
                'message'=>'No existe datos similares en la base de datos'
            ];

            echo json_encode($dato);
            exit();
        }
    }
}