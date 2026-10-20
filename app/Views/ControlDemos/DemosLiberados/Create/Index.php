<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Control de Demos - Agendar Demo (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#tab-home"
                                        role="tab" aria-controls="tab-home" aria-selected="true">General</a></li>
                <?php if($vinInfo[0]["fechaFinaliza"]<=$hoy){?>
                    <li class="nav-item"><a class="nav-link" id="seminuevo-tab" data-bs-toggle="tab" href="#tab-seminuevo"
                                            role="tab" aria-controls="tab-seminuevo" aria-selected="false">Enviar a Semi Nuevos</a></li>
                <?php }else{?>
                    <li class="nav-item"><a class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                            href="#tab-profile"
                                            role="tab" aria-controls="tab-profile" aria-selected="false">Agendar Demo</a>
                    </li>
                <?php }?>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div id="panelVinInfo">

                    </div>
                </div>
                <div class="tab-pane fade" id="tab-seminuevo" role="tabpanel" aria-labelledby="seminuevo-tab">
                    <form action="<?php echo base_url("ControlDemos/DemosDisponibles/SaveEditDelete/SaveSendSeminuevo") ?>"
                          id="formSeminuevo" method="POST">
                        <input hidden name="idliberacionDemo" value="<?php echo $idliberacionDemo?>">
                        <input hidden name="vinSeminuevo" value="<?php echo $vin ?>">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="form-floating mb-1">
                                    <input class="form-control form-control-sm" type="date" value="<?php echo $hoy?>" min="<?php echo $hoy?>" required name="fechaEnvio">
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
                <div class="tab-pane fade show" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form action="<?php echo base_url("ControlDemos/DemosLiberados/SaveEditDelete/SaveAsignacion") ?>"
                          id="formSave" method="POST">
                        <input hidden name="vinDisponible" value="<?php echo $vin ?>">
                        <input hidden name="idliberacionVin" value="<?php echo $idliberacionDemo?>">
                        <div class="row" style="padding-bottom: 2px">
                            <div class="col-md-6 col-sm-12">
                                <h5 class="text-primary">Entrega</h5>
                                <div class="input-group">
                                    <div class="form-floating mb-1" style="width: 50%">
                                        <input class="form-control form-control-sm" required type="date" max="<?php echo $infoLiberacion[0]["fechaFinaliza"]?>" min="<?php echo (!is_null($infoLiberacion[0]["fechaUltimoRetorno"]))?$infoLiberacion[0]["fechaUltimoRetorno"]:$infoLiberacion[0]["fechaActivacion"]?>" name="fechaEntrega">
                                        <label for="floatingInput">Fecha Entrega</label>
                                    </div>
                                    <div class="input-group-prepend" style="width: 50%">
                                        <div class="form-floating mb-1">
                                            <select class="form-control form-control-sm" required type="date" name="horaEntrega">
                                                <option value="">Hora</option>
                                                <?php foreach($hora as $hr){?>
                                                    <option value="<?php echo $hr["hora"]?>"><?php echo $hr["hora"]?></option>
                                                <?php }?>
                                            </select>
                                            <label for="floatingInput">Hora Entrega</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <h5 class="text-primary">Recepcion</h5>
                                <div class="input-group">
                                    <div class="form-floating mb-1" style="width: 50%">
                                        <input class="form-control form-control-sm" type="date" required max="<?php echo $infoLiberacion[0]["fechaFinaliza"]?>" min="<?php echo (!is_null($infoLiberacion[0]["fechaUltimoRetorno"]))?$infoLiberacion[0]["fechaUltimoRetorno"]:$infoLiberacion[0]["fechaActivacion"]?>" name="fechaRecepcion">
                                        <label for="floatingInput">Fecha Recepcion</label>
                                    </div>
                                    <div class="input-group-prepend" style="width: 50%">
                                        <div class="form-floating mb-1">
                                            <select class="form-control form-control-sm" required type="date"
                                                    name="horaRecepcion">
                                                <option value="">Hora</option>
                                                <?php foreach($hora as $hr){?>
                                                    <option value="<?php echo $hr["hora"]?>"><?php echo $hr["hora"]?></option>
                                                <?php }?>
                                            </select>
                                            <label for="floatingInput">Hora Recepcion</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-1">
                                    <textarea class="form-control form-control-sm bloqueo" style="height: 100px"
                                              id="comentarioAdicional" name="comentarioAdicional"></textarea>
                                    <label for="floatingInput">Comentario Adicional</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <h5 class="text-primary">Datos Externo</h5>
                            <div class="col-6">
                                <div class="input-group">
                                    <div class="form-floating mb-1" style="width: 75%">
                                        <input class="form-control form-control-sm" required id="documentoExterno"
                                               name="documentoExterno">
                                        <label for="floatingInput">Documento</label>
                                    </div>
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-primary" id="btnSearchDoc" style="height: 48px;"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group">
                                    <div class="form-floating mb-1">
                                        <input class="form-control form-control-sm bloqueo" required id="nombreExterno"
                                               name="nombreExterno">
                                        <label for="floatingInput">Nombre Externo</label>
                                    </div>
                                    <div class="input-group-prepend">
                                        <div class="form-floating mb-1">
                                            <input class="form-control form-control-sm bloqueo" id="telefonoExterno"
                                                   name="telefonoExterno">
                                            <label for="floatingInput">Telefono</label>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-1">
                                    <textarea class="form-control form-control-sm bloqueo" style="height: 100px" required
                                              id="direccionExterno" name="direccionExterno"></textarea>
                                    <label for="floatingInput">Direccion Externo</label>
                                </div>
                            </div>
                        </div>
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