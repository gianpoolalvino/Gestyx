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
        <td><?php echo $dt["color"]?></td>
        <td><?php echo $dt["eventoActual"]?></td>
        <td><?php echo $dt["nombreCliente"]?></td>
        <td><?php echo $dt["vendedor"]?></td>
        <td><?php echo $dt["agencia"]?></td>
        <td><?php echo $dt["fechaEvento"]?></td>
        <td><?php echo $dt["fechaFin"]?></td>
        <td><?php echo $dt["fechaFactura"]?></td>
        <td><?php echo $dt["fechaCancelado"]?></td>
        <td><?php echo $dt["operador"]?></td>
    </tr>
<?php }?>
