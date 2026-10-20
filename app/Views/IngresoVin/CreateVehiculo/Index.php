<style>
    .rowf {
        margin-bottom: 4px !important;
    }

    .titleLabel {
        font-size: 12px;
    }

    .spanlabel {
        padding-left: 0px;
    }
</style>
<div class="modal-body">
    <div class="row pb-2">
        <div class="col-12">
            <div style="padding: 4px" class="alert alert-subtle-info" role="alert"><i class="fas fa-info-circle"></i>&nbsp;Gestyx Validara si el VIN ya existe en la Base de Datos</div>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-6">
            <h5>Ingreso Vehicular</h5>
        </div>
        <div class="col-6">
            <select class="form-select form-control-sm" id="tipoCreacion">
                <option value="">Tipo de Cracion Vehiculo</option>
                <option value="manual">Manual</option>
            </select>
        </div>
    </div>
    <form enctype="multipart/form-data" action="<?php echo base_url('IngresoVin/SaveEditDelete/SaveVinCreadoGestyx'); ?>" method="POST" id="formCreadoGestyx">
        <div id="panelManual" style="display: none">
            <div id="capturePanel">
            <div class="row pb-2">
                <div class="col-12" style="text-align: center">
                    <video id="preview" style="width: 100%"></video>
                </div>
            </div>
            <hr>
                <div class="row pb-2">
                    <div class="col-12">
                        <div class="input-group">
                            <div class="form-floating">
                                <select class="form-select form-control-sm"  id="camerasSelect">
                                    <option value="">Seleccione una cámara</option>
                                </select>
                                <label for="floatingSelect">Seleccione Camaras</label>
                            </div>
                            <div class="input-prepend">
                                <button class="btn btn-outline-dark btn-sm" id="btnCapture" type="button" style="height: 100%"><i class="fas fa-camera"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="previewPanelCapture" style="display:none">
                <canvas id="snapshot" style="display: none;"></canvas>
                <input type="hidden" name="capturedImage" id="capturedImage">
                <div class="row pb-2">
                    <div class="col-12 text-center">
                        <img id="previewImg" style="max-width: 100%; display: none; margin-top: 10px;" />
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-12 text-center">
                        <button class="btn btn-warning btn-sm" type="button" id="btnVolverCapture"><i class="fas fa-refresh"></i>&nbsp;Volver a Tomar Foto</button>
                    </div>
                </div>
            </div>
            <div class="row pb-2">
                <div class="col-12">
                    <div class="input-group">
                        <div class="form-floating">
                            <input class="form-control form-control-sm" maxlength="17"  id="vinVerifica" oninput="this.value = this.value.toUpperCase();">
                            <label for="floatingSelect">Ingrese Vin</label>
                        </div>
                        <div class="input-prepend">
                            <button class="btn btn-outline-primary btn-sm" id="btnVerifiVin" type="button" style="height: 100%"><i class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12 text-center">
                <span style="font-size: 12px">Vin Verificado</span><br>
                <strong id="textVinVerificado">Genere Busqueda</strong>
                <input hidden name="vinValidado" id="vinValidado">
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select form-control-sm" id="marcaCreate" required name="marcaCreate">
                        <option value="">Seleccione Marca</option>
                        <?php foreach($marca as $mr){ ?>
                            <option value="<?php echo $mr["codigoMarca"]?>"><?php echo $mr["marca"]?></option>
                        <?php }?>
                    </select>
                    <label for="floatingSelect">Seleccione Marca</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select form-control-sm" required name="yearMod">
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option selected value="2025">2025</option>
                        <option value="2026">2026</option>
                    </select>
                    <label for="floatingSelect">Año Modelo</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <input class="form-control form-control-sm" id="modeloVehiculo" required name="modeloVehiculo">
                    <label for="floatingSelect">Modelo Vehiculo</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <input class="form-control form-control-sm" id="colorVin" required name="colorVin">
                    <label for="floatingSelect">Color Vehiculo</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 8px">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit" disabled id="btnProcessCrea">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>