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
    #tableAlistamiento {
        border-collapse: collapse;
        width: 100%;
    }


    .sticky-col {
        position: sticky;
        left: 0;
        color:white;
        background-color: #272727; /* Fondo blanco para la columna fija */
        z-index: 2; /* Asegura que esté encima de otras celdas */
    }

    .sticky-col.first-col {
        position: sticky;
        top: 0;
        color:white;
        z-index: 3; /* Mayor z-index para la primera fila */
        background-color: #272727; /* Fondo blanco para la fila fija */
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
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                            <tr>
                                <th class="sticky-col first-col" style="z-index:6 !important">Horario</th>
                                <?php foreach ($asesorEntrega as $as) { ?>
                                    <th class="sticky-col first-col"><?php echo $as["nombreAsesor"]; ?></th>
                                <?php } ?>
                            </tr>
                            <?php
                            $rowCount = count($horario); // Total de filas en el horario
                            $filasOcupadas = array_fill(0, $rowCount, array_fill(0, count($asesorEntrega), false)); // Control de filas ocupadas

                            foreach ($horario as $index => $hr) { ?>
                                <tr>
                                    <th class="sticky-col first-col"><?php echo $hr["hora"]; ?></th>
                                    <?php foreach ($asesorEntrega as $asIndex => $as) {
                                        if ($filasOcupadas[$index][$asIndex]) {
                                            continue; // Si la fila ya está ocupada, saltar
                                        }

                                        $ocupado = false;
                                        foreach ($horariosOcupado as $hs) {
                                            if ($hs["idasesor"] == $as["idusuario"] && $hs["horaAgendaInicio"] == $hr["hora"]) {

                                                if($fecha==$hoy && $hora>$hr["hora"]){
                                                    $backGroundTr="#be3144";
                                                }else if($fecha<$hoy){
                                                    $backGroundTr="#be3144";
                                                }

                                                $backGroundTr='';
                                                if($hs["idestadoEntrega"]==1){
                                                    $backGroundTr="#25b003";
                                                }else{
                                                    $backGroundTr="#113f67";
                                                }
                                                ?>

                                                <td style="vertical-align: middle;text-align:center;font-size:10px;background-color: <?php echo $backGroundTr?>;color:white;border-radius: 5px" rowspan="<?php echo $hs["columnas"] ?>" class="<?php echo ($hs["idestadoEntrega"]==1)?'btnAddAgenda':''?>"
                                                            data-opcion="EditAgenda"
                                                            data-vin="<?php echo $hs["vin"]?>"
                                                            data-idasesor="<?php echo $as["idusuario"] ?>"
                                                            data-fecha="<?php echo isset($fecha)?$fecha:$hoy ?>"
                                                            data-hora="<?php echo $hs["horaAgendaInicio"] ?>"
                                                            data-estadoAgenda="<?php echo $hs["idestadoEntrega"] ?>"
                                                            data-idcita="<?php echo $hs["idcitaEntrega"] ?>"
                                                            data-idAgenda="<?php echo $hs["idhorarioAsesor"] ?>">
                                                        <?php echo $hs["nombreCliente"]?><br>
                                                        <?php echo $hs["vin"]?>
                                                        <?php echo ($hs["idestadoEntrega"]==1)?'<br>Agendado':'<br>Entregado'?>
                                                    </button>
                                                </td>
                                                <?php
                                                // Marcar filas ocupadas
                                                for ($i = 0; $i < $hs["columnas"]; $i++) {
                                                    if (isset($horario[$index + $i])) {
                                                        $filasOcupadas[$index + $i][$asIndex] = true; // Ocultar las filas ocupadas
                                                    }
                                                }

                                                $ocupado = true;
                                                break; // Salimos del bucle si encontramos un horario ocupado
                                            }
                                        }

                                        // Si no está ocupado, mostrar la hora
                                        if (!$ocupado) {
                                            $background="";
                                            if($fecha==$hoy && $hora>$hr["hora"]){
                                                $background="table-secondary";
                                            }else if($fecha<$hoy){
                                                $background="table-secondary";
                                            }
                                            ?>
                                          <td class="<?php echo $background?> btnAddAgenda" style="vertical-align: middle;"
                                                data-opcion="CreateAgenda"
                                                data-vin=""
                                                data-idasesor="<?php echo $as["idusuario"] ?>"
                                                data-fecha="<?php echo isset($fecha)?$fecha:$hoy ?>"
                                                data-hora="<?php echo $hr["hora"] ?>"
                                                data-estadoAgenda=""
                                                data-idcita=""
                                                data-idAgenda=""><?php echo $hr["hora"] ?></td>
                                       <?php }
                                    } ?>
                                </tr>
                            <?php } ?>
                        </table>        </div>
                </div>
            </div>
        </div>
    </div>
</div>