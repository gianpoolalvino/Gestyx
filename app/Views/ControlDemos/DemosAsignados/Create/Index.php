<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
$hora = date("H:i:s");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Control de Demos - Gestionar Demo Asignado (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#tab-home"
                                        role="tab" aria-controls="tab-home" aria-selected="true">General</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        href="#tab-profile"
                                        role="tab" aria-controls="tab-profile" aria-selected="false">Retorno Demo</a>
                </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div id="panelVinInfo">

                    </div>
                </div>
                <div class="tab-pane fade show" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form target="_blank"
                          action="<?php echo base_url("ControlDemos/DemosAsignados/SaveEditDelete/SaveRetorno") ?>"
                          id="formSave" method="POST"
                          onsubmit="javascript: setTimeout(function(){location.reload();}, 1000);return true;">
                        <input hidden name="vinAsignado" value="<?php echo $vin ?>">
                        <input hidden name="idcheckListRetorno" id="idcheckListRetorno"
                               value="<?php echo (isset($checkListRetorno[0]["idcheckListDemo"])) ? $checkListRetorno[0]["idcheckListDemo"] : '' ?>">
                        <input hidden name="idliberacionVin" id="idliberacionVin"
                               value="<?php echo $idliberacionDemo ?>">
                        <input hidden name="idasignarDemo" id="idasignarDemo" value="<?php echo $idasignarDemo ?>">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h5 class="text-primary">Retorno</h5>
                                <div class="input-group">
                                    <div class="form-floating mb-1" style="width: 50%">
                                        <input class="form-control form-control-sm" required type="date"
                                               value="<?php echo $hoy ?>"
                                               min="<?php echo $infoAsignarDemo[0]["fechaEntrega"] ?>"
                                               name="fechaRetorno">
                                        <label for="floatingInput">Fecha Retorno</label>
                                    </div>
                                    <div class="input-group-prepend" style="width: 50%">
                                        <div class="form-floating mb-1">
                                            <input class="form-control form-control-sm" name="horaRetorno" required
                                                   readonly type="time" value="<?php echo $hora ?>">
                                            <label for="floatingInput">Hora Retorno</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h6 class="text-primary">Kilometraje y Gasolina</h6>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating mb-1">
                                    <input class="form-control form-control-sm" required name="kilometraje" placeholder="Kilometraje">
                                    <label for="floatingInput"><i class="fas fa-tire"></i>&nbsp;Kilometraje</label>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-6">
                                <div class="form-floating mb-1">
                                    <select class="form-control form-control-sm" required name="gasolina">
                                        <option value="2">No</option>
                                        <option value="1">Si</option>
                                    </select>
                                    <label for="floatingInput">Gasolina</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-8">
                                <h5 class="text-primary">Adjuntos</h5>
                            </div>
                            <div class="col-4" style="text-align: right">
                                <button class="btn btn-outline-info btn-sm" id="btnuploadResource"><i
                                            class="fas fa-plus"></i>&nbsp;Añadir Imagen
                                </button>
                            </div>
                        </div>
                        <div id="panelResourceAsignacion">
                            <div class="row">

                                <?php
                                if (!empty($detalleResource)) {
                                    foreach ($detalleResource as $dtr) {
                                        ?>
                                        <div class="col-sm-4 col-md-4 col-lg-4">
                                            <div class="card border border-secondary">
                                                <div class="card-body">
                                                    <p class="card-text"><?php echo $dtr["nombreImagen"] ?></p>
                                                </div>
                                                <div class="card-footer" style="padding:6px">
                                                    <button type="button" data-id="<?php echo $dtr["idresourceAsignacionDemo"]?>" onclick="DeleteResource(<?php echo $dtr["idresourceAsignacionDemo"]?>)" class="btn btn-danger btn-sm btnTrashImage"><i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-primary">Servicio Sugerido</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                            <?php foreach($servicioSugerido as $sgr){?>
                                <input hidden name="checkIdService[]" id="checkIdService<?php echo $sgr["idservicioSugerido"]?>" value="<?php echo $sgr["idservicioSugerido"]?>">
                                <input hidden name="checkService[]" value="0" id="checkService<?php echo $sgr["idservicioSugerido"]?>">
                                    <input class="form-check-input checkSerVin"
                                           data-id="<?php echo $sgr["idservicioSugerido"] ?>"
                                           name="serviceCheck[]"
                                           id="flexCheckService<?php echo $sgr["idservicioSugerido"] ?>"
                                           type="checkbox" value="1"/>
                                    <label class="form-check-label"
                                           for="flexCheckService<?php echo $sgr["idservicioSugerido"] ?>"><?php echo $sgr["descripcion"] ?></label>&nbsp;&nbsp;&nbsp;

                            <?php }?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-primary">Observaciones Bajo Piso</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-1" style="width: 100%">
                                    <textarea class="form-control form-control-sm" style="height: 80px"
                                              name="observacionesBajoPiso"></textarea>
                                    <label for="floatingInput">Observaciones Bajo Piso</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-8">
                                <h5 class="text-primary">Diagrama Vehiculo</h5>
                            </div>
                            <div class="col-4" style="text-align: right !important">
                                <button id="btnAddDiagrama" class="btn btn-outline-info btn-sm">Agregar Diagrama</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">

                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-8">
                                <h5 class="text-primary">Check List Retorno</h5>
                            </div>
                        </div>
                        <div class="row">
                            <?php foreach ($inventarioDemo as $idm) { ?>
                                <div class="col-md-4 col-sm-12">
                                    <input hidden name="idinventarioDemo[]"
                                           value="<?php echo $idm["idinventarioDemo"] ?>">
                                    <input hidden name="equipadoDemo[]" value="0"
                                           id="equipadoDemo<?php echo $idm["idinventarioDemo"] ?>">
                                    <div class="input-group">
                                        <div class="form-check" style="width: 80%">
                                            <input class="form-check-input checkVin"
                                                   data-id="<?php echo $idm["idinventarioDemo"] ?>" <?php echo ($idm["required"] == 1) ? 'required' : '' ?>
                                                   name="checkEq[]"
                                                   id="flexCheckDefault<?php echo $idm["idinventarioDemo"] ?>"
                                                   type="checkbox" value="1"/>
                                            <label class="form-check-label"
                                                   for="flexCheckDefault<?php echo $idm["idinventarioDemo"] ?>"><?php echo $idm["descripcion"] ?></label>
                                        </div>
                                        <?php if ($idm["cantidad"] == 1) { ?>
                                            <div class="input-group-prepend" style="width:20%">
                                                <input class="form-control form-control-sm"
                                                       id="cantidadEq<?php echo $idm["idinventarioDemo"] ?>"
                                                       min="<?php echo $idm["min"] ?>" max="<?php echo $idm["max"] ?>"
                                                       readonly name="cantidadEq[]">
                                            </div>
                                        <?php } else { ?>
                                            <input hidden name="cantidadEq[]">
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <h5 class="text-primary">Informe de Retorno</h5>
                                <div class="form-floating mb-1" style="width: 100%">
                                    <textarea class="form-control form-control-sm" style="height: 80px" required
                                              name="comentarioRetorno"></textarea>
                                    <label for="floatingInput">Comentarios Retorno</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" id="btnProcesarAccess" class="btn btn-primary btn-sm">PROCESAR
                                    RETORNO
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                                    CANCELAR
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>