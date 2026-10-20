<?php
date_default_timezone_set("America/Lima");
$hoy=date("Y-m-d");
$contador=$countReg;
foreach($detailIndex as $dt){
    $contador++;
    ?>
    <tr class="trVinSolicitud" data-vin="<?php echo $dt["vin"]?>" data-idsolicitudVin="<?php echo $dt["idsolicitudVehiculo"]?>">
        <td><?php echo $contador?></td>
        <td><?php echo $dt["tipoSolicitud"]?></td>
        <td><?php echo $dt["fechaSolicitud"]?></td>
        <td><?php echo $dt["fechaAtencion"]?></td>
        <td><?php echo $dt["fechaMaximaEntrega"]?></td>
        <td>
            <?php if($dt["idestadoSolicitudVehiculo"]!=6){?>
                <?php if($hoy<$dt["fechaPrimeraAlerta"]){?>
                    <i class="fas fa-circle text-primary"></i>
                <?php }else if(($dt["fechaPrimeraAlerta"]<= $hoy) && ($dt["fechaAlertaFinal"]>=$hoy)){?>
                    <i class="fas fa-circle text-warning"></i>
                <?php }else if($dt["fechaAlertaFinal"]<$hoy){?>
                    <i class="fas fa-circle text-danger"></i>
                <?php }?>
            <?php }else{?>
                <i class="fas fa-check-circle text-dark"></i>
            <?php }?>
        </td>
        <td><?php echo $dt["vin"]?></td>
        <td><?php echo $dt["estadoVehiculo"]?></td>
        <td><?php echo $dt["eventoActual"]?></td>
        <td><?php echo $dt["novedades"]?></td>
        <td><?php echo $dt["marca"]?></td>
        <td><?php echo $dt["modelo"]?></td>
        <td><?php echo $dt["color"]?></td>
        <td><?php echo $dt["ubicacionActual"]?></td>
        <td><?php echo $dt["destino"]?></td>
        <td><?php echo $dt["solicitante"]?></td>
        <td><?php echo $dt["centroCosto"]?></td>
        <td><?php echo $dt["estadoSolicitud"]?></td>

    </tr>
<?php }?>