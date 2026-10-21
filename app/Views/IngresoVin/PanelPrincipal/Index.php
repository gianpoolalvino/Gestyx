<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="row">
    <div class="col-3">
        <label class="spanlabel">Marca</label><br>
        <strong><?php echo $vinInfo[0]["marca"] ?></strong>
    </div>
    <div class="col-3">
        <label class="spanlabel">Familia</label><br>
        <strong><?php echo $vinInfo[0]["familia"] ?></strong>
    </div>
    <div class="col-6">
        <label class="spanlabel">Modelo</label><br>
        <strong><?php echo $vinInfo[0]["modelo"] ?></strong>
    </div>
</div>
<div class="row">
    <div class="col-3">
        <label class="spanlabel">Año Modelo</label><br>
        <strong><?php echo $vinInfo[0]["anhoModelo"] ?></strong>
    </div>
    <div class="col-3">
        <label class="spanlabel">Año Fabricacion</label><br>
        <strong><?php echo $vinInfo[0]["anhoFabricacion"] ?></strong>
    </div>
    <div class="col-6">
        <label class="spanlabel">Color</label><br>
        <strong><?php echo $vinInfo[0]["color"] ?></strong>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <label class="spanlabel">Bodega</label><br>
        <strong><?php echo $vinInfo[0]["bodega"] ?></strong>
    </div>
</div>
<hr>
<?php if (!empty($datosIngreso)) { ?>
    <div class="row" style="padding-bottom: 8px">
        <div class="col-3">
            <label class="spanlabel" style="font-size: 12px">Fecha Recepcion (*)</label><br>
            <strong><?php echo $datosIngreso[0]["fechaIngreso"] ?></strong>

        </div>
        <div class="col-4">
            <label class="spanlabel" style="font-size: 12px">Ubicacion Fisica</label><br>
            <strong><?php echo $datosIngreso[0]["ubicacion"] ?></strong>
        </div>
        <div class="col-2">
            <label class="spanlabel" style="font-size: 12px">Numero Guia (*)</label><br>
            <strong><?php echo $datosIngreso[0]["nroGuiaRemision"] ?></strong>
        </div>
        <div class="col-3">
            <label class="spanlabel" style="font-size: 12px">Kilometraje (*)</label><br>
            <strong><?php echo $datosIngreso[0]["kilometraje"] ?></strong>
        </div>
    </div>
    <div class="row" style="padding-bottom: 8px">
        <div class="col-12">
            <label class="spanlabel" style="font-size: 12px">Foto Guia (*)</label><br>
            <?php
            if(!is_null($datosIngreso[0]["imagenGuia"])){
                $base64 = imagen_src($datosIngreso[0]["imagenGuia"], $datosIngreso[0]["tipoImagen"]); ?>
                <img style="width: 20%" src="<?php echo $base64?>">
            <?php } ?>
        </div>
    </div>
    <input hidden id="idingresoVinPrin" value="<?php echo $idingresoVin ?>">
    <input hidden id="vinIngresoPrin" value="<?php echo $vin ?>">
    <div class="row" style="padding-bottom: 8px">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item" disabled><a class="nav-link active" id="ingreso-tab" data-bs-toggle="tab"
                                                 href="#tab-ingreso" role="tab"
                                                 aria-controls="tab-ingreso" aria-selected="true">Ingreso Vehiculo</a>
                </li>
                <li class="nav-item" disabled><a class="nav-link" id="imagen-tab" data-bs-toggle="tab"
                                                 href="#tab-imagen" role="tab"
                                                 aria-controls="tab-imagen" aria-selected="false">Imagen Vehiculo</a>
                </li>
                <li class="nav-item" disabled><a class="nav-link" id="observacion-tab" data-bs-toggle="tab"
                                                 href="#tab-observacion" role="tab"
                                                 aria-controls="tab-observacion" aria-selected="false">Observaciones</a>
                </li>

                <?php if($vinInfo[0]["marca"]=='FORD'){?>
                    <li class="nav-item" disabled><a class="nav-link" id="duaf-tab" data-bs-toggle="tab"
                                                     href="#tab-duaf" role="tab"
                                                     aria-controls="tab-duaf" aria-selected="false">DUAF</a>
                    </li>
                <?php }?>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="panelMultiple" role="tabpanel"
                     aria-labelledby="principal-tab">
                    <div id="panelPrincipalMultiple">
                    <?php
                    if (!empty($equipamientoIngreso)) {
                        ?>
                        <div class="row">
                            <?php foreach ($equipamientoIngreso as $form) { ?>
                                <div class="col-<?php echo $form["col"] ?>" style="padding-bottom: 8px">
                                    <label class="spanlabel" style="font-size: 12px"><?php echo $form["descripcion"] ?>
                                        (*)</label><br>
                                    <?php if ($form["tipoCampo"] == 'radiobutton') { ?>
                                        <?php echo ($form["resultado"] == 1) ? 'Si' : 'No' ?>
                                    <?php } else { ?>
                                        <?php echo $form["resultado"]; ?>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="row" style="padding-bottom: 8px">
                            <div class="col-12">
                                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">
                                    CERRAR
                                </button>
                            </div>
                        </div>
                    <?php } else { ?>
                        <form id="formEquipamientosVin" method="POST"
                              action="<?php echo base_url("IngresoVin/SaveEditDelete/SaveEquipamiento") ?>">
                            <input hidden name="idingresoCheckForm" value="<?php echo $idingresoVin ?>">
                            <input hidden name="viningresoCheckForm" value="<?php echo $vin ?>">
                            <div class="row">
                                <?php foreach ($formularioEquipamiento as $form) { ?>
                                    <input hidden required name="campoCheck[]"
                                           value="<?php echo $form["idcheckIngresoVin"] ?>">
                                    <div class="col-<?php echo $form["col"] ?>" style="padding-bottom: 8px">
                                        <label class="spanlabel"
                                               style="font-size: 12px"><?php echo $form["descripcion"] ?>(*)</label><br>
                                        <?php if ($form["tipoCampo"] == 'select') { ?>
                                            <select class="form-control form-control-sm" required
                                                    name="options<?php echo $form["idcheckIngresoVin"] ?>">
                                                <option value="">Seleccione Opcion...</option>
                                                <?php
                                                $frm = explode('##', $form["opciones"]);
                                                foreach ($frm as $fm) {
                                                    ?>
                                                    <option value="<?php echo $fm ?>"><?php echo $fm ?></option>
                                                <?php } ?>
                                            </select>
                                        <?php } else if ($form["tipoCampo"] == 'radiobutton') { ?>
                                            <input type="radio" class="btn-check" required
                                                   name="options<?php echo $form["idcheckIngresoVin"] ?>"
                                                   id="option<?php echo $form["idcheckIngresoVin"] ?>1" value="1"
                                                   autocomplete="off">
                                            <label class="btn btn-outline-secondary"
                                                   for="option<?php echo $form["idcheckIngresoVin"] ?>1">Si</label>

                                            <input type="radio" class="btn-check" required
                                                   name="options<?php echo $form["idcheckIngresoVin"] ?>"
                                                   id="option<?php echo $form["idcheckIngresoVin"] ?>2" value="2"
                                                   autocomplete="off">
                                            <label class="btn btn-outline-secondary"
                                                   for="option<?php echo $form["idcheckIngresoVin"] ?>2">No</label>
                                        <?php } else if ($form["tipoCampo"] == "textarea") { ?>
                                            <textarea class="form-control form-control-sm"
                                                      name="options<?php echo $form["idcheckIngresoVin"] ?>"
                                                      style="height: 80px"></textarea>
                                        <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row" style="padding-bottom: 8px">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-sm" type="submit" id="btnProcesar">PROCESAR
                                    </button>
                                    <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">
                                        CANCELAR
                                    </button>
                                </div>
                            </div>
                        </form>
                    <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } else { ?>
    <form id="formIngreso" method="POST" enctype="multipart/form-data" action="<?php echo base_url("IngresoVin/SaveEditDelete/SaveIngreso") ?>">
        <input hidden name="vinIngreso" value="<?php echo $vin ?>">
        <div class="row" style="padding-bottom: 8px">
            <div class="col-lg-3 col-sm-6 col-md-3">
                <label class="spanlabel" style="font-size: 12px">Fecha Recepcion (*)</label>
                <input class="form-control form-control-sm" name="fechaRecepcion" autocomplete="off" required
                       type="date"
                       value="<?php echo $hoy ?>" max="<?php echo $hoy ?>">
            </div>
            <div class="col-lg-5 col-sm-6 col-md-5">
                <label class="spanlabel" style="font-size: 12px">Ubicacion Fisica</label>
                <div class="input-group" style="width: 100%">
                    <div class="input-group-append" style="width: 70%">
                        <select class="form-control form-control-sm" id="selectUbicacion" style="width: 100%" name="selectUbicacion">
                            <option value="">Seleccionar Ubicacion...</option>
                            <?php foreach ($ubicacion as $ubi) { ?>
                                <option value="<?php echo $ubi["idubicacion"] ?>"><?php echo $ubi["descripcion"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="input-group-prepend" style="width: 30%">
                        <select class="form-control form-control-sm" id="boxNuevo" name="boxNuevo">
                            <option value="">Box</option>
                        </select>
                    </div>
                </div>


            </div>
            <input hidden name="ubicacionAnterior" value="<?php echo $vinInfo[0]["idubicacion"] ?>">
            <div class="col-lg-2 col-sm-6 col-md-2">
                <label class="spanlabel" style="font-size: 12px">Numero Guia (*)</label>
                <input class="form-control form-control-sm" required name="nroGuia" autocomplete="off">
            </div>
            <div class="col-lg-2 col-sm-6 col-md-2">
                <label class="spanlabel" style="font-size: 12px">Kilometraje (*)</label>
                <input class="form-control form-control-sm" type="number" min="0" step="any" autocomplete="off" required
                       name="kilometraje">
            </div>
        </div>
        <div class="row" style="padding-bottom: 8px">
            <div class="col-12">
                <label class="spanlabel" style="font-size: 12px">Foto Guia (*)</label><br>
                <div class="input-group">
                    <input style="width: 85%" class="form-control form-control-sm"
                           name="resourceImg"
                           required
                           id="resourceImg" type="file"/>
                    <div class="input-group-append" style="width: 15%">
                        <button class="btn btn-outline-primary" type="submit" id="procesarIngreso">Generar&nbsp;<i
                                    class="fas fa-arrow-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>
<?php } ?>

