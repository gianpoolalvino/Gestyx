<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Proceso Vehicular - Campañas (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                                        href="#tab-profile"
                                        role="tab" aria-controls="tab-profile" aria-selected="false">Campañas</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form action="<?php echo base_url("CampanhaVehicular/AplicacionCampanha/SaveEditDelete/SaveAplicarCampanha") ?>"
                          id="formSave" method="POST">
                        <input hidden name="idvinCampanha" value="<?php echo $idvinCampanha?>">
                        <input hidden name="vinCampanha" value="<?php echo $vin ?>">
                        Campaña
                        <div class="input-group mb-1" style="padding-bottom: 4px">
                            <div class="form-floating">
                                <select class="form-control form-control-sm selectCmp" id="selectCampanha" required
                                        name="selectCampanha"
                                        data-choices="data-choices"
                                        aria-label="Floating label select example">
                                    <?php foreach ($selectCampanha as $cmp) { ?>
                                        <?php if ($cmp["idcampanha"] != '1') { ?>
                                            <?php if ($idcampanha == $cmp["idcampanha"]) { ?>
                                                <option value="<?php echo $cmp["idcampanha"] ?>"><?php echo $cmp["codigo"] . " - " . $cmp["nombre"] ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </select>
                                <label for="floatingSelect">Campaña</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-group mb-1" style="padding-bottom: 4px">
                                <div class="form-floating">
                                    <select class="form-control form-control-sm selectCmp" id="selectEstado" required
                                            name="selectEstado"
                                            data-choices="data-choices"
                                            aria-label="Floating label select example">
                                        <?php foreach ($selectEstado as $ste) { ?>
                                            <?php if ($ste["idestadoCampanha"] == 1 || $ste["idestadoCampanha"] == 4) { ?>
                                                <option value="<?php echo $ste["idestadoCampanha"] ?>"><?php echo $ste["descripcion"] ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <label for="floatingSelect">Estado</label>
                                </div>
                                <div class="input-group-append">
                                    <div class="form-floating">
                                        <input class="form-control form-control-sm" type="date"
                                               value="<?php echo $hoy ?>"
                                               max="<?php echo $hoy ?>"
                                               name="fechaAplicacion">
                                        <label for="floatingSelect">fecha</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-floating">
                                <textarea class="form-control form-control-sm" style="height: 100px"
                                          name="comentarioCampanha"
                                          placeholder="Ingrese Comentarios"></textarea>
                                    <label for="floatingTextarea2">Comentarios de
                                        Campaña</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-12">
                                <button type="submit" id="btnProcesarAccess" class="btn btn-primary btn-sm">PROCESAR
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