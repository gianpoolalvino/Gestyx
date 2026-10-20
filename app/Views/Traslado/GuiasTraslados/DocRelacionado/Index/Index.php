<div class="modal-body" style="border: 0.5px solid #a2a2a2;border-radius: 5px">
    <div class="row pb-2">
        <div class="col-12">
            <span>Documentos Relacionados a la Guia</span>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <table class="table table-sm fs-9 mb-0">
                <thead>
                <tr class="bg-body-highlight">
                    <th class="sort border-top border-translucent ps-3" data-sort="name">#</th>
                    <th class="sort border-top border-translucent" data-sort="email">Tipo Documento</th>
                    <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Nro Documento</th>
                    <th class="sort border-top border-translucent text-end pe-3" data-sort="payment">Opc</th>
                </tr>
                </thead>
                <tbody id="tbodyDetailDocRel" class="list">
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
                </tbody>
            </table>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <button class="btn btn-info btn-sm" id="btnAddDoc" type="button">Agregar Doc</button>
        </div>
    </div>
    <hr>
    <div class="row pb-2">
        <div class="col-12 text-right">
            <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>
