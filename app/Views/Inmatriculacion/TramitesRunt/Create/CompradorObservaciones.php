


<!-- PUNTO 22: DATOS DEL COMPRADOR (TRASPASO) -->
<div class="mb-3">
    <label class="form-label fw-bold">22. Datos del Comprador (Traspaso)</label>
    <div class="row g-2">
        <div class="col-md-4">
            <select class="form-select" name="tipo_doc_comp">
                <option selected disabled>Tipo de documento</option>
                <option value="cc">C.C.</option>
                <option value="nit">NIT</option>
                <option value="pasaporte">Pasaporte</option>
                <option value="ce">C. Extranjería</option>
                <option value="ti">T. Identidad</option>
                <option value="nuip">NUIP</option>
                <option value="cd">C. Diplomático</option>
            </select>
        </div>
        <div class="col-md-8">
            <input type="text" class="form-control" name="doc_comp" placeholder="Número de documento">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="apellido1_comp" placeholder="Primer Apellido">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="apellido2_comp" placeholder="Segundo Apellido">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="nombres_comp" placeholder="Nombres">
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" name="direccion_comp" placeholder="Dirección">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="ciudad_comp" placeholder="Ciudad">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="telefono_comp" placeholder="Teléfono">
        </div>
        <div class="col-12">
            <label class="form-label">Firma del comprador (escriba nombre completo)</label>
            <input type="text" class="form-control" name="firma_comp">
        </div>
    </div>
</div>

<!-- PUNTO 23: OBSERVACIONES -->
<div class="mb-3">
    <label class="form-label fw-bold">23. Observaciones</label>
    <textarea class="form-control" name="observaciones" rows="4" placeholder="Transformaciones, aclaraciones o notas adicionales..."></textarea>
</div>