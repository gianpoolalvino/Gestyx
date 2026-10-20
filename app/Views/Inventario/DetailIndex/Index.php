<?php
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
$contador = $countReg;
$color = '';
foreach ($detailIndex as $dt) {
    $contador++;
    ?>
    <tr class="<?php echo $color ?>" id="<?php echo $contador ?>">
        <td class="sticky-column"><?php echo $contador ?></td>
        <td class="sticky-column vin"><a href="#" class="vinAccesorios" data-opcion="Proceso"
                                         id="vinText<?php echo $dt["vin"]?>"
                                         data-vin="<?php echo $dt["vin"] ?>"><?php echo $dt["vin"] ?></a>
            <button class="btn btn-sm btn-phoenix-secondary me-1 mb-1" onclick="copiarAlPortapapeles('#vinText<?php echo $dt["vin"]?>')"><i class="fas fa-copy"></i></button><br>
            <?php if (stristr($dt["modelo"], 'GLP')) { ?>
                <span class="badge badge-phoenix badge-phoenix-<?php echo ($dt["gas"] == 1) ? 'primary' : 'danger' ?>">GAS GLP</span>
            <?php } else if (stristr($dt["modelo"], 'GNV')) { ?>
                <span class="badge badge-phoenix badge-phoenix-<?php echo ($dt["gas"] == 1) ? 'primary' : 'danger' ?>">GAS GNV</span>
            <?php } ?>
        </td>
        <td class="marca"><?php echo $dt["marca"] ?></td>
        <td>
            <?php
        
            echo $dt["modelo"];

            ?>
        </td>
        <td><?php echo $dt["color"] ?></td>
        <td>
            <?php if (!is_null($dt["numeroTitulo"])) { ?>
                <h5><span class="badge badge-phoenix badge-phoenix-primary"><?php echo $dt["numeroTitulo"] ?></span>
                </h5>
            <?php } else { ?>
                <h5><span class="badge badge-phoenix badge-phoenix-danger">Sin Titulo</span></h5>
            <?php } ?>
        </td>
        <td>
            <?php if ($dt["placa"] != '') { ?>
                <h5><span class="badge badge-phoenix badge-phoenix-primary"><?php echo $dt["placa"] ?></span></h5>
            <?php } else { ?>
                <h5><span class="badge badge-phoenix badge-phoenix-danger">Sin Placa</span></h5>
            <?php } ?>
        </td>
        <td><?php echo ($dt["ubicacionAnterior"]!=null)?$dt["ubicacionAnterior"]:'No tiene'?></td>
        <td><?php echo ($dt["ubicacion"]!=null)?$dt["ubicacion"]:'No tiene' ?></td>
        <td><?php echo $dt["bodega"]?></td>
        <td>
            <?php if (is_null($dt["ideventoActual"])) { ?>
                <a href=""><h5><span class="badge badge-phoenix badge-phoenix-danger">Sin Eventos</span></h5></a>
            <?php } else { ?>
                <h5><span class="badge badge-phoenix badge-phoenix-primary"><?php echo $dt["eventoActual"] ?></span>
                </h5>
            <?php } ?>
        </td>
        <td>
            <?php if($dt["fechaTest"]=='No Realizado'){ ?>
                <h5>
                    <span class="badge badge-phoenix badge-phoenix-danger"><i class="fas fa-sad-cry"></i>&nbsp;<?php echo $dt["fechaTest"]?></span>
                </h5>
            <?php }else{?>
                <h5>
                    <span class="badge badge-phoenix badge-phoenix-info"><?php echo $dt["fechaTest"]?></span>
                </h5>
            <?php }?>
        </td>
        <td>
            <h5>
                <?php if($hoy<=$dt["primerAlertaTest"]){?>
                    <span class="badge badge-phoenix badge-phoenix-info"><?php echo $dt["fechaProximoTest"]?></span>
                <?php }else if(($hoy>=$dt["primerAlertaTest"]) && $hoy<=$dt["segundaAlertaTest"]){?>
                    <span class="badge badge-phoenix badge-phoenix-warning"><?php echo $dt["fechaProximoTest"]?></span>
                <?php }else{?>
                    <span class="badge badge-phoenix badge-phoenix-danger"><?php echo $dt["fechaProximoTest"]?></span>
                <?php }?>
            </h5>
        </td>
        <td><?php echo $dt["fechaCompra"]?></td>
        <td><?php echo ($dt["canceladoProveedor"]==1)?'Cancelado':'Pendiente Pago'?></td>
        <td>
            <button class="btn btn-subtle-info btn-sm btnBateria"
                    data-vin="<?php echo $dt["vin"] ?>" type="button"><i
                        class="fas fa-car-battery"></i></button>
    <?php if(session("enviarExibicion")==1){?>
            <button class="btn btn-subtle-success btn-sm btnExhibicion" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Enviar a Exhibicion"
                    data-vin="<?php echo $dt["vin"] ?>" type="button"><i class="fas fa-car-building"></i></button>
        <?php }?>
            <?php if (stristr($dt["modelo"], 'GLP')) { ?>
                <?php if ($dt["gas"] != 1) { ?>
                    <button class="btn btn-subtle-secondary btn-sm btnGas"
                            data-vin="<?php echo $dt["vin"] ?>" type="button"><i
                                class="fas fa-gas-pump"></i></button>
                <?php } ?>
            <?php } else if (stristr($dt["modelo"], 'GNV')) { ?>
                <?php if ($dt["gas"] != 1) { ?>
                    <button class="btn btn-subtle-secondary btn-sm btnGas"
                            data-vin="<?php echo $dt["vin"] ?>" type="button"><i
                                class="fas fa-gas-pump"></i></button>
                <?php } ?>
            <?php } ?>
        </td>
    </tr>
    <?php
    $color = '';
} ?>