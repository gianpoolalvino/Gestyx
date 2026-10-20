<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
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

    .bodyExhibicion {
        overflow: auto;
        height: 100%;
        white-space: nowrap;
    }

    .bodyExhibicion thead th {
        position: sticky;
        color: white;
        background: #505050;
        top: 0;
        z-index: 1;
    }

    .bodyExhibicion {
        height: 300px;
        width: 100%;
        overflow: auto;
    }
</style>
<div class="modal-body">
    <form id="formExhibicionVin" method="POST"
          action="<?php echo base_url("Inventario/SaveEditDelete/SaveExhibicion") ?>">
        <div class="form-row">
            <div class="col-12">
                <h5>ENVIAR A EXHIBICION (VIN: <?php echo $vin ?>)</h5>
            </div>
            <br>
        </div>
        <input hidden name="vinExhibicion" id="vinExhibicion" value="<?php echo $vin ?>">
        <input hidden name="idexhibicionVin" id="idexhibicionVin"
               value="<?php echo $viewExhibicion[0]["idexhibicionVin"] ?>">
        <div class="row" style="padding-bottom: 6px">
            <div class="col-6" style="padding-right: 2px">
                <div class="form-floating">
                    <input class="form-control form-control-sm" required
                           name="solicitante"
                           value="<?php echo $viewExhibicion[0]["solicitante"] ?>"
                           data-choices="data-choices"
                           aria-label="Floating label select example">
                    <label for="floatingSelect">Solicitante</label>
                </div>
            </div>
            <div class="col-6" style="padding-left: 2px">
                <div class="form-floating">
                    <select class="form-control form-control-sm" name="agenciaExhibicion">
                        <option value="">Seleccione Agencia Solicitante</option>
                        <?php foreach($selectAgencia as $sa){?>
                            <?php if($sa["idagencia"]==$viewExhibicion[0]["idagenciaSolicitante"]){?>
                                <option selected value="<?php echo $sa["idagencia"]?>"><?php echo $sa["descripcion"]?></option>
                            <?php }else{?>
                                <option value="<?php echo $sa["idagencia"]?>"><?php echo $sa["descripcion"]?></option>
                            <?php }?>
                        <?php }?>
                    </select>
                    <label for="floatingSelect">Agencia Solicitante</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 6px">
            <div class="col-5" style="padding-right: 2px">
                <div class="form-floating">
                    <select class="form-control form-control-sm" disabled required
                            data-choices="data-choices"
                            aria-label="Floating label select example">
                        <option value="1">POR ENVIAR PARA ALISTAMIENTO</option>
                    </select>
                    <label for="floatingSelect">Estado Exhibicion</label>
                </div>
            </div>
            <div class="col-5" style="padding-left: 2px;padding-right: 2px">
                <div class="input-group" style="width: 100%">
                    <div class="input-group-prepend" style="width: 50%">
                        <div class="form-floating">
                            <input class="form-control form-control-sm" type="date"
                                   value="<?php echo ($viewExhibicion[0]["fechaEstimadaEnvioExhibicion"] != '') ? $viewExhibicion[0]["fechaEstimadaEnvioExhibicion"] : $hoy ?>"
                                   placeholder="Fecha Envio" name="fechaEstimadaEnvio" required>
                            <label for="floatingSelect">Fecha Estimada Envio</label>
                        </div>
                    </div>
                    <div class="input-group-append" style="width: 50%">
                        <div class="form-floating">
                            <input class="form-control form-control-sm" type="date"
                                   value="<?php echo ($viewExhibicion[0]["fechaEstimadaRetornoExhibicion"] != '') ? $viewExhibicion[0]["fechaEstimadaRetornoExhibicion"] : $hoy ?>"
                                   placeholder="Fecha Retorno" name="fechaEstimadaRetorno" required>
                            <label for="floatingSelect">Fecha Estimada Retorno</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-2" style="padding-left: 2px">
                <button type="button" id="btnAddEquipamiento" class="btn btn-outline-info btn-sm">Agregar Accesorios
                </button>
            </div>
        </div>
        <div class="row" style="padding-bottom: 6px">
            <div class="col-12">
                <div class="bodyExhibicion" style="height:300px;border:solid 1px #cbd0dd;border-radius:6px">
                    <table class="table fs-9 mb-0 border-top border-translucent table-hover"
                           style="overflow-x: auto;white-space: nowrap;">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Cant.</th>
                            <th>Codigo</th>
                            <th>Descripcion</th>
                            <th>Opc.</th>
                        </tr>
                        </thead>
                        <tbody id="tbodyEquipamientoExhibicion">
                        <?php
                        $contador = 0;
                        if (!empty($detailExhibicion)) {
                            ?>
                            <?php foreach ($detailExhibicion as $dt) {
                                $contador++;
                                ?>
                                <tr style="vertical-align: middle">
                                    <td class="px-2"><?php echo $contador ?></td>
                                    <td class="px-2"><?php echo $dt["cantidad"] ?></td>
                                    <td class="px-2"><?php echo $dt["codigoEquipamiento"] ?></td>
                                    <td class="px-2"><?php echo $dt["equipamiento"] ?></td>
                                    <td>
                                        <button class="btn btn-danger btn-sm btndeleteEq" type="button"
                                                data-idequipamiento="<?php echo $dt["idequipamientoVin"]?>"><i
                                                    class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom:6px">
            <div class="col-12">
                <div class="form-floating">
                <textarea class="form-control form-control-sm"
                          name="comentario"
                          data-choices="data-choices"
                          style="height: 100px"
                          aria-label="Floating label select example"><?php echo $viewExhibicion[0]["comentario"] ?></textarea>
                    <label for="floatingSelect">Comentario</label>
                </div>
            </div>
        </div>
        <div class="form-row" style="padding-bottom: 6px">
            <div class="col-12">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <select class="form-control form-control-sm" name="estadoExhibicion">
                            <option selected value="1">Guardar Como Borrador</option>
                            <option value="2">Procesar</option>
                        </select>
                    </div>
                    <button class="btn btn-primary btn-sm" type="submit">GUARDAR</button>
                    <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
                </div>
            </div>
        </div>
    </form>
</div>