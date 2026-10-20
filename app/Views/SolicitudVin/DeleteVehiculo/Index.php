<div class="modal-body">
    <form id="formDeleteVehiculo" method="POST" action="<?php echo base_url("SolicitudVin/SolicitarVehiculo/SaveEditDelete/DeleteVehiculo") ?>">
        <div class="row pb-2">
            <div class="col-12 text-center">
                <h5 class="text-primary">Quitar Vehiculo / Solicitud Vin</h5>
                <span>¿Realmente desea eliminar el vehiculo de la solicitud?</span>
            </div>
        </div>
        <input hidden name="iddetalleSolicitudVehiculo" value="<?php echo $iddetalleSolicitudVehiculo ?>">
        <input hidden name="vinSol" value="<?php echo $vin?>">
        <div class="row pb-2">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                <button type="button" data-bs-dismiss="modal" class="btn btn-light btn-sm">CERRAR</button>
            </div>
        </div>
    </form>
</div>