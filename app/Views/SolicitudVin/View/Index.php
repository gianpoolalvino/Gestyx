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
    <form id="formStorageEst" method="POST"
          action="<?php echo base_url("SolicitudVin/SolicitarVehiculo/SaveEditDelete/StorageEstado") ?>">
        <input hidden name="idsolicitudVehiculo" id="idsolicitudVehiculo" value="<?php echo $idsolicitudVehiculo?>">
        <div class="row pb-2">
            <div class="col-9">
                <h5 class="text-primary">Ver / Procesar Solicitud de Vehiculo</h5>
            </div>
            <div style="text-align: right" class="col-3">
                <select class="form-control form-control-sm" id="estadoSolicitud" name="estadoSolicitud" required>
                    <option value="">Seleccione Proceso</option>
                    <option value="3">Atendido</option>
                    <option value="4">Rechazado</option>
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <span style="font-size: 12px">Tipo Solicitud</span><br>
                <strong style="font-size: 14px"><?php echo $viewSolicitud[0]["tipoSolicitud"]?></strong>
            </div>
            <div class="col-3">
                <span style="font-size: 12px">Fecha Solicitud</span><br>
                <strong style="font-size: 14px"><?php echo $viewSolicitud[0]["fechaSolicitudFormato"]?></strong>
            </div>
            <div class="col-3">
                <span style="font-size: 12px">Fecha Envio</span><br>
                <strong style="font-size: 14px"><?php echo $viewSolicitud[0]["fechaEnvioFormato"]?></strong>
            </div>
            <div class="col-3">
                <span style="font-size: 12px">Fecha Retorno</span><br>
                <strong style="font-size: 14px"><?php echo $viewSolicitud[0]["fechaRetornoFormato"]?></strong>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-6">
                <h6>Recepciona</h6>
                <span style="font-size: 12px">Nombre: </span><strong style="font-size: 14px"><?php echo $viewSolicitud[0]["nombreRecepciona"]?></strong><br>
                <span style="font-size: 12px">Cargo: </span><strong style="font-size: 14px"><?php echo $viewSolicitud[0]["cargoRecepciona"]?></strong><br>
                <span style="font-size: 12px">Telefono: </span><strong style="font-size: 14px"><?php echo $viewSolicitud[0]["telefonoRecepciona"]?></strong><br>
            </div>
            <div class="col-6">
                <h6>Custodia</h6>
                <span style="font-size: 12px">Nombre: </span><strong style="font-size: 14px"><?php echo $viewSolicitud[0]["nombreCustodia"]?></strong><br>
                <span style="font-size: 12px">Cargo: </span><strong style="font-size: 14px"><?php echo $viewSolicitud[0]["cargoCustodia"]?></strong><br>
                <span style="font-size: 12px">Telefono: </span><strong style="font-size: 14px"><?php echo $viewSolicitud[0]["telefonoCustodia"]?></strong><br>
            </div>
        </div>
        <hr>
        <div class="row pb-2">
            <div class="col-4">
                <span style="font-size: 12px">Centro de Costo</span><br>
                <strong style="font-size: 14px"><?php echo $viewSolicitud[0]["centroCosto"]?></strong>
            </div>
            <div class="col-4">
                <span style="font-size: 12px">Tipo de Origen y Destino</span><br>
                <strong style="font-size: 14px"><?php echo $viewSolicitud[0]["tipoDestino"]?></strong>
            </div>
            <div class="col-4">
                <span style="font-size: 12px">Origen</span><br>
                <strong style="font-size: 14px"><?php echo $viewSolicitud[0]["nombreOrigen"]?></strong><br>
                <span style="font-size: 12px">Destino</span><br>
                <strong style="font-size: 14px"><?php echo $viewSolicitud[0]["destino"]?></strong>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <table class="table fs-9 mb-0 border-top border-translucent table-hover table-sm table-responsive">
                    <thead>
                        <tr>
                            <td>#</td>
                            <td>Vin</td>
                            <td>Marca</td>
                            <td>Modelo</td>
                            <td>Origen</td>
                            <td>Destino</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $contador=0;
                        foreach($detailCreate as $dt){
                            $contador++;
                            ?>
                            <tr>
                                <td><?php echo $contador?></td>
                                <td><?php echo $dt["vin"]?></td>
                                <td><?php echo $dt["marca"]?></td>
                                <td><?php echo $dt["modelo"]?></td>
                                <td><?php echo $dt["origen"]?></td>
                                <td><?php echo $dt["destino"]?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <textarea  class="form-control form-control-sm" style="height: 120px" name="comentario" id="comentario"></textarea>
                    <label for="floatingSelect">Comentario Rechazo</label>
                </div>
            </div>

        </div>
        <div class="row pb-2">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-sm">Procesar</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-light btn-sm">CERRAR</button>
            </div>
        </div>
    </form>
</div>