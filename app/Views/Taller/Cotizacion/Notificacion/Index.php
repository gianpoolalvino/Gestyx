<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="row pb-2">
        <div class="col-12 text-center">
            <?php if ($status == 'danger') { ?>
                <i class="fal fa-sad-tear fa-3x"></i>
                <h5><?php echo $title ?></h5>
                <table id="tableAlistamiento"
                       class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                    <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Descripcion</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($detail as $dt) { ?>
                        <tr>
                            <td><?php echo $dt->MensajeError ?></td>
                            <td><?php echo $dt->CodigoGenerado ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php }else{ ?>
                <i class="far fa-smile-wink fa-3x"></i>
                <h5><?php echo $title ?></h5>
                <span><?php echo $message?></span>
            <?php }?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
        </div>
    </div>
</div>