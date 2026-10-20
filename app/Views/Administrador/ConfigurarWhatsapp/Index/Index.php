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
        background: #141824;
        color: white
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
<div class="content"
     style="padding-right: 0.2rem;padding-left:0.2rem;padding-top: 4.2rem;padding-bottom:0rem;display: flex;flex-direction: column;">
    <div class="pb-5" style="padding-bottom:0px !important">
        <div style="flex: 0 0 40%;position: relative;height: calc(100vh - 70px);min-width: 100%">
            <div class="card h-100" style="border: 0px;border-radius: 0px;height:100%">
                <div class="card-header" style="padding-bottom: 4px">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="mb-2">Administrador <small> / Configurar Whatsapp (Total de
                                    Registros: <?php echo 0 ?>)</small></h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-4">
                            <div class="input-group">
                                <input class="form-control form-control-sm" placeholder="Ingrese Busqueda..."
                                       autocomplete="off" id="filtro" name="filtro" style="width: 35%">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-outline-danger btn-sm" id="btnDeleteFilt"><i
                                                class="fas fa-times"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8 col-lg-8" style="text-align: right !important">
                            <button class="btn btn-success btn-sm" id="btnNewWhatsapp" type="button"><i
                                        class="fab fa-whatsapp"></i>&nbsp;Nuevo Numero
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableWsp" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm"
                               data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">#</th>
                                <th style="vertical-align: middle">Nro Whatsapp</th>
                                <th style="vertical-align: middle">Token</th>
                                <th style="vertical-align: middle">Estado Sesion</th>
                                <th style="vertical-align: middle">Fecha Registro</th>
                                <th style="vertical-align: middle;width:10%">Acciones</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyWsp" class="list">
                            <?php
                            $contador = 0;
                            foreach ($detailIndex as $dt) {
                                $contador++;
                                ?>
                                <tr>
                                    <td><?php echo $contador ?></td>
                                    <td><?php echo $dt["numero"] ?></td>
                                    <td><?php echo $dt["token"] ?></td>
                                    <td><?php echo ($dt["estado"] == 1) ? 'Activo' : 'Inactivo' ?></td>
                                    <td><?php echo $dt["fechaEscaneo"] ?></td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm btnSessionWhatsapp" data-opcion="escan" data-idsessionWhatsapp="<?php echo $dt["idsessionWhatsapp"]?>"><i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-outline-secondary btn-sm btnSessionWhatsapp" data-opcion="associate" data-idsessionWhatsapp="<?php echo $dt["idsessionWhatsapp"]?>"><i class="fas fa-user"></i></button>
                                        <button class="btn btn-outline-danger btn-sm btnSessionWhatsapp" data-opcion="delete" data-idsessionWhatsapp="<?php echo $dt["idsessionWhatsapp"]?>"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>