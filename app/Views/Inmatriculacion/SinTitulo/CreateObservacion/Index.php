<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Inmatriculacion - Observacion Titulo</h5>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                                        href="#tab-profile"
                                        role="tab" aria-controls="tab-profile" aria-selected="false">Inmatriculacion /
                        Observacion</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-subtle-warning alert-dismissible fade show" role="alert">
                                <strong><i class="fas fa-info-circle"></i>&nbsp;Advertencia de Observacion</strong> Este proceso requiere sustentos validos
                                <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    </div>
                    Crear Observacion Titulo
                    <form enctype="multipart/form-data" action="<?php echo base_url("Inmatriculacion/SinTitulo/SaveEditDelete/SaveObservacion") ?>"
                          id="formSaveObstitulo" method="POST">

                        <div class="input-group" style="padding-bottom: 4px">
                            <div class="input-group-prepend">
                                <div class="form-floating">
                                    <input class="form-control" id="tituloSearchTacha" name="tituloSearch">
                                    <label for="floatingSelect">Titulo</label>
                                </div>
                            </div>
                            <div class="form-floating">
                                <input class="form-control" id="vinSearchTacha" name="vinSearch">
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
                        <div class="row pb-2">
                            <div class="col-12">
                                <div class="form-floating">
                                <input class="form-control form-control-sm" autocomplete="off" required
                                          name="tituloObservacion"
                                          id="tituloObservacion"
                                          placeholder="Ingrese Titulo">
                                    <label for="floatingTextarea2">Motivo Observacion</label>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-12">
                                <div class="form-floating">
                                <textarea class="form-control form-control-sm" autocomplete="off" style="height: 100px"
                                          name="comentarioAdv"
                                          id="comentarioAdv"
                                          placeholder="Ingrese Comentarios"></textarea>
                                    <label for="floatingTextarea2">Detalles</label>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-12">
                                <label class="form-label" for="resourceDetalleObs">Subir Imagen</label>
                                <input class="form-control form-control-sm" required name="resourceDetalleObs" id="resourceDetalleObs" type="file"/>
                            </div>
                        </div>
                        <hr>
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