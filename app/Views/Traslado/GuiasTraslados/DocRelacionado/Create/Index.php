<div class="modal-body">
    <div class="row pb-2">
        <div class="col-12">
            <h6 class="text-primary">Agregar Documento a Guia</h6>
        </div>
    </div>
    <form id="formTipoDoc" method="POST" action="<?php echo base_url("Traslado/GuiasTraslados/SaveEditDelete/SaveTipoDocumentoRelacionado")?>">
    <input hidden name="idguiaRemisionDocumentoRel" value="<?php echo $idguiaRemision?>">
        <div class="row pb-3">
        <div class="col-12">
            <div class="form-floating">
                <select class="form-select" id="tipoDocumentoRelacionadoGuia" required name="tipoDocumentoRelacionadoGuia" aria-label="Floating label select example">
                    <option value="">Seleccione Tipo Documento</option>
                    <?php foreach($tipoDocumento as $tdc){?>
                        <option value="<?php echo $tdc["idtipoDocumentoRelacionadoGuia"]?>"><?php echo $tdc["descripcion"]?></option>
                    <?php }?>
                </select>
                <label for="floatingSelect">Tipo Documento</label>
            </div>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <div class="form-floating">
                <input class="form-control form-control-sm" id="numeroDocumentoRelacionado" name="numeroDocumentoRelacionado" required>
                <label for="floatingSelect">Numero de Documento</label>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button>
            <button class="btn btn-primary btn-sm" type="submit">Guardar</button>
        </div>
    </div>
    </form>
</div>