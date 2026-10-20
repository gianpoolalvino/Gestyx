<?php
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Control de Demos - Liberar Demo (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="profile-tab" data-bs-toggle="tab" href="#tab-profile"
                                        role="tab" aria-controls="tab-profile" aria-selected="false">Liberar Vin</a></li>
                <li class="nav-item"><a class="nav-link" id="seminuevo-tab" data-bs-toggle="tab" href="#tab-seminuevo"
                                        role="tab" aria-controls="tab-seminuevo" aria-selected="false">Enviar a Semi Nuevos</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form action="<?php echo base_url("ControlDemos/DemosDisponibles/SaveEditDelete/SaveLiberacion") ?>"
                          id="formSave" method="POST">
                        <input hidden name="vinDisponible" value="<?php echo $vin ?>">
                        <div class="input-group">
                            <div class="form-floating mb-1">
                                <select class="form-control form-control-sm" required
                                        name="tipoDemo"
                                        id="tipoDemo"
                                        data-choices="data-choices"
                                        aria-label="Floating label select example">
                                    <?php foreach($tipoDemo as $td){?>
                                        <option value="<?php echo $td["idtipoDemo"]?>"><?php echo $td["descripcion"]?></option>
                                    <?php }?>
                                </select>
                                <label for="floatingInput">Tipo Demo</label>
                            </div>
                            <div class="input-group-prepend">
                                <div class="form-floating mb-1">
                                    <input class="form-control form-control-sm" type="date" required name="fechaActivar">
                                    <label for="floatingInput">Fecha Activacion</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-floating mb-1">
                                    <textarea class="form-control form-control-sm" style="height:150px" required name="comentarioLiberado"></textarea>
                                    <label for="floatingInput">Comentario Liberacion</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <button type="submit" id="btnProcesarAccess" class="btn btn-primary btn-sm">PROCESAR</button>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                                    CANCELAR
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="tab-pane fade" id="tab-seminuevo" role="tabpanel" aria-labelledby="seminuevo-tab">
                    <form action="<?php echo base_url("ControlDemos/DemosDisponibles/SaveEditDelete/SaveSendSeminuevo") ?>"
                          id="formSeminuevo" method="POST">
                        <input hidden name="vinSeminuevo" value="<?php echo $vin ?>">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="form-floating mb-1">
                                    <input class="form-control form-control-sm" type="date" value="<?php echo $hoy?>" required name="fechaEnvio">
                                    <label for="floatingInput">Fecha Envio</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-floating mb-1">
                                    <textarea class="form-control form-control-sm" style="height:150px" required name="comentarioSeminuevo"></textarea>
                                    <label for="floatingInput">Comentario Envio Seminuevo</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <button type="submit" id="btnProcesarAccess" class="btn btn-primary btn-sm">PROCESAR</button>
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