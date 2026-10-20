<style>
    .select2-container {
        z-index: 1060 !important; /* Mayor que el modal */
    }
</style>
<div class="modal-body" style="border: 0.5px solid #a2a2a2;border-radius: 5px">
    <div class="row pb-2">
        <div class="col-12">
            <h5 class="text-primary">Crear Destino</h5>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input checkTipoDestino" value="1" id="tipoDestinoCheck1" type="radio"
                       name="tipoDestinoCheck" <?php echo ($guiaRem[0]["idtipoDestino"] == 1) ? 'checked' : '' ?> />
                <label class="form-check-label" for="tipoDestinoCheck1">Establecimmiento del Remitente</label>
            </div>
            <div class="form-check">
                <input class="form-check-input checkTipoDestino" value="2" id="tipoDestinoCheck2" type="radio"
                       name="tipoDestinoCheck" <?php echo ($guiaRem[0]["idtipoDestino"] == 2) ? 'checked' : '' ?>/>
                <label class="form-check-label" for="tipoDestinoCheck2">Establecimiento de un tercero inscrito en el
                    RUC</label>
            </div>
            <div class="form-check">
                <input class="form-check-input checkTipoDestino" value="3" id="tipoDestinoCheck3" type="radio"
                       name="tipoDestinoCheck" <?php echo ($guiaRem[0]["idtipoDestino"] == 3) ? 'checked' : '' ?>/>
                <label class="form-check-label" for="tipoDestinoCheck3">Otra direccion</label>
            </div>
        </div>
    </div>
    <input hidden name="inputTipoDestino" id="inputTipoDestino" value="<?php echo $guiaRem[0]["idtipoDestino"] ?>">
    <div id="panelRucTerceroDest" style="display:<?php echo ($guiaRem[0]["idtipoDestino"] == 2) ? 'block' : 'none' ?>">
        <div class="row pb-2">
            <div class="col-8">
            </div>
            <div class="col-4">
                <input class="form-control form-control-sm" id="rucTerceroDest" value="<?php echo ($guiaRem[0]["idtipoDestino"]==2)?$guiaRem[0]["rucTerceroDestino"]:''?>" placeholder="Ingrese RUC tercero...">
            </div>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <table class="table table-sm fs-9 mb-0 table-hover">

                <tbody id="tbodyEstablecimientoDest">
                <?php if ($guiaRem[0]["idtipoDestino"] == 1) { ?>
                    <?php
                    $contador = 0;
                    foreach ($establecimientos as $est) {
                        $contador++;
                        ?>
                        <tr>
                            <td class="ps-3" style="vertical-align: middle">
                                <div class="form-check">
                                    <input class="form-check-input checkEstablecimientoAnexoDest"
                                           value="<?php echo $est["idestablecimientoFisico"] ?>"
                                           id="flexEstableDest<?php echo $est["idestablecimientoFisico"] ?>" type="radio"
                                        <?php echo ($guiaRem[0]["idestablecimientoFisicoDestino"] == $est["idestablecimientoFisico"]) ? 'checked' : '' ?>
                                           name="checkEstablecimientoDest"/>
                                    <label class="form-check-label"
                                           for="flexEstableDest<?php echo $est["idestablecimientoFisico"] ?>"><?php echo $est["codigo"] ?></label>
                                </div>
                            </td>
                            <td class="ps-3"
                                style="vertical-align: middle"><?php echo $est["tipoEstablecimiento"] ?></td>
                            <td class="ps-3"
                                style="vertical-align: middle"><?php echo $est["codigoUbigeoDistrito"] ?></td>
                            <td class="ps-3" style="vertical-align: middle"><?php echo $est["direccion"] ?></td>
                        </tr>
                    <?php } ?>
                <?php } else if ($guiaRem[0]["idtipoDestino"] != 1) { ?>
                    <tr>
                        <td>
                            <select class="form-control" id="departamentoDestino" required name="departamentoDestino">
                                <option value="">Seleccione Departamento</option>
                                <?php
                                foreach ($departamento as $dep) { ?>
                                    <?php if($guiaRem[0]["ubigeoDepartamentoDestino"]==$dep["codigoUbigeo"]){?>
                                        <option selected value="<?php echo $dep["codigoUbigeo"] ?>"><?php echo $dep["descripcion"] ?></option>
                                    <?php }else{?>
                                        <option value="<?php echo $dep["codigoUbigeo"] ?>"><?php echo $dep["descripcion"] ?></option>
                                    <?php }?>
                                <?php } ?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="provinciaDestino" required name="provinciaDestino">
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
                            <select class="form-control" id="distritoDestino" required name="distritoDestino">
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
                                                            id="direccionDestino" value="<?php echo $guiaRem[0]["direccionDestino"]?>" name="direccionDestino">
                                <div class="input-group-prepend">
                                    <button type="button" id="btnSaveDestT" class="btn btn-light btn-sm">Guardar</button>
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