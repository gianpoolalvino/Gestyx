<div class="modal-body">
    <form method="POST" id="formDestroyDoc"
          action="<?php echo base_url("Traslado/GuiasTraslados/SaveEditDelete/DestroyDocumentoRelacionado") ?>">
        <div class="row">
            <div class="col-12 text-center">
                <h5 class="text-danger">¿Desea Eliminar el Documento Relacionado?</h5>
                <input hidden name="iddocumentoRelacionadoGuia" value="<?php echo $iddocumentoRelacionadoGuia?>">
                <span style="font-size: 12px">Se eliminara el documento relacionado del proceso de la creacion de la Guia</span>
                <hr>
                <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button>
                <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
            </div>
        </div>
    </form>
</div>