<style>
    .select2-container {
        z-index: 1060 !important; /* Mayor que el modal */
    }
</style>
<div class="modal-body" style="border: 0.5px solid #a2a2a2;border-radius: 5px">
    <div class="row pb-2">
        <div class="col-12">
            <h5 class="text-primary">Crear Origen</h5>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <div class="form-check form-check-inline">
                <input class="form-check-input checkTipoTransportista" value="2" id="checkTipoTransportista1" type="radio"
                       name="tipoOrigenCheck" <?php echo ($guiaRem[0]["idtipoTransportista"] == 2) ? 'checked' : '' ?> />
                <label class="form-check-label" for="checkTipoTransportista1">Transporte Privado</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input checkTipoTransportista" value="1" id="checkTipoTransportista2" type="radio"
                       name="tipoOrigenCheck" <?php echo ($guiaRem[0]["idtipoTransportista"] == 1) ? 'checked' : '' ?>/>
                <label class="form-check-label" for="checkTipoTransportista2">Transporte Publico</label>
            </div>
        </div>
    </div>
    <input hidden name="inputTipoTransportista" id="inputTipoTransportista" value="<?php echo $guiaRem[0]["idtipoTransportista"] ?>">
    <div id="panelTransportista">
        <?php if ($guiaRem[0]["idtipoTransportista"]==1) { ?>
            <div class="row pb-2">
                <div class="col-6">
                    <div class="form-floating">
                        <input class="form-control form-control-sm" value="<?php echo $guiaRem[0]["rucTransportista"]?>" name="rucTransportista" id="rucTransportista">
                        <label for="rucTransportista">R.U.C</label>
                    </div>
                </div>
            </div>
            <div class="row pb-2">
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control form-control-sm" value="<?php echo $guiaRem[0]["razonSocialTransportista"]?>" name="razonSocialTransportista"
                               id="razonSocialTransportista">
                        <label for="razonSocialTransportista">Razon Social</label>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="row pb-2">
                <div class="col-6">
                    <div class="form-floating">
                        <input class="form-control form-control-sm" readonly value="<?php echo $guiaRem[0]["rucTransportista"]?>" name="rucTransportista" id="rucTransportista">
                        <label for="rucTransportista">R.U.C</label>
                    </div>
                </div>
            </div>
            <div class="row pb-2">
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control form-control-sm" readonly value="<?php echo $guiaRem[0]["razonSocialTransportista"]?>" name="razonSocialTransportista"
                               id="razonSocialTransportista">
                        <label for="razonSocialTransportista">Razon Social</label>
                    </div>
                </div>
            </div><hr>
            <strong style="font-size: 12px">- Datos de Vehiculo y Chofer -</strong>
            <div class="row pb-2">
                <div class="col-4">
                    <div class="form-floating">
                        <select class="form-select form-control-sm"  name="tipoDocumentoChofer"
                                id="tipoDocumentoChofer">
                            <option value="">Seleccione tipo documento</option>
                            <?php foreach($tipoDocumento as $td){?>
                                    <?php if($guiaRem[0]["idtipoDocumentoChofer"]==$td["idtipoDocumento"]){?>
                                        <option selected value="<?php echo $td["idtipoDocumento"]?>"><?php echo $td["descripcion"]?></option>
                                    <?php }else{?>
                                        <option value="<?php echo $td["idtipoDocumento"]?>"><?php echo $td["descripcion"]?></option>
                                    <?php }?>
                            <?php }?>
                        </select>
                        <label for="tipoDocumentoChofer">Tipo Documento Chofer</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating">
                        <input class="form-control form-control-sm"  name="documentoChofer"
                               id="documentoChofer" value="<?php echo $guiaRem[0]["documentoChofer"]?>">
                        <label for="documentoChofer">Documento Chofer</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating">
                        <input class="form-control form-control-sm"  name="licenciaChofer"
                               id="licenciaChofer" value="<?php echo $guiaRem[0]["licenciaChofer"]?>">
                        <label for="licenciaChofer">Licencia Chofer</label>
                    </div>
                </div>
            </div>
            <div class="row pb-2">
                <div class="col-5">
                    <div class="form-floating">
                        <input class="form-control form-control-sm"  name="nombreChofer"
                               id="nombreChofer" value="<?php echo $guiaRem[0]["nombreChofer"]?>">
                        <label for="nombreChofer">Nombre Chofer</label>
                    </div>
                </div>
                <div class="col-5">
                    <div class="form-floating">
                        <input class="form-control form-control-sm"  name="apellidoChofer"
                               id="apellidoChofer" value="<?php echo $guiaRem[0]["apellidoChofer"]?>">
                        <label for="apellidoChofer">Apellido Chofer</label>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-floating">
                        <input class="form-control form-control-sm"  name="placaVehiculo"
                               id="placaVehiculo" value="<?php echo $guiaRem[0]["placaVehiculo"]?>">
                        <label for="placaVehiculo">Placa Vehiculo</label>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <button class="btn btn-primary btn-sm" type="button" id="btnProcesaTransport">Procesar</button>
            <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>