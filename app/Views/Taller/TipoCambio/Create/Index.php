<style>
    .rowf {
        margin-bottom: 4px !important
    }

    .titleLabel {
        font-size: 12px
    }

    .spanlabel {
        padding-left: 0px
    }
</style>
<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form id="formTipoCambio" method="POST" action="<?php echo base_url("Taller/TipoCambio/SaveEditDelete/SaveTipoCambio") ?>">
        <div class="row" style="padding-top:1px">
            <div class="col-12">
                <h4 class="text-primary">Tipo de Cambio</h4>
            </div>
        </div><hr>
        <div class="row">
            <div class="col-6">
                <div class="form-floating">
                    <input class="form-control form-control-sm" required
                           name="compra">
                    <label for="floatingSelect">Cambio Compra</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <input class="form-control form-control-sm"
                           required
                           name="venta">
                    <label for="floatingSelect">Cambio Venta</label>
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