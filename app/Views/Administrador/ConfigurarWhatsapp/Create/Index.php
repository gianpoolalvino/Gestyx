<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form method="POST" id="formSaveWsp" action="<?php echo base_url("Administrador/ConfigurarWhatsapp/SaveEditDelete/StorageWhatsapp")?>">
    <div class="row">
        <div class="col-12" style="text-align: center">
            <h5>Escanea el QR para Obtener el Api WSP</h5>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12" style="text-align: center">
            <div id="qr">
                <p>Esperando que se genere el código QR...</p>
            </div>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <div class="input-group">
                <div class="input-group-prepend">
                    <button class="btn btn-subtle-secondary btn-sm" id="requestNewQRBtn">Solicitar Nuevo QR</button>
                </div>
                <input class="form-control form-control-sm" name="numeroSession" id="numeroSession" placeholder="Ingrese numero para sesión..." />
                <div class="input-group-append">
                    <button class="btn btn-subtle-danger btn-sm" disabled id="btnresetNumber">X</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <input class="form-control form-control-sm" name="tokenSession" id="tokenSession" placeholder="Ingrese token de sesion...">
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12 text-center">
            <div id="status"></div>
            <div id="error"></div>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-sm" disabled id="saveWspQr">Guardar Wsp</button>
            <button type="button" class="btn btn-outline-danger btn-sm" id="btnDestroy">
                CERRAR
            </button>
        </div>
    </div>
    </form>
</div>