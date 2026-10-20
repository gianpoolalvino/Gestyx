<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Inmatriculacion - Tacha de Titulo</h5>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                                        href="#tab-profile"
                                        role="tab" aria-controls="tab-profile" aria-selected="false">Inmatriculacion /
                        Tachar Titulo</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-subtle-warning alert-dismissible fade show" role="alert">
                                <strong><i class="fas fa-info-circle"></i>&nbsp;Advertencia de Tacha</strong> Al Tachar un titulo se reiniciara el proceso y el sistema le solicitara ingrese un nuevo titulo
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    Tachar Titulo
                    <form action="<?php echo base_url("Inmatriculacion/SinTitulo/SaveEditDelete/SaveTacha") ?>"
                          id="formSave" method="POST">

                        <div class="input-group" style="padding-bottom: 4px">
                            <div class="input-group-prepend">
                                <div class="form-floating">
                                    <input class="form-control" id="tituloSearchTacha" name="tituloSearchTacha">
                                    <label for="floatingSelect">Titulo</label>
                                </div>
                            </div>
                            <div class="form-floating">
                                <input class="form-control" id="vinSearchTacha" name="vinSearchTacha">
                                <label for="floatingSelect">Vin</label>
                            </div>
                            <button class="btn btn-phoenix-primary btn-sm" id="btnSearchVinTacha" style="height: 48px;" type="button"><i
                                        class="fas fa-search"></i></button>

                            <div class="input-group-append">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="fechaTitulo" name="fechaTitulo"
                                           value="<?php echo $hoy ?>"
                                           max="<?php echo $hoy ?>"
                                           required type="date"/>
                                    <label for="floatingInput">Fecha Aplica.</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-floating">
                                <textarea class="form-control form-control-sm" readonly style="height: 100px"
                                          name="comentarioAdv"
                                          id="comentarioAdv"
                                          placeholder="Ingrese Comentarios"></textarea>
                                    <label for="floatingTextarea2">Motivo Tacha</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-12">
                                <button type="submit" disabled id="btnProccessTacha" class="btn btn-primary btn-sm">
                                    PROCESAR
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