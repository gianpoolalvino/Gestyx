<?php

namespace App\Controllers\Traslado\GuiasTraslados;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\GeneralesModel;
use App\Models\GuiaModel;
use App\Models\InventarioModel;
use App\Models\TrasladoModel;
use App\Models\VinModel;


class CreateViewEdit extends BaseController
{
    public function ChangeEmpresa()
    {
        $guiaModel=New GuiaModel();

        $idguiaRemision=$_POST["idguiaRemision"];

        $filtroGuia=[
            'idguiaRemision'=>$idguiaRemision
        ];

        $emp=$guiaModel->SelectEmpresa(["idempresa"=>$_POST["idempresa"]]);

        $updateGuia=[
            'idestadoGuia'=>1,
            'idtipoDestinatario'=>1,
            'idtipoOrigen'=>1,
            'idtipoDestino'=>1,
            'serie'=>null,
            'idempresa'=>$emp[0]["idempresa"],
            'numero'=>null,
            'idmotivoTrasladoGuia'=>null,
            'idprocesoGuia'=>null,
            'razonSocialDestinatario'=>$emp[0]["descripcion"],
            'rucDestinatario'=>$emp[0]["documento"],
            'direccionDestinatario'=>null,
            'idtipoDocumentoDestinatario'=>3,
            'idestablecimientoFisicoOrigen'=>null,
            'idestablecimientoFisicoDestino'=>null,
            'ubigeoDepartamentoOrigen'=>null,
            'ubigeoProvinciaOrigen'=>null,
            'ubigeoDistritoOrigen'=>null,
            'direccionOrigen'=>null,
            'rucTerceroOrigen'=>null,
            'ubigeoDepartamentoDestino'=>null,
            'ubigeoProvinciaDestino'=>null,
            'ubigeoDistritoDestino'=>null,
            'direccionDestino'=>null,
            'rucTerceroDestino'=>null,
            'idtipoTransportista'=>null,
            'rucTransportista'=>null,
            'razonSocialTransportista'=>null,
            'idtipoDocumentoChofer'=>null,
            'documentoChofer'=>null,
            'licenciaChofer'=>null,
            'nombreChofer'=>null,
            'apellidoChofer'=>null,
            'placaVehiculo'=>null
        ];

        $upg=$guiaModel->UpdateGuiaRemision($filtroGuia,$updateGuia);

        $deletVin=$guiaModel->DeleteVinGuia($filtroGuia);
        $deletDoc=$guiaModel->DestroyDocumentoRelacionadoGuia($filtroGuia);


        $datos=[
            'empresa'=>$guiaModel->Empresa(),
            'motivoTraslado'=>$guiaModel->MotivoTraslado(),
            'idguiaRemision'=>$idguiaRemision,
            'unidadMedida'=>$guiaModel->UnidadMedidaPesoBruto(),
            'idempresa'=>$_POST["idempresa"]
        ];

        $send=[
            'info'=>view("Traslado/GuiasTraslados/Create/Index",$datos).view("Traslado/GuiasTraslados/Create/Scripts"),
            'status'=>'success',
            'title'=>'Cambio de Empresa',
            'message'=>'Se realizo el cambio de empresa para la guia de remision',
        ];

        echo json_encode($send);
        exit();
    }



    public function Create()
    {
        $guiaModel=New GuiaModel();

        $guiasRem=$guiaModel->ViewGuia(["idusuario"=>session('idusuario'),'idestadoGuia'=>1]);

        foreach($guiasRem as $grm){
            $filtroGuia=[
                'idguiaRemision'=>$grm["idguiaRemision"]
            ];
            $deletVin=$guiaModel->DeleteVinGuia($filtroGuia);
            $deletDoc=$guiaModel->DestroyDocumentoRelacionadoGuia($filtroGuia);
        }


        $deleteGuias=$guiaModel->DestroyGuia(["idusuario"=>session('idusuario'),'idestadoGuia'=>1]);

        $guiaRemision=[
            'idestadoGuia'=>1,
            'idusuario'=>session("idusuario"),
            'idtipoDestinatario'=>1,
            'idtipoOrigen'=>1,
            'idtipoDestino'=>1,
        ];

        $idguiaRemision=$guiaModel->StorageGuia($guiaRemision);

        $datos=[
            'empresa'=>$guiaModel->Empresa(),
            'motivoTraslado'=>$guiaModel->MotivoTraslado(),
            'idguiaRemision'=>$idguiaRemision,
            'unidadMedida'=>$guiaModel->UnidadMedidaPesoBruto()
        ];

        $send=[
            'info'=>view("Traslado/GuiasTraslados/Create/Index",$datos).view("Traslado/GuiasTraslados/Create/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();
    }

    public function Actores()
    {
        $guiaModel=New GuiaModel();
        $idguiaRemision=$_POST["idguiaRemision"];

        $filtroGuia=[
            'idguiaRemision'=>$idguiaRemision
        ];

        $guiaR=$guiaModel->ViewGuia($filtroGuia);


        $filtro=[
            'idempresa'=>$_POST["idempresa"]
        ];
        $emp=$guiaModel->RazonSocial($filtro);

        if($guiaR[0]["idtipoDestinatario"]==1){
            $updateGuia=[
                'idtipoDestinatario'=>1,
                'idtipoDocumentoDestinatario'=>3,
                'rucDestinatario'=>$emp[0]["documento"],
                'razonSocialDestinatario'=>$emp[0]["descripcion"]
            ];
            $upg=$guiaModel->UpdateGuiaRemision($filtroGuia,$updateGuia);
        }

        $dato=[
            'guiaRem'=>$guiaModel->ViewGuia($filtroGuia),
            'idguiaRemision'=>$idguiaRemision,
            'idempresa'=>$_POST["idempresa"]
        ];

        $send=[
            'info'=>view("Traslado/GuiasTraslados/Actores/Index/Index",$dato).view("Traslado/GuiasTraslados/Actores/Index/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);

    }

    public function Distrito()
    {
        $guiaRemision=New GuiaModel();

        $filtroPro=[
            'codigoUbigeoProvincia'=>$_POST["ubigeoProvincia"]
        ];

        $distrito=$guiaRemision->Distrito($filtroPro);

        $principal='';

        $principal.='<option value="">Seleccione Distrito</option>';
        foreach($distrito as $dist){
            $principal.='<option value="'.$dist["codigoUbigeo"].'">'.$dist["descripcion"].'</option>';
        }

        $send=[
            'info'=>$principal,
            'status'=>'success'
        ];

        echo json_encode($send);

    }

    public function Provincia()
    {
        $guiaRemision=New GuiaModel();

        $filtroPro=[
            'codigoUbigeoDepartamento'=>$_POST["ubigeoDepartamento"]
        ];

        $provincia=$guiaRemision->Provincia($filtroPro);

        $principal='';

        $principal.='<option value="">Seleccione Provincia</option>';
            foreach($provincia as $pro){
                $principal.='<option value="'.$pro["codigoUbigeo"].'">'.$pro["descripcion"].'</option>';
            }


        $distrito='';
        $distrito.='<select class="form-control form-control-sm" id="distritoDir" name="distrito">';
        $distrito.='<option value="">Seleccione Distrito</option>';
        $distrito.='</select>';

        $send=[
            'info'=>$principal,
            'distrito'=>$distrito,
            'status'=>'success'
        ];

        echo json_encode($send);

    }

    public function ChangeOrigen()
    {
        $guiaModel=New GuiaModel();
        $departamento=$guiaModel->Departamento();
        $filtroEmp=[
            'idempresa'=>$_POST["idempresa"]
        ];
        $establecimientos=$guiaModel->EstablecimientoEmpresa($filtroEmp);
        $tipoOrigen=$_POST["tipoOrigen"];
        $principal='';

        $filtroGuia=[
            'idguiaRemision'=>$_POST["idguiaRemision"],
        ];

        $updGuia=[
            'idtipoOrigen'=>$_POST["tipoOrigen"]
        ];

        $up=$guiaModel->UpdateGuiaRemision($filtroGuia,$updGuia);

        if($tipoOrigen==1){
                foreach($establecimientos as $est) {
                    $principal .= '<tr>';
                    $principal .= '<td class="ps-3" style="vertical-align: middle">';
                    $principal .= '<div class="form-check">';
                    $principal .= '<input class="form-check-input checkEstablecimientoAnexo" value="' . $est["idestablecimientoFisico"] . '" id="flexEstable' . $est["idestablecimientoFisico"] . '" type="radio" name="checkEstablecimiento">';
                    $principal .= '<label class="form-check-label" for="flexEstable' . $est["idestablecimientoFisico"] . '">' . $est["codigo"] . '</label>';
                    $principal .= '</div>';
                    $principal .= '</td>';
                    $principal .= '<td class="ps-3" style="vertical-align: middle">' . $est["tipoEstablecimiento"] . '</td>';
                    $principal .= '<td class="ps-3" style="vertical-align: middle">' . $est["codigoUbigeoDistrito"] . '</td>';
                    $principal .= '<td class="ps-3" style="vertical-align: middle">' . $est["direccion"] . '</td>';
                    $principal .= '</tr>';
                    $principal .= '</tr>';
                }
        }else{
            $principal.='<tr>';
            $principal.='<td>';
            $principal.='<select class="form-control" id="departamentoOrigen" required name="departamentoOrigen">';
                    $principal.='<option value="">Seleccione Departamento</option>';
                    foreach($departamento as $dep){
                        $principal.='<option value="'.$dep["codigoUbigeo"].'">'.$dep["descripcion"].'</option>';
                    }
            $principal.='</select>';
            $principal.='</td>';
            $principal.='<td>';
            $principal.='<select class="form-control" id="provinciaOrigen" required name="provinciaOrigen">';
            $principal.='<option value="">Seleccione Provincia</option>';
            $principal.='</select>';
            $principal.='</td>';
            $principal.='<td>';
            $principal.='<select class="form-control" id="distritoOrigen" required name="distritoOrigen">';
            $principal.='<option value="">Seleccione Distrito</option>';
            $principal.='</select>';
            $principal.='</td>';
            $principal.='<td>';
            $principal.='<div class="input-group"><input required class="form-control form-control-sm" id="direccionOrigen" name="direccionOrigen"><div class="input-group-prepend"><button type="button" id="btnSaveOrigT" class="btn btn-light btn-sm">Guardar</button></div></div>';
            $principal.='</tr>';
        }

        $send=[
            'status'=>'success',
            'info'=>$principal,
            'tipoOrigen'=>$tipoOrigen,
            'button'=>'false',
        ];

        echo json_encode($send);
        exit();
    }

    public function CreateTransportista()
    {
        $guiaModel=New GuiaModel();

        $filtroGuia=[
            'idguiaRemision'=>$_POST["idguiaRemision"],
        ];

        $dato=[
            'tipoDocumento'=>$guiaModel->TipoDocumentoChofer(),
            'idguiaRemision'=>$_POST["idguiaRemision"],
            'guiaRem'=>$guiaModel->ViewGuia($filtroGuia),
        ];

        $send=[
            'info'=>view("Traslado/GuiasTraslados/CreateTransportista/Index",$dato).view("Traslado/GuiasTraslados/CreateTransportista/Scripts",$dato)
        ];

        echo json_encode($send);
        exit();
    }

    public function ChangeTransportista()
    {
        $guiaModel=New GuiaModel();
        $idtipoTransportista=$_POST["idtipoTransportista"];

        $dato=[
            'idtipoTransportista'=>$idtipoTransportista,
            'tipoDocumento'=>$guiaModel->TipoDocumentoChofer(),
            'idguiaRemision'=>$_POST["idguiaRemision"],
            'emp'=>$guiaModel->Empresa(),
        ];

        $send=[
            'info'=>view("Traslado/GuiasTraslados/TipoTransportista/Index",$dato).view("Traslado/GuiasTraslados/TipoTransportista/Scripts",$dato)
        ];

        echo json_encode($send);
        exit();
    }

    public function ChangeDestino()
    {
        $guiaModel=New GuiaModel();
        $departamento=$guiaModel->Departamento();
        $filtroEmp=[
            'idempresa'=>$_POST["idempresa"]
        ];
        $establecimientos=$guiaModel->EstablecimientoEmpresa($filtroEmp);
        $tipoDestino=$_POST["tipoDestino"];
        $principal='';

        $filtroGuia=[
            'idguiaRemision'=>$_POST["idguiaRemision"],
        ];

        $updGuia=[
            'idtipoDestino'=>$_POST["tipoDestino"]
        ];

        $up=$guiaModel->UpdateGuiaRemision($filtroGuia,$updGuia);

        if($tipoDestino==1){
            foreach($establecimientos as $est) {
                $principal .= '<tr>';
                $principal .= '<td class="ps-3" style="vertical-align: middle">';
                $principal .= '<div class="form-check">';
                $principal .= '<input class="form-check-input checkEstablecimientoAnexoDest" value="' . $est["idestablecimientoFisico"] . '" id="flexEstableDest' . $est["idestablecimientoFisico"] . '" type="radio" name="checkEstablecimientoDest">';
                $principal .= '<label class="form-check-label" for="flexEstableDest' . $est["idestablecimientoFisico"] . '">' . $est["codigo"] . '</label>';
                $principal .= '</div>';
                $principal .= '</td>';
                $principal .= '<td class="ps-3" style="vertical-align: middle">' . $est["tipoEstablecimiento"] . '</td>';
                $principal .= '<td class="ps-3" style="vertical-align: middle">' . $est["codigoUbigeoDistrito"] . '</td>';
                $principal .= '<td class="ps-3" style="vertical-align: middle">' . $est["direccion"] . '</td>';
                $principal .= '</tr>';
                $principal .= '</tr>';
            }
        }else{
            $principal.='<tr>';
            $principal.='<td>';
            $principal.='<select class="form-control" id="departamentoDestino" required name="departamentoDestino">';
            $principal.='<option value="">Seleccione Departamento</option>';
            foreach($departamento as $dep){
                $principal.='<option value="'.$dep["codigoUbigeo"].'">'.$dep["descripcion"].'</option>';
            }
            $principal.='</select>';
            $principal.='</td>';
            $principal.='<td>';
            $principal.='<select class="form-control" id="provinciaDestino" required name="provinciaDestino">';
            $principal.='<option value="">Seleccione Provincia</option>';
            $principal.='</select>';
            $principal.='</td>';
            $principal.='<td>';
            $principal.='<select class="form-control" id="distritoDestino" required name="distritoDestino">';
            $principal.='<option value="">Seleccione Distrito</option>';
            $principal.='</select>';
            $principal.='</td>';
            $principal.='<td>';
            $principal.='<div class="input-group"><input required class="form-control form-control-sm" id="direccionDestino" name="direccionDestino"><div class="input-group-prepend"><button type="button" id="btnSaveDestT" class="btn btn-light btn-sm">Guardar</button></div></div>';
            $principal.='</tr>';
        }

        $send=[
            'status'=>'success',
            'info'=>$principal,
            'tipoDestino'=>$tipoDestino,
            'button'=>'false',
        ];

        echo json_encode($send);
        exit();
    }
    public function OrigenGuia()
    {
        $guiaRemision=New GuiaModel();
        $idguiaRemision=$_POST["idguiaRemision"];
        $idempresa=$_POST["idempresa"];

        $filtroGuia=[
            'idguiaRemision'=>$idguiaRemision
        ];

        $filtroEmp=[
            'idempresa'=>$idempresa
        ];

        $viewG=$guiaRemision->ViewGuia($filtroGuia);

        $dato=[
            'departamento'=>$guiaRemision->Departamento(),
            'provincia'=>$guiaRemision->Provincia(['codigoUbigeoDepartamento'=>$viewG[0]["ubigeoDepartamentoOrigen"]]),
            'distrito'=>$guiaRemision->Distrito(['codigoUbigeoProvincia'=>$viewG[0]["ubigeoProvinciaOrigen"]]),
            'guiaRem'=>$viewG,
            'establecimientos'=>$guiaRemision->EstablecimientoEmpresa($filtroEmp),
            'idguiaRemision'=>$idguiaRemision,
            'idempresa'=>$idempresa
        ];

        $send=[
            'info'=>view("Traslado/GuiasTraslados/Origen/Create/Index",$dato).view("Traslado/GuiasTraslados/Origen/Create/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();

    }
    public function DestinoGuia()
    {
        $guiaRemision=New GuiaModel();
        $idguiaRemision=$_POST["idguiaRemision"];
        $idempresa=$_POST["idempresa"];

        $filtroGuia=[
            'idguiaRemision'=>$idguiaRemision
        ];

        $filtroEmp=[
            'idempresa'=>$idempresa
        ];

        $viewG=$guiaRemision->ViewGuia($filtroGuia);

        $dato=[
            'departamento'=>$guiaRemision->Departamento(),
            'provincia'=>$guiaRemision->Provincia(['codigoUbigeoDepartamento'=>$viewG[0]["ubigeoDepartamentoDestino"]]),
            'distrito'=>$guiaRemision->Distrito(['codigoUbigeoProvincia'=>$viewG[0]["ubigeoProvinciaDestino"]]),
            'guiaRem'=>$viewG,
            'establecimientos'=>$guiaRemision->EstablecimientoEmpresa($filtroEmp),
            'idguiaRemision'=>$idguiaRemision,
            'idempresa'=>$idempresa
        ];

        $send=[
            'info'=>view("Traslado/GuiasTraslados/Destino/Create/Index",$dato).view("Traslado/GuiasTraslados/Destino/Create/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();

    }

    public function ChangeDestinatario()
    {
        $guiaModel=New GuiaModel();
        $principal='';
        $send=[];
        if($_POST["tipoDestinatario"]==1){
            $filtroEmp=[
                'idempresa'=>$_POST["idempresa"]
            ];
            $empresa=$guiaModel->RazonSocial($filtroEmp);
            $filtroGuia=[
                'idguiaRemision'=>$_POST["idguiaRemision"]
            ];
            $updateGuia=[
                'idtipoDestinatario'=>1,
                'idtipoDocumentoDestinatario'=>3,
                'rucDestinatario'=>$empresa[0]["documento"],
                'razonSocialDestinatario'=>$empresa[0]["descripcion"]
            ];

            $updt=$guiaModel->UpdateGuiaRemision($filtroGuia,$updateGuia);

            $principal.='<tr><td class="ps-3">
                                <input hidden nane="documentoDestinatario" value="'.$empresa[0]["documento"].'">
                                <input hidden nane="nombreDestinatario" value="'.$empresa[0]["descripcion"].'">'.$empresa[0]["documento"].'</td>
                            <td class="ps-3">'.$empresa[0]["descripcion"].'</td></tr>';
            $send=[
                'info'=>$principal,
                'tabla'=>'tableDestinatario',
                'button'=>'disabled'
            ];
        }else{
            $filtroEmp=[
                'idempresa'=>$_POST["idempresa"]
            ];
            $empresa=$guiaModel->RazonSocial($filtroEmp);
            $filtroGuia=[
                'idguiaRemision'=>$_POST["idguiaRemision"]
            ];
            $updateGuia=[
                'idtipoDestinatario'=>$_POST["tipoDestinatario"],
                'rucDestinatario'=>null,
                'razonSocialDestinatario'=>null
            ];

            $updt=$guiaModel->UpdateGuiaRemision($filtroGuia,$updateGuia);
            $principal.='<tr><td class="ps-3 text-center" colspan="2"></td></tr>';
            $send=[
                'info'=>$principal,
                'button'=>''
            ];
        }
        echo json_encode($send);
        exit();
    }

    public function CreateDestinatario()
    {
        $guiaRemision=New GuiaModel();
        $idguiaRemision=$_POST["idguiaRemision"];

        $dato=[
            'tipoDocumento'=>$guiaRemision->TipoDocumentiIdentidad(),
            'idguiaRemision'=>$idguiaRemision
        ];

        $send=[
            'info'=>view("Traslado/GuiasTraslados/Actores/Create/Index",$dato).view("Traslado/GuiasTraslados/Actores/Create/Scripts"),
            'status'=>'success'
        ];

        echo json_encode($send);
        exit();
    }

    public function CreateDocumentoRelacionado()
    {
        $guiaModel=New GuiaModel();
        $idguiaRemision=$_POST["idguiaRemision"];

        $dato=[
            'tipoDocumento'=>$guiaModel->TipoDocumentoRel(),
            'idguiaRemision'=>$idguiaRemision
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Traslado/GuiasTraslados/DocRelacionado/Create/Index",$dato).view("Traslado/GuiasTraslados/DocRelacionado/Create/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function DeleteDocRelacionado()
    {
        $dato=[
            'iddocumentoRelacionadoGuia'=>$_POST["iddocumentoRelacionadoGuia"]
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Traslado/GuiasTraslados/DocRelacionado/Delete/Index",$dato).view("Traslado/GuiasTraslados/DocRelacionado/Delete/Scripts")
        ];

        echo json_encode($send);
    }

    public function CreateVinGuia()
    {
        $guiaModel=New GuiaModel();
        $idguiaRemision=$_POST["idguiaRemision"];

        $filtroGuia=[
            'idguiaRemision'=>$idguiaRemision
        ];

        $viewGuia=$guiaModel->ViewGuia($filtroGuia);

        $filtro=[
            'idempresa'=>$_POST["idempresa"]
        ];

        $dato=[
            'idguiaRemision'=>$idguiaRemision,
            'selectVin'=>$guiaModel->VinDisponibleGuia($filtro)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Traslado/GuiasTraslados/BienesTransportar/Create/Index",$dato).view("Traslado/GuiasTraslados/BienesTransportar/Create/Scripts")
        ];

        echo json_encode($send);
    }

    public function ViewVinGuia()
    {
        $guiaModel=New GuiaModel();
        $vin=$_POST["vin"];

        $filtro=[
            'vin'=>$vin
        ];

        $dato=[
            'vinView'=>$guiaModel->VinDisponibleGuia($filtro)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Traslado/GuiasTraslados/BienesTransportar/PanelVin/Index",$dato).view("Traslado/GuiasTraslados/BienesTransportar/PanelVin/Scripts")
        ];

        echo json_encode($send);
    }

    public function DeleteVinGuia()
    {
        $dato=[
            'vin'=>$_POST["vin"],
            'iddetalleGuiaRemision'=>$_POST["iddetalleGuiaRemision"],
            'idguiaRemision'=>$_POST["idguiaRemision"]
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Traslado/GuiasTraslados/BienesTransportar/Delete/Index",$dato).view("Traslado/GuiasTraslados/BienesTransportar/Delete/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function DetailBienesTransportar()
    {
        $guiaModel=New GuiaModel();
        $idguiaRemision=$_POST["idguiaRemision"];

        $filtro=[
            'idguiaRemision'=>$idguiaRemision
        ];

        $dato=[
            'detailVin'=>$guiaModel->DetailVinGuia($filtro)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("Traslado/GuiasTraslados/BienesTransportar/DetailIndex/Index",$dato).view("Traslado/GuiasTraslados/BienesTransportar/DetailIndex/Scripts")
        ];

        echo json_encode($send);
    }

    public function BienesTransportar()
    {
        $vinModel=New VinModel();
        $guiaModel=New GuiaModel();
        $dato=[
            'idguiaRemision'=>$_POST["idguiaRemision"],
            'unidadMedida'=>$guiaModel->UnidadMedida()
        ];

        $send=[
            'info'=>view("Traslado/GuiasTraslados/BienesTransportar/Index/Index",$dato).view("Traslado/GuiasTraslados/BienesTransportar/Index/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($send);
        exit();

    }



    public function PartidaLlegada()
    {
        $guiaModel=New GuiaModel();
    }

    public function DetailDocRelacionado()
    {
        $guiaModel=New GuiaModel();
        $idguiaRemision=$_POST["idguiaRemision"];
        $filtro=[
            'idguiaRemision'=>$idguiaRemision
        ];

        $datos=[
            'docRelacionado'=>$guiaModel->DetailDocRelacionado($filtro)
        ];

        $send=[
            'info'=>view("Traslado/GuiasTraslados/DocRelacionado/DetailIndex/Index",$datos).view("Traslado/GuiasTraslados/DocRelacionado/DetailIndex/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($send);
        exit();
    }

    public function DocRelacionado()
    {
        $guiaModel=New GuiaModel();
        $idguiaRemision=$_POST["idguiaRemision"];
        $filtro=[
          'idguiaRemision'=>$idguiaRemision
        ];

        $datos=[
            'guiaRemision'=>$guiaModel->GuiaRemision($filtro),
            'idguiaRemision'=>$idguiaRemision,
            'docRelacionado'=>$guiaModel->DetailDocRelacionado($filtro)
        ];

        $send=[
            'info'=>view("Traslado/GuiasTraslados/DocRelacionado/Index/Index",$datos).view("Traslado/GuiasTraslados/DocRelacionado/Index/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($send);
        exit();
    }
}