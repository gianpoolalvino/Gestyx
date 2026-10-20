<?php
$contador=$countReg;
foreach($detailIndex as $dt){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $dt["vin"]?></td>
        <td>
            <?php echo $dt["nombreCliente"]?>
        </td>
        <td><?php echo $dt["marca"]?></td>
        <td><?php echo $dt["modelo"]?></td>
        <td><?php echo $dt["color"]?></td>
        <td><?php echo $dt["agencia"]?></td>
        <td>
            <button class="btn btn-subtle-warning btn-sm btnAgendar" data-vin="<?php echo $dt["vin"]?>"><i class="fad fa-calendar"></i>&nbsp;Agendar</button>
        </td>
    </tr>
<?php }?>