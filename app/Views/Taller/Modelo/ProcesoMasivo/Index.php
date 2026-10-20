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
    <form id="formProcesoModelo" method="POST"
          action="<?php echo base_url("Taller/Modelo/SaveEditDelete/ProcesarModeloMasivo") ?>">
        <div class="row" style="padding-top:1px">
            <div class="col-12">
                <h4 class="text-primary">Carga Masiva Planes de Mto</h4>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="input-group">
                    <div class="form-floating">
                        <select class="form-control form-control-sm" required
                                name="marcaAfectada"
                                id="marcaAfectada"
                                data-choices="data-choices"
                                aria-label="Floating label select example">
                            <option selected value="">Seleccione Marca</option>
                            <?php foreach ($selectMarca as $smr) { ?>
                                <option value="<?php echo $smr["idmarca"] ?>"><?php echo $smr["descripcion"] ?></option>
                            <?php } ?>
                        </select>
                        <label for="floatingSelect">Marca</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" id="btnProcesarCarga" type="submit">PROCESAR</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR
                </button>
            </div>
        </div>
    </form>
</div>