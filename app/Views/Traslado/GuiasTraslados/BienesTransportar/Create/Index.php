<style>
    .select2-container {
        z-index: 1060 !important; /* Mayor que el modal */
    }
</style>
<div class="modal-body">
    <div class="row pb-2">
        <div class="col-12">
            <h5 class="text-primary">Agregar Vehiculo</h5>
        </div>
    </div>
    <form method="POST" id="formVinGuia" action="<?php echo base_url("Traslado/GuiasTraslados/SaveEditDelete/SaveVinGuia") ?>">
        <div class="row pb-2">
            <div class="col-12">
                <input hidden name="idguiaRemisionVin" value="<?php echo $idguiaRemision?>">
                <select class="select2" style="width: 100%;height: 38px !important" id="selectVinGuia"
                        name="selectVinGuia">
                    <option value=""></option>
                    <?php foreach ($selectVin as $svn) { ?>
                        <option value="<?php echo $svn["vin"] ?>"><?php echo $svn["vin"] . " - " . $svn["familia"] . " - " . $svn["marca"] . " - " . $svn["color"] . " - " . $svn["estadoVin"] ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div id="panelVinGuia">

        </div>
        <div class="row pb-2">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" id="btnAddVinG" type="submit"><i class="fas fa-plus"></i>&nbsp;Añadir
                </button>
                <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>