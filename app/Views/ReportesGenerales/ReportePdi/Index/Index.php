<style>

    .tableFixHead {
        overflow: auto;
        height: calc(100vh - 184px);
        white-space: nowrap;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 100;
        background: #141824;
        color: white
    }

    /* Just common table stuff. Really. */
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 8px 16px;
    }

    .fixed-bottom {
        padding-top: 8px;
        padding-bottom: 8px;
        border-top: solid 1.5px #b9b9b9;
    }

    <?php
    date_default_timezone_set("America/Lima");
    $hoy=date("Y-m-d");
    $hora=date("H:i:s");
    $hoyD = date("Y-m-d H:i:s");
    ?>
</style>
<div class="content"
     style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="pb-5" style="padding-bottom:0px !important">
        <div style="flex: 0 0 40%;position: relative;height: calc(100vh - 70px);min-width: 100%">

            <div class="card h-100" style="border: 0px;border-radius: 0px;height:100%">
                <div class="card-header">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="mb-2">Reportes Generales / <small>Reporte PDI</small></h3>
                        </div>
                    </div>
                    <div class="row g-4">

                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="input-group">
                                <div class="input-group-append" style="width: 55%">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <select class="form-select form-select-sm" name="tipoFiltro"
                                                    id="tipoFiltro" aria-label=".form-select-sm example">
                                                <option selected value="">Todos</option>
                                                <option value="vin">Vin</option>
                                                <option value="documentoCliente">Documento Cliente</option>
                                                <option value="nombreCliente">Nombre Cliente</option>
                                                <option value="numeroTitulo">Nro Titulo</option>
                                                <option value="placa">Nro Placa</option>
                                            </select>
                                        </div>
                                        <input class="form-control form-control-sm" required name="fechaInicio"
                                               id="fechaInicio" type="date">
                                        <div class="input-group-prepend">
                                            <input class="form-control form-control-sm" required name="fechaFin"
                                                   id="fechaFin" type="date">
                                        </div>
                                    </div>
                                </div>
                                <input class="form-control form-control-sm" name="filtro" id="filtro"
                                       style="width: 25%">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-success btn-sm" id="btnCreateExcel" type="button"><i
                                            class="fas fa-file-excel"></i>&nbsp;Excel
                                    </button>
                                    <button id="btnSearch" type="button" class="btn btn-outline-primary btn-sm">
                                        Buscar
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover"
                               data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Vin</th>
                                <th class="sort" data-sort="marca">Marca</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Evento</th>
                                <th>Nombre Cliente</th>
                                <th>Asesor Venta</th>
                                <th>Agencia</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Evento</th>
                                <th>Fecha Factura</th>
                                <th>Fecha Cancelado</th>
                                <th>Operador</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyAlistamiento" class="list">

                            </tbody>
                            <tfoot id="cargarData" style="display: none">
                            <tr>
                                <td colspan="14" class="text-center">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Cargando Datos...</span>
                                    </div>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>