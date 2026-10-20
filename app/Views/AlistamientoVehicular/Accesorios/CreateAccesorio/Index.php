<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Proceso Vehicular - Accesorios (Equipamiento: <?php echo $viewEq[0]["equipamiento"] ?>)</h5>
        </div>
    </div>
    <form action="<?php echo base_url("AlistamientoVehicular/Accesorios/SaveEditDelete/SaveEquipamientoId")?>" id="formSaveAccesorioEq" method="POST">
    <div class="form-row">
        <div class="col-12">
            <input hidden name="idequipamientoVin"
                   value="<?php echo $viewEq[0]["idequipamientoVin"] ?>">
            <input hidden name="vinEquipamiento" id="vinEquipamiento" value="<?php echo $vin?>">
            <input hidden name="idtipoEquipamiento" id="idtipoEquipamientoEq"
                   value="<?php echo $viewEq[0]["idtipoEquipamiento"] ?>">
            <div class="input-group" style="padding-bottom: 4px">
                <div class="form-floating">
                    <select class="form-control form-control-sm selectEquiVin" required
                            name="estadoEquipamiento"
                            data-choices="data-choices"
                            aria-label="Floating label select example">
                        <option selected value="2">Instalar</option>
                        <?php if (strpos($viewEq[0]["equipamiento"], "LAMINA") !== false) { ?>
                            <option value="1">Pendiente Instalacion</option>
                        <?php } ?>
                        <?php if (strpos($viewEq[0]["equipamiento"], "GPS") !== false) { ?>
                            <option value="1">Pendiente Instalacion</option>
                            <option value="3">Por validar</option>
                        <?php } ?>
                    </select>
                    <label for="floatingSelect"><?php echo $viewEq[0]["equipamiento"] ?></label>
                </div>
                <div class="input-group-append">
                    <div class="form-floating mb-3">
                        <input class="form-control" required name="fechaInstalacion" type="date"
                               value="<?php echo $hoy ?>"
                               max="<?php echo $hoy ?>"/>
                        <label for="floatingInput">Fecha Inst.</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($viewEq[0]["idtipoEquipamiento"] == 9) { ?>
        <input hidden name="requireGas" value="1">
        <div class="form-row">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-control form-control-sm" name="proveedorGas" required
                            data-choices="data-choices"
                            data-options='{"removeItemButton":true,"placeholder":true}'>
                        <option value="">Sin Proveedor</option>
                        <?php foreach ($proveedorGas as $pgs) { ?>
                            <option value="<?php echo $pgs["idproveedorGasRegion"] . "-" . $pgs["idproveedorGas"] ?>"><?php echo $pgs["razonSocial"] . " - " . $pgs["region"] ?></option>
                        <?php } ?>
                    </select>
                    <label for="floatingSelect">Proveedor de Gas</label>
                </div>
            </div>
        </div><br>
    <?php }else{ ?>
        <input hidden name="requireGas" value="0">
    <?php }?>
    <div class="form-row">
        <div class="col-12">
            <div class="input-group-append">
                <div class="form-floating mb-3">
                    <textarea class="form-control" style="height: 120px"  name="comentarioAccesorio"></textarea>
                    <label for="floatingInput">Observaciones o Comentarios</label>
                </div>
            </div>
        </div>
    </div>
    <div class="form-row">

        <div class="col-12">
            <label class="form-label spanlabel" for="resourceCheckCalidad">Subir Imagen</label>
            <input class="form-control form-control-sm" name="resourceAccesorio" type="file"/>
        </div>

    </div>
    <br>
    <div class="form-row">
        <div class="col-12">
            <button type="submit" id="btnProcesarAccess" class="btn btn-primary btn-sm">PROCESAR</button>
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                CANCELAR
            </button>
        </div>
    </div>
    </form>
</div>