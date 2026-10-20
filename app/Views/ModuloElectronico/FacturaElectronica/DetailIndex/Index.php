<?php
$contador = 0;
foreach ($detailIndex as $di) {
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador ?></td>
        <td><?php echo $di["prefix"] ?></td>
        <td><?php echo $di["identification"] ?></td>
        <td><?php
            $isoDate = $di["creationDate"];
            // Crear un objeto DateTime a partir de la cadena ISO 8601
            $date = new DateTime($isoDate);
            // Formatear la fecha en el formato deseado
            $formattedDate = $date->format('d/m/Y H:i:s');
            echo $formattedDate ?></td>
        <td><?php
            $isoDat = $di["issueDate"];
            // Crear un objeto DateTime a partir de la cadena ISO 8601
            $date2 = new DateTime($isoDat);
            // Formatear la fecha en el formato deseado
            $formattedDate2 = $date2->format('d/m/Y');
            echo $formattedDate2; ?></td>
        <td><?php echo $di["documentoProveedor"] ?></td>
        <td><?php echo $di["nombreProveedor"] ?></td>
        <td>
            <?php echo $di["numeroFactura"] ?>
        </td>
        <td>
            <?php echo $di["nroOc"] ?>
        </td>
        <td>
            <?php echo $di["usuarioOc"]?>
        </td>
        <td>
            <?php echo isset($di["events"]->acc->status) ? '<span class="badge badge-phoenix fs-10 badge-phoenix-success"><i class="far fa-check-circle"></i>&nbsp;<span class="badge-label">Realizado</span></span>' : 'Sin Registro' ?>
        </td>
        <td>
            <?php echo isset($di["events"]->ack->status) ? '<span class="badge badge-phoenix fs-10 badge-phoenix-success"><i class="far fa-check-circle"></i>&nbsp;<span class="badge-label">Realizado</span></span>' : 'Sin Registro' ?>
        </td>
        <td>
            <?php echo isset($di["events"]->asr->status) ? '<span class="badge badge-phoenix fs-10 badge-phoenix-success"><i class="far fa-check-circle"></i>&nbsp;<span class="badge-label">Realizado</span></span>' : 'Sin Registro' ?>
        </td>
        <td>
            <?php echo isset($di["events"]->rej->status) ? '<span class="badge badge-phoenix fs-10 badge-phoenix-success"><i class="far fa-check-circle"></i>&nbsp;<span class="badge-label">Realizado</span></span>' : 'Sin Registro' ?>
        </td>
        <td>
            <?php echo $di["total"] ?>
        </td>
        <td>
            <button class="btn btn-info btn-sm btnOpc" data-opcion="download" data-numeroFactura="<?php echo $di["identification"] ?>" data-idcpe="<?php echo $di["uuid"]?>"><i class="fas fa-file-code"></i></button>
            <button class="btn btn-outline-secondary btn-sm btnOpc" data-opcion="evento" data-numeroFactura="<?php echo $di["identification"] ?>" data-idcpe="<?php echo $di["uuid"]?>"><i class="fas fa-upload"></i></button>
        </td>
    </tr>
<?php } ?>
