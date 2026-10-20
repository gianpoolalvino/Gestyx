<?php
$contador = 0;
if (!empty($detailExhibicion)) {
    ?>
    <?php foreach ($detailExhibicion as $dt) {
        $contador++;
        ?>
        <tr style="vertical-align: middle">
            <td class="px-2"><?php echo $contador ?></td>
            <td class="px-2"><?php echo $dt["cantidad"] ?></td>
            <td class="px-2"><?php echo $dt["codigoEquipamiento"] ?></td>
            <td class="px-2"><?php echo $dt["equipamiento"] ?></td>
            <td>
                <button class="btn btn-danger btn-sm btndeleteEq" type="button"
                        data-idequipamiento="<?php echo $dt["idequipamientoVin"]?>"><i
                        class="fas fa-trash"></i></button>
            </td>
        </tr>
    <?php } ?>
<?php } ?>