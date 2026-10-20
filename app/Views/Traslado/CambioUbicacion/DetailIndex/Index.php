<?php
$contador=$countReg;
foreach($detailIndex as $di){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di["vin"]?></td>
        <td><?php echo $di["fechaIngreso"]?></td>
        <td><?php echo $di["marca"]?></td>
        <td><?php
                                        echo $di["modelo"];
                                        
                                        ?></td>
        <td><?php echo $di["color"]?></td>
        <td>
            <?php echo $di["grupoUbicacionDestino"]?>
        </td>
        <td><?php echo $di["bodegaAnterior"]?></td>
        <td><?php echo $di["bodega"]?></td>

        <td><?php echo $di["ubicacionAnterior"]." (".$di["boxAnterior"].")"?></td>
        <td>
            <?php if ($di["ubicacionActual"] == "Sin Ubicacion") { ?>
                En Transito
            <?php } else { ?>
                <?php if ($di["grupoUbicacionDestino"] != '') { ?>
                    <?php if (strpos($di["grupoUbicacionDestino"], 'Destino') !== false) { ?>
                        <?php echo $di["grupoUbicacionDestino"]; ?>
                    <?php }else if(strpos($di["grupoUbicacionDestino"], 'Sin Movimiento') !== false){ ?>
                        <?php echo $di["ubicacionActual"] . " (" . $di["boxActual"] . ")" ?>
                        <?php echo ($di["idgrupoUbicacionDestino"] != '') ? ' - En Transito' : '' ?>
                    <?php }?>
                <?php } else { ?>
                    <?php echo $di["ubicacionActual"] . " (" . $di["boxActual"] . ")" ?>
                    <?php echo ($di["idgrupoUbicacionDestino"] != '') ? ' - En Transito' : '' ?>
                <?php } ?>
            <?php } ?>

        </td>
        <td><?php echo $di["anhoModelo"]?></td>
        <td>
            <?php
            date_default_timezone_set("America/Lima");
            $hoy=date("Y-m-d");
            // Crear objetos DateTime para las fechas
            $date1 = new DateTime($di["fechaCompra"]);
            $date2 = new DateTime($hoy);

            // Calcular la diferencia entre las fechas
            $interval = $date1->diff($date2);

            $days = $interval->days; // Total de días entre las fechas

            // Mostrar la diferencia en días
            echo $days;
            ?>
        </td>
        <td><?php echo $di["estadoVin"]?></td>
        <td>
    <?php if(!is_null($di["fechaIngreso"])){?>
            <?php if (($di["ubicacionActual"] == 'Sin Ubicacion') && (is_null($di["idgrupoUbicacionDestino"]))) { ?>
                <?php if (is_null($di["idtrasladoUbicacion"])) { ?>
                    <button class="btn btn-subtle-success btn-sm btnRebox tooltipBtn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cambiar de box en la misma ubicacion al vin <?php echo $di["vin"]?>" data-vin="<?php echo $di["vin"]?>" type="button">
                        <i class="fas fa-exchange-alt"></i>
                    </button>
                    <button class="btn btn-subtle-info btn-sm btnOpcubica tooltipBtn"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Generar traslado de vin: <?php echo $di["vin"]?> en el mismo grupo de ubicacion"
                            data-vin="<?php echo $di["vin"] ?>" type="button"><i
                                class="fas fa-paper-plane"></i></button>
                <?php } else { ?>
                    <button class="btn btn-subtle-info btn-sm btnOpcubica tooltipBtn"
                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="Recepcionar traslado de vin: <?php echo $di["vin"]?>"
                            data-vin="<?php echo $di["vin"] ?>" type="button"><i
                                class="fas fa-map-marker-check"></i></button>
                <?php } ?>
                <?php if (is_null($di["idgrupoUbicacionDestino"])) { ?>
                    <?php if (is_null($di["idtrasladoUbicacion"])) { ?>
                        <button class="btn btn-subtle-primary btn-sm btnReUbi tooltipBtn"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="liberar vin: <?php echo $di["vin"]?> a otro grupo de ubicaciones"
                                data-vin="<?php echo $di["vin"] ?>" type="button"><i
                                    class="fas fa-unlock-alt"></i></button>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <?php if (in_array($di["idgrupoUbicacionActual"], session("codigoGrupoUbicacion"))) { ?>
                    <?php if (is_null($di["idtrasladoUbicacion"])) { ?>
                        <button class="btn btn-subtle-success btn-sm btnRebox tooltipBtn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Cambiar de box en la misma ubicacion al vin <?php echo $di["vin"]?>" data-vin="<?php echo $di["vin"]?>" type="button">
                            <i class="fas fa-exchange-alt"></i>
                        </button>
                        <button class="btn btn-subtle-info btn-sm btnOpcubica tooltipBtn"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Generar traslado de vin: <?php echo $di["vin"]?> en el mismo grupo de ubicacion"
                                data-vin="<?php echo $di["vin"] ?>" type="button"><i
                                    class="fas fa-paper-plane"></i></button>
                    <?php } else { ?>
                        <button class="btn btn-subtle-info btn-sm btnOpcubica tooltipBtn"
                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Recepcionar traslado de vin: <?php echo $di["vin"]?>"
                                data-vin="<?php echo $di["vin"] ?>" type="button"><i
                                    class="fas fa-map-marker-check"></i></button>
                    <?php } ?>
                    <?php if (is_null($di["idgrupoUbicacionDestino"])) { ?>
                        <?php if (is_null($di["idtrasladoUbicacion"])) { ?>
                            <button class="btn btn-subtle-primary btn-sm btnReUbi tooltipBtn"
                                    data-bs-toggle="tooltip" data-bs-placement="bottom" title="liberar vin: <?php echo $di["vin"]?> a otro grupo de ubicaciones"
                                    data-vin="<?php echo $di["vin"] ?>" type="button"><i
                                        class="fas fa-unlock-alt"></i></button>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            <?php } ?>
    <?php }else{?>
        No Tiene Ingreso
    <?php }?>
        </td>
    </tr>
<?php }?>