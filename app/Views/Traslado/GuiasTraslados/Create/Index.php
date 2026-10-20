<div class="modal-body">
    <div class="row">
        <div class="col-12">

            <form id="formGuia" method="POST"
                  action="<?php echo base_url("Traslado/GuiasTraslados/SaveEditDelete/SaveDatosEmision") ?>">
                <input hidden name="idguiaRemision" id="idguiaRemision" value="<?php echo $idguiaRemision ?>">
                <input hidden name="idprocesoGuia" id="idprocesoGuia" value="1">
                <div class="row pb-2">
                    <div class="col-6">
                        <strong>Tipo de GRE : </strong><span>Remitente</span>
                    </div>
                    <div style="text-align: right" class="col-6">
                        <button class="btn btn-phoenix-primary" type="button" id="btnTransporte">Transportista</button>
                        <button class="btn btn-phoenix-primary" id="btnActoresList" disabled type="button">Actores</button>
                        <button class="btn btn-phoenix-primary" id="btnRelDocAd" type="button">Doc. Relacionado</button>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-4">
                        <div class="form-floating">
                            <select class="form-select" id="empresa" name="empresa"
                                    aria-label="Floating label select example">
                                <?php if (!isset($idempresa)) { ?>
                                    <option selected value="">Seleccionar empresa</option>
                                <?php } ?>

                                <?php foreach ($empresa as $emp) { ?>
                                    <?php if (isset($idempresa)) { ?>
                                        <?php if ($idempresa == $emp["idempresa"]) { ?>
                                            <option selected value="<?php echo $emp["idempresa"] ?>"><?php echo $emp["descripcion"] ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $emp["idempresa"] ?>"><?php echo $emp["descripcion"] ?></option>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <option value="<?php echo $emp["idempresa"] ?>"><?php echo $emp["descripcion"] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <label for="floatingSelect">Empresa</label>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-floating">
                            <select class="form-select" id="motivoTraslado" name="motivoTraslado"
                                    aria-label="Floating label select example">
                                <?php foreach ($motivoTraslado as $mt) { ?>
                                    <?php if ($mt["idmotivoTrasladoGuia"] == 4) { ?>
                                        <option selected
                                                value="<?php echo $mt["idmotivoTrasladoGuia"] ?>"><?php echo $mt["descripcion"] ?></option>
                                    <?php } else { ?>
                                        <option value="<?php echo $mt["idmotivoTrasladoGuia"] ?>"><?php echo $mt["descripcion"] ?></option>
                                    <?php } ?>
                                <?php } ?>
                            </select>
                            <label for="motivoTraslado">Traslado</label>
                        </div>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-12">
                        <div id="panelOpcional" style="display: none">
                            <div class="form-floating">
                                <input class="form-control" style="height: 60px" id="especificarTraslado" name="especificarTraslado">
                                <label for="floatingSelect">Especificar Tipo de Traslado</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" id="checkUbicacion" type="checkbox"/>
                            <label class="form-check-label" for="checkUbicacion">Realizar cambio de ubicacion con la Guia</label>
                        </div>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-6">
                        <table class="table table-bordered table-hover" style="width: 100%;margin-bottom: 5px;">
                            <tbody id="tbodyDireccionOrigen">
                                <tr>
                                    <td style="width: 100%; padding-left: 8px;padding-bottom: 2px;padding-top: 2px;vertical-align: middle">Origen: Ingresar</td>
                                </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-subtle-primary btn-sm" id="btnAddOrigen" type="button">Agregar Origen</button>
                    </div>
                    <div class="col-6">
                        <table class="table table-bordered table-hover" style="width: 100%;margin-bottom: 5px;">
                            <tbody id="tbodyDireccionDestino">
                            <tr>
                                <td style="width: 100%; padding-left: 8px;padding-bottom: 2px;padding-top: 2px;vertical-align: middle">Destino: Ingresar</td>
                            </tr>
                            </tbody>
                        </table>
                        <button class="btn btn-subtle-primary btn-sm" id="btnAddDestino" type="button">Agregar Destino</button>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-8">

                    </div>
                    <div class="col-4" style="text-align: right">
                        <button class="btn btn-outline-primary btn-sm" type="button" id="btnAddVin"><i class="fas fa-plus"></i>&nbsp;Agregar Vin</button>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-12">
                        <table class="table table-sm fs-9 mb-0 table-hover">
                            <thead>
                            <tr class="bg-body-highlight">
                                <th style="text-align: left" class="sort border-top border-translucent ps-3" data-sort="name">#</th>
                                <th style="text-align: left" class="sort border-top border-translucent ps-3" data-sort="email">Vin</th>
                                <th style="text-align: left" class="sort border-top border-translucent ps-3" data-sort="payment">Marca</th>
                                <th class="sort border-top border-translucent ps-3" data-sort="payment">Modelo</th>
                                <th class="sort border-top border-translucent ps-3" data-sort="payment">Color</th>
                                <th class="sort border-top border-translucent ps-3" data-sort="payment">Unid. Medida</th>
                                <th class="sort border-top border-translucent ps-3" data-sort="payment">Opc.</th>
                            </tr>
                            </thead>
                            <tbody class="list" id="tbodyVinGuia">
                            <tr>
                                <td colspan="7" class="text-center">No ingreso ningun VIN :(</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row pb-2">
                    <div class="col-6">
                        <div class="form-floating">
                            <select class="form-select" id="unidadMedidaGuia" name="unidadMedidaGuia" aria-label="Floating label select example">
                                <option value="">Seleccione unidad de Medida Peso</option>
                                <?php foreach($unidadMedida as $um){?>
                                    <option value="<?php echo $um["codigoSunat"]?>"><?php echo $um["descripcion"]?></option>
                                <?php }?>
                            </select>
                            <label for="unidadMedidaGuia">Unidad de medida de peso bruto</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-floating">
                            <input class="form-control form-control-sm" id="pesoGuia" name="pesoGuia">
                            <label for="pesoGuia">Peso bruto total de la carga</label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row pb-2">
                    <div class="col-12" style="text-align: right">
                        <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Cancelar</button>
                        <button class="btn btn-primary btn-sm" type="submit">Procesar</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
                