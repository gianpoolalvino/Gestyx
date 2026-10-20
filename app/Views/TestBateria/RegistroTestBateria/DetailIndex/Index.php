<?php
$contador=$countReg;
$color='';
foreach($detailIndex as $dt){
    $contador++;
    ?>
    <tr style="vertical-align: middle">
        <td style="vertical-align: middle"><?php echo $contador?></td>
        <td style="vertical-align: middle">
            <?php echo $dt["vin"]?>
        </td>
        <td style="vertical-align: middle">
            <button class="btn btn-sm btn-phoenix-primary btnVerRegistro" data-vin="<?php echo $dt["vin"]?>" data-idbateriaTest="<?php echo $dt["idbateriaTest"]?>" type="button"><i class="fas fa-eye"></i></button>
        </td>
        <td style="vertical-align: middle"><?php echo $dt["marca"]?></td>
        <td style="vertical-align: middle"><?php echo $dt["modelo"]?></td>
        <td style="vertical-align: middle"><?php echo $dt["color"]?></td>
        <td style="vertical-align: middle"><?php echo $dt["estadoVin"]?></td>
        <td style="vertical-align: middle"><?php echo $dt["ubicacion"]?></td>
        <td style="vertical-align: middle">
            <?php echo "Realizado"?>
        </td>
        <td style="vertical-align: middle"><?php echo $dt["eventoActual"]?></td>
        <td style="vertical-align: middle"><?php echo $dt["fechaTest"]?></td>
        <td style="vertical-align: middle"><?php echo $dt["fechaProximoTest"]?></td>
        <td style="vertical-align: middle"><?php echo $dt["fechaRegistro"]?></td>
    </tr>
    <?php
    $color='';
}?>