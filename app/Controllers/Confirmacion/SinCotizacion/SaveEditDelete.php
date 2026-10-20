<?php
namespace App\Controllers\Confirmacion\SinCotizacion;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\EventoModel;
use App\Models\VinModel;

class SaveEditDelete extends BaseController
{
    public function ValidarCotizacion()
    {
        $alistamientoVehicular=New AlistamientoVehicularModel();
        $vin=isset($_POST["vin"])?$_POST["vin"]:$_GET["vin"];
        $numeroPedido=isset($_POST["numeroPedido"])?$_POST["numeroPedido"]:$_GET["numeroPedido"];
        $infoGen=$alistamientoVehicular->ViewVin($vin);
        $idvin=$infoGen[0]["idvin"];
        $documentoCliente=$infoGen[0]["documentoCliente"];
        $ruta='';
        if(session('database')==='logistica_colombia'){
          //  $ruta="https://pdicontrol.autoniza.net.pe:5443/sincronizaColombia/UpdatePedido.php";
            $ruta="https://api.autoniza.net.pe/sincronizaColombia/UpdatePedido.php";
        }else if(session('database')==='logistica_peru'){
            if(($infoGen[0]["marca"]=='CHEVROLET') || ($infoGen[0]["marca"]=='ISUZU')){
                if($infoGen[0]["fechaFactura"]>='2025-04-01'){
                    $ruta="https://api.autoniza.net.pe/coreSapAutonizaSac/UpdatePedido.php";
                }else{
                    $ruta="https://api.autoniza.net.pe/coreConcar/UpdatePedido.php";
                }
            }else{
                $ruta="https://api.autoniza.net.pe/coreSap/UpdatePedido.php";
            }
        }

        $data = array(
            "vin"	=> $vin,
            "idvin"=>$idvin,
            "numeroPedido"=>$numeroPedido,
            'documentoCliente'=>$documentoCliente
        );
        $data_json = json_encode($data);
// Ejemplo para JSON
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $ruta);
        curl_setopt(
            $ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
            )
        );
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//obtiene la data en Json.
        $respuesta  = curl_exec($ch);
        $respu=json_decode($respuesta);



        if($respu->status=='success'){
            $dato=[
                'status'=>$respu->status,
                'title'=>$respu->title,
                'message'=>$respu->message,
                'equipamiento'=>$respu->equipamiento,
                'gps'=>$respu->gps,
                'gas'=>$respu->gas,
                'modeloGas'=>$respu->modeloGas,
                'equipamientoActual'=>$alistamientoVehicular->EquipamientoVin($vin)
            ];

            $dats=[
                'status'=>$respu->status,
                'title'=>$respu->title,
                'message'=>$respu->message,
                'panel'=>view("Confirmacion/SinCotizacion/PanelEquipamiento/Index",$dato).view("Confirmacion/SinCotizacion/PanelEquipamiento/Scripts")
            ];
            echo json_encode($dats);
            exit();
        }else{
            $dato=[
                'status'=>$respu->status,
                'title'=>$respu->title,
                'message'=>$respu->message,
            ];
            $dats=[
                'status'=>$respu->status,
                'title'=>$respu->title,
                'message'=>$respu->message,
              //  'numeroPedidoSAP'=>$respu->numeroPedidoSAP,
               // 'numeroPedidoGestyx'=>$respu->numeroPedidoGestyx,
                'panel'=>view("Confirmacion/SinCotizacion/PanelEquipamiento/Index",$dato).view("Confirmacion/SinCotizacion/PanelEquipamiento/Scripts")
            ];
            echo json_encode($dats);
            exit();
        }
    }


    public function UpdateHojaNegocio()
    {
        $alistamientoVehicular=New AlistamientoVehicularModel();
        $vin=$_POST["vinPedido"];
        $estadoCotizacion=$_POST["estadoCotizacion"];
        $fechaAplicacion=$_POST["fechaAplicaCotiza"];
        $infoGen=$alistamientoVehicular->ViewVin($vin);
        $gps=$infoGen[0]["gps"];
        $gas=$infoGen[0]["gas"];
        $idvin=$infoGen[0]["idvin"];
        $numeroPedido=$infoGen[0]["numeroPedido"];

        $filtroVin=[
            'vin'=>$vin,
            'idvin'=>$idvin
        ];

        $update=[
            'gps'=>($gps==1)?1:null,
            'gas'=>($gas==1)?1:null,
        ];

        $updVin=$alistamientoVehicular->UpdateVinAccesorio($filtroVin,$update);

        if($updVin){
            $countDet=0;
            if(isset($_POST["codigoEquipamiento"])) {
                while ($countDet < count($_POST["codigoEquipamiento"])) {
                    $codigoEquipamiento = $_POST["codigoEquipamiento"][$countDet];
                    $accion = $_POST["accionEquipamiento"][$countDet];

                    if ($accion == 'Update') {
                        $filtroUpEqui = [
                            'codigoEquipamiento' => $codigoEquipamiento,
                            'vin' => $vin,
                            'idvin' => $idvin
                        ];
                        $equip = [
                            'cantidad' => $_POST["cantidad"][$countDet],
                            'equipamiento' => $_POST["equipamiento"][$countDet],
                            'precioTotal' => $_POST["precioTotal"][$countDet],
                            'subTotal' => $_POST["subTotal"][$countDet],
                            'igv' => $_POST["igv"][$countDet],
                            'tipoFacturacionEquipamiento' => $_POST["tipoFacturacionEquipamiento"][$countDet]
                        ];
                        $updateEquipa = $alistamientoVehicular->UpdateEquipamiento($filtroUpEqui, $equip);
                    } else if ($accion == 'Delete') {
                        $filtroDeletEqui = [
                            'codigoEquipamiento' => $codigoEquipamiento,
                            'vin' => $vin,
                            'idvin' => $idvin
                        ];
                        $delt = $alistamientoVehicular->DeleteEquipamiento($filtroDeletEqui);
                    } else if ($accion == 'Add') {

                        $equipamientoAdd = [
                            'idvin' => $idvin,
                            'vin' => $vin,
                            'equipamiento' => $_POST["equipamiento"][$countDet],
                            'cantidad' => $_POST["cantidad"][$countDet],
                            'idestadoEquipamiento' => $_POST["idestadoEquipamiento"][$countDet],
                            'codigoEquipamiento' => $codigoEquipamiento,
                            'idtipoEquipamiento' => $_POST["idtipoEquipamiento"][$countDet],
                            'precioTotal' => $_POST["precioTotal"][$countDet],
                            'subTotal' => $_POST["subTotal"][$countDet],
                            'igv' => $_POST["igv"][$countDet],
                            'tipoFacturacionEquipamiento' => $_POST["tipoFacturacionEquipamiento"][$countDet]
                        ];

                        $idequipamiento = $alistamientoVehicular->EquipamientoAdd($equipamientoAdd);
                    }
                    $countDet = $countDet + 1;
                }
            }
            $dato=[
                'status'=>'success',
                'title'=>'Actualizacion Correcta',
                'message'=>'Se Actualizo correctamente el Vin'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error de Datos',
                'message'=>'No se logro actualizar los datos'
            ];
            echo json_encode($dato);
            exit();
        }
    }

    public function SaveConfirmacionCoti()
    {
        $alistamientoVehicular=New AlistamientoVehicularModel();
        $vin=$_POST["vinPedido"];
        $estadoCotizacion=$_POST["estadoCotizacion"];
        $fechaAplicacion=$_POST["fechaAplicaCotiza"];
        $infoGen=$alistamientoVehicular->ViewVin($vin);
        $gps=$infoGen[0]["gps"];
        $gas=$infoGen[0]["gas"];
        $idvin=$infoGen[0]["idvin"];
        $numeroPedido=$infoGen[0]["numeroPedido"];

        $filtroVin=[
            'vin'=>$vin,
            'idvin'=>$idvin
        ];

        $update=[
            'gps'=>($gps==1)?1:null,
            'gas'=>($gas==1)?1:null,
            'fechaCotizacion'=>$_POST["fechaAplicaCotiza"],
            'idusuarioCotizacion'=>session("idusuario"),
            'cotizacion'=>1
        ];

        $updVin=$alistamientoVehicular->UpdateVinAccesorio($filtroVin,$update);

        if($updVin){
            $countDet=0;
            if(isset($_POST["codigoEquipamiento"])) {
                while ($countDet < count($_POST["codigoEquipamiento"])) {
                    $codigoEquipamiento = $_POST["codigoEquipamiento"][$countDet];
                    $accion = $_POST["accionEquipamiento"][$countDet];

                    if ($accion == 'Update') {
                        $filtroUpEqui = [
                            'codigoEquipamiento' => $codigoEquipamiento,
                            'vin' => $vin,
                            'idvin' => $idvin
                        ];
                        $equip = [
                            'cantidad' => $_POST["cantidad"][$countDet],
                            'equipamiento' => $_POST["equipamiento"][$countDet],
                            'precioTotal' => $_POST["precioTotal"][$countDet],
                            'subTotal' => $_POST["subTotal"][$countDet],
                            'igv' => $_POST["igv"][$countDet],
                            'tipoFacturacionEquipamiento' => $_POST["tipoFacturacionEquipamiento"][$countDet]
                        ];
                        $updateEquipa = $alistamientoVehicular->UpdateEquipamiento($filtroUpEqui, $equip);
                    } else if ($accion == 'Delete') {
                        $filtroDeletEqui = [
                            'codigoEquipamiento' => $codigoEquipamiento,
                            'vin' => $vin,
                            'idvin' => $idvin
                        ];
                        $delt = $alistamientoVehicular->DeleteEquipamiento($filtroDeletEqui);
                    } else if ($accion == 'Add') {

                        $equipamientoAdd = [
                            'idvin' => $idvin,
                            'vin' => $vin,
                            'equipamiento' => $_POST["equipamiento"][$countDet],
                            'cantidad' => $_POST["cantidad"][$countDet],
                            'idestadoEquipamiento' => $_POST["idestadoEquipamiento"][$countDet],
                            'codigoEquipamiento' => $codigoEquipamiento,
                            'idtipoEquipamiento' => $_POST["idtipoEquipamiento"][$countDet],
                            'precioTotal' => $_POST["precioTotal"][$countDet],
                            'subTotal' => $_POST["subTotal"][$countDet],
                            'igv' => $_POST["igv"][$countDet],
                            'tipoFacturacionEquipamiento' => $_POST["tipoFacturacionEquipamiento"][$countDet]
                        ];

                        $idequipamiento = $alistamientoVehicular->EquipamientoAdd($equipamientoAdd);
                    }
                    $countDet = $countDet + 1;
                }
            }
            $dato=[
                'status'=>'success',
                'title'=>'Actualizacion Correcta',
                'message'=>'Se Actualizo correctamente el Vin'
            ];
            echo json_encode($dato);
            exit();
        }else{
            $dato=[
                'status'=>'danger',
                'title'=>'Error de Datos',
                'message'=>'No se logro actualizar los datos'
            ];
            echo json_encode($dato);
            exit();
        }
    }
}