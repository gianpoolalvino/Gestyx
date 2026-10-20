<form id="formTramitePaso2" method="POST"
      action="<?php echo base_url("Inmatriculacion/TramitesRunt/SaveEditdelete/UpdatePaso2") ?>">
    <input hidden name="idtramite" id="idtramite" value="<?php echo $idtramite ?>">
    <div class="row pb-2">
        <div class="col-4">
            <label class="form-label fw-bold">5. Marca</label>
            <input type="text" class="form-control" name="marca" value="<?php echo $viewTramite[0]["marca"]?>" placeholder="Ejemplo: Chevrolet, Renault, etc.">
        </div>
        <div class="col-8">
            <label class="form-label fw-bold">6. Línea</label>
            <input type="text" class="form-control" name="linea" value="<?php echo $viewTramite[0]["linea"]?>" placeholder="Ejemplo: Aveo, Logan, etc.">
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-6">
            <label class="form-label fw-bold">7. Tipo de Combustible</label>
            <select class="form-select" name="combustible">
                <option selected disabled>Seleccione</option>
                <?php
                $count=0;
                foreach($tipoCombustible as $tc){
                    $count++;
                    if($viewTramite[0]["idtipoCombustible"]==$tc["idtipoCombustible"]){
                    ?>
                        <option selected value="<?php echo $tc["idtipoCombustible"]?>"><?php echo $count.". ".$tc["descripcion"]?></option>
                    <?php }else{?>
                        <option value="<?php echo $tc["idtipoCombustible"]?>"><?php echo $count.". ".$tc["descripcion"]?></option>
                    <?php }?>
                <?php }?>
            </select>
        </div>
        <div class="col-6">
            <label class="form-label fw-bold">8. Colores Predominantes (máx. 3)</label>
            <input type="text" class="form-control" name="colores" value="<?php echo $viewTramite[0]["color"]?>" placeholder="Ejemplo: Rojo, Negro, Gris">
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-4">
            <label class="form-label fw-bold">9. Modelo (Año)</label>
            <input type="number" class="form-control" name="modelo" value="<?php echo $viewTramite[0]["modelo"]?>" placeholder="Ejemplo: 2020">
        </div>
        <div class="col-4">
            <label class="form-label fw-bold">10. Cilindrada (cc)</label>
            <input type="number" class="form-control" name="cilindrada" value="<?php echo $viewTramite[0]["cilindrada"]?>" placeholder="Ejemplo: 1600">
        </div>
        <div class="col-4">
            <label class="form-label fw-bold">11. Capacidad</label>
            <input type="text" class="form-control" name="capacidad" value="<?php echo $viewTramite[0]["capacidadCargaPersona"]?>" placeholder="Kg o número de pasajeros">
        </div>
    </div>
    <!-- PUNTO 12: BLINDAJE -->
    <div class="row pb-2">
        <div class="col-6">
            <label class="form-label fw-bold">12. ¿Tiene blindaje?</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="blindaje" <?php echo ($viewTramite[0]["blindaje"]==1)?'checked':''?> id="blindajeSi" value="1">
                <label class="form-check-label" for="blindajeSi">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="blindaje" <?php echo ($viewTramite[0]["blindaje"]==2)?'checked':''?> id="blindajeNo" value="2">
                <label class="form-check-label" for="blindajeNo">No</label>
            </div>
            <div class="input-group">
                <input type="text" class="form-control mt-2" name="resolucionBlindaje" <?php echo ($viewTramite[0]["blindaje"]!=1)?'disabled':''?> placeholder="Número de resolución (si aplica)">
                <div class="input-group-prepend">
                    <input type="date" class="form-control mt-2" name="fechaBlindaje" <?php echo ($viewTramite[0]["blindaje"]!=1)?'disabled':''?> placeholder="fecha Resolucion">
                </div>
            </div>
        </div>
        <div class="col-6">
            <label class="form-label fw-bold">13. ¿Desmonte de Blindaje?</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="desmonteBlindaje" <?php echo ($viewTramite[0]["desmonteBlindaje"]==1)?'checked':''?> id="desmonteSi" value="1">
                <label class="form-check-label" for="desmonteSi">Sí</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="desmonteBlindaje" <?php echo ($viewTramite[0]["desmonteBlindaje"]==1)?'checked':''?> id="desmonteNo" value="2">
                <label class="form-check-label" for="desmonteNo">No</label>
            </div>
            <div class="input-group">
                <input type="text" class="form-control mt-2" name="resolucionDesmonte" <?php echo ($viewTramite[0]["desmonteBlindaje"]!=1)?'disabled':''?> placeholder="Número de resolución (si aplica)">
                <div class="input-group-prepend">
                    <input type="date" class="form-control mt-2" name="fechaResolucionDesmonte" <?php echo ($viewTramite[0]["desmonteBlindaje"]!=1)?'disabled':''?> placeholder="fecha Resolucion">
                </div>
            </div>
        </div>

    </div>
    <div class="row pb-2">
        <div class="col-6">
            <label class="form-label fw-bold">14. Potencia (HP)</label>
            <input type="number" class="form-control" name="potencia" value="<?php echo $viewTramite[0]["potenciaHp"]?>" placeholder="Ejemplo: 130">
        </div>
        <!-- PUNTO 15: CARROCERÍA -->
        <div class="col-6">
            <label class="form-label fw-bold">15. Carrocería</label>
            <div class="input-group">
                <select class="form-select" name="codigoCarroceria">
                    <option selected disabled>Seleccione</option>
                <?php foreach($tipoCarroceria as $tcr){?>
                    <?php if($tcr["idtipoCarroceria"]==$viewTramite[0]["idtipoCarroceria"]){?>
                        <option selected value="<?php echo $tcr["idtipoCarroceria"]?>"><?php echo $tcr["codigoCarroceria"].". ".$tcr["descripcion"]?></option>
                    <?php }else{?>
                        <option  value="<?php echo $tcr["idtipoCarroceria"]?>"><?php echo $tcr["codigoCarroceria"].". ".$tcr["descripcion"]?></option>
                        <?php }?>
                <?php }?>
                </select>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-outline-primary btn-sm" id="btnAtrasp1">Atras</button>
        <button type="submit" class="btn btn-primary btn-sm">Siguiente</button>
    </div>
</form>