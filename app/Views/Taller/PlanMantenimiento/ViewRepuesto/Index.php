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
    <form id="formDetailRepuesto" method="POST" action="<?php echo base_url("Taller/PlanMantenimiento/SaveEditDelete/SaveDetailFamilia") ?>">
        <div class="row" style="padding-top:1px">
            <div class="col-12">
                <h4 class="text-primary">Agregar Repuesto</h4>
            </div>
        </div>
        <input hidden name="idrepuestoAgregar" value="<?php echo $viewRepuesto[0]["idrepuesto"]?>">
        <input hidden name="idplanMantenimientoFamiliaAgregar" value="<?php echo $idplanmantenimientofamilia?>">
        <div class="row" style="padding-top:3px">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-group-append" style="width:40%">
                        <div class="form-floating">
                            <input class="form-control form-control-sm" readonly placeholder="Ingrese Codigo de Repuesto..." value="<?php echo $viewRepuesto[0]["codigo"]?>">
                            <label for="floatingSelect">Codigo</label>
                        </div>
                    </div>
                    <div class="form-floating">
                        <input class="form-control form-control-sm" readonly value="<?php echo $viewRepuesto[0]['descripcion']?>">
                        <label for="floatingSelect">Descripcion</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top:3px">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-group-append" style="width:50%">
                        <div class="form-floating">
                            <input class="form-control form-control-sm" readonly placeholder="Ingrese Codigo de Repuesto..." value="<?php echo $viewRepuesto[0]["precioSoles"]?>">
                            <label for="floatingSelect">Precio Soles</label>
                        </div>
                    </div>
                    <div class="form-floating">
                        <input class="form-control form-control-sm" name="precioDolaresRepuesto" readonly value="<?php echo $viewRepuesto[0]['precioDolares']?>">
                        <label for="floatingSelect">Precio Dolares</label>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-6">
                <div class="input-group">
                    <div class="input-group-append" style="width:100%">
                        <div class="form-floating">
                            <input class="form-control form-control-sm" placeholder="Ingrese Cantidad..." autocomplete="off" name="cantidadRepuesto">
                            <label for="floatingSelect">Cantidad</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top:8px">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" id="btnSaveRepuesto" type="submit">AGREGAR</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </form>
</div>