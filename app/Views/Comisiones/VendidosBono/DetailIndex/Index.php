<?php
$contador=$countReg;
foreach($detailIndex as $di){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di["vin"]?></td>
        <td><?php echo $di["marca"]?></td>
        <td><?php echo $di["codigoVin"]?></td>
        <td><?php echo $di["modelo"]?></td>
        <td><?php echo $di["color"]?></td>
        <td><?php echo $di["nombreCliente"]?></td>
        <td><?php echo $di["vendedor"]?></td>
        <td><?php echo $di["precioVehiculo"]?></td>
        <td><?php echo $di["precioCompra"]?></td>
        <td><?php echo $di["bono"]?></td>
        <td><?php echo $di["margenSinBono"]?></td>
        <td><?php echo $di["margenConBono"]?></td>
    </tr>
<?php }?>