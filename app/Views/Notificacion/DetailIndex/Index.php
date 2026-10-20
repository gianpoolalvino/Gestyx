<?php
$contador=0;
foreach($detail as $di){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di["nombreUsuario"]?></td>
        <td><?php echo $di["vin"]?></td>
        <td><?php echo $di["eventoRealizado"]?></td>
        <td><?php echo $di["fechaHoraEvento"]?></td>
        <td>Realizado</td>
    </tr>
<?php }?>
