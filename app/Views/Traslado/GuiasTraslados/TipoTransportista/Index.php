<?php
if ($idtipoTransportista == 1) { ?>
    <div class="row pb-2">
        <div class="col-6">
            <div class="form-floating">
                <input class="form-control form-control-sm" name="rucTransportista" id="rucTransportista">
                <label for="rucTransportista">R.U.C</label>
            </div>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <div class="form-floating">
                <input class="form-control form-control-sm" name="razonSocialTransportista"
                       id="razonSocialTransportista">
                <label for="razonSocialTransportista">Razon Social</label>
            </div>
        </div>
    </div>
<?php } else if($idtipoTransportista==2) { ?>
    <div class="row pb-2">
        <div class="col-6">
            <div class="form-floating">
                <input class="form-control form-control-sm" readonly value="<?php echo $emp[0]["documento"]?>" name="rucTransportista" id="rucTransportista">
                <label for="rucTransportista">R.U.C</label>
            </div>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <div class="form-floating">
                <input class="form-control form-control-sm" readonly value="<?php echo $emp[0]["descripcion"]?>" name="razonSocialTransportista"
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
                        <option value="<?php echo $td["idtipoDocumento"]?>"><?php echo $td["descripcion"]?></option>
                    <?php }?>
                </select>
                <label for="tipoDocumentoChofer">Tipo Documento Chofer</label>
            </div>
        </div>
        <div class="col-4">
            <div class="form-floating">
                <input class="form-control form-control-sm"  name="documentoChofer"
                        id="documentoChofer">
                <label for="documentoChofer">Documento Chofer</label>
            </div>
        </div>
        <div class="col-4">
            <div class="form-floating">
                <input class="form-control form-control-sm"  name="licenciaChofer"
                       id="licenciaChofer">
                <label for="licenciaChofer">Licencia Chofer</label>
            </div>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-5">
            <div class="form-floating">
                <input class="form-control form-control-sm"  name="nombreChofer"
                       id="nombreChofer">
                <label for="nombreChofer">Nombre Chofer</label>
            </div>
        </div>
        <div class="col-5">
            <div class="form-floating">
                <input class="form-control form-control-sm"  name="apellidoChofer"
                       id="apellidoChofer">
                <label for="nombreChofer">Apellido Chofer</label>
            </div>
        </div>
        <div class="col-2">
            <div class="form-floating">
                <input class="form-control form-control-sm"  name="placaVehiculo"
                       id="placaVehiculo">
                <label for="placaVehiculo">Placa Vehiculo</label>
            </div>
        </div>
    </div>
<?php } ?>
