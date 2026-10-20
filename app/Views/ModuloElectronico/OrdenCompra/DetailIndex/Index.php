<?php
$contador=0;
foreach($detailIndex as $di){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di->nroOc?></td>
        <td><?php echo ($di->numeroFactura!='')?$di->numeroFactura:'Sin Factura'?></td>
        <td><?php echo $di->fechaDocumento?></td>
        <td><?php echo $di->nombreUsuario?></td>
        <td><?php echo $di->nombreBodega?></td>
        <td><?php echo $di->nombreCentroCosto?></td>

        <td><?php echo $di->documentoProveedor?></td>
        <td><?php echo $di->nombreProveedor?></td>
        <td>
            <?php
            $encontrada='';
            if($di->numeroFactura!=''){?>
                <?php foreach($detailIndexWebService as $dw){?>
                    <?php
                        if ($dw->identification=== $di->numeroFactura && $dw->issuer->identification === $di->documentoProveedor) {
                            $encontrada = true;
                            break; // Salir del bucle una vez que se encuentra una coincidencia
                        }
                    ?>
                <?php }
                    echo $encontrada ? "Existente" : "No Existe";
                ?>
            <?php }else{?>
                No tiene Factura
            <?php }?>
        </td>
        <td><?php echo $di->valorTotal?></td>
        <td>
            <?php if($di->numeroFactura==''){?>
                <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
            <?php }?>
            <?php if($encontrada=='Existente'){?>
                <button class="btn btn-outline-danger btn-sm"><i class="fas fa-trash"></i></button>
            <?php }?>
        </td>
    </tr>
<?php }?>
