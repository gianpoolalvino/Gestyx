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
        <form id="formBateria" method="POST" action="<?php echo base_url("Inventario/SaveEditDelete/SaveBateria") ?>">
            <div class="row" style="padding-top:1px">
                <div class="col-12">
                    <h4 class="text-primary">Crear Plan de Mto por Familia</h4>
                </div>
            </div>
            <input hidden name="idplanMto" id="idplanMto">
            <div class="row">
                <div class="col-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="form-floating">
                                <select class="form-control form-control-sm inputGeneral" required
                                        name="createMarcas"
                                        id="createMarcas"
                                        data-choices="data-choices"
                                        aria-label="Floating label select example">
                                    <option selected value="">Marcas</option>
                                    <?php foreach($selectMarca as $smrc){?>
                                        <option value="<?php echo $smrc["idmarca"]?>"><?php echo $smrc["descripcion"]?></option>
                                    <?php }?>
                                </select>
                                <label for="floatingSelect">Marca</label>
                            </div>
                        </div>
                        <div class="form-floating">
                            <select class="form-control form-control-sm inputGeneral" required
                                    name="createModelo"
                                    id="createModelo"
                                    data-choices="data-choices"
                                    aria-label="Floating label select example">
                                <option selected value="">Modelos</option>
                            </select>
                            <label for="floatingSelect">Modelo</label>
                        </div>
                        <div class="input-group-append" style="width:50%" >
                            <div class="input-group">
                                <div class="form-floating">
                                    <select class="form-control form-control-sm inputGeneral" id="frecuencia" name="frecuencia" required>
                                        <option value="">Seleccione Frecuencia</option>
                                        <option value="5000">5000</option>
                                        <option value="10000">10000</option>
                                        <option value="15000">15000</option>
                                    </select>
                                    <label for="floatingSelect">Frecuencia</label>
                                </div>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success" id="btnSavePlan" style="height: 48px;">GENERAR</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="padding-top: 6px">
                <div class="col-12">
                    <div class="input-group">
                        <select class="form-control form-control-sm" disabled id="selectRepuesto">
                            <option value="">Seleccione Repuesto</option>
                        </select>
                        <div class="input-group-append">
                            <button type="button" disabled id="btnAddRepuesto" class="btn btn-outline-primary btn-sm">
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
                                <th>Precio</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-12">
                    <button disabled class="btn btn-primary btn-sm" id="btnProcesarPlan" type="submit">PROCESAR</button>
                    <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </form>

</div>