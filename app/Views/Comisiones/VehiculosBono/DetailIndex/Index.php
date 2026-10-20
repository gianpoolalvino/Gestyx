<?php
$contador=0;
foreach($detailIndex as $di){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di["marca"]?></td>
        <td></td>
        <td><?php echo $di["codigoModelo"]?></td>
        <td><?php echo $di["modelo"]?></td>
        <td>Carga de Bono</td>
        <td><?php echo $di["bono"]?></td>
        <td></td>
    </tr>
<?php }?>