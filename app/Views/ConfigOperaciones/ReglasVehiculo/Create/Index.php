<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<style>
    .select2-container--default .select2-selection--single {
        height: 33px; /* Ajusta la altura como necesites */
        line-height: 33px; /* Centra el texto verticalmente */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
    }
    .select2-dropdown {
        z-index: 9999999 !important; /* Asegúrate de que tenga un valor mayor que el del modal */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
        padding-top: 14px;
        font-size: 14px;
        padding-left: 15px;
    }
    .select2-container--default .select2-selection--single {
        height: 47px;
        line-height: 52px;
    }
</style>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h6>Nueva Regla Tiempo Entrega</h6>
        </div>
    </div>
    <hr>
    <form id="formSaveRegla" method="POST"
          action="<?php echo base_url("ConfigOperaciones/ReglasVehiculo/SaveEditDelete/SaveRegla") ?>">
        <input hidden name="idreglaVehiculo" id="idreglaVehiculo" value="<?php echo $idreglaEntrega?>">
        <div class="row" style="padding-bottom: 8px">
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select" id="tipoRegla" name="tipoRegla"
                            aria-label="Floating label select example">
                        <option selected
                                value="1">Inicio</option>
                        <option
                            value="2">Secuencia</option>
                    </select>
                    <label for="floatingSelect">Tipo de Regla</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select" id="campoVehiculo" name="campoVehiculo"
                            aria-label="Floating label select example">
                        <?php foreach($camposRegla as $cr){?>
                            <option value="<?php echo $cr["idcampoVehiculo"]?>"><?php echo $cr["nombreCampoVehiculo"]?></option>
                        <?php }?>
                    </select>
                    <label for="floatingSelect">Campo Regla</label>
                </div>
            </div>
        </div>
        <hr>
            <div class="row pb-2">
                <div class="col-3">
                    <select class="form-select form-control-sm" id="operadorRegla">
                        <option value="">Operadores</option>
                        <option value="LIKE">Contiene</option>
                        <option value="NOT LIKE">No Contiene</option>
                        <option value=">">Mayor a</option>
                        <option value="<">Menor a</option>
                        <option value="=">Igual</option>
                        <option value="IS NULL">Es Nulo</option>
                        <option value="IS NOT NULL">No es Nulo</option>
                    </select>
                </div>
                <div class="col-3">
                    <input class="form-control form-control-sm" id="valorRegla" placeholder="Valor de Regla">
                </div>
                <div class="col-3">
                    <input class="form-control form-control-sm" id="diasRegla" placeholder="Dias Entrega">
                </div>
                <div class="col-3">
                    <button class="btn btn-outline-primary btn-sm" id="btnSaveCondicion">Generar Condicion</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <table id="tableAlist" class="table fs-9 mb-0 border-top border-translucent table-hover table-sm">
                        <thead>
                        <tr>
                            <th class="sticky-col first-col">#</th>
                            <th>Valor</th>
                            <th>Operador</th>
                            <th>Tiempo</th>
                            <th>Opc</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyTare" class="list">

                        </tbody>
                    </table>
                </div>
            </div>
            <hr>

        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>