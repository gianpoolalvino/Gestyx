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
    <div class="row">
        <div class="col-12">
            <h5>Generar Reporte de Ingresos</h5>
        </div>
    </div>
    <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
        <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#tab-home" role="tab" aria-controls="tab-home" aria-selected="true">Por Seleccion de Vins</a></li>
        <li class="nav-item"><a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#tab-profile" role="tab" aria-controls="tab-profile" aria-selected="false">Por Rango de Fechas</a></li>
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
            <form id="formSenReport" action="<?php echo base_url("IngresoVin/SaveEditDelete/GenerateExcel") ?>" method="POST">
                <input hidden name="tipoRepoprte" value="porVin">
                <div class="row pb-2">
                    <div class="col-12">
                        <label style="font-size: 12px">Seleccione y Agrege el Vin para el Reporte</label><br>
                        <div class="input-group">
                            <select class="select-control form-control-sm" id="vinReporte"
                                    style="width: 75%;height: 38px !important">
                                <?php foreach ($vinIngreso as $vn) { ?>
                                    <option value="<?php echo $vn["vin"] ?>"><?php echo $vn["vin"] . " - " . $vn["marca"] ?></option>
                                <?php } ?>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-outline-primary btn-sm" id="btnSendVin" style="width: 100%"><i
                                            class="fas fa-plus"></i>&nbsp;Agregar a Reporte
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-12">
                        <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                            <tbody id="tbodyVins">
                            </tbody>
                        </table>
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
        <div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
            <form id="formSenReportFe" action="<?php echo base_url("IngresoVin/SaveEditDelete/GenerateExcel") ?>" method="POST">
                <input hidden name="tipoRepoprte" value="porFechas">
                <div class="row pb-2">
                <div class="col-6">
                    <div class="input-group">
                        <div class="input-group-prepend" style="width: 40%">
                            <input class="form-control form-control-sm" required placeholder="Fecha Origen" type="date" id="fechaInicioRepo" name="fechaInicioRepo">
                        </div>
                        <input class="form-control form-control-sm" style="width: 40%" required placeholder="Fecha Final" type="date" id="fechaFinRepo" name="fechaFinRepo">
                        <div class="input-group-append">
                            <button class="btn btn-outline-info btn-sm" id="addGenerate">
                                Añadir
                            </button>
                        </div>
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
    </div>
</div>