<style>
    .rowf {
        margin-bottom: 4px !important
    }

    .titleLabel {
        font-size: 12px
    }

    .spanlabel {
        padding-left: 0px
    }

    .bodyCotizacion {
        overflow: auto;
        height: 100%;
        white-space: nowrap;
    }

    .bodyCotizacion thead th {
        position: sticky;
        color: white;
        background: #505050;
        top: 0;
        z-index: 1;
    }

    .bodyCotizacion {
        height: 400px;
        width: 100%;
        overflow: auto;
    }

</style>
<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form id="formStorageSol" method="POST"
          action="<?php echo base_url("SolicitudVin/SolicitarVehiculo/SaveEditDelete/StorageSolicitud") ?>">
        <div class="row pb-2">
            <div class="col-6">
                <h5 class="text-primary">Generar Solicitud</h5>
                <input hidden name="idsolicitudVehiculo" id="idsolicitudVehiculo"
                       value="<?php echo $idsolicitudVehiculo ?>">
                <input hidden name="checkUbicacionGeneral" id="checkUbicacionGeneral" value="1">
            </div>
            <div class="col-6">
                <div class="form-check form-switch">
                    <input class="form-check-input" id="checkOrigen" name="checkOrigen" type="checkbox"/>
                    <label class="form-check-label" for="checkOrigen">Todos los Vehiculos Tienen el mismo Origen y
                        Destino</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select form-control-sm" name="tipoSolicitud" id="tipoSolicitud" required>
                        <option value="">Tipo Solicitud</option>
                        <?php

                        $idtipoSolicitud=session("idtipoSolicitud");
                        // Suponiendo que $idtipoSolicitud es un array con los valores que deseas verificar.
                        foreach ($tipoSolicitud as $ts) {
                            // Verifica si el valor de $ts["idtipoSolicitud"] está en el array $idtipoSolicitud.
                            if (in_array($ts["idtipoSolicitud"],$idtipoSolicitud )) {
                                ?>
                                <option value="<?php echo $ts["idtipoSolicitud"]; ?>"><?php echo $ts["descripcion"]; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <label for="floatingSelect">Tipo Solicitud</label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-floating">
                    <input type="date" class="form-control form-control-sm" min="<?php echo $hoy?>" name="fechaEstimadaEnvio" required>
                    <label for="floatingSelect">Fecha Envio</label>
                </div>
            </div>
            <div class="col-3">
                <div class="form-floating">
                    <input type="date" class="form-control form-control-sm" disabled min="<?php echo $hoy?>" name="fechaEstimadaRetorno"
                           id="fechaEstimadaRetorno" required>
                    <label for="floatingSelect">Fecha Retorno</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-6">
                <table class="table fs-9 mb-0 border-top border-translucent table-sm">
                    <tr>
                        <td style="padding-left: 11px;">Recepciona:</td>
                        <td style="text-align: right">
                            <button id="btnCreateRecep" class="btn btn-outline-primary btn-sm"
                                    style="padding-bottom: 3px;padding-top: 4px;"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-left: 11px;">Nombre: <span id="nombreRecepcionaVin"></span><br>
                            Cargo: <span id="cargoRecepcionaVin"></span><br>
                            Telefono: <span id="telefonoRecepcionaVin"></span></td>
                    </tr>
                </table>
            </div>
            <div class="col-6">
                <table class="table fs-9 mb-0 border-top border-translucent table-sm">
                    <tr>
                        <td style="padding-left: 11px;">Custodia:</td>
                        <td style="text-align: right">
                            <button id="btnCreateCusto" class="btn btn-outline-primary btn-sm"
                                    style="padding-bottom: 3px;padding-top: 4px;"><i class="fas fa-edit"></i></button>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="padding-left: 11px;">Nombre: <span id="nombreCustodiaVin"></span><br>
                            Cargo: <span id="cargoCustodiaVin"></span><br>
                            Telefono: <span id="telefonoCustodiaVin"></span></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-6">
                <label style="font-size:12px">Centro de Costo</label>
                    <select class="form-select form-control-sm" name="centroCosto" id="centroCosto" required>
                        <option value="">Centro Costo</option>
                        <?php foreach ($selectCentroCosto as $cc) { ?>
                            <option value="<?php echo $cc["idcentroCosto"] ?>"><?php echo $cc["descripcion"] . " - " . $cc["marca"] ?></option>
                        <?php } ?>
                    </select>
            </div>
            <div class="col-6">
                <label style="font-size:12px">Agencia Solicitante</label>
                <select class="form-select form-control-sm" name="agenciaSolicitud" disabled id="agenciaSolicitud">
                    <option value="">Agencias</option>
                    <?php foreach($selectAgencia as $sla){?>
                        <option value="<?php echo $sla["idagencia"]?>"><?php echo $sla["descripcion"]?></option>
                    <?php }?>
                </select>
            </div>
            <div style="display: none">
                <div class="col-4">
                    <div class="form-floating">
                        <select class="form-select form-control-sm inputTraslados" id="origenVin" name="origenVin" disabled>
                            <option value="">Origen</option>
                            <?php foreach ($origenVin as $ov) { ?>
                                <option value="<?php echo $ov["idubicacion"] ?>"><?php echo $ov["descripcion"]?></option>
                            <?php } ?>
                        </select>
                        <label for="floatingSelect">Origen</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating">
                        <input class="form-control form-control-sm inputTraslados" id="destinoVin" name="destinoVin"
                               disabled>
                        <label for="floatingSelect">Destino</label>
                    </div>
                </div>
            </div>

        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="input-group">
                    <select class="form-select form-control-sm" id="selectVehiculo" name="selectVehiculo">
                        <option value="">Seleccione Vin</option>
                        <?php foreach ($selectVin as $sv) { ?>
                            <option value="<?php echo $sv["vin"] ?>"><?php echo $sv["vin"] . " - " . $sv["marca"] . " - " . $sv["modelo"] . " - " . $sv["color"] ?></option>
                        <?php } ?>
                    </select>
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary btn-sm" id="btnAgregarVin" style="height: 28px">Agregar
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="tableFixHeadV2" id="tableAccessV2">
                <table id="vinsSoli" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                    <thead class="table-secondary">
                    <tr>
                        <th class="sticky-col first-col">#</th>
                        <th class="sticky-col second-col sort" data-sort="vin">Vin</th>
                        <th class="sort" data-sort="marca">Marca</th>
                        <th>Modelo</th>
                        <th>Origen</th>
                        <th>Destino</th>
                        <th>Opc.</th>
                    </tr>
                    </thead>
                    <tbody id="tbodyVinsSoli">
                    <tr>
                        <td colspan="7" class="text-center">No tiene ningun Vehiculo registrado :(</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <textarea class="form-control form-control-sm" style="height: 100px" name="comentarioSolicitud"></textarea>
                    <label for="floatingSelect">Comentarios Solicitante</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-sm">PROCESAR</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-outline-danger btn-sm">CERRAR</button>
            </div>
        </div>
    </form>
</div>