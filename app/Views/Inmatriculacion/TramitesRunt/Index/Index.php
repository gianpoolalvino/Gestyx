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
        background:#141824;
        color:white
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
    $fechaIn=date('Y-m-d',strtotime('-1 months', strtotime($hoy)));
    $hora=date("H:i:s");
    $hoyD = date("Y-m-d H:i:s");
    ?>
</style>
<div class="content" style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="pb-5" style="padding-bottom:0px !important">
        <div style="flex: 0 0 40%;position: relative;height: calc(100vh - 70px);min-width: 100%">

            <div class="card h-100" style="border: 0px;border-radius: 0px;height:100%">
                <div class="card-header">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="mb-2">Inmatriculacion / <small>Tramites Runt (Total de Registros: <?php echo $count?>)</small></h3>

                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-9 col-md-9 col-lg-9 col-sm-12">
                            <div class="input-group">
                                <div class="input-group-append" style="width: 20%">
                                    <select class="form-select form-select-sm" id="tipoFiltro"
                                            aria-label=".form-select-sm example">
                                        <option selected value="">Todos</option>
                                        <option value="vin">Vin</option>
                                        <option value="documentoCliente">Documento Cliente</option>
                                        <option value="nombreCliente">Nombre Cliente</option>
                                        <option value="marca">Marca</option>
                                    </select>
                                </div>
                                <div class="input-group-prepend">
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <select class="form-select form-select-sm" id="estadoTramite">
                                                <option value="">Todos</option>
                                                <option value="2">Sin Procesar</option>
                                                <option value="1">Procesado</option>
                                            </select>
                                        </div>
                                        <input class="form-control form-control-sm" type="date" value="<?php echo $fechaIn?>" id="fechaInicio">
                                        <div class="input-group-prepend">
                                            <input class="form-control form-control-sm" type="date" value="<?php echo $hoy?>" id="fechaFinal">
                                        </div>
                                    </div>
                                </div>
                                <input class="form-control form-control-sm" id="filtro" style="width: 20%">
                                <button id="btnSearch" class="btn btn-outline-primary btn-sm">Search</button>
                                <button class="btn btn-outline-danger btn-sm" id="btnDeleteFilt"><i class="fas fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="col-3 col-md-3 col-lg-3 col-sm-12" style="text-align: right !important">
                            <button class="btn btn-primary btn-sm" id="btnCreateTramite"><i class="fas fa-plus"></i>&nbsp;Nuevo Tramite</button>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <input hidden id="start" value="10">
                    <input hidden id="countReg" value="<?php echo $countReg?>">
                    <input hidden id="totalRegistros" value="<?php echo $count?>">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover" data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Vin</th>
                                <th class="sort"  data-sort="marca">Marca</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Bodega</th>
                                <th>Estado</th>
                                <th>Titulo</th>
                                <th>Fecha y Hora Placa</th>
                                <th>Placa</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyAlistamiento" class="list">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>