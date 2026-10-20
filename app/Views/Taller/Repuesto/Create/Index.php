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
    <form id="formRepuestoCre" method="POST" action="<?php echo base_url("Taller/Repuesto/SaveEditDelete/SaveRepuesto") ?>">
        <div class="row" style="padding-top:1px">
            <div class="col-12">
                <h4 class="text-primary">Crear Repuesto</h4>
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
                        <input class="form-control form-control-sm" placeholder="Ingrese Codigo de Repuesto..." name="codigoRepuesto">
                            <label for="floatingSelect">Codigo</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 6px">
            <div class="col-12">
                <div class="form-floating">
                    <textarea class="form-control form-control-sm" name="descripcionRepuesto" placeholder="Descripcion de Repuesto..." style="height:80px"></textarea>
                    <label for="floatingSelect">Descripcion de Repuesto</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 6px">
            <div class="col-6">
                <div class="form-floating">
                    <input class="form-control form-control-sm" name="precioSoles" placeholder="Precio Soles">
                    <label for="floatingSelect">Precio Soles</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                <input class="form-control form-control-sm" name="precioDolares" placeholder="Precio Dolares">
                    <label for="floatingSelect">Precio Dolares</label>
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