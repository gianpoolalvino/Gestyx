<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form method="POST" id="formSaveWsp" action="<?php echo base_url("Administrador/ConfigurarWhatsapp/SaveEditDelete/UpdateWhatsapp")?>">
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
                    <input class="form-control form-control-sm" readonly id="numeroSession" name="numeroSession" value="<?php echo $whatsapp[0]["numero"]?>" placeholder="Ingrese numero para sesión..." />
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <input class="form-control form-control-sm" value="<?php echo $whatsapp[0]["token"]?>" id="tokenSession" name="tokenSession" placeholder="Ingrese token de sesion...">
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12 text-center">
                <div id="status">
                    <?php echo ($whatsapp[0]["estado"]==1)?'La Session se encuentra activa':'El Whatsapp esta con sesion cerrada'?>
                </div>
                <div id="error"></div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-8">
                <button type="submit" class="btn btn-primary btn-sm" disabled id="saveWspQr">Guardar Wsp</button>
                <button type="button" class="btn btn-subtle-secondary btn-sm" id="btnDestroy">
                    CERRAR
                </button>
            </div>
            <div class="col-4">
                <button class="btn btn-danger btn-sm" id="btnCerrarSession" type="button">Cerrar Sesion WSP</button>
            </div>
        </div>
    </form>
</div>