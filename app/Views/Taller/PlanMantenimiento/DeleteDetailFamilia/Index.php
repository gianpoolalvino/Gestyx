<style>
    .rowf {
        margin-bottom: 4px !important
    }

    .titleLabel {
        font-size: 12px
    }

    .spanlabel {
        padding-left: 0px
    }
</style>
<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form id="formdetalletrash" method="POST" action="<?php echo base_url("Taller/PlanMantenimiento/SaveEditDelete/DeleteDetailFamilia") ?>">
        <input hidden name="iddetallePlanMantenimientoFamilia" value="<?php echo $iddetallePlanMantenimientoFamilia ?>">
        <div class="row" style="padding-top:1px">
            <div class="col-12 text-center">
                <i class="far fa-sad-tear fa-3x text-danger"></i>
                <h4 class="text-danger">¿Realmente desea eliminar el repuesto <?php echo $viewDetail[0]["repuesto"]?>?</h4>
            </div>
        </div><hr>
        <div class="row" style="padding-top: 6px">
            <div class="col-12 text-center">
                <button class="btn btn-danger btn-sm" type="submit">Eliminar</button>
                <button class="btn btn-outline-dark btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>