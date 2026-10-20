<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Traslado Vehicular - Agencia (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <hr>
    <?php
    $bloqueado='';
        if($vinInfo[0]["idregionAnteriorBodega"]==null){
            $bloqueado='disabled';
        }else{
            if($vinInfo[0]["idregionAnteriorBodega"]==$vinInfo[0]["idregionActualBodega"]){
                $bloqueado='disabled';
            }else{
                $bloqueado='';
            }
        }
    ?>
    <form id="formSaveUbi" method="POST"
          action="<?php echo base_url("Traslado/CambioAgencia/SaveEditDelete/SaveAgencia") ?>">
        <input hidden name="vinAgencia" value="<?php echo $vin?>">
        <div class="row">
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select" id="agenciaAnterior" name="agenciaAnterior" aria-label="Floating label select example">
                        <option selected
                                value="<?php echo $vinInfo[0]["codigoAgencia"] ?>"><?php echo $vinInfo[0]["agenciaActual"] ?></option>
                    </select>
                    <label for="floatingSelect">Agencia Anterior</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select" required id="agenciaNueva" name="agenciaNueva" aria-label="Floating label select example">
                        <option selected="">Seleccione Agencia</option>
                        <?php foreach ($agencia as $age) { ?>
                            <option value="<?php echo $age["codigoAgencia"] ?>"><?php echo $age["descripcion"] ?></option>
                        <?php } ?>
                    </select>
                    <label for="floatingSelect">Agencia Nueva</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm"  type="submit">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>