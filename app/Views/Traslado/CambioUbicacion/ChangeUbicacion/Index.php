<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
$tokenUnico=bin2hex(random_bytes(32));
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Traslado Vehicular - Ubicacion (VIN: <?php echo $vin ?>) <?php echo (is_null($idtrasladoVin))?'':' - Recepcion'?></h5>
        </div>
    </div><hr>
    <?php if($vinGeneral[0]['enTaller']==1){?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-subtle-warning alert-dismissible fade show" role="alert">
                    <strong>En Taller <?php echo $vinInfo[0]["ubicacionActual"] ?></strong> El vin se encuentra en Taller.
                </div>
            </div>
        </div>
    <?php }?>

    <?php if(is_null($idtrasladoVin)){?>
    <form id="formSaveUbi" method="POST"
          action="<?php echo base_url("Traslado/CambioUbicacion/SaveEditDelete/SaveUbicacion") ?>">
        <input hidden name="tokenSend" value="<?php echo $tokenUnico?>" id="tokenSend">
        <?php }else{?>
        <form id="formSaveUbi" method="POST"
              action="<?php echo base_url("Traslado/CambioUbicacion/SaveEditDelete/SaveRecepcionUbicacion") ?>">
        <?php }?>
        <input hidden name="vinUbicacion" id="vinUbicacion" value="<?php echo $vin?>">
        <input hidden name="idtrasladoVin" id="idtrasladoVin" value="<?php echo $idtrasladoVin?>">
        <div class="row">
            <div class="col-12">
                <h6>Ubicacion Fisica y Box Actuales</h6>
            </div>
        </div>
        <div class="row" style="padding-bottom: 8px">
            <div class="col-6">
                <div class="form-floating">
                    <input hidden name="idgrupoUbicacionActual" value="<?php echo $idgrupoUbicacion?>">
                    <select class="form-select" id="ubicacionAnterior" name="ubicacionAnterior" aria-label="Floating label select example">
                        <option selected
                                value="<?php echo $vinInfo[0]["idubicacionActual"] ?>"><?php echo $vinInfo[0]["ubicacionActual"] ?></option>
                    </select>
                    <label for="floatingSelect">Ubicacion Anterior</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select" id="boxAnterior" name="boxAnterior" aria-label="Floating label select example">
                        <option selected
                                value="<?php echo $vinInfo[0]["idboxUbicacionActual"] ?>"><?php echo $vinInfo[0]["boxActual"] ?></option>
                    </select>
                    <label for="floatingSelect">Box Anterior</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h6>Ubicacion Fisica y Box Nuevos</h6>
            </div>
        </div>
            <div class="row pb-2">
                <div class="col-12">
                    <div class="form-floating">
                        <select class="form-select"  id="transportista" name="transportista" aria-label="Floating label select example">
                            <option selected="">Seleccione Transportista</option>
                            <?php foreach ($selectTransporte as $trs) { ?>
                                <option value="<?php echo $trs["idtransportista"] ?>"><?php echo $trs["razonSocial"] ?></option>
                            <?php } ?>
                        </select>
                        <label for="floatingSelect">Transportista</label>
                    </div>
                </div>
            </div>
            <div class="row pb-2">
                <div class="col-8">
                    <div class="form-floating">
                        <input class="form-control" id="conductor" name="conductor" aria-label="Floating label select example">
                        <label for="floatingSelect">Conductor</label>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-floating">
                        <input class="form-control" id="placaVehiculo" name="placaVehiculo" aria-label="Floating label select example">
                        <label for="floatingSelect">Placa</label>
                    </div>
                </div>
            </div>
        <div class="row pb-2">
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select" required id="ubicacionNueva" name="ubicacionNueva" aria-label="Floating label select example">
                        <option selected="">Seleccione Ubicacion</option>
                        <?php foreach ($ubicacion as $ubi) { ?>
                            <?php if($idgrupoUbicacion==$ubi["idgrupoUbicacion"]){?>
                                <option value="<?php echo $ubi["idubicacion"] ?>"><?php echo $ubi["descripcion"] ?></option>
                            <?php }?>
                        <?php } ?>
                    </select>
                    <label for="floatingSelect">Ubicacion Nueva</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select" id="boxNuevo" name="boxNuevo" aria-label="Floating label select example">
                        <option selected
                                value="">Seleccione Box</option>
                    </select>
                    <label for="floatingSelect">Box Nuevo</label>
                </div>
            </div>
        </div>
            <div class="row pb-2">
                <div class="col-12">
                    <div class="form-floating">
                        <input class="form-control" id="otros" name="otros" aria-label="Floating label select example">
                        <label for="floatingSelect">Otros</label>
                    </div>
                </div>
            </div>
        <hr>
        <?php if(!is_null($idtrasladoVin)){?>
        <div class="row pb-2">
            <div class="col-12">
                <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                    <tbody  id="tbodyObs">
                    <?php
                    $contador=0;
                    foreach($detalleRecepcion as $dt){
                        $contador++;
                        ?>
                        <tr style="vertical-align: middle">
                            <td style="width: 10%" class="ps-2"><?php echo $contador?></td>
                            <td style="width: 20%" class="ps-2">
                                <img style="width: 100%" src="<?php echo base_url($dt["rutaImagen"])?>">
                            </td>
                            <td style="width: 60%" class="ps-2"><?php echo $dt["descripcion"]?></td>
                            <td style="width: 10%" class="ps-2 pe-2">
                                <button class="btn btn-danger btn-sm btpDelObs" data-iddetalleRecepion="<?php echo $dt["iddetalleRecepcionVin"]?>"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>

                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12" style="text-align: right">
                <button class="btn btn-outline-primary btn-sm" type="button" id="btnaddobs">Agregar Novedades</button>
            </div>
        </div>
        <hr>
        <?php }else if(is_null($idtrasladoVin)){?>
            <div class="row pb-2">
                <div class="col-12">
                    <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                        <tbody id="tbodyObsSend">

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-12" style="text-align: right">
                    <button class="btn btn-outline-primary btn-sm" type="button" id="btnaddobsSend">Agregar Novedades</button>
                </div>
            </div>
            <hr>
        <?php }?>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>