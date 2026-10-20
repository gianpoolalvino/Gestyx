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

    .iframe-container {
        display: none; /* Inicialmente oculto */
        width: 100%;
        height: 20vh; /* Ajusta la altura del div simulado */
        background-color: #ddd; /* Fondo para simular el iframe */
        border: 1px solid #ccc; /* Borde para simular un iframe */
    }

    .iframe-container.active {
        display: block;
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
    $fechaAnterior = date("Y-m-d", strtotime($hoy . ' -15 days'));
    $hora=date("H:i:s");
    $hoyD = date("Y-m-d H:i:s");
    ?>
</style>
<div class="content" style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="pb-5" style="padding-bottom:0px !important">
        <div style="flex: 0 0 40%;position: relative;height: calc(100vh - 70px);min-width: 100%">

            <div class="card h-100" style="border: 0px;border-radius: 0px;height:100%">
                <div class="card-header pb-1">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="mb-2">Solicitud de Vehiculos / <small>(Total de Registros: <?php echo $totales[0]["total"]?>)</small></h3>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="input-group">
                                <div class="input-group-append" style="width: 50%">
                                    <input class="form-control form-control-sm" type="date" value="<?php echo $fechaAnterior?>" id="fechaInicio" style="width: 100%">
                                </div>
                                <input class="form-control form-control-sm" type="date" value="<?php echo $hoy?>" id="fechaFin" style="width: 35%">
                            </div>
                        </div>
                        <div class="col-12 col-md-3 col-lg-3">
                            <div class="input-group">
                                <input class="form-control form-control-sm" id="searchVin" placeholder="Buscar por Vin...">
                                <div class="input-prepend">
                                    <button id="btnSearch" class="btn btn-outline-primary btn-sm">Search</button>
                                    <button class="btn btn-outline-danger btn-sm" id="btnDeleteFilt"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: right" class="col-12 col-md-6 col-lg-6">
                            <button id="btnNewSoli" class="btn btn-primary btn-sm">Nueva Solicitud</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <a href="#" class="badge badge-phoenix badge-phoenix-primary btnEstados" data-idestadoSolicitud="1">Recibidas <span id="recibidaLabel"><?php echo $totales[0]["recibida"]?></span></a>
                            <a href="#" class="badge badge-phoenix badge-phoenix-secondary btnEstados" data-idestadoSolicitud="2">Vistas <span id="vistaLabel"><?php echo $totales[0]["vista"]?></span></a>
                            <a href="#" class="badge badge-phoenix badge-phoenix-success btnEstados" data-idestadoSolicitud="3">Realizadas <span id="realizadaLabel"><?php echo $totales[0]["realizada"]?></span></a>
                            <a href="#" class="badge badge-phoenix badge-phoenix-danger btnEstados" data-idestadoSolicitud="4">Rechazadas <span id="rechazadaLabel"><?php echo $totales[0]["rechazada"]?></span></a>
                        </div>
                    </div>
                </div>

                <div class="card-body" style="padding:0px">
                    <input hidden id="start" value="10">
                    <input hidden id="countReg">
                    <input hidden id="totalRegistros">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamientoSol" class="table fs-9 mb-0 border-top border-translucent table-hover" data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Numero Solicitud</th>

                                <th>Tipo Solicitud</th>
                                <th class="sort"  data-sort="marca">Solicitante</th>
                                <th>Fecha Solicitud</th>
                                <th>Fecha Envio</th>
                                <th>Fecha Retorno</th>
                                <th>Origen y Destino</th>
                                <th>Estado</th>
                                <th>Opc.</th>
                            </tr>
                            </thead>
                            <tbody id="tbodySolicitud" class="list">
                            <?php
                            $contador = 0;

                            if (empty($detailIndex)) {
                                echo '<tr><td colspan="10" class="text-center">No existen datos :(</td></tr>';
                            } else {
                                foreach ($detailIndex as $di) {
                                    $contador++;
                                    ?>
                                    <tr class="<?php echo $di["estadoClase"]?>">
                                        <td><?php echo $contador ?></td>
                                        <td><?php echo $di["numeroSolicitud"] ?></td>
                                        <td><?php echo $di["tipoSolicitud"] ?></td>
                                        <td><?php echo $di["solicitante"] ?></td>
                                        <td><?php echo $di["fechaSolicitud"] ?></td>
                                        <td><?php echo $di["fechaEnvio"] ?></td>
                                        <td><?php echo $di["fechaRetorno"] ?></td>
                                        <td>
                                            <span>Tipo Origen y Destino: </span>&nbsp;<strong><?php echo $di["tipoDestino"] ?></strong><br>
                                            <span>Origen: </span>&nbsp;<strong><?php echo $di["nombreOrigen"] ?></strong><br>
                                            <span>Destino: </span>&nbsp;<strong><?php echo $di["destino"] ?></strong>
                                        </td>
                                        <td><?php echo $di["estadoSolicitud"] ?></td>
                                        <td>
                                            <?php if(session("gestorSolicitudVehiculo")==1){?>
                                            <?php if($di["idestadoSolicitud"]!=3 && $di["idestadoSolicitud"]!=4){?>
                                                <button class="btn btn-primary btn-sm btnOpcAtender" data-opcion="procesar" data-idsolicitudVehiculo="<?php echo $di["idsolicitudVehiculo"] ?>"><i class="fas fa-check-circle"></i></button>
                                            <?php }?>
                                            <?php }?>
                                            <button class="btn btn-light btn-sm btnOpcAtender" data-opcion="ver" data-idsolicitudVehiculo="<?php echo $di["idsolicitudVehiculo"] ?>"><i class="fas fa-eye"></i></button>
                                        </td>
                                    </tr>
                                <?php }
                            } ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
