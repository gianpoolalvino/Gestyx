<?php
foreach($detailIndex as $di){ ?>
    <tr>
        <td class="sticky-col first-col">#</td>
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
        <td><?php echo $di["numeroTitulo"]?></td>
        <td><?php echo $di["tipoPlaca"]?></td>
        <td><?php echo $di["placa"]?></td>
        <td><?php echo $di["estadoVin"]?></td>

        <td><?php echo $di["accesorio"]?></td>
        <td><?php echo $di["usuarioAccesorio"]?></td>

        <td><?php echo $di["conversionGas"]?></td>
        <td><?php echo $di["usuarioConversionGas"]?></td>
        <td><?php echo $di["proveedorGas"]?></td>

        <td><?php echo $di["pdi"]?></td>
        <td><?php echo $di["usuarioPdi"]?></td>

        <td><?php echo $di["lavado"]?></td>
        <td><?php echo $di["usuarioLavado"]?></td>

        <td><?php echo $di["controlCalidad"]?></td>
        <td><?php echo $di["usuarioControlCalidad"]?></td>

        <td><?php echo $di["instalacionGps"]?></td>
        <td><?php echo $di["usuarioGps"]?></td>

        <td><?php echo $di["onstar"]?></td>
        <td><?php echo $di["usuarioOnstar"]?></td>
    </tr>

<?php }?>
