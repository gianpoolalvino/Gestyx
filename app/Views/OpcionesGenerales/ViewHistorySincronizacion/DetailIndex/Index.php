<?php
$contador=0;
foreach($detailIndex as $di){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di["tipoSincronizacion"]?></td>
        <td><?php echo $di["fecha"]." ".$di["hora"]?></td>
        <td><?php echo $di["nombre"]?></td>
        <td><?php echo $di["descripcion"]?></td>
        <td>
            <?php if($di["idestadoSincronizacion"]==1){?>
                <span class="badge badge-phoenix fs-10 badge-phoenix-success"><i class="fas fa-solid fa-sync fa-spin fa-1x"></i>&nbsp;<span class="badge-label">En Proceso</span></span>
            <?php }else{?>
                <span class="badge badge-phoenix fs-10 badge-phoenix-primary"><span class="badge-label">Finalizado</span><span class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>
            <?php }?>
        </td>
    </tr>
<?php }?>