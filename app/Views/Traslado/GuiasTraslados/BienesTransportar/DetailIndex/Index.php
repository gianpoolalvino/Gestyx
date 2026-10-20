<?php
$contador=0;
    foreach($detailVin as $dvn){
        $contador++;
        ?>
    <tr>
        <td class="ps-3"><?php echo $contador?></td>
        <td class="ps-3"><?php echo $dvn["vin"]?></td>
        <td class="ps-3"><?php echo $dvn["marca"]?></td>
        <td class="ps-3"><?php echo $dvn["modelo"]?></td>
        <td class="ps-3"><?php echo $dvn["color"]?></td>
        <td class="ps-3"><?php echo $dvn["unidadMedida"]?></td>
        <td class="ps-3">
            <button data-vin="<?php echo $dvn["vin"]?>" data-idguiaRemision="<?php echo $dvn["idguiaRemision"]?>" data-iddetalleGuia="<?php echo $dvn["iddetalleGuiaRemision"]?>" type="button" class="btn btn-subtle-secondary btn-sm btnOpcDetGuia"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>
