<!-- PUNTO 11: CAPACIDAD -->
<input hidden name="idtramite" id="idtramite" value="<?php echo $idtramite?>">

<!-- PUNTO 16: IDENTIFICACIÓN INTERNA DEL VEHÍCULO -->
<div class="mb-3">
    <label class="form-label fw-bold">16. Identificación Interna del Vehículo</label>
    <input type="text" class="form-control mb-2" name="numero_motor" placeholder="Número de motor">
    <input type="text" class="form-control mb-2" name="numero_chasis" placeholder="Número de chasis">
    <input type="text" class="form-control mb-2" name="numero_serie" placeholder="Número de serie">
    <input type="text" class="form-control mb-2" name="numero_vin" placeholder="Número VIN">
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="regrabado_motor" id="regrabado_motor">
        <label class="form-check-label" for="regrabado_motor">Motor Regrabado</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="regrabado_chasis" id="regrabado_chasis">
        <label class="form-check-label" for="regrabado_chasis">Chasis Regrabado</label>
    </div>
</div>

<!-- PUNTO 17: IMPORTACIÓN O REMATE -->
<div class="mb-3">
    <label class="form-label fw-bold">17. Importación o Remate</label>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="documento_importacion" id="manifiesto" value="manifiesto">
        <label class="form-check-label" for="manifiesto">Manifiesto o Acta</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="documento_importacion" id="declaracion" value="declaracion">
        <label class="form-check-label" for="declaracion">Declaración de Importación</label>
    </div>
    <input type="text" class="form-control mt-2" name="entidad_remate" placeholder="Entidad (si es remate)">
    <input type="text" class="form-control mt-2" name="ciudad_documento" placeholder="Ciudad donde se hizo el documento">
    <input type="text" class="form-control mt-2" placeholder="Código de Aduana (lo llena la oficina de tránsito)" disabled>
</div>

<!-- PUNTO 18: TIPO DE SERVICIO -->
<div class="mb-3">
    <label class="form-label fw-bold">18. Tipo de Servicio</label>
    <select class="form-select" name="tipo_servicio">
        <option selected disabled>Seleccione</option>
        <option value="particular">Particular</option>
        <option value="publico">Público</option>
        <option value="diplomatico">Diplomático</option>
        <option value="oficial">Oficial</option>
        <option value="especial">Especial</option>
        <option value="otros">Otros</option>
    </select>
</div>

<!-- PUNTO 19: EMPRESA VINCULADORA -->
<div class="mb-3">
    <label class="form-label fw-bold">19. Empresa Vinculadora</label>
    <input type="text" class="form-control mb-2" name="nombre_empresa" placeholder="Nombre de la empresa">
    <input type="text" class="form-control" name="nit_empresa" placeholder="NIT de la empresa">
</div>

<!-- PUNTO 20: DATOS DE ALERTA -->
<div class="mb-3">
    <label class="form-label fw-bold">20. Datos de Alerta</label>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="alerta" id="hurto" value="hurto">
        <label class="form-check-label" for="hurto">Hurto</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="alerta" id="limitacion" value="limitacion">
        <label class="form-check-label" for="limitacion">Limitación de Propiedad</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="alerta" id="embargo" value="embargo">
        <label class="form-check-label" for="embargo">Embargo</label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="checkbox" name="alerta" id="otro_alerta" value="otro">
        <label class="form-check-label" for="otro_alerta">Otro</label>
    </div>
    <input type="text" class="form-control mt-2" name="detalle_alerta" placeholder="A favor de (persona o entidad)">
</div>
<div class="mb-3">
    <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
    <button type="button" class="btn btn-outline-primary btn-sm" id="btnAtrasp2">Atras</button>
    <button type="submit" class="btn btn-primary btn-sm">Siguiente</button>
</div>
