<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12" style="text-align: center">
            <h5>Escanea el QR para Obtener el Api WSP</h5>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12" style="text-align: center">
            <div id="qrCode"></div>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <input type="text" id="sessionId" value="<?php echo session('idusuario')?>" hidden placeholder="ID de sesión">
            <button type="button" class="btn btn-primary btn-sm" id="startSessionBtn">Nuevo QR</button>
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                CERRAR
            </button>
        </div>

    </div>
</div>