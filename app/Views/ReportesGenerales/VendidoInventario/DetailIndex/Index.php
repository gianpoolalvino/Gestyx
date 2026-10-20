<?php
$contador = 0;
foreach ($detailIndex as $di) {
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador ?></td>
        <td><?php echo $di["vin"] ?></td>
        <td><?php echo $di["marca"] ?></td>
        <td><?php echo $di["modelo"] ?></td>
        <td><?php echo $di["color"] ?></td>
        <td><?php echo $di["fechaCompra"] ?></td>
        <td><?php echo is_null($di["canceladoProveedor"])?'Pendiente Pago':'Cancelado' ?></td>
        <td><?php echo $di["fechaPagoProveedor"] ?></td>
        <td><?php echo $di["nombreProveedor"] ?></td>
        <td><?php echo $di["eventoActual"]?></td>
        <td><?php echo $di["anhoModelo"] ?></td>
        <td><?php echo $di["agencia"] ?></td>
        <td><?php echo $di["bodega"] ?></td>
        <td><?php echo $di["nombreCliente"] ?></td>
        <td><?php echo $di["numeroFactura"] ?></td>
        <td><?php echo $di["fechaFactura"] ?></td>
        <td><?php echo $di["fechaCancelado"] ?></td>
        <td><?php echo $di["estadoVin"] ?></td>
        <td><?php echo $di["ubicacionActual"] . " - " . $di["box"] ?></td>
    </tr>
<?php } ?>
