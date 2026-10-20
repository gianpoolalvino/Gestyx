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
                            <h3 class="mb-2">Taller / <small>Cotizaciones</small></h3>
                        </div>
                    </div>
                    <div class="row" style="display: flex; justify-content: flex-start; margin: 0;width: 100%">
                        <!-- Select Marca -->
                        <div class="col" style="flex: 10%; padding: 0;">
                            <select class="form-select form-select-sm" id="selectMarca" aria-label=".form-select-sm example">
                                <option selected value="">Seleccione Marca</option>
                                <?php foreach($selectMarca as $smc){ ?>
                                    <option value="<?php echo $smc["idmarca"] ?>"><?php echo $smc["codigo"]." - ".$smc["descripcion"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <!-- Fecha Inicio -->
                        <div class="col" style="flex: 5%; padding: 0;">
                            <input class="form-control form-control-sm" id="fechaInicio" value="<?php echo $hoy?>" max="<?php echo $hoy?>" type="date">
                        </div>
                        <!-- Fecha Fin -->
                        <div class="col" style="flex: 5%; padding: 0;">
                            <input class="form-control form-control-sm" id="fechaFin" value="<?php echo $hoy?>" type="date">
                        </div>
                        <!-- Filtro -->
                        <div class="col" style="flex: 10%; padding: 0;">
                            <select class="form-select form-select-sm" id="filtro">
                                <option value="">Todos</option>
                                <option value="nombreCliente">Nombre Cliente</option>
                                <option value="documentoCliente">Documento Cliente</option>
                            </select>
                        </div>
                        <!-- Input Search -->
                        <div class="col" style="flex: 15%; padding: 0;">
                            <input class="form-control form-control-sm" id="search" placeholder="Buscar Datos.....">
                        </div>
                        <!-- Botón Buscar -->
                        <div class="col" style="flex: 15%; padding: 0;">
                            <button id="btnSearch" class="btn btn-outline-primary btn-sm">Buscar</button>
                            <button id="btnCreateCoti" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i>&nbsp;Nueva Cotizacion</button>
                        </div>
                    </div>

                </div>
                <div class="card-body" style="padding:0px">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover">
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th>Marca</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Nro Cotizacion</th>
                                <th class="sort" data-sort="marca">Documento</th>
                                <th>Cliente</th>
                                <th>Placa</th>
                                <th>Tipo Moneda</th>
                                <th>Fecha</th>
                                <th>Opc</th>
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