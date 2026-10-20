<style>
    .select2-container {
        z-index: 1060 !important; /* Mayor que el modal */
    }
</style>
<div class="modal-body">
    <form method="POST" id="formVinDelete" action="<?php echo base_url("Traslado/GuiasTraslados/SaveEditDelete/DeleteVinGuia") ?>">
        <div class="row pb-2">
            <div class="col-12 text-center">
                <i class="far fa-info-circle fa-3x text-danger"></i><div style="height: 10px"></div>
                <input hidden name="iddetalleGuiaRemision" value="<?php echo $iddetalleGuiaRemision?>">
                <input hidden name="idguiaRemisionVin" value="<?php echo $idguiaRemision?>">
                <h5>¿Desea eliminar el Vin: <?php echo $vin?> de la generacion de la Guia?</h5>
                <hr>
                <button class="btn btn-danger btn-sm" type="submit"><i class="fas fa-trash"></i>&nbsp;Eliminar</button>
                <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>