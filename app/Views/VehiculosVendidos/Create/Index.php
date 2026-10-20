<?php
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Proceso Vehicular - Accesorios (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#tab-home"
                                        role="tab" aria-controls="tab-home" aria-selected="true">General</a></li>
                <?php if($contadorLiberado[0]["contador"]==0){?>
                <li class="nav-item"><a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#tab-profile"
                                        role="tab" aria-controls="tab-profile" aria-selected="false">Liberar Vin</a></li>
                <?php }?>
                <?php if($vinInfo[0]["urgente"]!=1){?>
                <li class="nav-item"><a class="nav-link" id="urgente-tab" data-bs-toggle="tab" href="#tab-urgente"
                                        role="tab" aria-controls="tab-urgente" aria-selected="false">Urgente</a></li>
                <?php }?>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div id="panelVinInfo">

                    </div>
                </div>
                <div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form id="formLiberacion" method="POST" action="<?php echo base_url("VehiculosVendidos/SaveEditDelete/SaveLiberar")?>">
                        <input hidden name="vinLiberacion" value="<?php echo $vin?>">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group">
                                    <div class="form-floating">
                                        <select class="form-control form-control-sm" id="liberarUnidad" required
                                                name="liberarUnidad"
                                                data-choices="data-choices"
                                                aria-label="Floating label select example">
                                            <option value="1">Liberar Vin (Entrega Anticipada)</option>
                                            <option value="2">Liberar Vin (Entrega Anticipada Urgente)</option>
                                        </select>
                                        <label for="floatingSelect">Liberar Vin</label>
                                    </div>
                                    <div class="input-group-append">
                                        <div class="form-floating mb-1">
                                            <input class="form-control" id="fechaLiberarVin" name="fechaLiberarVin"
                                                   value="<?php echo $hoy?>"
                                                   min="<?php echo $hoy?>"
                                                   required type="date"/>
                                            <label for="floatingInput">Fecha Aplica.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-1">
                                    <textarea class="form-control form-control-sm" name="comentarioLiberacion" style="height:120px"></textarea>
                                    <label for="floatingSelect">Comentario Liberacion</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" id="btnProcesarLiberar" class="btn btn-primary btn-sm">PROCESAR
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                                    CANCELAR
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="tab-urgente" role="tabpanel" aria-labelledby="urgente-tab">
                    <form id="formUrgente" method="POST" action="<?php echo base_url("VehiculosVendidos/SaveEditDelete/SaveUrgente")?>">
                        <input hidden name="vinUrgente" value="<?php echo $vin?>">
                        <div class="row">
                            <div class="col-12">
                                <div class="input-group">
                                    <div class="form-floating">
                                        <select class="form-control form-control-sm" id="marcarUrgente" required
                                                name="marcarUrgente"
                                                data-choices="data-choices"
                                                aria-label="Floating label select example">
                                            <option value="1">Urgente</option>
                                        </select>
                                        <label for="floatingSelect">Marcar Urgente</label>
                                    </div>
                                    <div class="input-group-append">
                                        <div class="form-floating mb-1">
                                            <input class="form-control" id="fechaUrgenteVin" name="fechaUrgenteVin"
                                                   value="<?php echo $hoy?>"
                                                   min="<?php echo $hoy?>"
                                                   required type="date"/>
                                            <label for="floatingInput">Fecha Aplica.</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-1">
                                    <select class="form-control form-control-sm" id="solicitante" required
                                            name="solicitante"
                                            data-choices="data-choices"
                                            aria-label="Floating label select example">
                                        <option value="">Seleccione Gerente...</option>
                                        <?php foreach($selectGerente as $sg){?>
                                            <option value="<?php echo $sg["idusuario"]?>"><?php echo $sg["nombres"]." ".$sg["primerApellido"]." ".$sg["segundoApellido"]?></option>
                                        <?php }?>
                                    </select>
                                    <label for="floatingSelect">Solicitanter</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-1">
                                    <textarea class="form-control form-control-sm" name="comentarioLiberacion" style="height:120px"></textarea>
                                    <label for="floatingSelect">Comentario Urgente</label>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" id="btnProcesarLiberar" class="btn btn-primary btn-sm">PROCESAR
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