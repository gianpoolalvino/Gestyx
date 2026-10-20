<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Proceso Vehicular - Control de Calidad (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#tab-home"
                                        role="tab" aria-controls="tab-home" aria-selected="true">General</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#tab-profile"
                                        role="tab" aria-controls="tab-profile" aria-selected="false">Control de
                        Calidad</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div id="panelVinInfo">

                    </div>
                </div>
                <div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                    <form action="<?php echo base_url("AlistamientoVehicular/ControlCalidad/SaveEditDelete/UpdateReporte") ?>"
                          id="formSaveCalidad" method="POST">
                        Verificar Equipamiento Instalado
                        <input hidden name="vinReporteCalidad" value="<?php echo $vin ?>">
                        <input hidden name="idreporteCalidad" required value="<?php echo $idprocesoCalidad ?>">
                        <div class="row">
                            <div class="col-12">
                                <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                                    <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col">Equipamiento</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Validar</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyEquipamientoCalidad">
                                    <?php
                                    $contador = 0;
                                    foreach ($equipamientoInstalado as $eqi) {
                                        $contador++;
                                        ?>
                                        <tr>
                                            <td>
                                                <div class="form-check">

                                                    <input class="form-check-input"
                                                           id="flexCheckChecked<?php echo $eqi['iddetalleEquipamientoCalidad'] ?>"
                                                           disabled
                                                           type="checkbox" <?php echo ($eqi["estadoEquipamientoCalidad"] != 3) ? 'checked' : '' ?>/>
                                                    <label class="form-check-label"
                                                           for="flexCheckChecked<?php echo $eqi['iddetalleEquipamientoCalidad'] ?>"><?php echo ($eqi["estadoEquipamientoCalidad"] == 3) ? 'Pendiente' : 'Realizado' ?></label>
                                                </div>
                                            </td>
                                            <td>
                                                <input hidden name="estadoRevisadoEq[]"
                                                       value="<?php echo $eqi["estadoEquipamientoCalidad"] ?>">
                                                <input hidden name="idequipamientoCalidad[]" value="<?php echo $eqi["iddetalleEquipamientoCalidad"] ?>">
                                                <?php echo $eqi["equipamiento"] ?><br>
                                                <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo $eqi['colorEstado']?>"><span class="badge-label"><?php echo $eqi['estado']?></span><span class="ms-1" data-feather="package" style="height:12.8px;width:12.8px;"></span></span>
                                            </td>
                                            <td><?php echo $eqi["nombreInstalo"] ?></td>
                                            <td><?php echo ($eqi["idestadoEquipamiento"] == 1) ? 'Pendiente' : 'Instalado' ?></td>
                                            <td>
                                                <?php if ($eqi["estadoEquipamientoCalidad"] == 3 || $eqi["estadoEquipamientoCalidad"]==5) { ?>
                                                    <div class="input-group">
                                                        <div class="input-group-append">
                                                            <button class="btn btn-subtle-primary btn-sm btnEditEquipamiento"
                                                                    data-vin="<?php echo $vin ?>"
                                                                    data-idequipamientoCalidad="<?php echo $eqi["iddetalleEquipamientoCalidad"] ?>"
                                                                    type="button"><i class="far fa-paperclip"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        Check List Control de Calidad
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
                                    <div class="card-header bg-body-highlight pt-3 pb-2 border-bottom-0">
                                        <ul class="nav justify-content-between nav-wizard">
                                            <?php
                                            $contador = 0;
                                            foreach($grupoCheckCC as $gcc){
                                                $contador++;
                                                ?>
                                                <li class="nav-item"><a
                                                            class="nav-link <?php echo ($gcc["idgrupoCheckCalidad"] == $idgrupoCheckCalidad) ? 'active' : '' ?> fw-semibold navTabGrupoCalidad"
                                                            data-idgrupoCheckCC="<?php echo $gcc["idgrupoCheckCalidad"]?>"
                                                            data-idprocesoCalidad="<?php echo $idprocesoCalidad ?>"
                                                            href="#bootstrap-wizard-tab<?php echo $contador ?>"
                                                            data-bs-toggle="tab" data-wizard-step="1">
                                                        <div class="text-center d-inline-block"><span
                                                                    class="nav-item-circle-parent"><span
                                                                        class="nav-item-circle"><i
                                                                            class="fas fa-car"></i></span></span><span
                                                                    class="d-none d-md-block mt-1 fs-9"><?php echo $gcc["grupoCheckCalidad"] ?></span>
                                                        </div>
                                                    </a></li>
                                            <?php }?>
                                        </ul>
                                    </div>
                                    <div class="card-body pt-4 pb-0">
                                        <div class="tab-content">
                                                <div class="tab-pane active"
                                                     role="tabpanel">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div id="panelChecksList">
                                                                <?php
                                                                $contado2 = 0;
                                                                foreach ($detalleCalidad as $ccls) {
                                                                    $contado2++;
                                                                    ?>
                                                                    <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                                                                        <thead>
                                                                        <tr>
                                                                            <th scope="col">Marcar</th>
                                                                            <th scope="col">Check List</th>
                                                                            <th scope="col">Opc</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php
                                                                        if($ccls["detalleCalidad"]!=''){
                                                                        $subq = explode("@@", $ccls["detalleCalidad"]);
                                                                        $conter = 0;
                                                                        foreach ($subq as $ssb) {
                                                                            $conter++;
                                                                            $ssbci = explode("##", $ssb);
                                                                            ?>
                                                                            <tr>
                                                                                <td>
                                                                                    <input hidden name="estadoRevisado[]"
                                                                                           value="<?php echo $ssbci[3] ?>">
                                                                                    <input hidden name="idDetCheckCalidad[]" value="<?php echo $ssbci[2] ?>">
                                                                                    <div class="form-check">
                                                                                        <input class="form-check-input"
                                                                                               id="flexCheckChecked<?php echo $ssbci[0] ?>"
                                                                                               disabled <?php echo ($ssbci[3] != 3) ? 'checked' : '' ?>
                                                                                               type="checkbox"/>
                                                                                        <label class="form-check-label"
                                                                                               for="flexCheckChecked<?php echo $ssbci[0] ?>"><?php echo ($ssbci[3] != 3) ? 'Realizado' : 'Pendiente' ?></label>
                                                                                    </div>
                                                                                </td>
                                                                                <td><?php echo $ssbci[4] ?><br>
                                                                                    <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo $ssbci[6]?>"><span class="badge-label"><?php echo $ssbci[5]?></span><span class="ms-1" data-feather="package" style="height:12.8px;width:12.8px;"></span></span>
                                                                                </td>
                                                                                <td>
                                                                                    <?php if ($ssbci[3] == 3 || $ssbci[3]==5) { ?>
                                                                                        <button class="btn btn-subtle-primary btn-sm btn btnEditProceso"
                                                                                                data-vin="<?php echo $vin ?>"
                                                                                                data-iddetalleCheck="<?php echo $ssbci[2] ?>">
                                                                                            <i class="far fa-paperclip"></i>
                                                                                        </button>
                                                                                    <?php } ?>
                                                                                </td>
                                                                            </tr>
                                                                        <?php } } ?>
                                                                        </tbody>
                                                                    </table><br>
                                                                <?php } ?>
                                                                <?php if($tipoProceso==2){?>
                                                                <button class="btn btn-outline-primary btn-sm btnAddCalidad" data-vin="<?php echo $vin ?>" data-idgrupoCalidad="<?php echo $idgrupoCheckCalidad?>"><i class="fas fa-check"></i>&nbsp;Agregar Campo</button><br><br>
                                                                <?php }?>
                                                            </div>

                                                        </div>
                                                    </div>

                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-floating">
                                <textarea class="form-control form-control-sm" style="height: 100px"
                                          name="comentarioReporteCalidad"
                                          placeholder="Ingrese Comentarios"></textarea>
                                    <label for="floatingTextarea2">Comentarios de
                                        Calidad</label>
                                </div>
                            </div>
                        </div>
                        <hr>
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