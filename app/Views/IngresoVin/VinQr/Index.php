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
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Ingreso Vehicular</h5><br>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <h4><?php echo $vinInfo[0]["vin"] ?></h4>
            <?php echo $vinQr?>
            <h4><?php echo $vinInfo[0]["marca"].' - '.$vinInfo[0]["modelo"] ?></h4>
        </div>
    </div>
    <hr>
    <div class="row" style="padding-bottom: 8px">
        <div class="col-12">
            <button class="btn btn-primary btn-sm" type="submit" id="btnProcesar">Imprimir</button>
            <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>