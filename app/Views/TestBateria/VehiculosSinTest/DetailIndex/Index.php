<?php
$contador=$countReg;
$color='';
foreach($detailIndex as $dt){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td>
            <a href="#" class="btnBateria"
               data-vin="<?php echo $dt["vin"] ?>"><?php echo $dt["vin"]?></a></td>
        <td><?php echo $dt["marca"]?></td>
        <td><?php echo $dt["modelo"]?></td>
        <td><?php echo $dt["color"]?></td>
        <td><?php echo $dt["estadoVin"]?></td>
        <td><?php echo $dt["ubicacion"]?></td>
        <td>
            <?php echo "No realizado"?>
        </td>
        <td><?php echo $dt["eventoActual"]?></td>
        <td><?php echo $dt["fechaIngreso"]?></td>
        <td><?php echo $dt["fechaProximoTest"]?></td>
        <td><?php echo $dt["fechaTest"]?></td>
    </tr>
    <?php
    $color='';
}?>