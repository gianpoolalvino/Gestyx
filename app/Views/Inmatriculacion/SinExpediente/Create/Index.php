<?php
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
?>

<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Proceso Vehicular - PDI (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#tab-home"
                                        role="tab" aria-controls="tab-home" aria-selected="true">General</a></li>
                <li class="nav-item"><a class="nav-link" id="timeline-tab" data-bs-toggle="tab" href="#tab-timeline"
                                        role="tab" aria-controls="tab-timeline" aria-selected="true">Linea de Tiempo</a>
                </li>
                <li class="nav-item"><a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#tab-profile"
                                        role="tab" aria-controls="tab-profile" aria-selected="false">Inmatriculacion / Expediente</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div id="panelVinInfo">
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-timeline" role="tabpanel" aria-labelledby="timeline-tab">
                    <div id="time">
                        <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
                            <div class="card-header bg-body-highlight pt-3 pb-2 border-bottom-0">
                                <ul class="nav justify-content-between nav-wizard" role="tablist">
                                    <li class="nav-item" role="presentation"><a class="nav-link active fw-semibold"
                                                                                href="#bootstrap-wizard-tab1"
                                                                                data-bs-toggle="tab"
                                                                                data-wizard-step="1"
                                                                                aria-selected="true" role="tab">
                                            <div class="text-center d-inline-block"><span
                                                    class="nav-item-circle-parent">
                                                    <span class="nav-item-circle">
                                                        <i class="fas fa-phone"></i>
                                                    </span></span><span
                                                    class="d-none d-md-block mt-1 fs-9">Bienvenida</span></div>
                                        </a></li>
                                </ul>
                            </div>
                            <div class="card-body pt-4 pb-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" role="tabpanel" aria-labelledby="bootstrap-wizard-tab1"
                                         id="bootstrap-wizard-tab1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">Expediente
                    <form action="<?php echo base_url("Inmatriculacion/SinExpediente/SaveEditDelete/SaveExpediente") ?>"
                          id="formSave" method="POST">
                        <input hidden name="vinExpe" value="<?php echo $vin ?>">
                        <div class="input-group" style="padding-bottom: 4px">
                            <div class="input-group-prepend" style="width: 60%">
                                <div class="form-floating">
                                    <input class="form-control form-control-sm" name="expediente">
                                    <label for="floatingSelect">Expediente</label>
                                </div>
                            </div>
                            <div class="form-floating">
                                <input class="form-control form-control-sm"
                                       name="ciudadMatricula"
                                       list="listaCiudades"
                                       oninput="this.value = this.value.toUpperCase();"
                                       id="ciudadMatricula">
                                <label for="ciudadMatricula">Ciudad Matricula</label>

                                <datalist id="listaCiudades">
                                    <?php foreach ($ciudad as $ci): ?>
                                        <option value="<?= strtoupper($ci['nombre']) ?>"></option>
                                    <?php endforeach; ?>
                                </datalist>
                            </div>
                            <div class="input-group-append">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="fechaExpediente" name="fechaExpediente"
                                           value="<?php echo $hoy?>"
                                           max="<?php echo $hoy?>"
                                           required type="date"/>
                                    <label for="floatingInput">Fecha Aplica.</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-floating">
                                <textarea class="form-control form-control-sm" style="height: 100px"
                                          name="comentarioAdv"
                                          placeholder="Ingrese Comentarios"></textarea>
                                    <label for="floatingTextarea2">Comentarios de
                                        ADV</label>
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