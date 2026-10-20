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
                <div class="card-header">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="mb-2">Agendamiento / <small>Calendario y Citas</small></h3>
                        </div>
                    </div>
                    <div class="row">
                        <form action="<?php echo base_url("Agendamiento/CalendarioCita/Index") ?>" method="POST">
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="input-group">
                                    <div class="input-group-append" style="width: 40%">
                                        <div class="input-group">
                                            <input class="form-control form-control-sm" type="date"
                                                   name="fechaCalendario" value="<?php echo isset($fecha)?$fecha:$hoy ?>"
                                                   id="fechaCalendario">
                                        </div>
                                    </div>
                                    <div class="input-group-prepend">
                                        <button id="btnSearch" class="btn btn-outline-primary btn-sm">Search</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover"
                               data-list='{"valueNames":["fechaFactura","marca","vin"]}'>
                            <thead>
                            <tr>
                                <th class="sticky-col first-col">ASESOR ENTREGA</th>
                                <?php foreach ($horario as $hr) { ?>
                                    <th><?php echo $hr["hora"] ?></th>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody id="tbodyAlistamiento" class="list">
                            <?php
                            $colorButton = '';
                            foreach ($asesorEntrega as $as) {
                                ?>
                                <tr>
                                    <td><?php echo $as["nombreAsesor"] ?></td>
                                    <?php
                                    $horas = $as["horarios"];
                                    foreach ($horas as $hs) { ?>
                                        <td colspan="<?php echo $hs["columnas"] ?>">
                                            <?php
                                            $labelButton = '';
                                            if (is_null($hs["vin"])) {
                                                $labelButton = $hs["horaAgenda"];
                                                $colorButton = 'secondary';
                                            } else {
                                                $labelButton = $hs["nombreCliente"] . "<br>" . $hs["telefonoCliente"] . "<br>" . $hs["vin"];
                                                $colorButton = 'primary';
                                            } ?>
                                            <button style="width: 100%"
                                                    class="btn btn-subtle-<?php echo $colorButton ?> btn-sm btnAddAgenda"
                                                    data-opcion="<?php echo ($hs["vin"] != '') ? 'EditAgenda' : 'CreateAgenda' ?>"
                                                    data-vin="<?php echo ($hs["vin"] != '') ? $hs["vin"] : '' ?>"
                                                    data-idasesor="<?php echo $as["idasesor"] ?>"
                                                    data-fecha="<?php echo $fecha ?>"
                                                    data-hora="<?php echo $hs["horaAgenda"] ?>"
                                                    data-estadoAgenda="<?php echo $hs["estadoEntrega"] ?>"
                                                    data-idcita="<?php echo $hs["idcita"] ?>"
                                                    data-idAgenda="<?php echo $hs["idhorarioAsesor"] ?>"
                                                    type="button"><?php echo $labelButton ?></button>
                                        </td>
                                    <?php } ?>
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