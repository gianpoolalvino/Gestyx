<?php
$contador=0;
foreach($detailIndex as $di){
    $contador++;?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $di["vin"]?></td>
        <td><?php echo $di["fechaIngreso"]?></td>
        <td><?php echo $di["estadoVin"]?></td>
        <td><?php echo $di["marca"]?></td>
        <td><?php echo $di["modelo"]?></td>
        <td><?php echo $di["color"]?></td>
        <td><?php echo $di["bodega"]?></td>
        <td><?php echo $di["ubicacion"]?></td>
        <td><?php echo $di["fechaIngreso"]?></td>
        <td><?php echo $di["horaRegistro"]?></td>
        <td>
            <button class="btn btn-outline-primary btn-sm btnViewQr" data-vin="<?php echo $di["vin"]?>"><i class="fas fa-qrcode"></i></button>
            <button class="btn btn-outline-info btn-sm btnViewIngreso" data-idingresoVin="<?php echo $di["idingresoVin"]?>" data-vin="<?php echo $di["vin"]?>"><i class="fas fa-eye"></i></button>
        </td>
    </tr>
<?php }?>
