<?php

namespace App\Controllers\ReportesGenerales;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AccessModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlCalidadModel;
use App\Models\EventoModel;
use App\Models\GeneralesModel;
use App\Models\OpcionesGeneralesModel;
use App\Models\ReportesGeneralModel;
use App\Models\VendidoInventarioModel;
use App\Models\VinModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class VendidoInventario extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(4,56,''));


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
        $dato=[
            'idgrupoModulo'=>4,
            'idmodulo'=>56,
        ];
        echo view("Layouts/Head",$dato);
        echo view("ReportesGenerales/VendidoInventario/Index/Index",$dato);
        echo view("Layouts/Footer");
        echo view("ReportesGenerales/VendidoInventario/Index/Scripts");
    }

    public function DetailIndex()
    {
        $vendidoInventario=New VendidoInventarioModel();

        $tipofiltro=$_POST["tipoFiltro"];
        $filt=$_POST["filtro"];

        $repot=$vendidoInventario->DetailIndex($tipofiltro,$filt);

        if($repot){
            $dats=[
                'detailIndex'=>$repot,
            ];
            $result=[
                'tbody'=>view("ReportesGenerales/VendidoInventario/DetailIndex/Index",$dats).view("ReportesGenerales/VendidoInventario/DetailIndex/Scripts"),
                'status'=>'success',
                'title'=>'Busqueda Correcta',
                'message'=>'Busqueda realizada con exito',
            ];
            echo json_encode($result);
            exit();
        }else{
            $result=[
                'status'=>'warning',
                'title'=>'Sin Resultados',
                'message'=>'No se encontraron datos en la aplicacion con los filtros realizados'
            ];
            echo json_encode($result);
            exit();
        }

    }
}