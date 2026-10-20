<style>
    .select2-container {
        z-index: 1060 !important; /* Mayor que el modal */
    }
</style>
<div class="modal-body">
    <div class="row pb-2">
        <div class="col-12">
            <h5 class="text-primary">Crear Destinatario</h5>
        </div>
    </div>
    <form action="<?php echo base_url("Traslado/GuiasTraslados/SaveEditDelete/SaveDestinatario") ?>" method="POST"
          id="formDestina">
        <input hidden name="idguiaRemision" value="<?php echo $idguiaRemision?>">
        <div class="row pb-2">
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select" id="tipoDocumentoDestinatario" name="tipoDocumentoDestinatario"
                            aria-label="Floating label select example">
                        <?php foreach ($tipoDocumento as $tip) { ?>
                            <option value="<?php echo $tip["idtipoDocumento"] ?>"><?php echo $tip["descripcion"] ?></option>
                        <?php } ?>
                    </select>
                    <label for="floatingSelect">Tipo de Documento</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <input class="form-control" name="documentoDestinatario">
                    <label for="floatingSelect">Documento</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <input class="form-control" name="nombreDestinatario">
                    <label for="floatingSelect">Razon Social / Nombre</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
                <button class="btn btn-primary btn-sm" type="submit">Procesar</button>
            </div>
        </div>
    </form>
</div>