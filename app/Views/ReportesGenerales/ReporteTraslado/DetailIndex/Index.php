<?php
$contador=0;
foreach($detailIndex as $dt){
    $contador++;
    ?>
<tr>
    <td><?php echo $contador?></td>
    <td><?php echo $dt["vin"]?></td>
    <td><?php echo $dt["marca"]?></td>
    <td><?php echo $dt["modelo"]?></td>
    <td><?php echo $dt["fechaTraslado"]?></td>
    <td><?php echo $dt["estadoTraslado"]?></td>
    <td><?php echo $dt["tipoTraslado"]?></td>
    <td><?php echo $dt["origen"]?></td>
    <td><?php echo $dt["fechaRecepcion"]?></td>
    <td><?php echo $dt["destino"]?></td>
</tr>
<?php } ?>
