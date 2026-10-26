<div class="modal-body">
    <h4 class="mb-3">
        <i class="fas fa-qrcode text-primary me-2"></i>Ingreso Vehicular
    </h4>

    <div class="border border-primary-subtle rounded overflow-hidden">
        <table class="table table-borderless fs-9 mb-0 align-middle">
            <tbody>
                <tr>
                    <th class="w-25 ps-3 bg-primary-subtle text-primary-emphasis">VIN</th>
                    <td class="fw-bold"><?php echo $vinInfo[0]["vin"] ?></td>
                </tr>
                <tr>
                    <th class="w-25 ps-3 bg-primary-subtle text-primary-emphasis">Marca</th>
                    <td><?php echo $vinInfo[0]["marca"] ?></td>
                </tr>
                <tr>
                    <th class="w-25 ps-3 bg-primary-subtle text-primary-emphasis">Modelo</th>
                    <td><?php echo $vinInfo[0]["modelo"] ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="bg-body-tertiary rounded text-center p-3 my-3">
        <?php echo $vinQr ?>
    </div>

    <div class="d-grid gap-2 d-sm-flex justify-content-sm-end">
        <button class="btn btn-primary btn-sm" type="submit" id="btnProcesar">
            <i class="fas fa-print me-1"></i>Imprimir
        </button>
        <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
    </div>
</div>
