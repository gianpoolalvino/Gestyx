<?php

namespace App\Controllers\IngresoVin;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AgendamientoModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\GeneralesModel;
use App\Models\IngresoModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(22,'',''));


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
        $generalModel=New GeneralesModel();
        $ingresoModel=New IngresoModel();
        date_default_timezone_set("America/Lima");
        $hoy=date("Y-m-d");

        $filtro=[
            'idusuario'=>session("idusuario"),
            'idgrupoModulo'=>22
        ];

        $filtroSesion=$generalModel->FiltroSesion($filtro);
        $filtSe=[];
        if(!$filtroSesion){
            $filtroMod=[
                'idgrupoModulo'=>22
            ];
            $filtroSesion=$generalModel->FiltroModulo($filtroMod);

            foreach($filtroSesion as $cmp){
                $insertFilt=[
                    'idusuario'=>session("idusuario"),
                    'idgrupoModulo'=>22,
                    'nombreCampo'=>$cmp["nombreCampo"],
                    'campo'=>$cmp["campo"],
                    'estadoCampo'=>1
                ];
                $stor=$generalModel->StorageFiltro($insertFilt);
            }
        }

        $limit=10;
        $start=0;
        $finish=10;
        $filters=$generalModel->FiltroSesion($filtro);
        $filtroFechas=[
            'fechaIngresoReal>='=>$hoy,
            'fechaIngresoReal<='=>$hoy
        ];
        $dato=[
            'idgrupoModulo'=>22,
            'idmodulo'=>'',
            'filtros'=>$filters,
            'detailIndex'=>$ingresoModel->DetailIngresoVin($filters,'','','','',$filtroFechas)
        ];

        echo view("Layouts/Head",$dato);
        echo view("IngresoVin/Index/Index",$dato);
        echo view("Layouts/RightFiltro",$dato);
        echo view("Layouts/Footer");
        echo view("IngresoVin/Index/Scripts",$dato);
    }

    public function DetailIndex()
    {
        $ingresoModel=New IngresoModel();
        $generalModel=New GeneralesModel();

        $selectAvanzado=$_POST["selectAvanzado"]??[];
        $tipoSelectAvanzado=$_POST["tipoSelectAvanzado"]??[];
        $searchInputs=$_POST["searchAvanzado"]??[];

        $filtro=[
            'idusuario'=>session("idusuario"),
            'estadoCampo'=>1,
            'idgrupoModulo'=>22
        ];

        $filtroFechas=[
            'fechaIngresoReal>='=>$_POST["fechaInicio"],
            'fechaIngresoReal<='=>$_POST["fechaFin"],
        ];

        $filtroModulo=$generalModel->FiltroSesion($filtro);
        $search=$_POST["filtro"];
        $dato=[
            'detailIndex'=>$ingresoModel->DetailIngresoVin($filtroModulo,$search,$selectAvanzado,$tipoSelectAvanzado,$searchInputs,$filtroFechas)
        ];

        $send=[
            'status'=>'success',
            'info'=>view("IngresoVin/DetailIndex/Index",$dato).view("IngresoVin/DetailIndex/Scripts")
        ];
        echo json_encode($send);
        exit();
    }

    public function FiltrosAvanzados()
    {
        $generalModel=New GeneralesModel();
        $count=$_POST["count"];

        $filtro=[
            'idusuario'=>session("idusuario"),
            'idgrupoModulo'=>22
        ];
        $filtroModulo=$generalModel->FiltroSesion($filtro);
        $table="";
        $table.="<tr id='filtroAvanced".$count."'>";
        $table.="<td>";
        $table.="<select class='form-control form-control-sm' name='selectAvanzado[]'>";
        $table.="<option value=''>Seleccione Filtro...</option>";
            foreach($filtroModulo as $ft){
                if($ft["campo"]!='vin') {
                    $table .= "<option value='" . $ft["campo"] . "'>" . $ft["nombreCampo"] . "</option>";
                }
            }
        $table.="</select>";
        $table.="</td>";
        $table.="<td>";
        $table.="<select class='form-control form-control-sm' name='tipoSelectAvanzado[]'>";
        $table.="<option value='like'>Like</option>";
        $table.="<option value='orlike'>Or Like</option>";
        $table.="<option value='igual'>=</option>";
        $table.="<option value='diferente'><></option>";
        $table.="</select>";
        $table.="</td>";
        $table.="<td><div class='input-group'><input class='form-control form-control-sm' autocomplete='off' name='searchAvanzado[]'><div class='input-group-append'><button class='btn btn-danger btn-sm trashButtonFilt' data-idtrash='".$count."'><i class='fas fa-trash'></i></button></div></div></td>";
        $table.="</tr>";

        $send=[
            'count'=>$count+1,
            'info'=>$table
        ];
        echo json_encode($send);
        exit();
    }

    public function ModificarFiltro()
    {
        $generalModel=New GeneralesModel();

        $idcampoFiltro=$_POST["idcampoFiltro"];
        $estadoFiltro=$_POST["estadoCampo"];
        $filtroUpdate=[
            'idusuario'=>session("idusuario"),
            'idfiltroSesion'=>$idcampoFiltro
        ];

        $update=[
            'estadoCampo'=>$estadoFiltro
        ];

        $estup=$generalModel->UpdateFiltro($filtroUpdate,$update);

        if($estup){
            $send = [
                "status" => "success",
                "title" => "Filtro Actualizado",
                "message" => "Se actualizo correctamente el filtro"
            ];
            echo json_encode($send);
            exit();
        }else{
            $send = [
                "status" => "danger",
                "title" => "Error de grabado",
                "message" => "No se lograron realizar los cambios"
            ];
            echo json_encode($send);
            exit();
        }

    }

    public function PanelCreado()
    {
        $ingresoModel=New IngresoModel();

        $filtro=[];

        $dato=[
            'detailIndex'=>$ingresoModel->DetailIndexCreado($filtro)
        ];


        $send=[
            'status'=>'success',
            'title'=>'',
            'message'=>'',
            'info'=>view("IngresoVin/PanelCreado/Index/Index",$dato).view("IngresoVin/PanelCreado/Index/Scripts")
        ];

        echo json_encode($send);
    }

}