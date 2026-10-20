<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<style>
    .fontCheck {
        font-size: 13px
    }
</style>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Solucionar Novedad</h5>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <h5>Detalles de Novedad</h5>
            <strong style="font-size: 14px"><?php echo $viewNovedad[0]['tipoNovedad'] ?></strong>
        </div>
    </div>
    <?php if ($idtipoNovedad == 1) { ?>
        <div class="row" style="padding-bottom: 8px">
            <div class="col-12">
                <strong class="fontCheck">Area Daño: </strong><span
                        class="fontCheck"><?php echo $viewNovedad[0]['areaDanho'] ?></span><br>
                <strong class="fontCheck">Sub Area Daño: </strong><span
                        class="fontCheck"><?php echo $viewNovedad[0]['subAreaDanho'] ?></span><br>
                <strong class="fontCheck">Nivel Daño: </strong><span
                        class="fontCheck"><?php echo $viewNovedad[0]['nivelDanho'] ?></span><br>
                <strong class="fontCheck">Tipo Daño: </strong><span
                        class="fontCheck"><?php echo $viewNovedad[0]['tipoDanho'] ?></span><br>
                <strong class="fontCheck">Reparacion: </strong><span
                        class="fontCheck"><?php echo $viewNovedad[0]['reparacion'] ?></span><br>
                <strong class="fontCheck">Fecha Registro: </strong><span
                        class="fontCheck"><?php echo $viewNovedad[0]['fechaRegistro'] ?></span><br>
                <strong class="fontCheck">Comentarios: </strong><span
                        class="fontCheck"><?php echo $viewNovedad[0]['comentarios'] ?></span><br>
            </div>
        </div>
    <?php } else if ($idtipoNovedad == 2) { ?>
        <div class="row" style="padding-bottom: 8px">
            <div class="col-12">
                <strong class="fontCheck">Descripcion: </strong><span
                        class="fontCheck"><?php echo $viewNovedad[0]['descripcion'] ?></span><br>
                <strong class="fontCheck">Detalles: </strong><span
                        class="fontCheck"><?php echo $viewNovedad[0]['detalles'] ?></span><br>
                <strong class="fontCheck">Fecha Novedad: </strong><span
                        class="fontCheck"><?php echo $viewNovedad[0]['fechaObservacion'] ?></span><br>
            </div>
        </div>
    <?php } else { ?>
        <div class="row" style="padding-bottom: 8px">
            <div class="col-12">
                <strong class="fontCheck">Descripcion: </strong><span
                        class="fontCheck"><?php echo $viewNovedad[0]['descripcion'] ?></span><br>
                <strong class="fontCheck">Comentario: </strong><span
                        class="fontCheck"><?php echo $viewNovedad[0]['comentarios'] ?></span><br>
                <strong class="fontCheck">Fecha Novedad: </strong><span
                        class="fontCheck"><?php echo $viewNovedad[0]['fecha'] ?></span><br>
            </div>
        </div>
    <?php } ?>
    <hr>
    <form method="POST" id="formCheckForm" action="<?php echo base_url('SolicitudVin/VinSolicitud/SaveEditDelete/StorageCheckNovedad') ?>">
        <input hidden name="idtipoNovedad" id="idtipoNovedad" value="<?php echo $idtipoNovedad?>">
        <input hidden name="idnovedad" value="<?php echo $idnovedad?>">
        <input hidden name="idcabeceraNovedad" value="<?php echo $idcabeceraNovedad?>">
        <input hidden name="vin" value="<?php echo $vin?>">
        <div class="row" style="padding-bottom: 4px">
            <div class="col-12">
                <div class="form-floating">
                <textarea class="form-control form-control-sm" id="comentarioText" name="comentarioText"
                          style="height: 140px"></textarea>
                    <label for="floatingSelect">Comentario Novedad</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 8px">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-select" id="estadoNovedad" name="estadoNovedad"
                            aria-label="Floating label select example">
                        <option selected
                                value="3">Solucionada
                        </option>
                    </select>
                    <label for="floatingSelect">Estado Novedad</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>
