<?php

namespace App\Controllers\ReportesGenerales;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AccessModel;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\AuditoriaVehicularModel;
use App\Models\ControlCalidadModel;
use App\Models\EventoModel;
use App\Models\GeneralesModel;
use App\Models\OpcionesGeneralesModel;
use App\Models\ReportesGeneralModel;
use App\Models\TrasladoModel;
use App\Models\VinModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class AuditoriaVehicular extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(4,60,''));


        if($access->status=='error'){
            $dato = [
                'idgrupoModulo' => '',
                'idmodulo' => '',
            ];
            echo view("Layouts/Head",$dato);
            echo view("ErrorAcceso/Index/Index");
            echo view("Layouts/Footer");
            echo view("ErrorAcceso/Index/Scripts");
            exit();
        }

        $dato = [
            'idgrupoModulo' => 4,
            'idmodulo' => 60,
        ];

        echo view("Layouts/Head", $dato);
        echo view("ReportesGenerales/AuditoriaVehicular/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("ReportesGenerales/AuditoriaVehicular/Index/Scripts");
    }

    public function AuditoriaEventos()
    {
        $auditoriaModel = new AuditoriaVehicularModel();

        $dato=[
            'eventos'=>$auditoriaModel->EventosGenerales($_POST["vin"])
        ];

        $send=[
            'info'=>view("ReportesGenerales/AuditoriaVehicular/Eventos/Index",$dato).view("ReportesGenerales/AuditoriaVehicular/Eventos/Scripts")
        ];

        echo json_encode($send);
        exit();
    }

    public function ViewVin()
    {
        $vinInfo=New VinModel();
        $auditoriaModel=New AuditoriaVehicularModel();
        $agendamientoVin=New AgendamientoModel();
        $trasladoVin=New TrasladoModel();
        $vin=$_POST['vin'];

        $filtro=[
            'vin'=>$vin
        ];

        $agend=$agendamientoVin->CitaEntregaVin($vin);
        $trasla=$auditoriaModel->DetailTrasladoAuditoria($filtro);
        $accesorios=$auditoriaModel->AccesoriosAuditoria($filtro);

        $dato=[
            'idgrupoModulo' => 4,
            'idmodulo' => 60,
            'vinInfo'=>$vinInfo->VinInfo($vin),
            'vin'=>$vin,
            'equipamiento'=>$accesorios,
            'estadoTraslado'=>$trasladoVin->EstadoTrasladoVin($vin),
            'eventos'=>$vinInfo->VinEventosRealizados($vin),
            'novedadesRecepcion'=>$auditoriaModel->VinNovedadRecepcion($vin),
            'novedadesIngreso'=>$auditoriaModel->VinNovedadIngreso($vin),
            'citaEntrega'=>$agend,
            'traslado'=>$trasla
        ];

        echo view("Layouts/Head",$dato);
        echo view("ReportesGenerales/AuditoriaVehicular/Result/Index",$dato);
        echo view("Layouts/Footer");
        echo view("ReportesGenerales/AuditoriaVehicular/Result/Scripts");
    }

    public function SelectVin()
    {
        $vinModel=New VinModel();
        $search=$_POST["query"];

        $selectVin=$vinModel->VinSelect($search);


        $principal='';
        foreach($selectVin as $sr){
            $principal.='<div class="result-item" data-vin="'.$sr["vin"].'">' .$sr['vin'].' - '.$sr["marca"].' - '.$sr["modelo"]. '</div>';
        }

        $send=[
            'info'=>$principal
        ];

        echo json_encode($send);
        exit();
    }

    public function ViewAuditoria()
    {
        $vinModel=New VinModel();
        $auditoriaModel=New AuditoriaVehicularModel();
        $vin=$_POST["vin"];
        $vinView=$vinModel->VinInfo($vin);

        $filtro=[
            'vin'=>$vin
        ];

        $tableEventoPro=$auditoriaModel->DetailEventosRealizados($filtro);

        $tableEventoDelt=$auditoriaModel->DetailEventosEliminados($filtro);

        $accesorios=$auditoriaModel->AccesoriosAuditoria($filtro);

        $traslado=$auditoriaModel->DetailTrasladoAuditoria($filtro);

        $trs='';
        $countTrs=0;
        foreach($traslado as $tr){
            $countTrs++;
            $trs.='<tr>';
            $trs.='<td>'.$tr["vin"].'</td>';
            $trs.='<td>'.$tr["fechaTraslado"].'</td>';
            $trs.='<td>'.$tr["horaTraslado"].'</td>';
            $trs.='<td>'.$tr["tipo_traslado"].'</td>';
            $trs.='<td>'.$tr["origen"].'</td>';
            $trs.='<td>'.$tr["destino"].'</td>';
            $trs.='</tr>';
        }


        $accs='';
        $countAc=0;
        foreach($accesorios as $acs){
            $countAc++;
            $accs.='<tr>';
            $accs.='<td>'.$acs["cantidad"].'</td>';
            $accs.='<td>'.$acs["equipamiento"].'</td>';
            $accs.='<td>'.$acs["estado"].'</td>';
            $accs.='<td>'.$acs["proveedorGas"].'</td>';
            $accs.='<td>'.$acs["usuario"].'</td>';
            $accs.='</tr>';
        }

        $procesado='';
        $countPro=0;
        foreach($tableEventoPro as $ep){
            $countPro++;
            $procesado.='<tr>';
                $procesado.='<td>'.$countPro.'</td>';
                $procesado.='<td>'.$ep["eventoActual"].'</td>';
                $procesado.='<td>'.$ep["estadoEvento"].'</td>';
                $procesado.='<td>'.$ep["comentarios"].'</td>';
                $procesado.='<td>'.$ep["fechaInicio"].'</td>';
                $procesado.='<td>'.$ep["fechaFin"].'</td>';
                $procesado.='<td>'.$ep["fechaRegistroSistemaFin"].'</td>';
                $procesado.='<td>'.$ep["usuario"].'</td>';
            $procesado.='</tr>';
        }
        $eliminado='';
        $countEli=0;
        foreach($tableEventoDelt as $epd){
            $countEli++;
            $eliminado.='<tr>';
            $eliminado.='<td>'.$countEli.'</td>';
            $eliminado.='<td>'.$epd["eventoActual"].'</td>';
            $eliminado.='<td>'.$epd["estadoEvento"].'</td>';
            $eliminado.='<td>'.$epd["comentarios"].'</td>';
            $eliminado.='<td>'.$epd["fechaInicio"].'</td>';
            $eliminado.='<td>'.$epd["fechaFin"].'</td>';
            $eliminado.='<td>'.$epd["fechaRegistroSistemaFin"].'</td>';
            $eliminado.='<td>'.$epd["usuario"].'</td>';
            $eliminado.='</tr>';
        }



        $send=[
            'status'=>'success',
            'estadoVin'=>($vinView[0]["idestadoVin"]==2)?'<span id="labelEstadoVin" class="badge badge-phoenix badge-phoenix-primary">Por Entregar</span>':'<span id="labelEstadoVin" class="badge badge-phoenix badge-phoenix-success">Por Entregar</span>',
            'tablaTraslado'=>$trs,
            'tablaProcesados'=>$procesado,
            'tableEliminados'=>$eliminado,
            'tableAccesorios'=>$accs,
            'title'=>'Datos Encontrados',
            'message'=>'Se Encontraron los siguientes registros',
            'marca'=>$vinView[0]["marca"],
            'modelo'=>$vinView[0]["modelo"],
            'color'=>$vinView[0]["color"],
            'anhoModelo'=>$vinView[0]["anhoModelo"],
            'agencia'=>$vinView[0]["agencia"],
            'vendedor'=>$vinView[0]["vendedor"],
            'numeroFactura'=>$vinView[0]["numeroFactura"],
            'fechaFactura'=>$vinView[0]["fechaFactura"],
            'tipoNegocio'=>$vinView[0]["tipoNegocio"],
            'numeroPedido'=>$vinView[0]["numeroPedido"],

            'precioVenta'=>$vinView[0]["precioVehiculo"],
            'precioCompra'=>$vinView[0]["precioCompra"],
            'fechaCancelado'=>$vinView[0]["fechaCancelado"],
            'saldoPendiente'=>$vinView[0]["saldoPendiente"],
            'montoAbonado'=>($vinView[0]["precioVehiculo"]-$vinView[0]["saldoPendiente"]),

            'documentoCliente'=>$vinView[0]["documentoCliente"],
            'nombreCliente'=>$vinView[0]["nombreCliente"],
            'telefonoCliente'=>$vinView[0]["telefonoCliente"],
            'correoCliente'=>$vinView[0]["correoCliente"],
            'direccionCliente'=>$vinView[0]["direccionCliente"],
        ];

        echo json_encode($send);
        exit();
    }

    public function ViewControlCalidad()
    {
        $auditoriaModel=New AuditoriaVehicularModel();

        $vin=$_POST["vin"];

        $dato=[
            'grupoCheck'=>$auditoriaModel->GrupoCalidad(),
            'vin'=>$vin,
            'checkCalidad'=>$auditoriaModel->ControlCalidadReporte($vin)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("ReportesGenerales/AuditoriaVehicular/ControlCalidad/Index",$dato).view("ReportesGenerales/AuditoriaVehicular/ControlCalidad/Scripts"),
        ];
        echo json_encode($send);
        exit();
    }
}