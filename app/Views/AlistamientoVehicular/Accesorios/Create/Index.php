<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Proceso Vehicular - Accesorios (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#tab-home"
                                        role="tab" aria-controls="tab-home" aria-selected="true">General</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#tab-profile"
                                        role="tab" aria-controls="tab-profile" aria-selected="false">Equipamiento</a>
                </li>
                <li class="nav-item"><a class="nav-link" id="hoja-tab" data-bs-toggle="tab" href="#tab-hoja"
                                        role="tab" aria-controls="tab-hoja" aria-selected="false">Actualizar Hoja de Negocio</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div id="panelVinInfo">

                    </div>
                </div>
                <div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">
                    <h6 style="font-size: 16px">- Accesorización General -</h6>
                    <form action="<?php echo base_url("AlistamientoVehicular/Accesorios/SaveEditDelete/SaveProcesoAccesorio") ?>"
                          id="formSave" method="POST">
                        <input hidden name="vinEquipamiento" value="<?php echo $vin ?>">
                        <div class="form-row">
                            <div class="col-12">
                                <table class="table fs-9 mb-0 px-2 border-top border-translucent table-hover">
                                    <tbody id="tbodyEqSimple">
                                    <?php if (!empty($equipamiento)) {
                                        $count = 0;
                                        ?>
                                        <?php foreach ($equipamiento as $eq) { ?>
                                            <?php if ($eq["eliminado"] != 1) {
                                                if ($eq["idtipoEquipamiento"] == 1) {
                                                    $count++;
                                                    ?>
                                                    <tr style="vertical-align: middle;">
                                                        <td class="px-2">
                                                            <?php echo ($eq["idestadoEquipamiento"] == 2) ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>' ?>
                                                            <?php echo $eq["equipamiento"] ?>
                                                            <span><?php echo ($eq["idestadoEquipamiento"] != 2) ? $eq["fechaInstalacion"] : '' ?></span>
                                                        </td>
                                                        <td class="px-2" style="width: 20%">
                                                            <?php if ($eq["idestadoEquipamiento"] != 2) { ?>
                                                                <?php if ($eq["eventoLamina"] > 0) { ?>
                                                                    <span class="badge badge-phoenix fs-10 badge-phoenix-secondary"><i
                                                                                class="fas fa-cog fa-spin"></i>&nbsp;Evento Lamina</span>
                                                                <?php } else { ?>
                                                                    <button class="btn btn-outline-primary btnOpcionAccesorio"
                                                                            type="button" data-vin="<?php echo $vin ?>"
                                                                            data-idequipamiento="<?php echo $eq["idequipamientoVin"] ?>">
                                                                        <i class="fas fa-wrench"></i>&nbsp;Equipar
                                                                    </button>
                                                                <?php } ?>
                                                            <?php } else { ?>
                                                                <span class="badge badge-phoenix fs-10 badge-phoenix-success"><i
                                                                            class="fas fa-cog fa-spin"></i>&nbsp;Instalado</span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            }
                                        }
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <br>
                        <h6 style="font-size: 16px">- Accesorización GPS y GAS -</h6>
                        <div class="form-row">
                            <div class="col-12">
                                <table class="table fs-9 mb-0 px-2 border-top border-translucent table-hover">
                                    <tbody id="tbodyEqCritico">
                                    <?php if (!empty($equipamiento)) {
                                        $count = 0;
                                        ?>
                                        <?php foreach ($equipamiento as $eq) { ?>
                                            <?php if ($eq["eliminado"] != 1) {
                                                if ($eq["idtipoEquipamiento"] != 1) { ?>
                                                    <tr style="vertical-align: middle;">
                                                        <td class="px-2">
                                                            <?php if ($eq["idestadoEquipamiento"] == 1) { ?>
                                                                <i class="fas fa-times text-danger"></i>
                                                            <?php } else if ($eq["idestadoEquipamiento"] == 2) { ?>
                                                                <i class="fas fa-check text-success"></i>
                                                            <?php } else { ?>
                                                                <i class="fas fa-check text-warning"></i>
                                                            <?php } ?>
                                                            <?php echo $eq["equipamiento"] ?><br>
                                                            <span><?php echo ($eq["idestadoEquipamiento"] != 2) ? $eq["fechaInstalacion"] : '' ?></span>
                                                        </td>
                                                        <td class="px-2" style="width: 20%">
                                                            <?php if ($eq["idtipoEquipamiento"] == 9 && $eq["eventoGas"] == 0) { ?>
                                                                <button class="btn btn-outline-primary btnOpcionAccesorio"
                                                                        type="button" data-vin="<?php echo $vin ?>"
                                                                        data-idequipamiento="<?php echo $eq["idequipamientoVin"] ?>">
                                                                    <i class="fas fa-wrench"></i>&nbsp;Equipar
                                                                </button>
                                                            <?php } ?>
                                                            <?php if ($eq["idtipoEquipamiento"] == 9 && $eq["eventoGas"] == 1) { ?>
                                                                <span class="badge badge-phoenix fs-10 badge-phoenix-primary"><i
                                                                            class="fas fa-cog fa-spin"></i>&nbsp;Convertido a Gas</span>
                                                            <?php } ?>
                                                            <?php if ($eq["idtipoEquipamiento"] == 2 && $eq["eventoGps"] == 0) { ?>
                                                                <button class="btn btn-outline-primary btnOpcionAccesorio"
                                                                        type="button" data-vin="<?php echo $vin ?>"
                                                                        data-idequipamiento="<?php echo $eq["idequipamientoVin"] ?>">
                                                                    <i class="fas fa-wrench"></i>&nbsp;Equipar
                                                                </button>
                                                            <?php } ?>
                                                            <?php if ($eq["idtipoEquipamiento"] == 2 && $eq["eventoGps"] == 1) { ?>
                                                                <span class="badge badge-phoenix fs-10 badge-phoenix-secondary"><i
                                                                            class="fas fa-cog fa-spin"></i>&nbsp;En Evento GPS</span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php }
                                            }
                                        }
                                    } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-row" style="padding-top: 8px">
                            <div class="col-12">
                                <div class="input-group-append">
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" style="height: 120px"  name="comentarioProcesoAccesorio"></textarea>
                                        <label for="floatingInput">Observaciones o Comentarios</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-12">
                                <button type="submit" id="btnProcesarAccess" class="btn btn-primary btn-sm">PROCESAR
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                                    CANCELAR
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="tab-hoja" role="tabpanel" aria-labelledby="hoja-tab">Agregar
                    Cotizacion
                    <form action="<?php echo base_url("Confirmacion/SinCotizacion/SaveEditDelete/UpdateHojaNegocio") ?>"
                          id="formSaveHoja" method="POST">
                        <input hidden name="vinPedido" id="vinPedido" value="<?php echo $vin ?>">
                        <div class="input-group" style="padding-bottom: 4px">
                            <div class="input-group-prepend" style="width: 60%">
                                <div class="form-floating">
                                    <select class="form-control form-control-sm" id="selectEstadoCoti" required
                                            name="estadoCotizacion"
                                            data-choices="data-choices"
                                            aria-label="Floating label select example">
                                        <option value="1">Realizada</option>
                                    </select>
                                    <label for="floatingSelect">Estado de Cotizacion</label>
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input class="form-control" <?php echo ($infoVin[0]["numeroPedido"] != '') ? 'readonly' : '' ?>
                                       id="numeroPedido" name="numeroPedido"
                                       value="<?php echo $infoVin[0]["numeroPedido"] ?>"
                                       required/>
                                <label for="floatingInput">Numero Pedido.</label>
                            </div>
                            <button type="button" id="btnVerificar" class="btn btn-phoenix-primary me-1 mb-1" style="height: 48px;"><i class="fa-solid fa-rotate-right"></i></button>
                            <div class="input-group-append">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="fechaAplicaCotiza" name="fechaAplicaCotiza"
                                           value="<?php echo $hoy ?>"
                                           max="<?php echo $hoy ?>"
                                           required type="date"/>
                                    <label for="floatingInput">Fecha Aplica.</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div id="panelResultPedido">

                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div id="preloaderFooterModal" style="display:none">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden"></span>
                                    </div>
                                    Buscando Datos...
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-12">
                                <button type="submit" disabled id="btnProcesarAccessC" class="btn btn-primary btn-sm">PROCESAR
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                                    CANCELAR
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
