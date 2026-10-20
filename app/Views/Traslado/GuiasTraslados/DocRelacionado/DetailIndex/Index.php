<?php
if (!empty($docRelacionado)) {
    $contador = 0;
    ?>
    <?php foreach ($docRelacionado as $dcr) {
        $contador++;
        ?>
        <tr>
            <td><?php echo $contador ?></td>
            <td><?php echo $dcr["tipoDocumento"] ?></td>
            <td><?php echo $dcr["numeroDocumento"] ?></td>
            <td>
                <button class="btn btn-subtle-secondary btn-sm btnDeleteDoc"
                        data-iddocRelGuia="<?php echo $dcr["iddocumentoRelacionadoGuia"] ?>"><i
                        class="fas fa-trash"></i></button>
            </td>
        </tr>
    <?php } ?>
<?php } else { ?>
    <tr>
        <td colspan="4" style="text-align: center">:( No tiene documentos relacionados</td>
    </tr>
<?php } ?>