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
                            <h3 class="mb-2">Traslado Vehicular / <small>Ubicacion (Total de
                                    Registros: <?php echo $count ?>)</small></h3>
                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="input-group d-flex align-items-center">
                                <div class="input-group-append" style="width: 20%">
                                    <select class="form-select form-select-sm" id="tipoFiltro" aria-label=".form-select-sm example">
                                        <option selected value="">Tipo Filtro</option>
                                        <option value="vin">Vin</option>
                                        <option value="modelo">Modelo</option>
                                    </select>
                                </div>

                                <div class="input-group-prepend" style="width: 20%">
                                    <select class="form-control form-control-sm" id="estadovin">
                                        <option value="">TODOS</option>
                                        <option selected value="1">INVENTARIO</option>
                                        <option value="2">FACTURADO</option>
                                        <option value="4">EXHIBICION</option>
                                    </select>
                                </div>

                                <div class="input-group-append" style="width: 20%">
                                    <input class="form-control form-control-sm" id="filtro">
                                </div>

                                <div class="input-group-prepend" style="width: 20%">
                                    <button id="btnSearch" class="btn btn-outline-primary btn-sm">Search</button>
                                    <button class="btn btn-outline-danger btn-sm" id="btnDeleteFilt"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-6" style="text-align: right">
                            <button class="btn btn-dark btn-sm" id="btnTransportista"><i class="fas fa-shuttle-van"></i>&nbsp;Transportista</button>
                            <button class="btn btn-info btn-sm" id="btnNewTraslado">Nuevo Traslado</button>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <input hidden id="start" value="10">
                    <input hidden id="countReg" value="<?php echo $countReg ?>">
                    <input hidden id="totalRegistros" value="<?php echo $count ?>">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover"
                               data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th class="sticky-col second-col sort" data-sort="vin">Vin</th>
                                <th>Fecha Ingreso</th>
                                <th class="sort" data-sort="marca">Marca</th>
                                <th>Modelo</th>
                                <th>Color</th>
                                <th>Estado Traslado</th>
                                <th>Bodega Anterior</th>
                                <th>Bodega</th>
                                <th>Ubicacion Anterior</th>
                                <th>Ubicacion Actual</th>
                                <th>Año Modelo</th>
                                <th>Tiempo en Inventario</th>
                                <th>Estado Vin</th>

                                <th>Opc</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyAlistamiento" class="list">
                            <?php
                            $contador = 0;
                            foreach ($detailIndex as $di) {
                                $contador++;
                                ?>
                                <tr>
                                    <td><?php echo $contador ?></td>
                                    <td><?php echo $di["vin"] ?></td>
                                    <td><?php echo $di["fechaIngreso"] ?></td>
                                    <td><?php echo $di["marca"] ?></td>
                                    <td><?php
                                        echo $di["modelo"];
                                        
                                        ?></td>
                                    <td><?php echo $di["color"] ?></td>
                                    <td>
                                        <?php echo $di["grupoUbicacionDestino"] ?>
                                    </td>
                                    <td><?php echo $di["bodegaAnterior"] ?></td>
                                    <td><?php echo $di["bodega"] ?></td>
                                    <td>
                                        <?php echo $di["ubicacionAnterior"] . " (" . $di["boxAnterior"] . ")" ?>
                                    </td>
                                    <td>
                                        <?php if ($di["ubicacionActual"] == "Sin Ubicacion") { ?>
                                            En Transito
                                        <?php } else { ?>
                                            <?php if ($di["grupoUbicacionDestino"] != '') { ?>
                                                <?php if (strpos($di["grupoUbicacionDestino"], 'Destino') !== false) { ?>
                                                    <?php echo $di["grupoUbicacionDestino"]; ?>
                                                <?php }else if(strpos($di["grupoUbicacionDestino"], 'Sin Movimiento') !== false){ ?>
                                                    <?php echo $di["ubicacionActual"] . " (" . $di["boxActual"] . ")" ?>
                                                    <?php echo ($di["idgrupoUbicacionDestino"] != '') ? ' - En Transito' : '' ?>
                                                <?php }?>
                                            <?php } else { ?>
                                                <?php echo $di["ubicacionActual"] . " (" . $di["boxActual"] . ")" ?>
                                                <?php echo ($di["idgrupoUbicacionDestino"] != '') ? ' - En Transito' : '' ?>
                                            <?php } ?>
                                        <?php } ?>

                                    </td>
                                    <td><?php echo $di["anhoModelo"] ?></td>
                                    <td>
                                        <?php
                                        date_default_timezone_set("America/Lima");
                                        $hoy = date("Y-m-d");
                                        // Crear objetos DateTime para las fechas
                                        $date1 = new DateTime($di["fechaCompra"]);
                                        $date2 = new DateTime($hoy);

                                        // Calcular la diferencia entre las fechas
                                        $interval = $date1->diff($date2);
                                        // Obtener la diferencia total en días
                                        $days = $interval->days; // Total de días entre las fechas

                                        // Mostrar la diferencia en días
                                        echo $days;
                                        ?>
                                    </td>
                                    <td><?php echo $di["estadoVin"] ?></td>
                                    <td>
                                        <?php if(!is_null($di["fechaIngreso"])){?>
                                        <?php if (($di["ubicacionActual"] == 'Sin Ubicacion') && (is_null($di["idgrupoUbicacionDestino"]))) { ?>
                                            <?php if (is_null($di["idtrasladoUbicacion"])) { ?>
                                                <button class="btn btn-subtle-success btn-sm btnRebox tooltipBtn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cambiar de box en la misma ubicacion al vin <?php echo $di["vin"]?>" data-vin="<?php echo $di["vin"]?>" type="button">
                                                    <i class="fas fa-exchange-alt"></i>
                                                </button>
                                                <button class="btn btn-subtle-info btn-sm btnOpcubica tooltipBtn"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Generar traslado de vin: <?php echo $di["vin"]?> en el mismo grupo de ubicacion"
                                                        data-vin="<?php echo $di["vin"] ?>" type="button"><i
                                                            class="fas fa-paper-plane"></i></button>
                                            <?php } else { ?>
                                                <button class="btn btn-subtle-info btn-sm btnOpcubica tooltipBtn"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom" title="Recepcionar traslado de vin: <?php echo $di["vin"]?>"
                                                        data-vin="<?php echo $di["vin"] ?>" type="button"><i
                                                            class="fas fa-map-marker-check"></i></button>
                                            <?php } ?>
                                            <?php if (is_null($di["idgrupoUbicacionDestino"])) { ?>
                                                <?php if (is_null($di["idtrasladoUbicacion"])) { ?>
                                                    <button class="btn btn-subtle-primary btn-sm btnReUbi tooltipBtn"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="liberar vin: <?php echo $di["vin"]?> a otro grupo de ubicaciones"
                                                            data-vin="<?php echo $di["vin"] ?>" type="button"><i
                                                                class="fas fa-unlock-alt"></i></button>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <?php if (in_array($di["idgrupoUbicacionActual"], session("codigoGrupoUbicacion"))) { ?>
                                                <?php if (is_null($di["idtrasladoUbicacion"])) { ?>
                                                    <button class="btn btn-subtle-success btn-sm btnRebox tooltipBtn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cambiar de box en la misma ubicacion al vin <?php echo $di["vin"]?>" data-vin="<?php echo $di["vin"]?>" type="button">
                                                        <i class="fas fa-exchange-alt"></i>
                                                    </button>
                                                    <button class="btn btn-subtle-info btn-sm btnOpcubica tooltipBtn"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Generar traslado de vin: <?php echo $di["vin"]?> en el mismo grupo de ubicacion"
                                                            data-vin="<?php echo $di["vin"] ?>" type="button"><i
                                                                class="fas fa-paper-plane"></i></button>
                                                <?php } else { ?>
                                                    <button class="btn btn-subtle-info btn-sm btnOpcubica tooltipBtn"
                                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Recepcionar traslado de vin: <?php echo $di["vin"]?>"
                                                            data-vin="<?php echo $di["vin"] ?>" type="button"><i
                                                                class="fas fa-map-marker-check"></i></button>
                                                <?php } ?>
                                                <?php if (is_null($di["idgrupoUbicacionDestino"])) { ?>
                                                    <?php if (is_null($di["idtrasladoUbicacion"])) { ?>
                                                        <button class="btn btn-subtle-primary btn-sm btnReUbi tooltipBtn"
                                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="liberar vin: <?php echo $di["vin"]?> a otro grupo de ubicaciones"
                                                                data-vin="<?php echo $di["vin"] ?>" type="button"><i
                                                                    class="fas fa-unlock-alt"></i></button>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                        <?php }else{?>
                                                No Tiene Ingreso
                                        <?php }?>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>