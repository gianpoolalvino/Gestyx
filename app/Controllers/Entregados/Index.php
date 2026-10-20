<?php

namespace App\Controllers\Entregados;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\EntregadoModel;
use App\Models\VehiculosVendidosModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(3,'',''));


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
        $vehiculosEntregados=New EntregadoModel();
        date_default_timezone_set("America/Lima");
        $fechaIn=date("Y-m-d");
        $fechaOut=date("Y-m-d");
        $idevento=1;
        $limit=10;
        $start=0;
        $finish=10;
        $detail=$vehiculosEntregados->DetailIndex('','',$limit,$start,$fechaIn,$fechaOut);
        $co=$vehiculosEntregados->CountDetail('','',$fechaIn,$fechaOut);
        $countReg=0;
        foreach($detail as $dt){
            $countReg++;
        }
        $dato=[
            'idgrupoModulo'=>3,
            'idmodulo'=>'',
            'detailIndex'=>$detail,
            'finish'=>$start,
            'count'=>$co[0]["contadorTotal"],
            'countReg'=>$countReg
        ];
        echo view("Layouts/Head",$dato);
        echo view("Entregados/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("Entregados/Index/Scripts");
    }

    public function DetailIndexExcel()
    {
        $vehiculosEntregados=New EntregadoModel();
        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltro"];
        $fechaIn=$_POST["fechaInicio"];
        $fechaOut=$_POST["fechaFinal"];

        $detail=$vehiculosEntregados->DetailIndexExcel($tipoFiltro,$filtro,$fechaIn,$fechaOut);

        $spread=new Spreadsheet();
        $spread->getProperties()
            ->setCreator("AUTONIZA")
            ->setTitle("Reporte Entregados del ".$fechaIn." al ".$fechaOut)
            ->setKeywords('PHPSpreadsheet');

        $sheet=$spread->getActiveSheet();
        $sheet->setTitle('Reporte Entregado');

        $encabezado=[
            'Chasis',
            'Marca',
            'Modelo',
            'Color',
            'Agencia',
            'Asesor de Venta',
            'Asesor Entrega',
            'Factura',
            'Fecha Factura',
            'Fecha Cancelado',
            'Fecha Entrega',
            'Dias Alistamiento',
            'Doc. Cliente',
            'Cliente',
            'Placa',
            'Direccion',
            'Correo Cliente',
            'Telefono',
            'Tipo de negocio / Tipo de Venta',
            'Nro Pedido / Hoja de Negocio'
        ];
        $sheet->fromArray($encabezado,null,'A1');

        $numeroDeFila=2;

        $spread->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
        $spread->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
        foreach($detail as $dit){

            $days='';
            if($dit["fechaCancelado"]!=''){
                $fechaFact=date("Y-m-d",strtotime($dit["fechaFactura"]));
                $fechaEnt=date("Y-m-d",strtotime($dit["fechaEntrega"]));
                $fecha1=date_create($fechaEnt);
                $fecha2=date_create($fechaFact);
                $diff=date_diff($fecha2,$fecha1);
                $days=str_replace('+','',$diff->format('%R%a'));
            }else{
                $fechaFact=date("Y-m-d",strtotime($dit["fechaCancelado"]));
                $fechaEnt=date("Y-m-d",strtotime($dit["fechaEntrega"]));
                $fecha1=date_create($fechaEnt);
                $fecha2=date_create($fechaFact);
                $diff=date_diff($fecha2,$fecha1);
                $days=str_replace('+','',$diff->format('%R%a'));
            }
            $ds=$days." Dias";
            $sheet->setCellValue("A".$numeroDeFila, $dit["vin"],null);
            $sheet->setCellValue("B".$numeroDeFila, $dit["marca"],null);
            $sheet->setCellValue("C".$numeroDeFila, $dit["modelo"],null);
            $sheet->setCellValue("D".$numeroDeFila, $dit["color"],null);
            $sheet->setCellValue("E".$numeroDeFila, $dit["agencia"],null);
            $sheet->setCellValue("F".$numeroDeFila, $dit["vendedor"],null);
            $sheet->setCellValue("G".$numeroDeFila, $dit["nombreAsesor"],null);
            $sheet->setCellValue("H".$numeroDeFila, $dit["numeroFactura"],null);
            $sheet->setCellValue("I".$numeroDeFila, $dit["fechaFacturaLabel"],null);
            $sheet->setCellValue("J".$numeroDeFila, $dit["fechaCanceladoLabel"],null);
            $sheet->setCellValue("K".$numeroDeFila, $dit["fechaEntregaLabel"],null);
            $sheet->setCellValue("L".$numeroDeFila, $ds,null);
            $sheet->setCellValue("M".$numeroDeFila, $dit["documentoCliente"],null);
            $sheet->setCellValue("N".$numeroDeFila, $dit["nombreCliente"],null);
            $sheet->setCellValue("O".$numeroDeFila, $dit["placa"],null);
            $sheet->setCellValue("P".$numeroDeFila, $dit["direccionCliente"],null);
            $sheet->setCellValue("Q".$numeroDeFila, $dit["telefonoCliente"],null);
            $sheet->setCellValue("R".$numeroDeFila, $dit["correoCliente"],null);
            $sheet->setCellValue("S".$numeroDeFila, $dit["tipoNegocio"],null);
            $sheet->setCellValue("T".$numeroDeFila, $dit["numeroPedido"],null);
            $numeroDeFila++;
        }

        $fileName = 'Reporte Entregados ' . $fechaIn . ' - ' . $fechaOut . ".xlsx";
        # Crear un "escritor"
        $writer = new Xlsx($spread);
        # Le pasamos la ruta de guardado
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($fileName) . '"');
        $writer->save('php://output');

    }

    public function DetailIndex()
    {
        $vehiculosEntregados=New EntregadoModel();
        $limit=10;
        $countRegv2=$_POST["countReg"];

        $filtro=$_POST["filtro"];
        $tipoFiltro=$_POST["tipoFiltr"];
        $fechaIn=$_POST["fechaInicio"];
        $fechaOut=$_POST["fechaFinal"];
        $start=$_POST["start"];
        $finish=$_POST["start"]+10;
        $co=$vehiculosEntregados->CountDetail($tipoFiltro,$filtro,$fechaIn,$fechaOut);
        $detail=$vehiculosEntregados->DetailIndex($tipoFiltro,$filtro,$limit,$start,$fechaIn,$fechaOut);
        $cnt=0;
        foreach($detail as $dt){
            $cnt++;
        }

        $countReg=$cnt+$countRegv2;

        $dats=[
            'detailIndex'=>$detail,
            'countReg'=>$countRegv2,
        ];

        $dato=[
            'tbody'=>view("Entregados/DetailIndex/Index",$dats).view("Entregados/DetailIndex/Scripts"),
            'countReg'=>$countReg,
            'start'=>$finish,
            'total'=>$co[0]["contadorTotal"],
        ];

        echo json_encode($dato);
        exit();
    }
}