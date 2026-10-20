<style>
    .rowf {
        margin-bottom: 4px !important
    }

    .titleLabel {
        font-size: 12px
    }

    .spanlabel {
        padding-left: 0px
    }

    .select2-container--default .select2-selection--single {
        height: 33px; /* Ajusta la altura como necesites */
        line-height: 33px; /* Centra el texto verticalmente */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
    }
</style>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Accesos de Usuario
                : <?php echo $viewUser[0]["nombres"] . " " . $viewUser[0]["primerApellido"] . " " . $viewUser[0]["segundoApellido"] ?></h5>
            <br>
        </div>
    </div>
    <input hidden id="idusuarioGen" value="<?php echo $idusuario ?>">
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#tab-home"
                                        role="tab" aria-controls="tab-home" aria-selected="true">Sede</a></li>
                <li class="nav-item"><a class="nav-link" id="sede-tab" data-bs-toggle="tab" href="#tab-sede" role="tab"
                                        aria-controls="tab-sede" aria-selected="true">Bodega</a></li>
                <li class="nav-item"><a class="nav-link" id="ubicacion-tab" data-bs-toggle="tab" href="#tab-ubicacion" role="tab"
                                        aria-controls="tab-ubicacion" aria-selected="true">Grupo Ubicacion</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#tab-profile"
                                        role="tab" aria-controls="tab-profile" aria-selected="false">Modulos</a></li>

                <li class="nav-item"><a class="nav-link" id="tiposoli-tab" data-bs-toggle="tab" href="#tab-tiposoli"
                                        role="tab" aria-controls="tab-tiposoli" aria-selected="false">Tipo Solicitud</a></li>

                <li class="nav-item"><a class="nav-link" id="contact-tab" data-bs-toggle="tab" href="#tab-contact"
                                        role="tab" aria-controls="tab-contact" aria-selected="false">Gestiones de
                        Usuario</a></li>
                <li class="nav-item"><a class="nav-link" id="admin-tab" data-bs-toggle="tab" href="#tab-admin"
                                        role="tab" aria-controls="tab-admin" aria-selected="false">Opciones Avanzadas</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <input hidden name="idusEmpAg" id="idusEmpAg" value="<?php echo $idusuario ?>">
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="idselectEmpresaAg"
                                        aria-label="Floating label select example">
                                    <option value="" selected>Seleccione Empresa...</option>
                                    <?php foreach ($empresa as $emp) { ?>
                                        <option value="<?php echo $emp["idempresa"] ?>"><?php echo $emp["descripcion"] ?></option>
                                    <?php } ?>
                                </select>
                                <label for="idselectEmpresaAg">Empresa Aisgnada</label>
                            </div>
                        </div>
                        <div class="col-6" style="text-align: right">
                            <button class="btn btn-primary btn-sm" id="btnAddSede">Agregar Sede</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Sede</th>
                                    <th>Estado</th>
                                    <th>Opc</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyAgencia">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-sede" role="tabpanel" aria-labelledby="sede-tab">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="idselectBodegaUs"
                                        aria-label="Floating label select example">
                                    <option value="" selected>Seleccione Empresa...</option>
                                    <?php foreach ($empresa as $emp) { ?>
                                        <option value="<?php echo $emp["idempresa"] ?>"><?php echo $emp["descripcion"] ?></option>
                                    <?php } ?>
                                </select>
                                <label for="idselectBodegaUs">Empresa Aisgnada</label>
                            </div>
                        </div>
                        <div class="col-6" style="text-align: right">
                            <button class="btn btn-primary btn-sm" type="button" id="btnAddBodega">Agregar Bodega
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Bodega</th>
                                    <th>Estado</th>
                                    <th>Opc</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyBodega">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-ubicacion" role="tabpanel" aria-labelledby="ubicacion-tab">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="idselectUbicacionUs"
                                        aria-label="Floating label select example">
                                    <option value="" selected>Seleccione Empresa...</option>
                                    <?php foreach ($empresa as $emp) { ?>
                                        <option value="<?php echo $emp["idempresa"] ?>"><?php echo $emp["descripcion"] ?></option>
                                    <?php } ?>
                                </select>
                                <label for="idselectBodegaUs">Empresa Aisgnada</label>
                            </div>
                        </div>
                        <div class="col-6" style="text-align: right">
                            <button class="btn btn-primary btn-sm" type="button" id="btnAddUbicacion">Agregar Ubicacion
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Ubicacion</th>
                                    <th>Estado</th>
                                    <th>Opc</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyUbicacion">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-tiposoli" role="tabpanel" aria-labelledby="tiposoli-tab">
                    <div class="row">
                        <input hidden name="idusSoli" id="idusSoli" value="<?php echo $idusuario ?>">
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="idtipoSoli"
                                        aria-label="Floating label select example">
                                    <option value="" selected>Seleccione Tipo Solicitud...</option>
                                    <?php foreach ($selectTipoSoli as $ts) { ?>
                                        <option value="<?php echo $ts["idtipoSolicitud"] ?>"><?php echo $ts["descripcion"]; ?></option>
                                    <?php } ?>
                                </select>
                                <label for="idtipoSoli">Grupos de Modulos</label>
                            </div>
                        </div>
                        <div class="col-6" style="text-align: right">
                            <button class="btn btn-info btn-sm" id="btnAddTipoSo" type="button">Agregar Solicitud</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <table id="tableTipoSoli" class="table fs-9 mb-0 border-top border-translucent table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tipo Solicitud</th>
                                    <th>Estado</th>
                                    <th>Opc</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyTipoSol">
                                    <?php
                                    $contador=0;
                                    foreach($tipoSolicitud as $tss){
                                        $contador++;
                                        ?>
                                        <tr>
                                            <td><?php echo $contador?></td>
                                            <td><?php echo $tss['tipoSolicitud']?></td>
                                            <td>Activo</td>
                                            <td>
                                                <button class="btn btn-outline-danger btn-sm btnDeletTipoSo" data-idusuario="<?php echo $tss["idusuario"]?>" data-idtipoSolicitudUsuario="<?php echo $tss["idtipoSolicitudUsuario"]?>"><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
                <div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row">
                        <input hidden name="idusGmdMd" id="idusGmdMd" value="<?php echo $idusuario ?>">
                        <div class="col-6">
                            <div class="form-floating">
                                <select class="form-select" id="idgrupoModuloUs"
                                        aria-label="Floating label select example">
                                    <option value="" selected>Seleccione Grupo Modulo...</option>
                                    <?php foreach ($grupoModulo as $gm) { ?>
                                        <option value="<?php echo $gm["idgrupoModulo"] ?>"><?php echo $gm["descripcion"] . " " . (($gm["parent"] == 1) ? '- Contiene Modulos' : '- Modulo Unico') ?></option>
                                    <?php } ?>
                                </select>
                                <label for="idgrupoModuloUs">Grupos de Modulos</label>
                            </div>
                        </div>
                        <div class="col-6" style="text-align: right">
                            <button class="btn btn-info btn-sm" id="btnAddModulo" type="button">Agregar Modulo</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Grupo Modulo</th>
                                    <th>Modulo</th>
                                    <th>Estado</th>
                                    <th>Opc</th>
                                </tr>
                                </thead>
                                <tbody id="tbodyModulo">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="row pb-2">
                        <div class="col-12">
                            <strong style="font-size: 14px">Permite Habilitar Opciones para el usuario</strong>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <?php if ($viewUser[0]["asesorEntrega"] == 1) { ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="checkAsesorEntrega" value="1" checked type="checkbox"/>
                                    <label class="form-check-label" for="checkAsesorEntrega">Marque la opcion para
                                        habilitar las funciones de Asesor</label>
                                </div>
                            <?php } else { ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="checkAsesorEntrega" value="1" type="checkbox"/>
                                    <label class="form-check-label" for="checkAsesorEntrega">Marque la opcion para
                                        habilitar las funciones de Asesor</label>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-6">
                            <?php if ($viewUser[0]["gestorSolicitudVehiculo"] == 1) { ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="checkGestorVehicular" value="1" checked type="checkbox"/>
                                    <label class="form-check-label" for="checkGestorVehicular">Marque la opcion para
                                        habilitar las funciones de Gestionar solicitudes vehiculares</label>
                                </div>
                            <?php } else { ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="checkGestorVehicular" value="1" type="checkbox"/>
                                    <label class="form-check-label" for="checkGestorVehicular">Marque la opcion para
                                        habilitar las funciones de Gestionar solicitudes vehiculares</label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <?php if ($viewUser[0]["gestorAdv"] == 1) { ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="checkGestorAdv" value="1" checked type="checkbox"/>
                                    <label class="form-check-label" for="checkGestorAdv">Marque la opcion para Gestionar Expedientes y Titulos</label>
                                </div>
                            <?php } else { ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="checkGestorAdv" value="1" type="checkbox"/>
                                    <label class="form-check-label" for="checkGestorAdv">Marque la opcion para Gestionar Expedientes y Titulos</label>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-6">
                            <?php if ($viewUser[0]["gestorPlaca"] == 1) { ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="checkGestorPlaca" value="1" checked type="checkbox"/>
                                    <label class="form-check-label" for="checkGestorPlaca">Marque la opcion para
                                        registrar Placas</label>
                                </div>
                            <?php } else { ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="checkGestorPlaca" value="1" type="checkbox"/>
                                    <label class="form-check-label" for="checkGestorPlaca">Marque la opcion para
                                        registrar Placas</label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <?php if ($viewUser[0]["gestorAuditoria"] == 1) { ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="checkAuditoria" value="1" checked type="checkbox"/>
                                    <label class="form-check-label" for="checkAuditoria">Marque para mostrar todas las funcionalidades de Auditoria Vehicular</label>
                                </div>
                            <?php } else { ?>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" id="checkAuditoria" value="1" type="checkbox"/>
                                    <label class="form-check-label" for="checkAuditoria">Marque para mostrar todas las funcionalidades de Auditoria Vehiculas</label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-admin" role="tabpanel" aria-labelledby="admin-tab">
                    <div class="row pb-2">
                        <div class="col-12">
                            <div class="input-group">
                                <div class="form-floating">
                                    <select class="form-select" id="selectDuplicarPerfil"
                                            aria-label="Floating label select example">
                                        <option value="" selected>Seleccione Origen de Replica...</option>
                                        <?php foreach ($selectUsuario as $usi) { ?>
                                                <?php if($usi["idusuario"]!=$idusuario){?>
                                                    <option value="<?php echo $usi["idusuario"] ?>"><?php echo $usi["nombres"]." - ",$usi["email"] ?></option>
                                                <?php }?>
                                        <?php } ?>
                                    </select>
                                    <label for="idselectBodegaUs">Usuario Origen</label>
                                </div>
                                <div class="input-group-prepend">
                                    <button type="button" id="btnProcesarClon" class="btn btn-phoenix-primary me-1 mb-1" style="height: 48px;"><i class="fa-solid fa-rotate-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-8">
            <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
        </div>
        <div class="col-4" style="text-align: right">
            <button class="btn btn-secondary btn-sm" type="button" id="btnLogOut"><i class="fas fa-wifi-slash"></i>&nbsp;Cerrar
                Sesion de Usuario
            </button>
        </div>
    </div>
</div>