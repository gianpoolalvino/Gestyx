<?php
$contador=0;
foreach($detailIndex as $dt){
    $contador++;?>
<tr>
    <td><?php echo $contador?></td>
    <td><?php echo $dt["vin"]?></td>
    <td><?php echo $dt["marca"]?></td>
    <td><?php echo $dt["modelo"]?></td>
    <td><?php echo $dt["origen"]?></td>
    <td><?php echo $dt["destino"]?></td>
    <td>
        <button class="btn btn-outline-danger btn-sm btnOpcVin" data-vin="<?php echo $dt["vin"]?>" data-iddetalleSolicitud="<?php echo $dt["iddetalleSolicitudVehiculo"]?>"><i class="fas fa-trash"></i></button>
    </td>
</tr>

<?php }?>
