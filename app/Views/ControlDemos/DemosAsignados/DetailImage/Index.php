<div class="row">
<?php
if (!empty($detalleResource)) {
    foreach ($detalleResource as $dtr) {
        ?>
        <div class="col-sm-4 col-md-4 col-lg-4">
            <div class="card border border-secondary">
                <div class="card-body">
                    <p class="card-text"><?php echo $dtr["nombreImagen"] ?></p>
                </div>
                <div class="card-footer" style="padding:6px">
                    <button type="button" data-id="<?php echo $dtr["idresourceAsignacionDemo"]?>" onclick="DeleteResource(<?php echo $dtr["idresourceAsignacionDemo"]?>)" class="btn btn-danger btn-sm btnTrashImage"><i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>
</div>
