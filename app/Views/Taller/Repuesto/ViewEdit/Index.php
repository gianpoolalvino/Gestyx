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
    <form id="formRepuestoEdit" method="POST" action="<?php echo base_url("Taller/Repuesto/SaveEditDelete/UpdateRepuesto") ?>">
        <div class="row" style="padding-top:1px">
            <div class="col-12">
                <h4 class="text-primary">Editar Repuesto</h4>
            </div>
        </div>
        <input hidden name="idrepuesto" value="<?php echo $repuesto[0]["idrepuesto"] ?>">
        <div class="row">
            <div class="col-12">
                <div class="input-group">
                    <div class="form-floating">
                        <select class="form-control form-control-sm"  disabled
                                name="marca"
                                data-choices="data-choices"
                                aria-label="Floating label select example">
                            <option value="">Seleccione Marca</option>
                            <?php foreach($selectMarca as $smr){?>
                                <?php if($repuesto[0]["idmarcaAfectada"]==$smr["idmarca"]){?>
                                    <option selected value="<?php echo $smr["idmarca"]?>"><?php echo $smr["descripcion"]?></option>
                                <?php }else{?>
                                    <option value="<?php echo $smr["idmarca"]?>"><?php echo $smr["descripcion"]?></option>
                                <?php }?>
                            <?php }?>
                        </select>
                        <label for="floatingSelect">Marca</label>
                    </div>
                    <div class="input-group-append" style="width:60%">
                        <div class="form-floating">
                            <input class="form-control form-control-sm" disabled placeholder="Ingrese Codigo de Repuesto..." value="<?php echo $repuesto[0]["codigo"]?>">
                            <label for="floatingSelect">Codigo</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 6px">
            <div class="col-12">
                <div class="form-floating">
                    <textarea class="form-control form-control-sm" disabled placeholder="Descripcion de Repuesto..." style="height:80px"><?php echo $repuesto[0]["descripcion"]?></textarea>
                    <label for="floatingSelect">Descripcion de Repuesto</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 6px">
            <div class="col-6">
                <div class="form-floating">
                    <input class="form-control form-control-sm" name="precioSoles" value="<?php echo $repuesto[0]["precioSoles"] ?>" placeholder="Precio Soles">
                    <label for="floatingSelect">Precio Soles</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <input class="form-control form-control-sm" name="precioDolares" value="<?php echo $repuesto[0]["precioDolares"] ?>" placeholder="Precio Dolares">
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