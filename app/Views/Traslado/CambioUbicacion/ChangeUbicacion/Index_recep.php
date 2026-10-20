<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Traslado Vehicular - Ubicacion (VIN: <?php echo $vin ?>
                ) <?php echo (is_null($idtrasladoVin)) ? '' : ' - Recepcion' ?></h5>
        </div>
    </div>
    <hr>
    <?php if(!empty($trasladoDatos)){?>
        <?php if($trasladoDatos[0]['idtipoTraslado']==5){?>
            <div class="alert alert-subtle-warning alert-dismissible fade show" role="alert">
                <strong>Recepcion a Taller</strong> Vin enviado a taller con novedades esta recepcion no permite novedades adicionales
            </div>
        <?php }else if($trasladoDatos[0]["idtipoTraslado"]==6){?>
            <div class="alert alert-subtle-warning alert-dismissible fade show" role="alert">
                <strong>Recepcion de Solicitante</strong> Vin: <?php echo $vin?> enviado a solicitante.
            </div>
        <?php }?>
    <?php }?>
    <?php if (is_null($idtrasladoVin)){ ?>
    <form id="formSaveUbi" method="POST"
          action="<?php echo base_url("Traslado/CambioUbicacion/SaveEditDelete/SaveUbicacion") ?>">
        <?php }else{ ?>
        <form id="formSaveUbi" method="POST"
              action="<?php echo base_url("Traslado/CambioUbicacion/SaveEditDelete/SaveRecepcionUbicacion") ?>">
            <input hidden id="idtipoTraslado" name="idtipoTraslado" value="<?php echo $trasladoDatos[0]['idtipoTraslado']?>">
            <input hidden name="identradaTaller" value="<?php echo $vinGeneral[0]['identradaTaller']?>">
            <input hidden name="retornoTaller" value="<?php echo $vinGeneral[0]['retornoDeTaller']?>">
            <input hidden name="envioSolicitante" value="<?php echo $vinGeneral[0]['envioSolicitante']?>">
            <input hidden name="idsolitiudVin" value="<?php echo $vinGeneral[0]['idsolicitudVin']?>">
            <?php } ?>
            <input hidden name="vinUbicacion" id="vinUbicacion" value="<?php echo $vin ?>">
            <input hidden name="idtrasladoVin" id="idtrasladoVin" value="<?php echo $idtrasladoVin ?>">
            <div class="row">
                <div class="col-12">
                    <h6>Ubicacion Fisica y Box Anteriores</h6>
                </div>
            </div>
            <div class="row" style="padding-bottom: 8px">
                <div class="col-6">
                    <div class="form-floating">
                        <input hidden name="idgrupoUbicacionActual" value="<?php echo $idgrupoUbicacion ?>">
                        <select class="form-select" id="ubicacionAnterior" name="ubicacionAnterior"
                                aria-label="Floating label select example">
                            <option selected
                                    value="<?php echo $vinInfo[0]["idubicacionAnterior"] ?>"><?php echo $vinInfo[0]["ubicacionAnterior"] ?></option>
                        </select>
                        <label for="floatingSelect">Ubicacion Anterior</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating">
                        <select class="form-select" id="boxAnterior" name="boxAnterior"
                                aria-label="Floating label select example">
                            <option selected
                                    value="<?php echo $vinInfo[0]["idboxUbicacionAnterior"] ?>"><?php echo $vinInfo[0]["boxAnterior"] ?></option>
                        </select>
                        <label for="floatingSelect">Box Anterior</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <h6>Ubicacion Fisica y Box Ingreso</h6>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <div class="form-floating">
                        <select class="form-select" required id="ubicacionNueva" name="ubicacionNueva"
                                aria-label="Floating label select example">
                            <?php if (!is_null($idgrupoUbicacion)) { ?>
                                <?php foreach ($ubicacion as $ubi) { ?>
                                    <?php if ($idgrupoUbicacion == $ubi["idgrupoUbicacion"]) { ?>
                                        <?php if ($vinInfo[0]["idubicacionActual"] == $ubi["idubicacion"]) { ?>
                                            <option selected
                                                    value="<?php echo $ubi["idubicacion"] ?>"><?php echo $ubi["descripcion"] ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $ubi["idubicacion"] ?>"><?php echo $ubi["descripcion"] ?></option>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?>
                                <option selected
                                        value="<?php echo $vinInfo[0]["idubicacionActual"] ?>"><?php echo $vinInfo[0]["ubicacionActual"] ?></option>
                            <?php } ?>
                        </select>
                        <label for="floatingSelect">Ubicacion Nueva</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-floating">
                        <select class="form-select" id="boxNuevo" required name="boxNuevo"
                                aria-label="Floating label select example">
                            <option selected
                                    value="<?php echo $vinInfo[0]["idboxUbicacionActual"] ?>"><?php echo $vinInfo[0]["boxActual"] ?></option>
                        </select>
                        <label for="floatingSelect">Box Nuevo</label>
                    </div>
                </div>
            </div>
            <hr>
            <?php if($vinGeneral[0]['retornoDeTaller']==1){?>
                <?php if(!empty($detalleTaller)){?>
                    <div class="row pb-2">
                        <div class="col-12">
                            <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                                <tbody id="tbodyNoveda">
                                    <?php foreach($detalleTaller as $dtn){?>
                                        <tr>
                                            <td><?php echo $dtn['tipoNovedad']?></td>
                                            <td><?php echo $dtn["comentario"]?></td>
                                            <td><?php echo $dtn['fechaIngreso']?></td>
                                            <td>
                                                <?php if($dtn['idestadoNovedad']==1){?>
                                                <button class="btn btn-outline-primary btn-sm btnOpcNovedadTr" data-idtipoNovedad="<?php echo $dtn["idtipoNovedad"]?>" data-vin="<?php echo $vin?>" data-idtrasladoVin="<?php echo $vinGeneral[0]['identradaTaller']?>" data-iddetalleTaller="<?php echo $dtn['iddetalleEnvioTaller']?>"><i class="fas fa-check-circle"></i></button>
                                                <?php }else{?>
                                                    Solucionado
                                                <?php }?>
                                            </td>
                                        </tr>
                                    <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php }?>
            <?php }?>
            <?php if (!is_null($idtrasladoVin)) { ?>
                <div class="row pb-2">
                    <div class="col-12">
                        <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                            <tbody id="tbodyObs">
                            <?php
                            $contador = 0;
                            foreach ($detalleRecepcion as $dt) {
                                $contador++;
                                ?>
                                <tr style="vertical-align: middle">
                                    <td style="width: 10%" class="ps-2"><?php echo $contador ?></td>
                                    <td style="width: 20%" class="ps-2">
                                        <img style="width: 100%" src="<?php echo base_url($dt["rutaImagen"]) ?>">
                                    </td>
                                    <td style="width: 60%" class="ps-2"><?php echo $dt["descripcion"] ?></td>
                                    <td style="width: 10%" class="ps-2 pe-2">
                                        <button class="btn btn-danger btn-sm btpDelObs"
                                                data-iddetalleRecepion="<?php echo $dt["iddetalleRecepcionVin"] ?>"><i
                                                    class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>

                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12" style="text-align: right">
                        <button class="btn btn-outline-primary btn-sm" type="button" id="btnaddobs">Agregar
                            Observacion
                        </button>
                    </div>
                </div>
                <hr>
            <?php } ?>
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-primary btn-sm" type="submit">Procesar</button>
                    <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </form>
</div>