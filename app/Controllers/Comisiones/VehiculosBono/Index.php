<?php

namespace App\Controllers\Comisiones\VehiculosBono;
use App\Controllers\BaseController;
use App\Controllers\Tokens;
use App\Models\AlistamientoVehicularModel;
use App\Models\ComisionModel;
use App\Models\MarcaModel;
use App\Models\VehiculosVendidosModel;

class Index extends BaseController
{
    public function Index()
    {
        $tokenController=New Tokens();

        $access=json_decode($tokenController->AccessRolUser(21,49,''));


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
        // Parámetros de paginación
        $limit = 20; // Número de registros por página
        $pagina = $this->request->getVar('page') ?? 1;  // Obtener el número de página actual desde la URL, si no existe, será 1
        $start = ($pagina - 1) * $limit;  // Calcular el inicio de los registros

        // Obtener los detalles de los vehículos
        $detail = $bonoModel->DetailIndexBono( '', $limit, $start);

        // Obtener el número total de registros
        $countReg = count($bonoModel->DetailIndexBono('', '', ''));

        // Calcular el número total de páginas
        $totalPages = ceil($countReg / $limit);

        // Datos para la vista
        $dato = [
            'idgrupoModulo' => 21,
            'idmodulo' => 49,
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
        echo view("Comisiones/VehiculosBono/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Comisiones/VehiculosBono/Index/Scripts");
    }

    public function DetailIndex()
    {
        $bonoModel = new ComisionModel();
        $marcaModel=New MarcaModel();
        $limit = 20; // Número de registros por página
        $marca = $_POST["marca"];


        // Obtener la página desde AJAX, si no existe será la página 1
        $pagina = $this->request->getVar('page') ?? 1;
        $start = ($pagina - 1) * $limit;

        // Consultar los registros paginados
        $detail = $bonoModel->DetailIndexBono( $marca, $limit, $start);

        // Obtener el número total de registros (sin paginación)
        $countReg = count($bonoModel->DetailIndexBono($marca,'',''));

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
            'tbody' => view("Comisiones/VehiculosBono/DetailIndex/Index", $dats) . view("Comisiones/VehiculosBono/DetailIndex/Scripts"),
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
    public function Indexold()
    {
        $marcaModel=New MarcaModel();
        $dato = [
            'idgrupoModulo' => 21,
            'idmodulo' => 49,
            'selectMarca'=>$marcaModel->SelectMarca()
        ];
        echo view("Layouts/Head", $dato);
        echo view("Comisiones/VehiculosBono/Index/Index", $dato);
        echo view("Layouts/Footer");
        echo view("Comisiones/VehiculosBono/Index/Scripts");
    }
}