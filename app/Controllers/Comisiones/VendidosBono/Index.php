<?php

namespace App\Controllers\Comisiones\VendidosBono;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ComisionModel;
use App\Models\GeneralesModel;
use App\Models\MarcaModel;
use App\Models\VehiculosVendidosModel;

class Index extends BaseController
{

    public function SelectYear()
    {
        date_default_timezone_set("America/Lima");
        $generalModel=New GeneralesModel();
        $anhoActual=date("Y");
        $mesaAtual=date("m");
        $anho=$_POST["anho"];

        if($anho==$anhoActual){
            $meses=$generalModel->SelectMes($mesaAtual);
        }else{
            $meses=$generalModel->SelectMes('');
        }

        $principal='';

        foreach($meses as $ms){
            $principal.="<option value='".$ms["codigoMes"]."'>".$ms["nombreMes"]."</option>";
        }

        $send=[
            'info'=>$principal,
            'status'=>'success',
            'message'=>'',
            'title'=>''
        ];

        echo json_encode($send);
        exit();
    }

    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(21,77,''));


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
// Instanciamos el modelo
        $bonoModel = new ComisionModel();
        $marcaModel=New MarcaModel();
        $generalModel=New GeneralesModel();
        date_default_timezone_set("America/Lima");
        $anho=date("Y");

        $yearAct=date("Y");
        //$mes=date("m");
        $mes=date("m");

        $mesAct=date("m");

        if($anho==$yearAct){
            $meses=$generalModel->SelectMes($mesAct);
        }else{
            $meses=$generalModel->SelectMes('');
        }


        // Parámetros de paginación
        $limit = 20; // Número de registros por página
        $pagina = $this->request->getVar('page') ?? 1;  // Obtener el número de página actual desde la URL, si no existe, será 1
        $start = ($pagina - 1) * $limit;  // Calcular el inicio de los registros

        // Obtener los detalles de los vehículos
        $detail = $bonoModel->DetailIndexVendidosBono( '', $limit, $start,$anho,$mes);

        // Obtener el número total de registros
        $countReg = count($bonoModel->DetailIndexVendidosBono('', '', '',$anho,$mes));

        // Calcular el número total de páginas
        $totalPages = ceil($countReg / $limit);

        // Datos para la vista
        $dato = [
            'idgrupoModulo' => 21,
            'idmodulo' => 77,
            'anho'=>$generalModel->Anho(),
            'mes'=>$meses,
            'selectMarca'=>$marcaModel->SelectMarca(),
            'detailIndex' => $detail,
            'finish' => $start,
            'count' => $limit,
            'total'=>$countReg,
            'countReg' => $countReg,
            'totalPages' => $totalPages,  // Pasar el total de páginas
            'pagina' => $pagina,          // Pasar la página actual
        ];

        // Cargar las vistas
        echo view("Layouts/Head", $dato);
        echo view("Comisiones/VendidosBono/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Comisiones/VendidosBono/Index/Scripts");
    }

    public function DetailIndex()
    {

        date_default_timezone_set("America/Lima");
        $bonoModel = new ComisionModel();
        $anho=$_POST["anho"];
        $mes=$_POST["mes"];

        $limit = 20; // Número de registros por página
        $marca = $_POST["marca"];
        // Obtener la página desde AJAX, si no existe será la página 1
        $pagina = $this->request->getVar('page') ?? 1;
        $start = ($pagina - 1) * $limit;

        // Consultar los registros paginados
        $detail = $bonoModel->DetailIndexVendidosBono( $marca, $limit, $start,$anho,$mes);

        // Obtener el número total de registros (sin paginación)
        $countReg = count($bonoModel->DetailIndexVendidosBono($marca,'','',$anho,$mes));

        // Calcular el número total de páginas
        $totalPages = ceil($countReg / $limit);

        // Generar la paginación HTML
        $paginationHtml = '';
        if ($totalPages > 1) {
            $paginationHtml .= '<nav aria-label="Page navigation example"><ul class="pagination">';

            // Página anterior
            if ($pagina > 1) {
                $paginationHtml .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="changePage(' . ($pagina - 1) . ')"><span class="fas fa-chevron-left"></span></a></li>';
            }

            // Mostrar páginas de 5 en 5
            $range = 10;
            $startPage = max(1, $pagina - floor($range / 2));
            $endPage = min($totalPages, $startPage + $range - 1);

            if ($endPage - $startPage + 1 < $range) {
                $startPage = max(1, $endPage - $range + 1);
            }

            for ($i = $startPage; $i <= $endPage; $i++) {
                $activeClass = ($pagina == $i) ? 'active' : '';
                $paginationHtml .= '<li class="page-item ' . $activeClass . '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' . $i . ')">' . $i . '</a></li>';
            }

            // Página siguiente
            if ($pagina < $totalPages) {
                $paginationHtml .= '<li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="changePage(' . ($pagina + 1) . ')"><span class="fas fa-chevron-right"></span></a></li>';
            }

            $paginationHtml .= '</ul></nav>';
        }

        // Preparar los datos para la respuesta
        $dats = [
            'detailIndex' => $detail,
            'countReg' => $start,
        ];

        $dato = [
            'tbody' => view("Comisiones/VendidosBono/DetailIndex/Index", $dats) . view("Comisiones/VendidosBono/DetailIndex/Scripts"),
            'countReg' => $countReg,
            'total' => $countReg,
            'totalRegistroPagina'=>$start,
            'currentPage' => $pagina,
            'totalPages' => $totalPages,
            'paginationHtml' => $paginationHtml, // Agregar el HTML de paginación a la respuesta
        ];

        echo json_encode($dato);
        exit();
    }
}