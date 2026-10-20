<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12 text-center">
            <i class="far fa-smile fa-4x text-success"></i><br>
            <h5>Archivo Excel Generado</h5>
            <a class="btn btn-outline-success" download="reportePdi.xlsx" href="<?php echo base_url($rutaArchivo)?>"><i class="fas fa-file-excel"></i>&nbsp;Descargar</a>
        </div>
    </div>
</div>