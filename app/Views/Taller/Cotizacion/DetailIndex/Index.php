<?php
$contador=0;
foreach($detailIndex as $dt){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $dt["marca"]?></td>
        <td><?php echo $dt["numero"]?></td>
        <td><?php echo $dt["documentoCliente"]?></td>
        <td><?php echo $dt["nombreCliente"]?></td>
        <td><?php echo $dt["placaCliente"]?></td>
        <td><?php echo $dt["moneda"]?></td>
        <td><?php echo $dt["fecha"]?></td>
        <td>
            <button class="btn btn-danger btn-sm btnPdfOp" data-idcotizacion="<?php echo $dt["idcotizacion"]?>"><i class="fas fa-file-pdf"></i></button>
            <?php if($dt["sendErp"]!=1){?>
            <button class="btn btn-primary btn-sm btnSendErp" data-idcotizacion="<?php echo $dt["idcotizacion"]?>"><i class="fas fa-paper-plane"></i></button>
            <?php } ?>
        </td>
    </tr>
<?php }?>
