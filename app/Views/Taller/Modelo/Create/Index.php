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
    <form id="formModeloCre" method="POST" action="<?php echo base_url("Taller/Modelo/SaveEditDelete/SaveModelo") ?>">
        <div class="row" style="padding-top:1px">
            <div class="col-12">
                <h4 class="text-primary">Crear Modelo</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="input-group">
                    <div class="form-floating">
                        <select class="form-control form-control-sm"  required
                                name="marca"
                                data-choices="data-choices"
                                aria-label="Floating label select example">
                            <option selected value="">Seleccione Marca</option>
                            <?php foreach($selectMarca as $smr){?>
                                <option value="<?php echo $smr["idmarca"]?>"><?php echo $smr["descripcion"]?></option>
                            <?php }?>
                        </select>
                        <label for="floatingSelect">Marca</label>
                    </div>
                    <div class="input-group-append" style="width:60%">
                        <div class="form-floating">
                            <input class="form-control form-control-sm" placeholder="Ingrese Codigo de Repuesto..." name="codigoModelo">
                            <label for="floatingSelect">Codigo</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 6px">
            <div class="col-12">
                <div class="form-floating">
                    <input class="form-control form-control-sm" name="descripcionModelo" placeholder="Descripcion de Modelo...">
                    <label for="floatingSelect">Nombre Modelo</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 6px">
            <div class="col-12">
                <div class="form-floating">
                    <input class="form-control form-control-sm" name="versionModelo" placeholder="Version de Modelo...">
                    <label for="floatingSelect">Version</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 6px">
            <div class="col-6">

            </div>
            <div class="col-6">
                <div class="form-floating">
                    <input class="form-control form-control-sm" name="anhoModelo" placeholder="Año Modelo...">
                    <label for="floatingSelect">Año Modelo</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm"  type="submit">PROCESAR</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </form>

</div>