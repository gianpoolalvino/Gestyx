<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form method="POST" id="formSaveRegla" action="<?php echo base_url("Comisiones/ReglaComision/SaveEditDelete/SaveRegla") ?>">
        <input hidden name="idreglaComision" id="idreglaComision" value="<?php echo $idreglaComisionVentaVehiculo?>">
        <div class="row">
            <div class="col-12">
                <h5>Crear Reglas de Comision</h5>
            </div>
        </div>
        <div class="row" style="padding-bottom: 4px">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-append">
                        <select class="form-select form-control-sm" name="marcaCarga">
                            <?php foreach ($selectMarca as $sm) { ?>
                                <option value="<?php echo $sm["idmarca"] ?>"><?php echo $sm["descripcion"] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <input readonly class="form-control form-control-sm" style="height: 37px" value="Total: 100%">
                    <div class="input-prepend">
                        <button class="btn btn-outline-primary btn-sm" style="height: 37px" id="btnAddConcept">Nuevo Concepto</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="padding-bottom: 4px">
            <div class="col-12">
                <table id="tableConcepto" class="table fs-9 mb-0 border-top border-translucent table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Concepto</th>
                        <th>Meta</th>
                        <th>Peso</th>
                        <th>Opc.</th>
                    </tr>
                    </thead>
                    <tbody id="tbodyConcepto">

                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row" style="padding-bottom: 4px">
            <input hidden name="idreglaComisionCategoria" id="idreglaComisionCategoria" value="<?php echo $idreglaComisionVentaVehiculo?>">
            <div class="col-12">
                <div class="input-group" style="width: 100%">
                    <div class="input-prepend" style="width:35%">
                        <input class="form-control form-control-sm" style="height: 37px" name="categoriaRegla" id="categoriaRegla" placeholder="Categoria...">
                    </div>
                    <div class="input-append" style="width: 65%">
                        <div class="input-group">
                            <div class="input-group-append">
                                <select class="form-select form-control-sm" id="condicionCategoria" name="condicionCategoria">
                                    <option value="mayor">Mayor</option>
                                    <option value="menor">Menor</option>
                                </select>
                            </div>
                            <input class="form-control form-control-sm" placeholder="Porcentaje..." id="porcentajeCategoria" name="porcentajeCategoria">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-success btn-sm" id="BtnAddCategoriaRe" type="button" style="height: 37px">Agregar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" style="padding-bottom: 4px">
            <div class="col-12">
                <table id="tableCategoria" class="table fs-9 mb-0 border-top border-translucent table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Categoria</th>
                        <th>Condicion</th>
                        <th>Porcentaje</th>
                        <th>Opc.</th>
                    </tr>
                    </thead>
                    <tbody id="tbodyCategoria">

                    </tbody>
                </table>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button type="submit" id="btnProcesarRegla" class="btn btn-primary btn-sm">PROCESAR
                </button>
                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                    CANCELAR
                </button>
            </div>
        </div>
    </form>
</div>