<div class="modal-body">
    <form id="formRecepciona" method="POST" action="<?php echo base_url("SolicitudVin/SolicitarVehiculo/SaveEditDelete/SaveRecepciona") ?>">
        <div class="row pb-2">
            <div class="col-12">
                <h5 class="text-primary">Agregar Recepcion / Solicitud Vin</h5>
            </div>
        </div>
        <input hidden name="idsolicitudVehiculo" value="<?php echo $viewSolicitud[0]["idsolicitudVehiculo"] ?>">
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <input class="form-control form-control-sm"
                           value="<?php echo $viewSolicitud[0]["nombreRecepciona"] ?>" name="nombreRecepciona" required>
                    <label for="floatingSelect">Nombre</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-6">
                <div class="form-floating">
                    <input class="form-control form-control-sm"
                           value="<?php echo $viewSolicitud[0]["cargoRecepciona"] ?>" name="cargoRecepciona" required>
                    <label for="floatingSelect">Cargo</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <input class="form-control form-control-sm"
                           value="<?php echo $viewSolicitud[0]["telefonoRecepciona"] ?>" id="telefonoRecepciona" name="telefonoRecepciona"
                           required>
                    <label for="floatingSelect">Telefono</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-outline-danger btn-sm">CERRAR</button>
            </div>
        </div>
    </form>
</div>