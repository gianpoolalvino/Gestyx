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
    .select2-container--default .select2-selection--single {
        height: 33px; /* Ajusta la altura como necesites */
        line-height: 33px; /* Centra el texto verticalmente */
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
    }
</style>
<div class="modal-body">
    <form id="formProceOsb" action="<?php echo base_url("IngresoVin/SaveEditDelete/ProcesarObservacion")?>" method="POST">
        <div class="row">
            <input hidden name="idobservacionIngresoVin" value="<?php echo $idobservacionIngresoVin?>">
            <div class="col-12 text-center">
                <i class="far fa-paper-plane fa-3x text-primary"></i>
                <h5>Si Procesa la Observacion, esta no se podra modificar o eliminar</h5>
                <button class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i>&nbsp;Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </form>
</div>