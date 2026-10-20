<?php

namespace App\Controllers\Traslado\GuiasTraslados;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\GuiaModel;
use App\Models\InventarioModel;
use App\Models\TrasladoModel;


class SaveEditDelete extends BaseController
{
    public function SaveDatosEmision()
    {
        $guiaModel=New GuiaModel();
        $idguiaRemision=$_POST["idguiaRemision"];

        $filtroEmp=[
            'idempresa'=>$_POST["empresa"]
        ];

        $gui=$guiaModel->UltimoNumeracion($filtroEmp);

        $numeracion=$gui[0]["numero"]+1;

        $filtroUpdate=[
            'idguiaRemision'=>$_POST["idguiaRemision"]
        ];
        $serieGeneral='TG01';

        $updateGuia=[
            "idmotivoTrasladoGuia"=>$_POST["motivoTraslado"],
            "serie"=>$serieGeneral,
            "numero"=>$numeracion,
            "idestadoGuia"=>2,
            "idprocesoGuia"=>1,
            "sustentoOtros"=>$_POST["especificarTraslado"],
            "codigoUnidadPesoBruto"=>$_POST["unidadMedidaGuia"],
            "pesoBruto"=>$_POST["pesoGuia"]
        ];

        $up=$guiaModel->UpdateGuiaRemision($filtroUpdate,$updateGuia);
        if($up){
            $send = [
                'status' => 'success',
                'title' => 'Registro Correcto',
                'message' => 'Se ingresó correctamente la guia de remision',
            ];
        }else{
            $send = [
                'status' => 'danger',
                'title' => 'Registro Errado',
                'message' => 'Ocurrio un error al guardar la guia de remision',
            ];
        }
        echo json_encode($send);
        exit();
    }

    public function SaveVinGuia()
    {
        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $guiaRemisonModel=New GuiaModel();
            $detalleGuia=[
                'vin'=>$_POST["selectVinGuia"],
                'idguiaRemision'=>$_POST["idguiaRemisionVin"],
                'cantidad'=>1,
                'unidadMedida'=>'NIU',
                'descripcion'=>'',
                'codigoBien'=>$_POST["selectVinGuia"]
            ];

            $iddetalle=$guiaRemisonModel->StorageDetalleGuiaRemision($detalleGuia);

            if ($db->transStatus() === FALSE) {
                // Revierte la transacción si algo salió mal
                $db->transRollback();
                $send=[
                    'status'=>'danger',
                    'title'=>'Error BD',
                    'message'=>'No se logro insertar el vin en la guia de remision'
                ];

                echo json_encode($send);
                exit();
            } else {
                $db->transCommit();
                $send=[
                    'status'=>'success',
                    'title'=>'Vin Agregado',
                    'idguiaRemision'=>$_POST["idguiaRemisionVin"],
                    'message'=>'El vin se agrego correctamente a la guia de remision'
                ];
                echo json_encode($send);
                exit();
            }
        }catch(\Exception $e){
            $db->transRollback();
            echo json_encode([
                "status" => "danger",
                "title" => "Error en la transaccion",
                "message" => $e->getMessage()
            ]);
        }
    }

    public function SaveTransportista()
    {
// Cargar el modelo y la base de datos
        $guiaModel = new GuiaModel();
        $db = \Config\Database::connect();

        $idguiaRemision = $_POST["idguiaRemision"];
        $filtroUpdate = [
            'idguiaRemision' => $idguiaRemision
        ];

        $updateGuia = [];
        $missingFields = [];
// Iniciar una transacción
        $db->transBegin();
        try {
            // Validación según tipo de transportista
            if ($_POST["inputTipoTransportista"] == 1) {
                // Si es tipo 1 (Transportista sin chofer), solo verificamos los datos del transportista
                if (empty($_POST["rucTransportista"])) {
                    $missingFields[] = 'rucTransportista';
                }
                if (empty($_POST["razonSocialTransportista"])) {
                    $missingFields[] = 'razonSocialTransportista';
                }

                $updateGuia = [
                    'idtipoTransportista' => $_POST["inputTipoTransportista"],
                    'rucTransportista' => $_POST["rucTransportista"],
                    'razonSocialTransportista' => $_POST["razonSocialTransportista"],
                    'idtipoDocumentoChofer' => null,
                    'documentoChofer' => null,
                    'licenciaChofer' => null,
                    'nombreChofer' => null,
                    'apellidoChofer' => null,
                    'placaVehiculo' => null
                ];
            } else {
                if (empty($_POST["rucTransportista"])) {
                    $missingFields[] = 'rucTransportista';
                }
                if (empty($_POST["razonSocialTransportista"])) {
                    $missingFields[] = 'razonSocialTransportista';
                }
                if (empty($_POST["idtipoDocumentoChofer"])) {
                    $missingFields[] = 'idtipoDocumentoChofer';
                }
                if (empty($_POST["documentoChofer"])) {
                    $missingFields[] = 'documentoChofer';
                }
                if (empty($_POST["licenciaChofer"])) {
                    $missingFields[] = 'licenciaChofer';
                }
                if (empty($_POST["nombreChofer"])) {
                    $missingFields[] = 'nombreChofer';
                }
                if (empty($_POST["apellidoChofer"])) {
                    $missingFields[] = 'apellidoChofer';
                }
                if (empty($_POST["placaVehiculo"])) {
                    $missingFields[] = 'placaVehiculo';
                }
                $updateGuia = [
                    'idtipoTransportista' => $_POST["inputTipoTransportista"],
                    'rucTransportista' => $_POST["rucTransportista"],
                    'razonSocialTransportista' => $_POST["razonSocialTransportista"],
                    'idtipoDocumentoChofer' => $_POST["idtipoDocumentoChofer"],
                    'documentoChofer' => $_POST["documentoChofer"],
                    'licenciaChofer' => $_POST["licenciaChofer"],
                    'nombreChofer' => $_POST["nombreChofer"],
                    'apellidoChofer' => $_POST["apellidoChofer"],
                    'placaVehiculo' => $_POST["placaVehiculo"]
                ];
            }

            // Verificamos si faltan campos obligatorios
            if (count($missingFields) > 0) {
                throw new \Exception('Faltan los siguientes campos: ' . implode(', ', $missingFields));
            }

            // Actualización en la base de datos
            $updt = $guiaModel->UpdateGuiaRemision($filtroUpdate, $updateGuia);

            if (!$updt) {
                throw new \Exception('No se logró almacenar el transportista');
            }

            // Sitodo fue bien, commit de la transacción
            $db->transCommit();

            // Respuesta de éxito
            $send = [
                'status' => 'success',
                'title' => 'Registro Correcto',
                'message' => 'Se ingresó correctamente el transportista',
            ];

        } catch (\Exception $e) {
            // Si ocurre un error, hacemos rollback de la transacción
            $db->transRollback();

            // Respuesta de error
            $send = [
                'status' => 'danger',
                'title' => 'Error Registro',
                'message' => 'Se registró un error: ' . $e->getMessage(),
            ];
        }

        echo json_encode($send);
        exit();
    }

    public function SaveDestino()
    {
        $guiaRemision=New GuiaModel();
        $idtipoDestino=$_POST["tipoDestino"];
        $filtroGuia=[
            'idguiaRemision'=>$_POST["idguiaRemision"]
        ];
        $updateDestino=[];
        if($idtipoDestino==1){
            $updateDestino+=[
                'idestablecimientoFisicoDestino'=>$_POST["establecimientoAnexo"]
            ];
        }else if($idtipoDestino==2){
            $updateDestino+=[
                'rucTerceroDestino'=>$_POST["rucTercero"],
                'ubigeoDepartamentoDestino'=>$_POST["departamentoDestino"],
                'ubigeoProvinciaDestino'=>$_POST["provinciaDestino"],
                'ubigeoDistritoDestino'=>$_POST["distritoDestino"],
                'direccionDestino'=>$_POST["direccionDestino"]
            ];
        }else if($idtipoDestino==3){
            $updateDestino+=[
                'ubigeoDepartamentoDestino'=>$_POST["departamentoDestino"],
                'ubigeoProvinciaDestino'=>$_POST["provinciaDestino"],
                'ubigeoDistritoDestino'=>$_POST["distritoDestino"],
                'direccionDestino'=>$_POST["direccionDestino"]
            ];
        }

        $up=$guiaRemision->UpdateGuiaRemision($filtroGuia,$updateDestino);

        $datos=[
            'viewGuia'=>$guiaRemision->ViewGuiaOrigenDestino($filtroGuia)
        ];

        if($up){
            $send=[
                'status'=>'success',
                'title'=>'Registro Correcto',
                'tipoOrigen'=>$idtipoDestino,
                'message'=>'Se ingreso correctamente el destino de la Guia de Remision',
                'info'=>view("Traslado/GuiasTraslados/ViewDestino/Index",$datos)
            ];
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error en Almacenado',
                'message'=>'No se logro actualizar el destino de la guia de remision',
            ];
        }

        echo json_encode($send);
        exit();
    }

    public function SaveOrigen()
    {
        $guiaRemision=New GuiaModel();
        $idtipoOrigen=$_POST["tipoOrigen"];
        $filtroGuia=[
            'idguiaRemision'=>$_POST["idguiaRemision"]
        ];
        $updateOrigen=[];
        if($idtipoOrigen==1){
            $updateOrigen+=[
                'idestablecimientoFisicoOrigen'=>$_POST["establecimientoAnexo"]
            ];
        }else if($idtipoOrigen==2){
            $updateOrigen+=[
                'rucTerceroOrigen'=>$_POST["rucTercero"],
                'ubigeoDepartamentoOrigen'=>$_POST["departamentoOrigen"],
                'ubigeoProvinciaOrigen'=>$_POST["provinciaOrigen"],
                'ubigeoDistritoOrigen'=>$_POST["distritoOrigen"],
                'direccionOrigen'=>$_POST["direccionOrigen"]
            ];
        }else if($idtipoOrigen==3){
            $updateOrigen+=[
                'ubigeoDepartamentoOrigen'=>$_POST["departamentoOrigen"],
                'ubigeoProvinciaOrigen'=>$_POST["provinciaOrigen"],
                'ubigeoDistritoOrigen'=>$_POST["distritoOrigen"],
                'direccionOrigen'=>$_POST["direccionOrigen"]
            ];
        }

        $up=$guiaRemision->UpdateGuiaRemision($filtroGuia,$updateOrigen);

        $datos=[
            'viewGuia'=>$guiaRemision->ViewGuiaOrigenDestino($filtroGuia)
        ];

        if($up){
            $send=[
                'status'=>'success',
                'title'=>'Registro Correcto',
                'tipoOrigen'=>$idtipoOrigen,
                'message'=>'Se ingreso correctamente el origen de la Guia de Remision',
                'info'=>view("Traslado/GuiasTraslados/ViewOrigen/Index",$datos)
            ];
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error en Almacenado',
                'message'=>'No se logro actualizar el origen de la guia de remision',
            ];
        }

        echo json_encode($send);
        exit();

    }

    public function SaveDestinatario()
    {
        $guiaRemision = New GuiaModel();

        $filtroGuia=[
            'idguiaRemision'=>$_POST["idguiaRemision"]
        ];

        $destinatario=[
            'idtipoDocumentoDestinatario'=>$_POST["tipoDocumentoDestinatario"],
            'razonSocialDestinatario'=>$_POST["documentoDestinatario"],
            'rucDestinatario'=>$_POST["nombreDestinatario"]
        ];

        $dest=$guiaRemision->StorageDestinatario($filtroGuia,$destinatario);
        $principal='';
        if($dest!=''){
            $principal.='<tr><td class="ps-3">
                                <input hidden nane="documentoDestinatario" value="'.$_POST["documentoDestinatario"].'">
                                <input hidden nane="nombreDestinatario" value="'.$_POST["nombreDestinatario"].'">'.$_POST["documentoDestinatario"].'</td>
                            <td class="ps-3">'.$_POST["nombreDestinatario"].'</td></tr>';

            $send=[
                'status'=>'success',
                'title'=>'Ingreso Correcto',
                'message'=>'Se ingreso correctamente el destinatario',
                'info'=>$principal,
                'button'=>'disabled'
            ];
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Proceso Errado',
                'message'=>'no se logro actualizar el destinatario',
            ];
        }
        echo json_encode($send);
        exit();
    }

    public function DeleteVinGuia()
    {
        $guiaModel=New GuiaModel();
        $iddetalleGuia=$_POST["iddetalleGuiaRemision"];
        $idguiaRemision=$_POST["idguiaRemisionVin"];

        $filtro=[
            'iddetalleGuiaRemision'=>$iddetalleGuia
        ];

        $exec=$guiaModel->DeleteVinGuia($filtro);

        if($exec){
            $send=[
                'status'=>'success',
                'title'=>'Eliminado Correctamente',
                'idguiaRemision'=>$idguiaRemision,
                'message'=>'El vin relacionado se elimino correctamente de la guia'
            ];
            echo json_encode($send);
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error en Proceso',
                'message'=>'Ocurrio un error comuniquese con Sistemas'
            ];
            echo json_encode($send);
            exit();
        }
    }
    public function DestroyDocumentoRelacionado()
    {
        $guiaRemisonModel=New GuiaModel();

        $filtro=[
            'iddocumentoRelacionadoGuia'=>$_POST["iddocumentoRelacionadoGuia"]
        ];

        $destr=$guiaRemisonModel->DestroyDocumentoRelacionadoGuia($filtro);

        if($destr){
            $send=[
                'status'=>'success',
                'title'=>'Eliminado Correctamente',
                'message'=>'El documento relacionado se elimino correctamente de la guia'
            ];

            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error en Proceso',
                'message'=>'Ocurrio un error comuniquese con Sistemas'
            ];

            echo json_encode($send);
            exit();
        }
    }

    public function ValidarProceso()
    {
        $guiaModel=New GuiaModel();
        $idestadoGuia=$_POST["idestadoGuia"];
        $idguiaRemision=$_POST["idguiaRemision"];

        if($idestadoGuia==3){
            $send=[
                'idestadoGuia'=>4,
                'idguiaRemision'=>$idguiaRemision,
                'status'=>'success',
                'title'=>'Proceso Correcto',
                'message'=>'El Proceso de Documentos relacionados es correcto'
            ];

            echo json_encode($send);
            exit();
        }else if($idestadoGuia==4){
            $filtro=[
                'idguiaRemision'=>$idguiaRemision
            ];
            $detail=$guiaModel->DetailVinGuia($filtro);

            $camposVacios = [];
            if (empty($_POST["unidadMedidaGuia"])) {
                $camposVacios[] = 'Unidad de Medida de Peso';
            }
            if (empty($_POST["pesoGuia"])) {
                $camposVacios[] = 'Peso Bruto Total';
            }

            if(!empty($detail) && count($camposVacios)==0){
                $updateGuia=[
                    'idunidadMedidaPeso'=>$_POST["unidadMedidaGuia"],
                    'pesoBrutoTotal'=>$_POST["pesoGuia"]
                ];
                $up=$guiaModel->UpdateGuiaRemision($filtro,$updateGuia);

                $send=[
                    'idestadoGuia'=>5,
                    'idguiaRemision'=>$idguiaRemision,
                    'status'=>'success',
                    'title'=>'Proceso Correcto',
                    'message'=>'El Proceso de Bienes se registro correctamente'
                ];
                echo json_encode($send);
                exit();
            }else{

                if(empty($detail)){
                    $camposVacios[] = 'Sin Vin en Sistema';
                }

                $send=[
                    'idestadoGuia'=>4,
                    'idguiaRemision'=>$idguiaRemision,
                    'status'=>'danger',
                    'title'=>'Campos requeridos Vacios',
                    'message' => 'Los siguientes campos están vacíos: ' . implode(', ', $camposVacios)
                ];
                echo json_encode($send);
                exit();
            }

        }
    }
    public function SaveDatosEmision_old()
    {
        $guiaModel=New GuiaModel();
        $controladorViewGuia=New CreateViewEdit();


        $guiaRemision=[
            'idempresa'=>$_POST["empresa"],
            'idmotivoTrasladoGuia'=>$_POST["motivoTraslado"],
            'idusuario'=>session("idusuario")
        ];

        $result='';
        $idestadoGuia='';
        if($_POST["motivoTraslado"]==4){
            $active='active_docrel';
            $guiaRemision+=[
                'idestadoGuia'=>3,
            ];
            $idestadoGuia=3;
        }else{
            $active='actores';
            $guiaRemision+=[
                'idestadoGuia'=>2,
            ];
            $idestadoGuia=2;
        }

        $idguiaRemision=$guiaModel->StorageGuia($guiaRemision);


        $send=[
            'status'=>'success',
            'title'=>'Operacion correcta',
            'message'=>'Ingrese los Actores de la Guia',
            'idguiaRemision'=>$idguiaRemision,
            'idestadoGuia'=>$idestadoGuia,
            'active'=>$active,
        ];

        echo json_encode($send);
        exit();
    }

    public function SaveTipoDocumentoRelacionado()
    {
        $guiaModel=New GuiaModel();

        $tipoDocumentoRel=[
            'idguiaRemision'=>$_POST["idguiaRemisionDocumentoRel"],
            'idtipoDocumentoRelacionadoGuia'=>$_POST["tipoDocumentoRelacionadoGuia"],
            'numeroDocumento'=>$_POST["numeroDocumentoRelacionado"]
        ];
        $idtipoDocumento=$guiaModel->StorageDocumentoRelacionado($tipoDocumentoRel);

        if($idtipoDocumento!=''){
            $send=[
                'status'=>'success',
                'title'=>'Se Almaceno correctamente',
                'message'=>'Se agrego correctamente el tipo de documento'
            ];

            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'Error de almacenado',
                'message'=>'No se logro almacenar el tipo de documento'
            ];
            echo json_encode($send);
            exit();
        }
    }
}