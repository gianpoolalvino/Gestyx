<?php
namespace App\Controllers\AlistamientoVehicular\Accesorios;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EventoModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function __constructor()
    {
        if (!session("login") == true) {
            return redirect()->to(base_url("/"));
        }
    }

    public function SaveProcesoAccesorio()
    {
        $alistamientoModel=New AlistamientoVehicularModel();
        $eventoModel=New EventoModel();
        $vinInfo=New VinModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $countAccesorio=0;
        $countGeneral=0;
        $vin=$_POST["vinEquipamiento"];
        $comentario=$_POST["comentarioProcesoAccesorio"];
        $vinView=$vinInfo->VinInfo($vin);
        $equipamientoVin=$alistamientoModel->EquipamientoVinNew($vin,'');
        foreach($equipamientoVin as $eqc){
            $countGeneral++;
            if($eqc["idtipoEquipamiento"]==1){
                if (strpos($eqc["equipamiento"], "LAMINA") !== false) {
                    if($eqc["idestadoEquipamiento"]==2){
                        $countAccesorio++;
                    }else{
                        if($eqc["eventoLamina"]==1){
                            $countAccesorio++;
                        }
                    }
                }else{
                    if($eqc["idestadoEquipamiento"]==2){
                        $countAccesorio++;
                    }
                }
            }
            if($eqc["idtipoEquipamiento"]==2 && $eqc["eventoGps"]==1){
                $countAccesorio++;
            }
            if($eqc["idtipoEquipamiento"]==9 && $eqc["eventoGas"]==1){
                $countAccesorio++;
            }
        }

        $filtroOrd=[
            'idevento'=>1
        ];
        $odpdi=$eventoModel->OrdenEvento($filtroOrd);
        $ordenNuevoEvent=$odpdi[0]['orden']+1;

        $filtrOn=[
            'orden'=>$ordenNuevoEvent
        ];
        $odnuEv=$eventoModel->OrdenEvento($filtrOn);

        if($countGeneral==$countAccesorio){

            $updateVin=[
                'ideventoAnterior'=>1,
                'eventoAnterior'=>'Accesorios',
                'fechaEventoAnterior'=>$hoy,
                'horaEventoAnterior'=>$hora,
                'fechaEventoActual'=>$hoy,
                'horaEventoActual'=>$hora,
                'ideventoActual'=>$odnuEv[0]["idevento"],
                'eventoActual'=>$odnuEv[0]["descripcionOrden"]
            ];

            $filtroUpdateEvento=[
                'ideventoActual'=>1,
                'vin'=>$vin,
                'idestadoEvento'=>1
            ];

            $updateVinEvent=[
                'fechaFin'=>$hoy,
                'horaFin'=>$hora,
                'idusuariofinaliza'=>session("idusuario"),
                'idestadoEvento'=>2,
                'comentarios'=>$comentario
            ];

            $updateEvent=$eventoModel->UpdateEvento($filtroUpdateEvento,$updateVinEvent);

            $insertEvent=[
                'ideventoAnterior'=>1,
                'eventoAnterior'=>'Accesorios',
                'vin'=>$vin,
                'ideventoActual'=>$odnuEv[0]["idevento"],
                'eventoActual'=>$odnuEv[0]["descripcionOrden"],
                'fechaInicio'=>$hoy,
                'horaInicio'=>$hora,
                'idestadoEvento'=>1,
                'idusuario'=>session("idusuario"),
            ];
            $insertime=$eventoModel->StorageEvento($insertEvent);

            $filtroVin=[
                'vin'=>$vin
            ];
            $updtVin=$alistamientoModel->UpdateVinAccesorio($filtroVin,$updateVin);

            $dato=[
                'vin'=>$vin,
                'status'=>'success',
                'title'=>'Proceso finalizado',
                'message'=>'El evento se finalizo correctamente'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Pendientes de Gestion',
                'message'=>'No puede procesar el evento accesorios sin finalizar el equipamiento '.$countAccesorio.' - '.$countGeneral
            ];
            echo json_encode($dato);
            exit();
        }

    }
    public function SaveEquipamientoId()
    {
        $alistamientoModel=New AlistamientoVehicularModel();
        $eventoModel=New EventoModel();
        $vinInfo=New VinModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $vin=$_POST["vinEquipamiento"];
        $idequipamientoVin=$_POST["idequipamientoVin"];
        $idtipoEquipamiento=$_POST["idtipoEquipamiento"];
        $estadoEquipamiento=$_POST["estadoEquipamiento"];
        $fechaInstalacion=$_POST["fechaInstalacion"];
        $requireGas=$_POST["requireGas"];

        $filtro=[
            'vin'=>$vin,
            'idequipamientoVin'=>$idequipamientoVin
        ];

        $viewEq=$alistamientoModel->ViewEquipamiento($filtro);

        $descripcionEq=$viewEq[0]["equipamiento"];


        $filtroUpdate=[
            'vin'=>$vin,
            'idequipamientoVin'=>$idequipamientoVin
        ];
        $equipamiento=[];
        if($estadoEquipamiento!=2){
            $equipamiento+=[
                'idestadoEquipamiento'=>$estadoEquipamiento,
                'fechaInicio'=>$fechaInstalacion,
                'fechaRegistro'=>$hoy,
                'comentario'=>$_POST["comentarioAccesorio"],
            ];
        }else{
            $equipamiento+=[
                'fechaInstalacion'=>$fechaInstalacion,
                'comentario'=>$_POST["comentarioAccesorio"],
                'idestadoEquipamiento'=>$estadoEquipamiento,
                'fechaInicio'=>$fechaInstalacion,
                'fechaRegistro'=>$hoy,
            ];
        }

        if($idtipoEquipamiento==9){
            $provGas=explode("-",$_POST["proveedorGas"]);
            $idproveedorGas=$provGas[0];
            $idproveedorGasRegion=$provGas[1];

            $equipamiento+=[
                'idproveedorGas'=>$idproveedorGas,
                'idproveedorGasRegion'=>$idproveedorGasRegion
            ];
        }

        $archivo = $_FILES['resourceAccesorio']['tmp_name'];
        if (isset($archivo) && $archivo != "") {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['resourceAccesorio']['type'];
            $temp = $_FILES['resourceAccesorio']['name'];
            $tps = explode('/', $_FILES['resourceAccesorio']['type']);
            $typo = $tps[1];
            //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
            if (!(strpos($tipo, "jpeg") || strpos($tipo, "jpg") || strpos($tipo, "png"))) {
                $dato = [
                    "status" => "warning",
                    "title" => "Error de extension",
                    "message" => "El tipo de imagen no es admitido en PDI"
                ];
                echo json_encode($dato);
                exit();
            } else {
                $path = $archivo;
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = $archivo;
                $equipamiento+=[
                    'imagenAdjunto' => base64_encode(file_get_contents($data)),
                    'nombreImagen' => $temp,
                    'tipoImagen' => $typo,
                ];
            }
        }

        $updt=$alistamientoModel->UpdateEquipamiento($filtroUpdate,$equipamiento);

        if($updt){
            if (strpos($descripcionEq, 'LAMINA') !== false) {
                if($estadoEquipamiento==2){
                    $insertEventoLmn=[
                        'ideventoAnterior'=>1,
                        'eventoAnterior'=>'Accesorios',
                        'vin'=>$vin,
                        'ideventoActual'=>29,
                        'eventoActual'=>'Instalacion Lamina',
                        'fechaInicio'=>$fechaInstalacion,
                        'horaInicio'=>$hora,
                        'fechaFin'=>$fechaInstalacion,
                        'horaFin'=>$hora,
                        'idusuario'=>session("idusuario"),
                        'idusuariofinaliza'=>session("idusuario"),
                        'idestadoEvento'=>2,
                        'comentarios'=>$_POST["comentarioAccesorio"],
                        'idequipamientoVin'=>$idequipamientoVin
                    ];
                    $insertimeGs=$eventoModel->StorageEvento($insertEventoLmn);
                }else{
                    $insertEventoLmna=[
                        'ideventoAnterior'=>1,
                        'eventoAnterior'=>'Accesorios',
                        'vin'=>$vin,
                        'ideventoActual'=>29,
                        'eventoActual'=>'Instalacion Lamina',
                        'fechaInicio'=>$hoy,
                        'horaInicio'=>$hora,
                        'idestadoEvento'=>1,
                        'idusuario'=>session("idusuario"),
                        'idequipamientoVin'=>$idequipamientoVin
                    ];
                    $insertimeGsa=$eventoModel->StorageEvento($insertEventoLmna);
                }
            }
            if($idtipoEquipamiento==9){
                if($estadoEquipamiento==2){
                    $insertEventoGs=[
                        'ideventoAnterior'=>1,
                        'eventoAnterior'=>'Accesorios',
                        'vin'=>$vin,
                        'ideventoActual'=>10,
                        'eventoActual'=>'Conversion Gas',
                        'fechaInicio'=>$fechaInstalacion,
                        'horaInicio'=>$hora,
                        'fechaFin'=>$fechaInstalacion,
                        'horaFin'=>$hora,
                        'idproveedorGas'=>$idproveedorGas,
                        'idusuario'=>session("idusuario"),
                        'idusuariofinaliza'=>session("idusuario"),
                        'idestadoEvento'=>2,
                        'comentarios'=>$_POST["comentarioAccesorio"],
                        'idequipamientoVin'=>$idequipamientoVin
                    ];
                    $insertimeGs=$eventoModel->StorageEvento($insertEventoGs);
                    $updateVin=[
                        'idproveedorGas'=>$idproveedorGas,
                        'idproveedorGasRegion'=>$idproveedorGasRegion,
                        'gas'=>2
                    ];
                    $filtroVinGps=[
                        'vin'=>$vin
                    ];
                    $updtVin=$alistamientoModel->UpdateVinAccesorio($filtroVinGps,$updateVin);

                }
            }
            if($idtipoEquipamiento==2){
                $insertEventoGps=[];
                if($estadoEquipamiento==2){
                    $insertEventoGps+=[
                        'ideventoAnterior'=>1,
                        'eventoAnterior'=>'Accesorios',
                        'vin'=>$vin,
                        'ideventoActual'=>5,
                        'eventoActual'=>'Instalacion GPS',
                        'fechaInicio'=>$fechaInstalacion,
                        'horaInicio'=>$hora,
                        'fechaFin'=>$fechaInstalacion,
                        'horaFin'=>$hora,
                        'idusuario'=>session("idusuario"),
                        'idusuariofinaliza'=>session("idusuario"),
                        'idestadoEvento'=>2,
                        'comentarios'=>$_POST["comentarioAccesorio"],
                        'idequipamientoVin'=>$idequipamientoVin
                    ];

                    $insertimeGps=$eventoModel->StorageEvento($insertEventoGps);
                    $updateVin=[
                        'gps'=>2
                    ];
                    $filtroVinGps=[
                        'vin'=>$vin
                    ];
                    $updtVin=$alistamientoModel->UpdateVinAccesorio($filtroVinGps,$updateVin);
                }else{
                    $insertEventoGps+=[
                        'ideventoAnterior'=>1,
                        'eventoAnterior'=>'Accesorios',
                        'vin'=>$vin,
                        'ideventoActual'=>5,
                        'eventoActual'=>'Instalacion GPS',
                        'fechaInicio'=>$hoy,
                        'horaInicio'=>$hora,
                        'idestadoEvento'=>1,
                        'idusuario'=>session("idusuario"),
                        'idequipamientoVin'=>$idequipamientoVin
                    ];
                    $insertimeGsa=$eventoModel->StorageEvento($insertEventoGps);
                    $updateVin=[
                        'gps'=>1
                    ];
                    $filtroVinGps=[
                        'vin'=>$vin
                    ];
                    $updtVin=$alistamientoModel->UpdateVinAccesorio($filtroVinGps,$updateVin);
                }
            }
            $datReturn=[
                'status'=>'success',
                'title'=>'Accesorizacion correcta',
                'message'=>'Se Equipo correctamente el Vehiculo'
            ];

            echo json_encode($datReturn);
            exit();
        }else{
            $datReturn=[
                'status'=>'danger',
                'title'=>'Accesorizacion Errada',
                'message'=>'Ocurrio un error que impidio el almacenado de la data'
            ];

            echo json_encode($datReturn);
            exit();
        }

    }

    public function SaveEquipamiento()
    {
        $alistamientoModel=New AlistamientoVehicularModel();
        $eventoModel=New EventoModel();
        $vinInfo=New VinModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $hora=date("H:i:s");
        $countAccesorio=0;
        $vin=$_POST["vinEquipamiento"];
        $vinView=$vinInfo->VinInfo($vin);

        if($_POST["totalEquipamiento"]!=0){
            $countDet=0;
            while ($countDet < count($_POST["equipamiento"])) {

                $filtroUpdate=[
                    'vin'=>$_POST["vinEquipamiento"],
                    'idequipamientoVin'=>$_POST["equipamiento"][$countDet]
                ];

                $equipamiento=[
                    'idestadoEquipamiento'=>$_POST["estadoEquipamiento"][$countDet]
                ];

                if($_POST["estadoEquipamiento"][$countDet]==2){
                    $equipamiento+=[
                        'fechaInicio'=>$_POST["fechaInstalacion"][$countDet],
                        'fechaInstalacion'=>$_POST["fechaInstalacion"][$countDet],
                        'idusuarioFinal'=>session("idusuario"),
                        'fechaRegistro'=>$hoy,
                    ];
                    $countAccesorio=$countAccesorio+1;
                }else {
                    $equipamiento+=[
                        'fechaInicio'=>$_POST["fechaInstalacion"][$countDet],
                        'fechaRegistro'=>$hoy,
                    ];
                    $countAccesorio=$countAccesorio+1;
                }
                $updat=$alistamientoModel->ProcesoAccesorioEquipamiento($filtroUpdate,$equipamiento);
                $countDet=$countDet+1;
            }

            if($countAccesorio==$_POST["totalEquipamiento"]){
                $updateVin=[
                    'ideventoAnterior'=>1,
                    'eventoAnterior'=>'Accesorios',
                    'fechaEventoAnterior'=>$vinView[0]["fechaEventoActual"],
                    'horaEventoAnterior'=>$vinView[0]["horaEventoActual"],
                    'fechaEventoActual'=>$hoy,
                    'horaEventoActual'=>$hora,
                    'ideventoActual'=>2,
                    'eventoActual'=>'PDI'
                ];

                $filtroUpdateEvento=[
                    'ideventoActual'=>1,
                    'vin'=>$_POST["vinEquipamiento"],
                    'idestadoEvento'=>1
                ];

                $updateVinEvent=[
                    'fechaFin'=>$hoy,
                    'horaFin'=>$hora,
                    'idusuariofinaliza'=>session("idusuario"),
                    'idestadoEvento'=>2,
                    'comentarios'=>$_POST["comentarioAccesorio"]
                ];

                $updateEvent=$eventoModel->UpdateEvento($filtroUpdateEvento,$updateVinEvent);

                $insertEvent=[
                    'ideventoAnterior'=>1,
                    'eventoAnterior'=>'Accesorios',
                    'vin'=>$_POST["vinEquipamiento"],
                    'ideventoActual'=>2,
                    'eventoActual'=>'PDI',
                    'fechaInicio'=>$hoy,
                    'horaInicio'=>$hora,
                    'idestadoEvento'=>1,
                    'idusuario'=>session("idusuario"),
                ];
                $insertime=$eventoModel->StorageEvento($insertEvent);

                $filtroVin=[
                    'vin'=>$_POST['vinEquipamiento']
                ];
                $updtVin=$alistamientoModel->UpdateVinAccesorio($filtroVin,$updateVin);
            }

        }else{
            $filtroUpdateEvento=[
                'ideventoActual'=>1,
                'vin'=>$_POST["vinEquipamiento"],
                'idestadoEvento'=>1
            ];

            $updateVinEvent=[
                'fechaFin'=>$hoy,
                'horaFin'=>$hora,
                'idusuariofinaliza'=>session("idusuario"),
                'idestadoEvento'=>2,
                'comentarios'=>$_POST["comentarioAccesorio"]
            ];

            $updateEvent=$eventoModel->UpdateEvento($filtroUpdateEvento,$updateVinEvent);

            $insertEvent=[
                'ideventoAnterior'=>1,
                'eventoAnterior'=>'Accesorios',
                'vin'=>$_POST["vinEquipamiento"],
                'ideventoActual'=>2,
                'eventoActual'=>'PDI',
                'fechaInicio'=>$hoy,
                'horaInicio'=>$hora,
                'idestadoEvento'=>1,
                'idusuario'=>session("idusuario"),
            ];
            $insertime=$eventoModel->StorageEvento($insertEvent);

            $updateVin=[
                'ideventoAnterior'=>1,
                'eventoAnterior'=>'Accesorios',
                'fechaEventoAnterior'=>$vinView[0]["fechaEventoActual"],
                'horaEventoAnterior'=>$vinView[0]["horaEventoActual"],
                'fechaEventoActual'=>$hoy,
                'horaEventoActual'=>$hora,
                'ideventoActual'=>2,
                'eventoActual'=>'PDI'
            ];
            $filtroVin=[
                'vin'=>$_POST['vinEquipamiento']
            ];
            $updtVin=$alistamientoModel->UpdateVinAccesorio($filtroVin,$updateVin);
        }
        $instalacionGas=0;
        if($_POST["conversionGas"]==1){
            $equipamientoGas=[];
            $filtroUpGas=[
                'idequipamientoVin'=>$_POST["equipamientoGas"],
                'vin'=>$_POST["vinEquipamiento"]
            ];

            $equipamientoGas+=[
                'idestadoEquipamiento'=>$_POST["estadoEquipamientoGas"]
            ];

            if($_POST["estadoEquipamientoGas"]==2){

                $provGas=explode("-",$_POST["proveedorGas"]);
                $idproveedorGas=$provGas[0];
                $idproveedorGasRegion=$provGas[1];

                $equipamientoGas+=[
                    'fechaInicio'=>$_POST["fechaInstalacionGas"],
                    'fechaInstalacion'=>$_POST["fechaInstalacionGas"],
                    'fechaRegistro'=>$hoy,
                    'idusuarioFinal'=>session("idusuario"),
                    'idproveedorGas'=>$idproveedorGas,
                    'idproveedorGasRegion'=>$idproveedorGasRegion
                ];

                $insertEventoGas=[
                    'ideventoAnterior'=>1,
                    'eventoAnterior'=>'Accesorios',
                    'vin'=>$_POST["vinEquipamiento"],
                    'ideventoActual'=>10,
                    'eventoActual'=>'Conversion Gas',
                    'fechaInicio'=>$_POST["fechaInstalacionGas"],
                    'horaInicio'=>$hora,
                    'fechaFin'=>$_POST["fechaInstalacionGas"],
                    'horaFin'=>$hora,
                    'idusuario'=>session("idusuario"),
                    'idusuariofinaliza'=>session("idusuario"),
                    'idestadoEvento'=>2,
                    'comentarios'=>$_POST["comentarioAccesorio"]
                ];

                $insertimeGs=$eventoModel->StorageEvento($insertEventoGas);

                $instalacionGas=1;
            }else{
                $equipamientoGas+=[
                    'fechaInicio'=>$_POST["fechaInstalacionGas"],
                    'fechaRegistro'=>$hoy,
                ];
                $insertEventGsa=[
                    'ideventoAnterior'=>1,
                    'eventoAnterior'=>'Accesorios',
                    'vin'=>$_POST["vinEquipamiento"],
                    'ideventoActual'=>10,
                    'eventoActual'=>'Conversion Gas',
                    'fechaInicio'=>$hoy,
                    'horaInicio'=>$hora,
                    'idestadoEvento'=>1,
                    'idusuario'=>session("idusuario"),
                ];
                $insertimeGsa=$eventoModel->StorageEvento($insertEventGsa);
            }
            $updat=$alistamientoModel->ProcesoAccesorioEquipamiento($filtroUpGas,$equipamientoGas);

            if($instalacionGas==1){
                $provGas=explode("-",$_POST["proveedorGas"]);
                $idproveedorGas=$provGas[0];
                $idproveedorGasRegion=$provGas[1];

                $updateVinGas=[
                    'gas'=>2,
                    'idproveedorGas'=>$idproveedorGas,
                    'idproveedorGasRegion'=>$idproveedorGasRegion
                ];
                $filtroVinGas=[
                    'vin'=>$_POST['vinEquipamiento']
                ];
                $updtVin=$alistamientoModel->UpdateVinAccesorio($filtroVinGas,$updateVinGas);
            }
        }
        $instalacionGps=0;
        if($_POST["gps"]==1){
            $equipamientoGps=[];
            $filtroUpGps=[
                'idequipamientoVin'=>$_POST["equipamientoGps"],
                'vin'=>$_POST["vinEquipamiento"]
            ];
            $equipamientoGps+=[
                'idestadoEquipamiento'=>$_POST["estadoEquipamientoGps"]
            ];
            if($_POST["estadoEquipamientoGps"]==2){
                $equipamientoGps+=[
                    'fechaInicio'=>$_POST["fechaInstalacionGps"],
                    'fechaInstalacion'=>$_POST["fechaInstalacionGps"],
                    'idusuarioFinal'=>session("idusuario"),
                    'fechaRegistro'=>$hoy,
                ];

                $insertEventoGps=[
                    'ideventoAnterior'=>1,
                    'eventoAnterior'=>'Accesorios',
                    'vin'=>$_POST["vinEquipamiento"],
                    'ideventoActual'=>5,
                    'eventoActual'=>'Instalacion GPS',
                    'fechaInicio'=>$_POST["fechaInstalacionGps"],
                    'horaInicio'=>$hora,
                    'fechaFin'=>$_POST["fechaInstalacionGps"],
                    'horaFin'=>$hora,
                    'idusuario'=>session("idusuario"),
                    'idusuariofinaliza'=>session("idusuario"),
                    'idestadoEvento'=>2,
                    'comentarios'=>$_POST["comentarioAccesorio"]
                ];

                $insertimeGps=$eventoModel->StorageEvento($insertEventoGps);

                $instalacionGps=1;
            }else{
                $equipamientoGps+=[
                    'fechaInicio'=>$_POST["fechaInstalacionGps"],
                    'fechaRegistro'=>$hoy,
                ];

                $insertEventGps=[
                    'ideventoAnterior'=>1,
                    'eventoAnterior'=>'Accesorios',
                    'vin'=>$_POST["vinEquipamiento"],
                    'ideventoActual'=>5,
                    'eventoActual'=>'Instalacion GPS',
                    'fechaInicio'=>$hoy,
                    'horaInicio'=>$hora,
                    'idestadoEvento'=>1,
                    'idusuario'=>session("idusuario"),
                ];
                $insertimeGsa=$eventoModel->StorageEvento($insertEventGps);
            }
            $updat=$alistamientoModel->ProcesoAccesorioEquipamiento($filtroUpGps,$equipamientoGps);

            if($instalacionGps==1){
                $updateVinGps=[
                    'gps'=>2
                ];
                $filtroVinGps=[
                    'vin'=>$_POST['vinEquipamiento']
                ];
                $updtVin=$alistamientoModel->UpdateVinAccesorio($filtroVinGps,$updateVinGps);
            }
        }

        $datReturn=[
            'status'=>'success',
            'title'=>'Accesorizacion correcta',
            'message'=>'Se Equipo correctamente el Vehiculo'
        ];

        echo json_encode($datReturn);
        exit();
    }
}

