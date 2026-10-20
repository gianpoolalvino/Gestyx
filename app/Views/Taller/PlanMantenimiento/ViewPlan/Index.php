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
<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form id="formPlanMtoFam" method="POST"
          action="<?php echo base_url("Taller/PlanMantenimiento/SaveEditDelete/UpdatePlanFamilia") ?>">
        <div class="row" style="padding-top:1px">
            <div class="col-12">
                <h4 class="text-primary">Editar Plan de Mto por Familia</h4>
            </div>
        </div>
        <input hidden name="idplanMto" id="idplanMto" value="<?php echo $idplanMantenimientoFamilia ?>">
        <div class="row">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="form-floating">
                            <select class="form-control form-control-sm inputGeneral"
                                    disabled
                                    data-choices="data-choices"
                                    aria-label="Floating label select example">
                                <option selected value=""><?php echo $viewPlan[0]["marca"] ?></option>
                            </select>
                            <label for="floatingSelect">Marca</label>
                        </div>
                    </div>
                    <div class="form-floating">
                        <select class="form-control form-control-sm inputGeneral"
                                disabled
                                data-choices="data-choices"
                                aria-label="Floating label select example">
                            <option selected value=""><?php echo $viewPlan[0]["modelo"] ?></option>
                        </select>
                        <label for="floatingSelect">Modelo</label>
                    </div>
                    <div class="input-group-append" style="width:50%">
                        <div class="input-group">
                            <div class="form-floating">
                                <select class="form-control form-control-sm inputGeneral" disabled>
                                    <option value=""><?php echo $viewPlan[0]["frecuencia"] ?></option>
                                </select>
                                <label for="floatingSelect">Frecuencia</label>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-outline-success" disabled style="height: 48px;">GENERAR</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 6px">
            <div class="col-12">
                <div class="input-group">
                    <div class="form-floating">
                        <input class="form-control form-control-sm" value="Mano de Obra" disabled>
                        <label for="floatingSelect">Servicio</label>
                    </div>
                    <div class="input-group-prepend" style="width: 60%">
                        <div class="input-group" style="width: 100%">
                            <div class="form-floating">
                                <input class="form-control form-control-sm" name="costoManoObra"
                                       value="<?php echo $viewPlan[0]["costoManoObra"] ?>" required>
                                <label for="floatingSelect">Costo Mano de obra</label>
                            </div>
                            <div class="input-group-prepend" style="width: 50%">
                                <div class="form-floating">
                                    <select class="form-control form-control-sm" name="kilometrajeMax" required>
                                        <?php foreach ($kilometraje as $km) { ?>
                                            <?php if ($km["idkilometrajeMantenimiento"] == $viewPlan[0]["idkilometroMaximo"]) { ?>
                                                <option selected
                                                        value="<?php echo $km["idkilometrajeMantenimiento"] ?>"><?php echo $km["kilometraje"] ?></option>
                                            <?php } else { ?>
                                                <option value="<?php echo $km["idkilometrajeMantenimiento"] ?>"><?php echo $km["kilometraje"] ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                    <label for="floatingSelect">Kilometraje Max</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top: 6px">
            <div class="col-12">
                <div class="input-group">
                    <select class="form-control form-control-sm" style="width: 85%;height: 38px !important" id="selectRepuesto">
                        <option value="">Seleccione Repuesto</option>
                        <?php
                        foreach ($selectRepuesto as $mcc) {
                            echo '<option value="' . $mcc["idrepuesto"] . '">' . $mcc["codigo"] . ' - ' . $mcc["descripcion"] . '</option>';
                        } ?>
                    </select>
                    <div class="input-group-append" style="width: 15%">
                        <button type="button" style="width: 100%" id="btnAddRepuesto" class="btn btn-outline-primary btn-sm">
                            Agregar
                        </button>
                    </div>
                </div>

            </div>
        </div>
        <div class="row" style="padding-top: 6px">
            <div class="col-12">
                <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Cant.</th>
                        <th>Codigo</th>
                        <th>Descripcion</th>
                        <th>Precio Unidad</th>
                        <th>Precio Total</th>
                        <th>Opc.</th>
                    </tr>
                    </thead>
                    <tbody id="tbodyPlanMto">
                    <?php
                    $contador = 0;
                    foreach ($detailViewPlan as $dvp) {
                        $contador++;
                        ?>
                        <tr>
                            <td><?php echo $contador ?></td>
                            <td><?php echo $dvp["cantidad"] ?></td>
                            <td><?php echo $dvp["codigo"] ?></td>
                            <td><?php echo $dvp["repuesto"] ?></td>
                            <td><?php echo $dvp["precioUnidadDolares"] ?></td>
                            <td><?php echo $dvp["precioTotalDolares"] ?></td>
                            <td>
                                <button class="btn btn-danger btn-sm btnDetailRepuesto"
                                        data-iddetallePlanMtoFam="<?php echo $dvp["iddetallePlanMantenimientoFamilia"] ?>">
                                    <i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-6">
                <div class="input-group">
                    <select name="tipoProceso" id="tipoProceso" class="form-control form-control-sm">
                        <option value="">Sin Acciones</option>
                        <option value="1">Guardar</option>
                        <option value="2">Guardar y Procesar</option>
                    </select>
                    <div class="input-group-prepend">
                        <button class="btn btn-primary btn-sm" id="btnProcesarPlan" disabled type="submit">PROCESAR
                        </button>
                        <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-6" style="text-align: right">
                <button class="btn btn-primary btn-sm" id="btnCargaMysql"><i class="fas fa-database"></i>&nbsp;Carga Mysql</button>
            </div>
        </div>
    </form>

</div>