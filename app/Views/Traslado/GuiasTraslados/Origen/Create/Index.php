<style>
    .select2-container {
        z-index: 1060 !important; /* Mayor que el modal */
    }
</style>
<div class="modal-body" style="border: 0.5px solid #a2a2a2;border-radius: 5px">
    <div class="row pb-2">
        <div class="col-12">
            <h5 class="text-primary">Crear Origen</h5>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input checkTipoOrigen" value="1" id="tipoOrigenCheck1" type="radio"
                       name="tipoOrigenCheck" <?php echo ($guiaRem[0]["idtipoOrigen"] == 1) ? 'checked' : '' ?> />
                <label class="form-check-label" for="tipoOrigenCheck1">Establecimmiento del Remitente</label>
            </div>
            <div class="form-check">
                <input class="form-check-input checkTipoOrigen" value="2" id="tipoOrigenCheck2" type="radio"
                       name="tipoOrigenCheck" <?php echo ($guiaRem[0]["idtipoOrigen"] == 2) ? 'checked' : '' ?>/>
                <label class="form-check-label" for="tipoOrigenCheck2">Establecimiento de un tercero inscrito en el
                    RUC</label>
            </div>
            <div class="form-check">
                <input class="form-check-input checkTipoOrigen" value="3" id="tipoOrigenCheck3" type="radio"
                       name="tipoOrigenCheck" <?php echo ($guiaRem[0]["idtipoOrigen"] == 3) ? 'checked' : '' ?>/>
                <label class="form-check-label" for="tipoOrigenCheck3">Otra direccion</label>
            </div>
        </div>
    </div>
    <input hidden name="inputTipoOrigen" id="inputTipoOrigen" value="<?php echo $guiaRem[0]["idtipoOrigen"] ?>">
    <div id="panelRucTercero" style="display:<?php echo ($guiaRem[0]["idtipoOrigen"] == 2) ? 'block' : 'none' ?>">
        <div class="row pb-2">
            <div class="col-8">
            </div>
            <div class="col-4">
                <input class="form-control form-control-sm" id="rucTercero" value="<?php echo ($guiaRem[0]["idtipoOrigen"]==2)?$guiaRem[0]["rucTerceroOrigen"]:''?>" placeholder="Ingrese RUC tercero...">
            </div>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <table class="table table-sm fs-9 mb-0 table-hover">

                <tbody id="tbodyEstablecimiento">
                <?php if ($guiaRem[0]["idtipoOrigen"] == 1) { ?>
                    <?php
                    $contador = 0;
                    foreach ($establecimientos as $est) {
                        $contador++;
                        ?>
                        <tr>
                            <td class="ps-3" style="vertical-align: middle">
                                <div class="form-check">
                                    <input class="form-check-input checkEstablecimientoAnexo"
                                           value="<?php echo $est["idestablecimientoFisico"] ?>"
                                           id="flexEstable<?php echo $est["idestablecimientoFisico"] ?>" type="radio"
                                        <?php echo ($guiaRem[0]["idestablecimientoFisicoOrigen"] == $est["idestablecimientoFisico"]) ? 'checked' : '' ?>
                                           name="checkEstablecimiento"/>
                                    <label class="form-check-label"
                                           for="flexEstable<?php echo $est["idestablecimientoFisico"] ?>"><?php echo $est["codigo"] ?></label>
                                </div>
                            </td>
                            <td class="ps-3"
                                style="vertical-align: middle"><?php echo $est["tipoEstablecimiento"] ?></td>
                            <td class="ps-3"
                                style="vertical-align: middle"><?php echo $est["codigoUbigeoDistrito"] ?></td>
                            <td class="ps-3" style="vertical-align: middle"><?php echo $est["direccion"] ?></td>
                        </tr>
                    <?php } ?>
                <?php } else if ($guiaRem[0]["idtipoOrigen"] != 1) { ?>
                    <tr>
                        <td>
                            <select class="form-control" id="departamentoOrigen" required name="departamentoOrigen">
                                <option value="">Seleccione Departamento</option>
                                <?php
                                foreach ($departamento as $dep) { ?>
                                    <?php if($guiaRem[0]["ubigeoDepartamentoOrigen"]==$dep["codigoUbigeo"]){?>
                                        <option selected value="<?php echo $dep["codigoUbigeo"] ?>"><?php echo $dep["descripcion"] ?></option>
                                    <?php }else{?>
                                        <option value="<?php echo $dep["codigoUbigeo"] ?>"><?php echo $dep["descripcion"] ?></option>
                                    <?php }?>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="provinciaOrigen" required name="provinciaOrigen">
                                <option value="">Seleccione Provincia</option>
                                <?php foreach ($provincia as $pro) { ?>
                                    <?php if($guiaRem[0]["ubigeoProvinciaOrigen"]==$pro["codigoUbigeo"]){?>
                                        <option selected value="<?php echo $pro["codigoUbigeo"] ?>"><?php echo $pro["descripcion"] ?></option>
                                    <?php }else{?>
                                        <option value="<?php echo $pro["codigoUbigeo"] ?>"><?php echo $pro["descripcion"] ?></option>
                                    <?php }?>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="distritoOrigen" required name="distritoOrigen">
                                <option value="">Seleccione Distrito</option>
                                <?php foreach ($distrito as $dist) { ?>
                                    <?php if($guiaRem[0]["ubigeoDistritoOrigen"]==$dist["codigoUbigeo"]){?>
                                        <option selected value="<?php echo $dist["codigoUbigeo"] ?>"><?php echo $dist["descripcion"] ?></option>
                                    <?php }else{?>
                                        <option value="<?php echo $dist["codigoUbigeo"] ?>"><?php echo $dist["descripcion"] ?></option>
                                    <?php }?>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <div class="input-group"><input required class="form-control form-control-sm"
                                                            id="direccionOrigen" value="<?php echo $guiaRem[0]["direccionOrigen"]?>" name="direccionOrigen">
                                <div class="input-group-prepend">
                                    <button type="button" id="btnSaveOrigT" class="btn btn-light btn-sm">Guardar</button>
                                </div>
                            </div>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>