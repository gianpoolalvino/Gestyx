<?php

namespace App\Controllers\Taller\Cotizacion;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\ControlSalidaVehicular;
use App\Models\CotizacionModel;
use App\Models\GeneralesModel;
use App\Models\InventarioModel;
use App\Models\MarcaModel;
use App\Models\ModeloModel;
use App\Models\PlanMantenimientoModel;
use App\Models\RepuestoModel;
use App\Models\TipoCambioModel;
use \Dompdf\Dompdf;

class CreateViewEdit extends BaseController
{
    public function ObtenerCliente()
    {
        $cotizacionModel=New CotizacionModel();

        $filtro=[
            'documentoCliente'=>$_POST["documentoCliente"]
        ];

        $client=$cotizacionModel->Cliente($filtro);

        if($client){
            $send=[
                'status'=>'success',
                'title'=>'Resultado Correcto',
                'message'=>'El Cliente existe en la BD',
                'documentoCliente'=>$client[0]["documentoCliente"],
                'nombreCliente'=>$client[0]["nombreCliente"],
                'correoCliente'=>$client[0]["correoCliente"],
                'telefonoCliente'=>$client[0]["telefonoCliente"],
                'direccionCliente'=>$client[0]["direccionCliente"]
            ];
            echo json_encode($send);
            exit();
        }else{
            $send=[
                'status'=>'danger',
                'title'=>'No existe',
                'message'=>'El Cliente no existe en la BD',
            ];
            echo json_encode($send);
            exit();
        }
    }

    public function Create()
    {
        $marcaModel=New MarcaModel();

        $datos=[
            'selectMarca'=>$marcaModel->SelectMarca()
        ];

        $result=[
            'info'=>view("Taller/Cotizacion/Create/Index",$datos).view("Taller/Cotizacion/Create/Scripts"),
            'status'=>'success'
        ];
        echo json_encode($result);
        exit();
    }

    public function DetailCreate()
    {
        $planMantenimientoModelo=New PlanMantenimientoModel();
        $tipoCambio=New TipoCambioModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");

        $filtro=[
            'idplanMantenimiento'=>$_POST["idplanMantenimiento"]
        ];

        $filtroTC=[
            'idmonedaSol'=>2,
            'fecha'=>$hoy
        ];

        $viewPlan=$planMantenimientoModelo->ViewPlanMantenimientoFull($filtro);
        $viewTipoCambio=$tipoCambio->CambioDia($filtroTC);
        $desct=0;
        if($_POST["descuento"]>0 or $_POST["descuento"]!=''){
            $desct=$_POST["descuento"];
        }else{
            $desct=0;
        }


        $dato=[
            'descuento'=>$desct,
            'tipoMoneda'=>$_POST["tipoMoneda"],
            'precioVenta'=>$viewTipoCambio[0]["precioVenta"],
            'detailView'=>$planMantenimientoModelo->ViewDetalleMantenimiento($filtro)
        ];

        $resultado=[
            'info'=>view("Taller/Cotizacion/DetailCreate/Index",$dato).view("Taller/Cotizacion/DetailCreate/Scripts"),
            'status'=>'success',
        ];

        if($_POST["tipoMoneda"]==1){
            $resultado+=[
                'cantidadManoObra'=>$viewPlan[0]["tiempoManoObra"],
                'costoManoObra'=>($viewPlan[0]["costoManoObra"]*$viewPlan[0]["tiempoManoObra"]),
            ];
        }else{
            $resultado+=[
                'cantidadManoObra'=>$viewPlan[0]["tiempoManoObra"],
                'costoManoObra'=>(($viewPlan[0]["costoManoObra"]*$viewTipoCambio[0]["precioVenta"])*$viewPlan[0]["tiempoManoObra"]),
            ];
        }


        echo json_encode($resultado);
        exit();

    }

    public function DescuentoManoObra()
    {

        $dsto=($_POST["descuentoPorcentaje"]!='')?$_POST["descuentoPorcentaje"]:0;

        $descuento=number_format(($_POST["subTotal"]*$dsto)/100,2,".","");

        $dato=[
            'descuentoMano'=>$descuento,
            'total'=>number_format($_POST["subTotal"]-$descuento,2,".","")
        ];

        echo json_encode($dato);
        exit();
    }

    public function CalcularTotal()
    {
        $totalRepuestos=$_POST["total"];
        $descuentoRepuestos=($_POST["descuento"]!='')?$_POST["descuento"]:0;
        $totalMano=$_POST["totalMano"];
        $descuentoMano=($_POST["descuentoMano"]!='')?$_POST["descuentoMano"]:0;

        $total=($totalRepuestos+$totalMano);

        $subTotal=number_format($total/1.18,2,".","");
        $igv=number_format($total-$subTotal,2,".","");
        $descuentoTotal=number_format($descuentoMano+$descuentoRepuestos,2,".","");

        $resultado=[
            'subTotal'=>$subTotal,
            'total'=>number_format($total,2,".",""),
            'igv'=>$igv,
            'descuentoTotal'=>$descuentoTotal
        ];

        echo json_encode($resultado);
        exit();
    }
    public function VerificarTipoCambio()
    {
        $tipoCambioModel=New TipoCambioModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");
        $filtroCambio=[
            'fecha'=>$hoy
        ];

        $cambio=$tipoCambioModel->CambioDia($filtroCambio);

        if($cambio){
            $result=[
                'status'=>'success',
                'title'=>'',
                'message'=>''
            ];
            echo json_encode($result);
            exit();
        }else{
            $result=[
                'status'=>'danger',
                'title'=>'Tipo de Cambio',
                'message'=>'No se a ingresado el tipo de cambio del dia'
            ];
            echo json_encode($result);
            exit();
        }
    }

    public function Kilometraje()
    {
        $planModelo=New PlanMantenimientoModel();

        $idmarca=$_POST["idmarca"];
        $idmodelo=$_POST["idmodelo"];

        $select='';

        $filtro=[
            'idmarca'=>$idmarca,
            'idmodelo'=>$idmodelo,
            'idestadoPlanMantenimientoFamilia'=>2
        ];

        $viewPlan=$planModelo->ViewPlanFam($filtro);
        if(!$viewPlan){

            $select.="<option value=''>Seleccione Kilometraje</option>";
            $dato=[
                'selectKilometraje'=>$select,
                'status'=>'warning'
            ];
            echo json_encode($dato);
            exit();
        }
        $idplanFamilia=$viewPlan[0]["idplanMantenimientoFamilia"];

        $filtroPlan=[
            'idplanMantenimientoFamilia'=>$idplanFamilia
        ];

        $kilometrajes=$planModelo->ViewPlanMantenimientoFull($filtroPlan);
        $select.="<option value=''>Seleccione Kilometraje</option>";
        foreach($kilometrajes as $km){
            $select.="<option value='".$km["idplanMantenimiento"]."'>".$km["kilometraje"]."</option>";
        }

        $dato=[
            'selectKilometraje'=>$select,
            'status'=>'success'
        ];

        echo json_encode($dato);
        exit();
    }

    public function Pdf()
    {
        $cotizacionModel=New CotizacionModel();
        $filtroCot=[
            'idcotizacion'=>$_POST["idcotizacion"]
        ];
        $viewCot=$cotizacionModel->ViewCotizacion($filtroCot);
        $filename="COTIZACION ".$viewCot[0]["numero"];
        $dato=[
            'nombreFile'=>$filename,
            'viewCotizacion'=>$cotizacionModel->ViewCotizacion($filtroCot),
            'detailCotizacion'=>$cotizacionModel->ViewDetalleCotizacion($filtroCot),
        ];

        /*echo '<pre>';
print_r($dato);
echo '</pre>';
exit;*/

        $dompdf = new Dompdf(array('enable_remote' => true));
        $dompdf->loadHtml(view("Taller/Cotizacion/Pdf/Index",$dato));
        // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'portrait');
        // Render the HTML as PDF
        $dompdf->render();
        // Output the generated PDF to Browser
        $dompdf->stream($filename.".pdf",array("Attachment" => 0));
        exit;
    }

    public function SendERP()
    {
        $generalModel=New GeneralesModel();
        $idcotizacion=$_POST["idcotizacion"];

        $dato=[
            'selectAgencia'=>$generalModel->SelectAgenciaActivaCotizador(),
            'idcotizacion'=>$idcotizacion
        ];

        $send=[
            'sttatus'=>'success',
            'info'=>view('Taller/Cotizacion/Confirmacion/Index',$dato).view('Taller/Cotizacion/Confirmacion/Scripts')
        ];

        echo json_encode($send);
        exit();

    }
}