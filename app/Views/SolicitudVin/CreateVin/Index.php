<div class="modal-body">
    <form id="formVehiculo" method="POST" action="<?php echo base_url("SolicitudVin/SolicitarVehiculo/SaveEditDelete/SaveVehiculo") ?>">
        <div class="row pb-2">
            <div class="col-12">
                <h5 class="text-primary">Agregar Vehiculo / Solicitud Vin</h5>
            </div>
        </div>
        <input hidden name="idsolicitudVehiculo" value="<?php echo $idsolicitudVehiculo ?>">
        <input hidden name="vinSol" value="<?php echo $vinView[0]["vin"]?>">
        <div class="row pb-2">
            <div class="col-12">
                <span>VIN:</span><br>
                <strong><?php echo $vinView[0]["vin"]?></strong>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-4">
                <span>Marca:</span><br>
                <strong><?php echo $vinView[0]["marca"]?></strong><br>
                <span>Color:</span><br>
                <strong><?php echo $vinView[0]["color"]?></strong>
            </div>
            <div class="col-8">
                <span>Modelo:</span><br>
                <strong><?php echo $vinView[0]["modelo"]?></strong><br>
                <span>Año Modelo:</span><br>
                <strong><?php echo $vinView[0]["anhoModelo"]?></strong>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-select form-control-sm inputTraslados" required name="origenVinInd">
<?php
$ubicacionSeleccionada = $checkOrigenDestino == 2 ? $origen : ($vinView[0]['idubicacion'] ?? null);
$opcionMostrada = false;

foreach ($origenVin as $ov) {
    if ($ubicacionSeleccionada == $ov['idubicacion']) {
        echo '<option selected value="' . $ov['idubicacion'] . '">' . $ov['descripcion'] . '</option>';
        $opcionMostrada = true;
        break; // ya encontramos la ubicación, salimos del bucle
    }
}

// Si no se encontró ninguna coincidencia válida, mostrar "En Transito"
if (!$opcionMostrada) {
    echo '<option selected value="999">En Transito</option>';
}
?>
                    </select>
                    <label for="floatingSelect">Origen</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <input class="form-control form-control-sm inputTraslados" <?php echo ($checkOrigenDestino==1)?'':'readonly'?> value="<?php echo $destino?>" name="destinoVinInd">
                    <label for="floatingSelect">Destino</label>
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