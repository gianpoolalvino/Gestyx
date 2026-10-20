<?php
$contador=0;
foreach($detail as $di){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di["moneda"]?></td>
        <td><?php echo $di["fecha"]?></td>
        <td><?php echo $di["nombres"]." ".$di["primerApellido"]." ".$di["segundoApellido"]?></td>
        <td><?php echo $di["precioCompra"]?></td>
        <td><?php echo $di["precioVenta"]?></td>
        <td></td>
    </tr>
<?php }?>