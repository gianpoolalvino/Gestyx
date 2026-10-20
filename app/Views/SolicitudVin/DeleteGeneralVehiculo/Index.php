<div class="modal-body">
    <form id="formDeleteVehiculo" method="POST" action="<?php echo base_url("SolicitudVin/SolicitarVehiculo/SaveEditDelete/DeleteVehiculo") ?>">
        <div class="row pb-2">
            <div class="col-12 text-center">
                <h5 class="text-primary">Quitar Vehiculos / Solicitud Vin</h5>
                <span>¿Cambiar ?</span>
            </div>
        </div>
        <input hidden name="idsolicitudVehiculo" value="<?php echo $idsolicitudVehiculo ?>">
        <div class="row pb-2">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-light btn-sm">CERRAR</button>
            </div>
        </div>
    </form>
</div>