<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
$hora=date("H:i:s");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Control de Demos - Entregar Demo (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#tab-home"
                                        role="tab" aria-controls="tab-home" aria-selected="true">General</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                        href="#tab-profile"
                                        role="tab" aria-controls="tab-profile" aria-selected="false">Entregar Demo</a>
                </li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div id="panelVinInfo">

                    </div>
                </div>
                <div class="tab-pane fade show" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form action="<?php echo base_url("ControlDemos/DemosPorEntregar/SaveEditDelete/SaveEntrega") ?>"
                          id="formSave" method="POST">
                        <input hidden name="vinDisponible" value="<?php echo $vin ?>">
                        <input hidden name="idliberacionVin" value="<?php echo $idliberacionDemo?>">
                        <input hidden name="idasignarDemo" value="<?php echo $idasignarDemo?>">
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <h6 class="text-primary">Entrega</h6>
                                <div class="input-group">
                                    <div class="form-floating mb-1" style="width: 50%">
                                        <input class="form-control form-control-sm" required type="date" value="<?php echo $hoy?>" max="<?php echo $infoAsignarDemo[0]["fechaEntrega"]?>" min="<?php echo $infoAsignarDemo[0]["fechaEntrega"]?>" name="fechaEntrega">
                                        <label for="floatingInput">Fecha Entrega</label>
                                    </div>
                                    <div class="input-group-prepend" style="width: 50%">
                                        <div class="form-floating mb-1">
                                            <input class="form-control form-control-sm" name="horaEntrega" required readonly type="time" value="<?php echo $hora?>" >
                                            <label for="floatingInput">Hora Entrega</label>
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
                            <div class="col-12">
                                <h6 class="text-primary">Check List de Entrega</h6>
                            </div>
                        </div>
                        <div class="row">
                            <?php foreach($inventarioDemo as $idm){?>
                                <div class="col-md-4 col-sm-12">
                                    <input hidden name="idinventarioDemo[]" value="<?php echo $idm["idinventarioDemo"]?>">
                                    <input hidden name="equipadoDemo[]" value="0" id="equipadoDemo<?php echo $idm["idinventarioDemo"]?>">
                                    <div class="input-group">
                                        <div class="form-check" style="width: 80%">
                                            <input class="form-check-input checkVin" data-id="<?php echo $idm["idinventarioDemo"]?>" <?php echo ($idm["required"]==1)?'required':''?> name="checkEq[]" id="flexCheckDefault<?php echo $idm["idinventarioDemo"]?>" type="checkbox" value="1" />
                                            <label class="form-check-label" for="flexCheckDefault<?php echo $idm["idinventarioDemo"]?>"><?php echo $idm["descripcion"]?></label>
                                        </div>
                                        <?php if($idm["cantidad"]==1){?>
                                            <div class="input-group-prepend" style="width:20%">
                                                <input class="form-control form-control-sm" id="cantidadEq<?php echo $idm["idinventarioDemo"]?>" min="<?php echo $idm["min"]?>" max="<?php echo $idm["max"]?>" readonly name="cantidadEq[]">
                                            </div>
                                        <?php }else{?>
                                            <input hidden name="cantidadEq[]">
                                        <?php }?>
                                    </div>
                                </div>
                            <?php }?>
                        </div><br>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-floating mb-1" style="width: 100%">
                                    <textarea class="form-control form-control-sm" style="height: 100px" required name="comentarioEntrega"></textarea>
                                    <label for="floatingInput">Comentarios y Observaciones Adicionales</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <button type="submit" id="btnProcesarAccess" class="btn btn-primary btn-sm">PROCESAR COMODATO Y CHECKLIST
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