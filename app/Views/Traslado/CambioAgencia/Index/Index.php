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
                            <h3 class="mb-2">Traslado Vehicular / <small>Agencia (Total de Registros: <?php echo $count?>)</small></h3>

                        </div>
                    </div>
                    <div class="row g-4">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="input-group">
                                <div class="input-group-append" style="width: 35%">
                                    <select class="form-select form-select-sm" id="tipoFiltro" aria-label=".form-select-sm example">
                                        <option selected value="">Tipo Filtro</option>
                                        <option value="vin">Vin</option>
                                        <option value="documentoCliente">Documento Cliente</option>
                                        <option value="nombreCliente">Nombre Cliente</option>
                                        <option value="modelo">Modelo</option>
                                    </select>
                                </div>
                                <input class="form-control form-control-sm" id="filtro" style="width: 35%">
                                <div class="input-group-prepend">
                                    <button id="btnSearch" class="btn btn-outline-primary btn-sm">Search</button>
                                    <button class="btn btn-outline-danger btn-sm" id="btnDeleteFilt"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
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
                                <th>Agencia Anterior</th>
                                <th>Agencia Actual</th>
                                <th>Estado Vin</th>
                                <th>Opc</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyAlistamiento" class="list">
                            <?php
                            $contador=0;
                            foreach($detailIndex as $di){
                                $contador++;
                                ?>
                                <tr>
                                    <td><?php echo $contador?></td>
                                    <td><?php echo $di["vin"]?></td>
                                    <td><?php echo $di["marca"]?></td>
                                    <td><?php
                                            echo $di["modelo"];
                                        ?></td>
                                    <td><?php echo $di["color"]?></td>
                                    <td><?php echo $di["agenciaAnterior"]?></td>
                                    <td><?php echo $di["estadoTraslado"]?></td>
                                    <td><?php echo $di["estadoVin"]?></td>
                                    <td>
                                        <?php if(($di["idestadoTraslado"]==1) && $di["codigoAgenciaDestino"]!=""){?>
                                            <?php if(in_array($di["codigoAgenciaDestino"],session("codigoAgencia"))){?>
                                                <button class="btn btn-subtle-warning btn-sm btnOrecep" data-idtrasladoVin="<?php echo $di["idtrasladoVin"]?>" data-vin="<?php echo $di["vin"]?>" type="button">Recepcionar</button>
                                            <?php }else{?>
                                                <button class="btn btn-subtle-warning btn-sm btnOrecep" disabled><i class="fas fa-cog fa-spin"></i>&nbsp;En Transito</button>
                                            <?php }?>
                                        <?php }else{?>
                                            <button class="btn btn-subtle-primary btn-sm btnOpcubica" data-vin="<?php echo $di["vin"]?>" type="button">Enviar</button>
                                        <?php }?>
                                    </td>
                                </tr>
                            <?php }?>
                            </tbody>
                            <tfoot id="cargarData">
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