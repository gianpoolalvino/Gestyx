<?php
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Equipamiento Adicional - GPS (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#tab-home"
                                        role="tab" aria-controls="tab-home" aria-selected="true">General</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#tab-profile"
                                        role="tab" aria-controls="tab-profile" aria-selected="false">GPS</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div id="panelVinInfo">

                    </div>
                </div>
                <div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form action="<?php echo base_url("EquipamientoAdicional/Gps/SaveEditDelete/SaveGps") ?>"
                          id="formSave" method="POST">
                        <input hidden name="vinEquipamiento" value="<?php echo $vin ?>">
                        <div class="form-row">
                            <div class="col-12">
                                <?php if($infoVin[0]["gps"]==1){?>
                                    GPS
                                    <?php $requiredGps='';?>
                                    <input hidden name="gps" value="1">
                                    <?php foreach ($equipamiento as $eq) { ?>
                                        <?php if ($eq["idestadoEquipamiento"] != 2) {
                                            if ($eq["idtipoEquipamiento"] == 2) {
                                                ?>
                                                <input hidden name="equipamientoGps"
                                                       value="<?php echo $eq["idequipamientoVin"] ?>">
                                                <input hidden name="idtipoEquipamientoGps"
                                                       value="<?php echo $eq["idtipoEquipamiento"] ?>">
                                                <div class="input-group" style="padding-bottom: 4px">
                                                    <div class="form-floating">
                                                        <select class="form-control form-control-sm" required
                                                                name="estadoEquipamientoGps"
                                                                id="estadoEquipamientoGps"
                                                                data-choices="data-choices"
                                                                aria-label="Floating label select example">
                                                            <?php if($eq["idestadoEquipamiento"]==1){
                                                                $requiredGps='required';
                                                                ?>
                                                                <option selected value="2">Instalar</option>
                                                                <option value="4">No Requiere</option>
                                                            <?php }else if($eq["idestadoEquipamiento"]==3){?>
                                                                <option  value="2">Instalar</option>
                                                                <option value="4">No Requiere</option>
                                                            <?php }?>
                                                        </select>
                                                        <label for="floatingSelect"><?php echo $eq["equipamiento"] ?></label>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <div class="form-floating mb-3">
                                                            <input class="form-control" name="fechaInstalacionGps" <?php echo $requiredGps?> id="fechaInstalacionGps" type="date"
                                                                   value="<?php echo $hoy?>"
                                                                   max="<?php echo $hoy?>"/>
                                                            <label for="floatingInput">Fecha Inst.</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php }else{?>
                                    <input hidden name="gps" value="0">
                                <?php }?>
                            </div>
                        </div><br>
                        ADICIONALES
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-floating">
                                <textarea class="form-control form-control-sm" style="height: 100px" name="comentarioAccesorio"
                                          placeholder="Ingrese Comentarios"></textarea>
                                    <label for="floatingTextarea2">Comentarios de
                                        Instalacion</label>
                                </div>
                            </div>
                        </div>
                        <br>
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