<?php
$contador=0;
foreach($detailComision as $di){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <th><?php echo $di["vin"]?></th>
        <td><?php echo $di["estadoVin"]?></td>
        <td><?php echo ($di["comisionPagada"]==1)?'Pagada':'Pendiente'?></td>
        <th><strong class="<?php echo ($di["comisionPagada"]==1)?'text-primary':'text-danger'?>"><?php echo $di["vendedor"]?></strong></th>
        <td><?php echo $di["marca"]?></td>
        <td><?php echo $di["modelo"]?></td>
        <td><?php echo $di["color"]?></td>
        <th><?php echo $di["numeroFactura"]?></th>
        <td><?php echo $di["fechaFactura"]?></td>
        <td><?php echo $di["precioVehiculo"]?></td>
        <th><?php echo $di["totalComision"]?></th>
        <td><?php echo $di["agencia"]?></td>
    </tr>
<?php }?>
