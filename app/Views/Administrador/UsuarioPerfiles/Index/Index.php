<style>

    .tableFixHead {
        overflow: auto;
        height: calc(100vh - 184px);
        white-space: nowrap;
    }

    .tableFixHead thead th {
        position: sticky;
        top: 0;
        z-index: 100;
        background:#141824;
        color:white
    }

    /* Just common table stuff. Really. */
    table {
        border-collapse: collapse;
        width: 100%;
    }

    th, td {
        padding: 8px 16px;
    }

    .fixed-bottom {
        padding-top: 8px;
        padding-bottom: 8px;
        border-top: solid 1.5px #b9b9b9;
    }

    <?php
    date_default_timezone_set("America/Lima");
    $hoy=date("Y-m-d");
    $hora=date("H:i:s");
    $hoyD = date("Y-m-d H:i:s");
    ?>
</style>
<div class="content" style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="pb-5" style="padding-bottom:0px !important">
        <div style="flex: 0 0 40%;position: relative;height: calc(100vh - 70px);min-width: 100%">
            <div class="card h-100" style="border: 0px;border-radius: 0px;height:100%">
                <div class="card-header" style="padding-bottom: 4px">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="mb-2">Administrador <small> / Usuarios y Perfiles (Total de Registros: <?php echo 0?>)</small></h3>
                        </div>
                    </div>
                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="input-group">
                                    <input class="form-control form-control-sm"  placeholder="Ingrese Busqueda..." autocomplete="off" id="filtro" name="filtro" style="width: 35%">
                                    <div class="input-group-prepend">
                                        <button type="button" class="btn btn-outline-danger btn-sm" id="btnDeleteFilt"><i class="fas fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-8 col-lg-8" style="text-align: right !important">
                                <button class="btn btn-dark btn-sm" id="btnNewIngreso" type="button"><i class="fas fa-user"></i>&nbsp;Nuevo Usuario</button>
                            </div>
                        </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm" data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th style="vertical-align: middle">Tipo Documento</th>
                                <th style="vertical-align: middle">Documento</th>
                                <th style="vertical-align: middle" class="sticky-col second-col sort" data-sort="vin">Nombres</th>
                                <th style="vertical-align: middle">Apellidos</th>
                                <th style="vertical-align: middle" class="sort"  data-sort="marca">Area</th>
                                <th style="vertical-align: middle">Cargo</th>
                                <th style="vertical-align: middle">Estado</th>
                                <th style="vertical-align: middle">Acciones</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyAlistamiento" class="list">
                            <?php
                            $contador=0;
                            foreach($detailIndex as $di){
                                $contador++;?>
                                <tr>
                                    <td style="vertical-align: middle"><?php echo $contador?></td>
                                    <td style="vertical-align: middle"><?php echo $di["tipoDocumento"]?></td>
                                    <td style="vertical-align: middle"><?php echo $di["documento"]?></td>
                                    <td style="vertical-align: middle"><?php echo $di["nombres"]?></td>
                                    <td style="vertical-align: middle"><?php echo $di["primerApellido"]." ".$di["segundoApellido"]?></td>
                                    <td style="vertical-align: middle"><?php echo $di["area"]?></td>
                                    <td style="vertical-align: middle"><?php echo $di["cargo"]?></td>
                                    <td style="vertical-align: middle"><?php echo ($di["estadoUsuario"]==1)?'Activo':'Deshabilitado'?></td>
                                    <td style="width: 10%;vertical-align: middle">
                                        <button class="btn btn-subtle-primary btn-sm btnOpcionUser" data-opcion="edit" data-idusuario="<?php echo $di["idusuario"]?>"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-subtle-success btn-sm btnOpcionUser" data-opcion="send" data-idusuario="<?php echo $di["idusuario"]?>"><i class="fas fa-paper-plane"></i></button>
                                        <button class="btn btn-subtle-info btn-sm btnOpcionUser" data-opcion="access" data-idusuario="<?php echo $di["idusuario"]?>"><i class="fas fa-cogs"></i></button>
                                        <?php if($di['estadoUsuario']==1){?>
                                            <button class="btn btn-subtle-danger btn-sm btnOpcionUser" data-opcion="delete" data-idusuario="<?php echo $di["idusuario"]?>"><i class="fas fa-trash"></i></button>
                                        <?php }?>
                                    </td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>