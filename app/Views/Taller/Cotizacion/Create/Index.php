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

    .bodyCotizacion {
        overflow: auto;
        height: 100%;
        white-space: nowrap;
    }

    .bodyCotizacion thead th {
        position: sticky;
        color:white;
        background: #505050;
        top: 0;
        z-index: 1;
    }

    .bodyCotizacion {
        height: 400px;
        width: 100%;
        overflow: auto;
    }
</style>
<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form id="formCotizacion" method="POST"
          action="<?php echo base_url("Taller/Cotizacion/SaveEditDelete/SaveCotizacion") ?>">
        <div class="row" style="padding-top:1px;padding-bottom:4px">
            <div class="col-9">
                <h4 class="text-primary">Crear Cotizacion</h4>
            </div>
            <div class="col-3">
                <select class="form-control form-control-sm" id="tipoMoneda" name="tipoMoneda" required>
                    <option value="">Tipo Moneda</option>
                    <option selected value="1">Dolares</option>
                    <option value="2">Soles</option>
                </select>
            </div>
        </div>
        <div class="row" style="padding-bottom:4px">
            <div class="col-4">
                <div class="input-group">
                    <div class="form-floating">
                        <input class="form-control form-control-sm"  name="documentoCliente" id="documentoCliente" required>
                        <label for="floatingSelect">Documento</label>
                    </div>
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary btn-sm" type="button" id="btnSearchCli" style="height: 48px"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom:4px">
            <div class="col-12">
                <div class="input-group">
                    <div class="form-floating">
                        <input class="form-control form-control-sm" name="nombreCliente" id="nombreCliente" required>
                        <label for="floatingSelect">Nombre</label>
                    </div>
                    <div class="input-group-prepend" style="width:50%">
                        <div class="form-floating">
                            <input class="form-control form-control-sm" name="direccionCliente" id="direccionCliente" required>
                            <label for="floatingSelect">Direccion</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom:4px">
            <div class="col-12">
                <div class="input-group">
                    <div class="form-floating" style="width:50%">
                        <input class="form-control form-control-sm" type="email" name="correoCliente" id="correoCliente" required>
                        <label for="floatingSelect">Correo</label>
                    </div>
                    <div class="input-group-prepend" style="width:25%">
                        <div class="form-floating">
                            <input class="form-control form-control-sm" name="telefonoCliente" id="telefonoCliente" required>
                            <label for="floatingSelect">Telefono</label>
                        </div>
                    </div>
                    <div class="form-floating">
                        <input class="form-control form-control-sm" name="placaCliente" required>
                        <label for="floatingSelect">Placa</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="form-floating">
                            <select class="form-control form-control-sm inputGeneral" required
                                    name="createMarca"
                                    id="createMarca"
                                    data-choices="data-choices"
                                    aria-label="Floating label select example">
                                <option selected value="">Marcas</option>
                                <?php foreach ($selectMarca as $smrc) { ?>
                                    <option value="<?php echo $smrc["idmarca"] ?>"><?php echo $smrc["descripcion"] ?></option>
                                <?php } ?>
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
                    <div class="input-group-append" style="width:50%">
                        <div class="input-group">
                            <div class="form-floating">
                                <select class="form-control form-control-sm inputGeneral" id="kilometraje"
                                        name="kilometraje" required>
                                    <option value="">Seleccione Kilometraje</option>
                                </select>
                                <label for="floatingSelect">Kilometraje</label>
                            </div>
                            <div class="input-group-append">
                                <div class="form-floating">
                                    <input class="form-control form-control-sm" name="descuento" id="descuento">
                                    <label for="floatingSelect">Descuento</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top:2px">
            <div class="col-12">
                <div class="bodyCotizacion" style="height:400px">
                    <table id="tableCotizacion" class="table fs-9 mb-0 border-top border-translucent table-hover"
                           style="overflow-x: auto;white-space: nowrap;">
                        <thead>
                        <tr>
                            <th>Codigo</th>
                            <th>Cant.</th>
                            <th>Repuesto</th>
                            <th>Precio Unit.</th>
                            <th>Sub Total</th>
                            <th>Dscto</th>
                            <th>Total</th>
                            <th>Opc</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyCotizacion" class="list">
                        <tr>
                            <td colspan="6" class="text-center">Seleccione un plan de Mantenimiento :)</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top:2px">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-group-append" style="width:50%">
                        <div class="input-group">
                            <div class="input-group-append" style="width:40%">
                                <div class="form-floating">
                                    <input class="form-control form-control-sm" disabled value="Mano de Obra">
                                    <label for="floatingSelect">Mano de Obra</label>
                                </div>
                            </div>
                            <div class="form-floating">
                                <input class="form-control form-control-sm" id="cantidadManoObra" name="cantidadManoObra" readonly>
                                <label for="floatingSelect">Cant.</label>
                            </div>
                            <div class="input-group-prepend" style="width:30%">
                                <div class="form-floating">
                                    <input class="form-control form-control-sm" id="costoManoObra" name="costoManoObra" readonly>
                                    <label for="floatingSelect">Sub Total.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="input-group-prepend" style="width:50%">
                        <div class="input-group">
                            <div class="input-group-append" style="width:20%">
                                <div class="form-floating">
                                    <input class="form-control form-control-sm" id="descuentoPorcentaje" name="descuentoPorcentajeManoObra">
                                    <label for="floatingSelect">Dscto %.</label>
                                </div>
                            </div>
                            <div class="form-floating">
                                <input class="form-control form-control-sm" id="descuentoMano" name="descuentoMano" readonly>
                                <label for="floatingSelect">Dscto.</label>
                            </div>
                            <div class="input-group-prepend" style="width:40%">
                                <div class="form-floating">
                                    <input class="form-control form-control-sm" id="totalManoObra" name="totalManoObra" readonly>
                                    <label for="floatingSelect">Total.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top:2px">
            <div class="col-12">
                <div class="form-floating">
                    <textarea class="form-control form-control-sm" name="observacionesCotizacion"
                              style="height:80px"></textarea>
                    <label for="floatingSelect">Observaciones</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-top:6px">
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-sm">PROCESAR</button>
                <button type="button"  data-bs-dismiss="modal" class="btn btn-outline-danger btn-sm">CERRAR</button>
            </div>
            <div class="col-8">
                <div class="row">
                    <div class="col-3">
                        <span id="labeldsctoTotal"></span><br>
                        <strong style="font-size: 12px">Dscto Total:</strong>&nbsp;

                    </div>
                    <div class="col-3">
                        <span id="labelsubTotal"></span><br>
                        <strong style="font-size: 12px">Sub Total:</strong>&nbsp;

                    </div>
                    <div class="col-3">
                        <span id="labeligv"></span><br>
                        <strong style="font-size: 12px">IGV:</strong>&nbsp;

                    </div>
                    <div class="col-3">
                        <span id="labelTotal"></span><br>
                        <strong style="font-size: 12px">Total:</strong>&nbsp;

                    </div>
                    <input hidden name="total" id="total">
                    <input hidden name="subTotal" id="subTotal">
                    <input hidden name="dscto" id="dscto">
                    <input hidden name="descuentoRepuesto" id="descuentoRepuesto">
                    <input hidden name="igv" id="igv">
                </div>
            </div>
        </div>
    </form>
</div>