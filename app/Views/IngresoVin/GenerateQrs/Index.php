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
    <?php
        date_default_timezone_set('America/Lima');
        $fecha=date('Y-m-d');

    ?>
</style>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Generador de Qrs</h5>
        </div>
    </div>
    <form id="formGenerateQr" target="_blank" action="<?php echo base_url("IngresoVin/CreateViewEdit/ViewQrPrint") ?>" method="POST">
        <input hidden name="tipoRepoprte" value="porFechas">
        <div class="row pb-2">
            <div class="col-3">
                <select class="form-select form-control-sm" name="idubicacionRepo" style="height: 32px;">
                    <?php foreach($ubicacion as $ubi){?>
                        <option value="<?php echo $ubi['idubicacion']?>"><?php echo $ubi['descripcion']?></option>
                    <?php }?>
                </select>
            </div>
            <div class="col-5">
                <div class="input-group" style="width: 100%">
                    <div class="input-group-prepend" style="width: 45%">
                        <input class="form-control form-control-sm" value="<?php echo $fecha ?>" required placeholder="Fecha Origen" type="date"
                               id="fechaInicioRepo" name="fechaInicioRepo">
                    </div>
                    <input class="form-control form-control-sm" value="<?php echo $fecha ?>" max="<?php echo $fecha ?>" style="width: 35%" required placeholder="Fecha Final"
                           type="date" id="fechaFinRepo" name="fechaFinRepo">
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <h6 id="resultado"></h6>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit" id="btnProcesar">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" id="btnCloseReporte"
                        data-bs-dismiss="modal">Cerrar
                </button>
            </div>
        </div>
    </form>
</div>