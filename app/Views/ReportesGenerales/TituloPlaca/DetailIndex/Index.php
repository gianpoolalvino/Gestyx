<?php
$count=0;
foreach($detailIndex as $di){
    $count++;
    ?>
    <tr>
        <td><?php echo $count?></td>
        <td><?php echo $di["vin"]?></td>
        <td><?php echo $di["marca"]?></td>
        <td><?php echo $di["modelo"]?></td>
        <td><?php echo $di["color"]?></td>
        <td><?php echo $di["agencia"]?></td>
        <td><?php echo $di["bodega"]?></td>
        <td><?php echo $di["documentoCliente"]?></td>
        <td><?php echo $di["nombreCliente"]?></td>
        <td><?php echo $di["fechaFactura"]?></td>
        <td><?php echo $di["fechaCancelado"]?></td>
        <td><?php echo $di["fechaTitulo"]?></td>
        <td><?php echo $di["numeroTitulo"]?></td>
        <td><?php echo $di["usuarioTitulo"]?></td>
        <td><?php echo $di["fechaPlaca"]?></td>
        <td><?php echo $di["usuarioPlaca"]?></td>
        <td><?php echo $di["tipoPlaca"]?></td>
        <td><?php echo $di["placa"]?></td>
        <td><?php echo $di["estadoVin"]?></td>
    </tr>
<?php }?>
