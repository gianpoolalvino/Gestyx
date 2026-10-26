<?php foreach ($detailIndex as $i => $di) {
    $det = "det-" . $di["idingresoVin"]; ?>
    <tr>
        <td class="d-none d-md-table-cell"><?php echo $i + 1 ?></td>

        <td>
            <a class="d-md-none fw-bold text-decoration-none" data-bs-toggle="collapse"
               href="#<?php echo $det ?>" role="button" aria-expanded="false" aria-controls="<?php echo $det ?>">
                <?php echo $di["vin"] ?> <i class="fas fa-chevron-down ms-1"></i>
            </a>
            <span class="d-none d-md-inline"><?php echo $di["vin"] ?></span>

            <div class="collapse d-md-none mt-2" id="<?php echo $det ?>">
                <dl class="row mb-2">
                    <dt class="col-5">Estado</dt><dd class="col-7"><?php echo $di["estadoVin"] ?></dd>
                    <dt class="col-5">Marca</dt><dd class="col-7"><?php echo $di["marca"] ?></dd>
                    <dt class="col-5">Modelo</dt><dd class="col-7 text-wrap: balance"><?php echo $di["modelo"] ?></dd>
                    <dt class="col-5">Color</dt><dd class="col-7"><?php echo $di["color"] ?></dd>
                    <dt class="col-5">Bodega</dt><dd class="col-7"><?php echo $di["bodega"] ?></dd>
                    <dt class="col-5">Ubicación</dt><dd class="col-7"><?php echo $di["ubicacion"] ?></dd>
                    <dt class="col-5">Fecha</dt><dd class="col-7"><?php echo $di["fechaIngreso"] ?></dd>
                    <dt class="col-5">Hora</dt><dd class="col-7"><?php echo $di["horaRegistro"] ?></dd>
                </dl>
                <button class="btn btn-outline-primary btn-sm btnViewQr" data-vin="<?php echo $di["vin"] ?>"><i class="fas fa-qrcode"></i></button>
                <button class="btn btn-outline-info btn-sm btnViewIngreso" data-idingresoVin="<?php echo $di["idingresoVin"] ?>" data-vin="<?php echo $di["vin"] ?>"><i class="fas fa-eye"></i></button>
            </div>
        </td>

        <td class="d-none d-md-table-cell"><?php echo $di["estadoVin"] ?></td>
        <td class="d-none d-md-table-cell"><?php echo $di["marca"] ?></td>
        <td class="d-none d-md-table-cell"><?php echo $di["modelo"] ?></td>
        <td class="d-none d-md-table-cell"><?php echo $di["color"] ?></td>
        <td class="d-none d-md-table-cell"><?php echo $di["bodega"] ?></td>
        <td class="d-none d-md-table-cell"><?php echo $di["ubicacion"] ?></td>
        <td class="d-none d-md-table-cell"><?php echo $di["fechaIngreso"] ?></td>
        <td class="d-none d-md-table-cell"><?php echo $di["horaRegistro"] ?></td>
        <td class="d-none d-md-table-cell">
            <button class="btn btn-outline-primary btn-sm btnViewQr" data-vin="<?php echo $di["vin"] ?>"><i class="fas fa-qrcode"></i></button>
            <button class="btn btn-outline-info btn-sm btnViewIngreso" data-idingresoVin="<?php echo $di["idingresoVin"] ?>" data-vin="<?php echo $di["vin"] ?>"><i class="fas fa-eye"></i></button>
        </td>
    </tr>
<?php } ?>
