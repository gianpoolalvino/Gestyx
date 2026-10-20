<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Nueva Condicion - <?php echo $viewRegla[0]["nombreCampo"] ?></h5>
        </div>
    </div>
    <hr>
    <form id="formCondicional" method="POST"
          action="<?php echo base_url("ConfigOperaciones/ReglasVehiculo/SaveEditDelete/SaveCondicional") ?>">
        <input hidden name="idreglaEntregaCond" value="<?php echo $idreglaVehiculo?>">
        <div class="row pb-2" style="padding-bottom: 8px">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-select" id="operadorRegla" required name="operadorRegla"
                            aria-label="Floating label select example">
                        <option value="">Condicion</option>
                        <?php foreach ($selectCondicones as $sl) { ?>
                            <option value="<?php echo $sl["sentenciaSql"] ?>"><?php echo $sl["descripcion"] ?></option>
                        <?php } ?>
                    </select>
                    <label for="floatingSelect">Operador</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <input class="form-control form-control-sm" autocomplete="off" required name="condicionRegla"
                           id="condicionRegla">
                    <label for="floatingSelect">Condicion</label>
                </div>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <div class="form-floating">
                    <input class="form-control form-control-sm" type="number" autocomplete="off" name="diasRegla"
                           id="diasRegla">
                    <label for="floatingSelect">Tiempo de Condicion</label>
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