<!-- PUNTO 21: DATOS DEL PROPIETARIO -->
<div class="mb-3">
    <label class="form-label fw-bold">21. Datos del Propietario</label>
    <div class="row g-2">
        <div class="col-md-4">
            <select class="form-select" name="tipo_doc_prop">
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
            <input type="text" class="form-control" name="doc_prop" placeholder="Número de documento">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="apellido1_prop" placeholder="Primer Apellido">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="apellido2_prop" placeholder="Segundo Apellido">
        </div>
        <div class="col-md-4">
            <input type="text" class="form-control" name="nombres_prop" placeholder="Nombres">
        </div>
        <div class="col-md-6">
            <input type="text" class="form-control" name="direccion_prop" placeholder="Dirección">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="ciudad_prop" placeholder="Ciudad">
        </div>
        <div class="col-md-3">
            <input type="text" class="form-control" name="telefono_prop" placeholder="Teléfono">
        </div>
        <div class="col-12">
            <label class="form-label">Firma del propietario (escriba nombre completo)</label>
            <input type="text" class="form-control" name="firma_prop">
        </div>
    </div>
</div>