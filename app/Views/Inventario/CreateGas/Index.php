<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form method="POST" id="formGas" action="<?php echo base_url("Inventario/SaveEditDelete/SaveGas") ?>">
        <input hidden name="vinGas" value="<?php echo $vin ?>">
        <?php
        $modeloGas = '';
        if (stristr($vinInfo[0]["modelo"], 'GLP')) {
            $modeloGas = 'MODELO GLP';
            ?>
            <input hidden name="modeloGas" value="MODELO GLP">
        <?php } else if (stristr($vinInfo[0]["modelo"], 'GNV')) {
            $modeloGas = 'MODELO GNV';
            ?>
            <input hidden name="modeloGas" value="MODELO GNV">
        <?php } ?>
        <div class="row" style="padding-top:1px">
            <div class="col-12">
                <h4 class="text-primary">Convertir a GAS <?php echo $modeloGas ?></h4>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <div class="input-group">
                    <div class="form-floating">
                        <select class="form-control form-control-sm" id="selectGas" required
                                name="estadoEquipamientoGas"
                                data-choices="data-choices"
                                aria-label="Floating label select example">
                            <option selected value="2">Instalar</option>
                        </select>
                        <label for="floatingSelect">Instalar Gas</label>
                    </div>
                    <div class="input-group-append">
                        <div class="form-floating mb-3">
                            <input class="form-control" id="fechaInstalacionGas" name="fechaInstalacionGas" required
                                   type="date"
                                   value="<?php echo $hoy ?>"
                                   max="<?php echo $hoy ?>"/>
                            <label for="floatingInput">Fecha Inst.</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-control form-control-sm" name="proveedorGas" id="proveedorGas" required
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
        </div>
        <div class="row" style="padding-top: 6px">
            <div class="col-12">
                <div class="form-floating">
                    <textarea class="form-control form-control-sm" style="height:80px" name="observacion"></textarea>
                    <label for="floatingSelect">Observaciones</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit">PROCESAR</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </form>
</div>