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
        <td><?php echo $dt["nombreCliente"]?></td>
        <td><?php echo $dt["documentoCliente"]?></td>
        <td><?php echo $dt["telefonoCliente"]?></td>
        <td><?php echo $dt["correoCliente"]?></td>
        <td><?php echo $dt["placa"]?></td>
        <td><?php echo $dt["fechaVenta"]?></td>
        <td>
            <?php if(!is_null($dt["gas"])){?>
                Convertido a Gas
            <?php }?>
        </td>
        <td><?php echo $dt["proveedorGas"]?></td>
    </tr>
<?php }?>
