<?php
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
?>
<style>
    #chartdiv {
        width: 100%;
        height: 200px;
    }
</style>
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
                                        role="tab" aria-controls="tab-profile" aria-selected="false">PDI</a></li>
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
                <div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">PDI
                    <form action="<?php echo base_url("AlistamientoVehicular/Pdi/SaveEditDelete/SavePdi") ?>"
                          id="formSave" method="POST">
                        <input hidden name="vinPdi" value="<?php echo $vin ?>">
                        <div class="input-group" style="padding-bottom: 4px">
                            <div class="form-floating">
                                <select class="form-control form-control-sm" id="estadoOnstar" required
                                        name="estadoOnstar"
                                        data-choices="data-choices"
                                        aria-label="Floating label select example">
                                    <option value="1">Aplica</option>
                                    <option value="2">No Aplica</option>
                                </select>
                                <label for="floatingSelect">Onstar</label>
                            </div>
                            <div class="input-group-append">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="fechaValidacionOns" name="fechaValidacionOns"
                                           value="<?php echo $hoy?>"
                                           max="<?php echo $hoy?>"
                                           required type="date"/>
                                    <label for="floatingInput">Fecha Aplica.</label>
                                </div>
                            </div>
                        </div>
                        <?php if($idtipoFormulario==1){?>
                                <div class="row pb-2">
                                    <div class="col-6">
                                        <div id="chartdiv"></div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row pb-2">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <select class="form-control form-control-sm" id="nivelGasolina" required
                                                            name="nivelGasolina"
                                                            data-choices="data-choices"
                                                            aria-label="Floating label select example">
                                                        <option value="">Seleccione Nivel</option>
                                                        <?php foreach($nivelGasolina as $ng){?>
                                                        <option value="<?php echo $ng["codigo"]?>"><?php echo $ng["descripcion"]?></option>
                                                        <?php }?>
                                                    </select>
                                                    <label for="floatingSelect">Nivel Conbustible</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row pb-2">
                                            <div class="col-6">
                                                <div class="form-floating">
                                                    <input class="form-control form-control-sm" value="Bateria:" readonly>
                                                    <label for="floatingSelect">Tipo de Medidor</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-floating">
                                                    <input class="form-control form-control-sm" required name="voltage">
                                                    <label for="floatingSelect">Voltaje</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row pb-2">
                                            <div class="col-12">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input checkBateria" id="inlineRadio1" type="radio" name="inlineRadioOptions" value="1" />
                                                    <label class="form-check-label" for="inlineRadio1">Conforme</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input checkBateria" id="inlineRadio2" type="radio" name="inlineRadioOptions" value="2" />
                                                    <label class="form-check-label" for="inlineRadio2">Con Fallas</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="panelObservacionBateria" style="display:none">
                                            <div class="row pb-2">
                                                <div class="col-12">
                                                    <div class="form-floating">
                                                        <textarea class="form-control form-control-sm" style="height: 60px" id="observacionesBateria" name="observacionesBateria"></textarea>
                                                        <label for="floatingSelect">Observaciones de Falla</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        <?php }?>
                        <?php if($idtipoFormulario==1){?>
                            <input hidden name="procesoPdiForm" value="<?php echo $idprocesoPdi?>">
                            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                                <?php
                                $contador=0;
                                foreach($grupoCheckList as $gchi){
                                    $contador++;
                                    ?>
                                    <li class="nav-item"><a class="nav-link <?php echo ($contador==1)?'active':''?> navGrupoChecks" data-idgrupoCheckList="<?php echo $gchi["idgrupoCheckListFormularioPdi"]?>" data-vin="<?php echo $vin?>" data-idprocesoPdi="<?php echo $idprocesoPdi?>"  data-bs-toggle="tab" href="#" role="tab"  aria-selected="true"><?php echo $gchi["descripcion"]?></a></li>
                                <?php }?>
                            </ul>
                            <div class="tab-content mt-3" id="myTabContent">
                                <div id="panelItemsCheck">
                                    <table class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col"></th>
                                                <th scope="col">Check List</th>
                                                <th scope="col">Resource</th>
                                                <th scope="col">Opc</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyPanelPdi">
                                        <?php foreach($checkListPdi as $chp){?>
                                            <tr>
                                                <td style="vertical-align: middle;">
                                                    <div class="form-check">
                                                        <input class="form-check-input" id="flexCheckCheck<?php echo $chp["idresultadoFormularioPdi"] ?>" disabled="disabled" <?php echo (is_null($chp["idestadoResultado"]))?'':'checked'?> type="checkbox">
                                                        <label class="form-check-label" for="flexCheckCheck<?php echo $chp["idresultadoFormularioPdi"] ?>"><?php echo (is_null($chp["idestadoResultado"]))?'Pendiente':'Finalizado'?></label>
                                                    </div>
                                                </td>
                                                <td style="vertical-align: middle;"><?php echo $chp["descripcion"]?>
                                                </td>
                                                <td>
                                                    <?php if(is_null($chp["rutaImagen"])){?>
                                                        <button class="btn btn-subtle-secondary btn-sm viewCameraActive" data-idresultadoFormularioPdi="<?php echo $chp["idresultadoFormularioPdi"] ?>" data-vin="<?php echo $vin ?>" data-idprocesoPdi="<?php echo $chp["idprocesoPdi"]?>" data-idgrupoCheckListFormularioPdi="<?php echo $chp["idgrupoCheckListFormularioPdi"]?>"><i class="fas fa-camera"></i></button>
                                                    <?php }else{?>
                                                        <button class="btn btn-subtle-success btn-sm viewCameraActive" data-idresultadoFormularioPdi="<?php echo $chp["idresultadoFormularioPdi"] ?>" data-vin="<?php echo $vin ?>" data-idprocesoPdi="<?php echo $chp["idprocesoPdi"]?>" data-idgrupoCheckListFormularioPdi="<?php echo $chp["idgrupoCheckListFormularioPdi"]?>"><i class="fas fa-camera"></i></button>
                                                    <?php }?>
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <?php if(is_null($chp["idestadoResultado"])){?>
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <select class="form-select form-control-sm changeEstadoPdi" id="estadoCheckPdi<?php echo $chp["idresultadoFormularioPdi"]?>"
                                                                        data-idprocesoPdi="<?php echo $chp["idprocesoPdi"]?>"
                                                                        data-idgrupoCheckListFormularioPdi="<?php echo $chp["idgrupoCheckListFormularioPdi"]?>"
                                                                        data-vin="<?php echo $vin ?>"
                                                                        data-idresultadoFormularioPdi="<?php echo $chp["idresultadoFormularioPdi"] ?>" required name="estadoCheckPdi">
                                                                    <option value="">Seleccione un Estado</option>
                                                                    <option value="1">CONFORME</option>
                                                                    <option value="2">NO CONFORME</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    <?php }else{?>
                                                        <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo ($chp["idestadoResultado"]==1)?'success':'warning'?>"><?php echo ($chp["idestadoResultado"]==1)?'Conforme':'Con Obs.'?></span>
                                                    <?php }?>
                                                </td>
                                            </tr>
                                        <?php }?>
                                        </tbody>
                                    </table><br>
                                </div>
                            </div>
                            <hr>
                        <?php }?>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-floating">
                                <textarea class="form-control form-control-sm" style="height: 100px"
                                          name="comentarioPdi"
                                          placeholder="Ingrese Comentarios"></textarea>
                                    <label for="floatingTextarea2">Comentarios de
                                        Pdi</label>
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