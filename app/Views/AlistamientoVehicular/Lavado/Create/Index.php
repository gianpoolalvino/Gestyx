<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Proceso Vehicular - Lavado (VIN: <?php echo $vin ?>)</h5>
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
                                        role="tab" aria-controls="tab-profile" aria-selected="false">Lavado</a></li>
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
                <div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">Lavado
                    <form action="<?php echo base_url("AlistamientoVehicular/Lavado/SaveEditDelete/SaveLavado") ?>"
                          id="formSave" method="POST">
                        <input hidden name="vinLavado" value="<?php echo $vin ?>">
                        <div class="input-group  mb-1" style="padding-bottom: 4px">
                            <div class="form-floating" style="margin-bottom: 0px">
                                <select class="form-control form-control-sm" id="estadoLavado" required
                                        name="estadoOnstar"
                                        data-choices="data-choices"
                                        aria-label="Floating label select example">
                                    <option value="1">Realizado</option>
                                </select>
                                <label for="floatingSelect">Lavado</label>
                            </div>
                            <div class="input-group-append">
                                <div class="form-floating">
                                    <input class="form-control" id="fechaLavadoVin" name="fechaLavadoVin"
                                           value="<?php echo $hoy ?>"
                                           max="<?php echo $hoy ?>"
                                           required type="date"/>
                                    <label for="floatingInput">Fecha Aplica.</label>
                                </div>
                            </div>
                        </div>
                        Proveedor
                        <div class="input-group mb-1" style="padding-bottom: 4px">
                        <div class="form-floating">
                            <select class="form-control form-control-sm" id="proveedorLavado" required
                                    name="proveedorLavado"
                                    data-choices="data-choices"
                                    aria-label="Floating label select example">
                                <option value="-1">No tiene</option>
                                <?php foreach($proveedorLavado as $pl){?>
                                    <option value="<?php echo $pl["idproveedorLavado"]?>"><?php echo $pl["razonSocial"]?></option>
                                <?php }?>
                            </select>
                            <label for="floatingSelect">Proveedor de Lavado</label>
                        </div>
                        </div>
                        <?php if(!empty($detailLavado)){?>
                            <div class="row pb-2">
                            <div class="col-12">
                                <table id="tableLava" class="table fs-9 mb-0 border-top border-translucent table-hover" data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                                    <thead>
                                    <tr>
                                        <th class="sticky-col first-col">#</th>
                                        <th class="sticky-col second-col sort" data-sort="vin">Tipo Lavado</th>
                                        <th>Estado</th>
                                        <th>Opcion</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tbodyLava" class="list">
                                        <?php
                                        $contador=0;
                                        foreach($detailLavado as $di){
                                            $contador++;?>
                                            <tr>
                                                <td><?php echo $contador?></td>
                                                <td><?php echo $di["descripcion"]?></td>
                                                <td>
                                                    <?php echo ($di["idestadoLavado"]==1)?'<span class="badge badge-phoenix badge-phoenix-warning">Pendiente</span>':'<span class="badge badge-phoenix badge-phoenix-primary">Realizado</span>'?>
                                                </td>
                                                <td>
                                                    <?php echo ($di["idestadoLavado"]==1)?'<button class="btn btn-outline-primary btn-sm btnLavadoItem" type="button" data-id="'.$di["iddetalleLavado"].'"><i class="fas fa-car-wash"></i></button>':''?>
                                                </td>
                                            </tr>
                                        <?php }?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php }?>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-floating">
                                <textarea class="form-control form-control-sm" style="height: 100px"
                                          name="comentarioLavado"
                                          placeholder="Ingrese Comentarios"></textarea>
                                    <label for="floatingTextarea2">Comentarios de
                                        Lavado</label>
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