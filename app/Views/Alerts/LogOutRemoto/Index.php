<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12 text-center">
            <i class="fas fa-wifi-slash fa-3x"></i>
            <h5><?php echo $title?></h5>
            <span><?php echo $message?></span><hr>
            <a href="<?php echo base_url()?>" class="btn btn-primary btn-sm">Volver a Login</a>
        </div>
    </div>
</div>