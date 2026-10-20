<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form method="POST" id="formSaveConcepto"
          action="<?php echo base_url("Comisiones/ReglaComision/SaveEditDelete/SaveConcepto") ?>">
        <input hidden name="idreglaComisionVenta" value="<?php echo $idreglaComisionVentaVehiculo ?>">
        <div class="row">
            <div class="col-12">
                <h5>Crear Concepto de Venta</h5>
            </div>
        </div>
        <div class="row" style="padding-bottom: 4px">
            <div class="col-12">
                <div class="form-floating">
                    <input class="form-control form-icon-input" name="nombreConcepto">
                    <label class="form-icon-label" for="floatingInputIconExample">Nombre Concepto</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 4px">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-append">
                        <div class="form-floating">
                            <input class="form-control form-icon-input" name="metaConcepto">
                            <label class="form-icon-label" for="floatingInputIconExample">Meta</label>
                        </div>
                    </div>
                    <div class="form-floating">
                        <input class="form-control form-icon-input" name="pesoConcepto">
                        <label class="form-icon-label" for="floatingInputIconExample">Peso</label>
                    </div>

                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
                <button class="btn btn-primary btn-sm" type="submit" id="btnSaveConcep">Guardar</button>
            </div>
        </div>
    </form>
</div>