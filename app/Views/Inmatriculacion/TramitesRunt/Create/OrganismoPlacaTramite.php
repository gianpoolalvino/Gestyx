<form id="formTramitePaso1" method="POST"
      action="<?php echo base_url("Inmatriculacion/TramitesRunt/SaveEditdelete/UpdatePaso1") ?>">
    <input hidden name="idtramite" id="idtramite" value="<?php echo $idtramite ?>">
    <div class="row pb-2">
        <div class="col-4">
            <label class="form-label fw-bold">1. Tipo Vehiculo Tramite</label>
            <select class="form-select form-control-sm" name="tipoVehiculoTramite">
                <option selected disabled>Seleccione tipo vehiculo</option>
                <option <?php echo ($viewTramite[0]["idtipoVehiculoTramite"] == 1) ? 'selected' : '' ?> value="1">1.
                    Nuevo
                </option>
                <option <?php echo ($viewTramite[0]["idtipoVehiculoTramite"] == 2) ? 'selected' : '' ?> value="2">2.
                    Semi Nuevo
                </option>
            </select>
        </div>
        <div class="col-5">
            <label class="form-label fw-bold">2. Organismo de Tránsito</label>
            <input type="text" class="form-control" name="organismoTramite" disabled placeholder="Ejemplo: SIM Bogotá">
        </div>
        <div class="col-3">
            <label class="form-label fw-bold">3. Placa</label>
            <input type="text" class="form-control" value="<?php echo $viewTramite[0]["placa"] ?>" name="placa"
                   placeholder="Ejemplo: ABC123">
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <label class="form-label fw-bold">4. Trámite Solicitado</label>
            <select class="form-select" name="idtipoTramite">
                <?php
                $cont = 0;
                foreach ($tipoTramite as $tt) {
                    $cont++;
                    if ($viewTramite[0]["idtramiteSolicitado"] == $tt["idtipoTramite"]) {
                        ?>
                        <option selected
                                value="<?php echo $tt["idtipoTramite"] ?>"><?php echo $cont . ". " . $tt["descripcion"] ?></option>
                    <?php } else {
                        ?>
                        <option value="<?php echo $tt["idtipoTramite"] ?>"><?php echo $cont . ". " . $tt["descripcion"] ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
            <small class="text-muted">Usa Ctrl (o Cmd en Mac) para seleccionar varios trámites si es necesario.</small>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <label class="form-label fw-bold">5. Clase de Vehículo</label>
            <select class="form-select" name="claseVehiculo" required>
                <option selected disabled>Seleccione una clase</option>
                <?php
                $count = 0;
                foreach ($tipoVehiculo as $tv) {
                    $count++;
                    if ($viewTramite[0]["idclaseVehiculo"] == $tv["idtipoVehiculo"]) {
                        ?>
                        <option selected
                                value="<?php echo $tv["idtipoVehiculo"] ?>"><?php echo $count . ". " . $tv["descripcion"] ?></option>
                    <?php } else {
                        ?>
                        <option value="<?php echo $tv["idtipoVehiculo"] ?>"><?php echo $count . ". " . $tv["descripcion"] ?></option>
                    <?php } ?>
                <?php } ?>
            </select>
        </div>
    </div>
    <div class="mb-3">
        <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
        <button type="submit" class="btn btn-primary btn-sm">Siguiente</button>
    </div>
</form>
