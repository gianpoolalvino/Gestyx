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
        color: white;
        background-color: #272727; /* Fondo blanco para la columna fija */
        z-index: 2; /* Asegura que esté encima de otras celdas */
    }

    .sticky-col.first-col {
        position: sticky;
        top: 0;
        color: white;
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
                <div class="card-header" style="padding-bottom: 8px">
                    <div class="row g-4">
                        <div class="col-12">
                            <h3 class="mb-2">Agendamiento / <small>Calendario Asesor</small></h3>
                        </div>
                    </div>
                    <div class="row">
                        <?php
                        $fechaIn = new \DateTime($primerDia); // Fecha de ejemplo (puedes usar cualquier fecha)
                        // Sumar 1 día
                        $fechaIn->modify('-1 day');
                        // Mostrar la nueva fecha
                        $diaIn=$fechaIn->format('Y-m-d');

                        $fechaOut = new \DateTime($ultimoDia); // Fecha de ejemplo (puedes usar cualquier fecha)
                        // Sumar 1 día
                        $fechaOut->modify('+1 day');
                        // Mostrar la nueva fecha
                        $diaOut=$fechaOut->format('Y-m-d');
                        ?>

                        <div class="col-4 col-md-4 col-lg-4" style="text-align: left">
                            <a href="<?php echo base_url("Agendamiento/CalendarioAsesor/Index?fecha=").$diaIn?>" class="btn btn-outline-primary btn-sm"><< Semana Anterior</a>
                        </div>
                        <div class="col-4 col-md-4 col-lg-4" style="text-align: center">
                            <h5><?php echo session("nombresWebService") . " " . session("apellidosWebService") ?></h5>
                        </div>
                        <div class="col-4 col-md-4 col-lg-4" style="text-align: right">
                            <a href="<?php echo base_url("Agendamiento/CalendarioAsesor/Index?fecha=").$diaOut?>" class="btn btn-outline-primary btn-sm">Semana Siguiente >></a>
                        </div>

                    </div>
                </div>
                <div class="card-body" style="padding:0px">
                    <div class="tableFixHead" id="tableAccess">
                        <table id="tableAlistamiento" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                            <thead>
                            <tr>
                                <th class="sticky-col first-col" style="z-index:6 !important">Horario</th>
                                <?php foreach ($diasSemana as $ds) { ?>
                                    <th class="sticky-col first-col"><?php echo $ds["nombreDia"]." (".$ds["fecha"].")"; ?></th>
                                <?php } ?>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $rowCount = count($horario); // Total de filas en el horario
                            $filasOcupadas = array_fill(0, $rowCount, array_fill(0, count($diasSemana), false)); // Control de filas ocupadas

                            // Recorremos las horas, que serán las filas
                            foreach ($horario as $index => $hr) { ?>
                                <tr>
                                    <th class="sticky-col first-col"><?php echo $hr["hora"]; ?></th> <!-- Mostrar la hora en la primera columna -->

                                    <?php foreach ($diasSemana as $indexFecha => $fechaVal) { ?>

                                        <?php
                                        $ocupado = false;
                                        // Filtrar los horarios ocupados para esta fecha y hora
                                        foreach ($horariosOcupado as $hs) {
                                            if ($hs["fecha"] == $fechaVal["fecha"] && $hs["horaAgendaInicio"] == $hr["hora"]) {

                                                // Definir el color de fondo dependiendo de las condiciones de ocupación
                                                if ($fechaVal["fecha"]  == $hoy && $hora > $hr["hora"]) {
                                                    $backGroundTr = "#be3144";
                                                } else if ($fechaVal["fecha"]  < $hoy) {
                                                    $backGroundTr = "#be3144";
                                                } else {
                                                    $backGroundTr = '';
                                                }

                                                if ($hs["idestadoEntrega"] == 1) {
                                                    $backGroundTr = "#25b003"; // Agendado
                                                } else {
                                                    $backGroundTr = "#113f67"; // Entregado
                                                }
                                                ?>

                                                <td style="vertical-align: middle;text-align:center;font-size:10px;background-color: <?php echo $backGroundTr; ?>;color:white;border-radius: 5px" rowspan="<?php echo $hs["columnas"]; ?>" class="<?php echo ($hs["idestadoEntrega"] == 1) ? 'btnAddAgenda' : ''; ?>"
                                                    data-opcion="EditAgenda"
                                                    data-vin="<?php echo $hs["vin"]; ?>"
                                                    data-idasesor="<?php echo session("idusuario"); ?>"
                                                    data-fecha="<?php echo isset($fechaVal["fecha"] ) ? $fechaVal["fecha"]  : $hoy; ?>"
                                                    data-hora="<?php echo $hs["horaAgendaInicio"]; ?>"
                                                    data-estadoAgenda="<?php echo $hs["idestadoEntrega"]; ?>"
                                                    data-idcita="<?php echo $hs["idcitaEntrega"]; ?>"
                                                    data-idAgenda="<?php echo $hs["idhorarioAsesor"]; ?>">
                                                    <?php echo $hs["nombreCliente"]; ?><br>
                                                    <?php echo $hs["vin"]; ?><br>
                                                    <?php echo ($hs["idestadoEntrega"] == 1) ? 'Agendado' : 'Entregado'; ?>
                                                </td>
                                                <?php
                                                // Marcar filas ocupadas
                                                for ($i = 0; $i < $hs["columnas"]; $i++) {
                                                    if (isset($horario[$index + $i])) {
                                                        $filasOcupadas[$index + $i][$indexFecha] = true; // Ocultar las filas ocupadas
                                                    }
                                                }

                                                $ocupado = true;
                                                break; // Salimos del bucle si encontramos un horario ocupado
                                            }
                                        }

                                        // Si no está ocupado, mostrar la hora
                                        if (!$ocupado) {
                                            $background = "";
                                            if ($fechaVal["fecha"]  == $hoy && $hora > $hr["hora"]) {
                                                $background = "table-secondary";
                                            } else if ($fechaVal["fecha"]  < $hoy) {
                                                $background = "table-secondary";
                                            }
                                            ?>
                                            <td class="<?php echo $background; ?> btnAddAgenda" style="vertical-align: middle;"
                                                data-opcion="CreateAgenda"
                                                data-vin=""
                                                data-idasesor="<?php echo session("idusuario"); ?>"
                                                data-fecha="<?php echo isset($fechaVal["fecha"] ) ? $fechaVal["fecha"]  : $hoy; ?>"
                                                data-hora="<?php echo $hr["hora"]; ?>"
                                                data-estadoAgenda=""
                                                data-idcita=""
                                                data-idAgenda=""><?php echo "Disponible" ?></td>
                                            <?php
                                        }
                                        ?>
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