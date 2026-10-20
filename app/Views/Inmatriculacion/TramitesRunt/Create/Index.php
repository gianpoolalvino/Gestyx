<!-- Datos del Vehículo -->
<style>
    .nav-wizard .nav-item {
        position: relative;
    }

    .nav-wizard .nav-item::before {
        content: "";
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 2px;
        background-color: #ccc;
        z-index: -1;
    }
</style>
<div class="modal-body">
    <!-- Timeline -->
    <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
        <div class="card-header bg-body-highlight pt-3 pb-2 border-bottom-0">
            <ul class="nav justify-content-between nav-wizard">
                <li class="nav-item"><a class="nav-link active fw-semibold" href="#bootstrap-wizard-tab1" data-bs-toggle="tab" data-wizard-step="1">
                        <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-lock"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Tramite</span></div>
                    </a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#bootstrap-wizard-tab2" data-bs-toggle="tab" data-wizard-step="2">
                        <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-car"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Caracteristicas</span></div>
                    </a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#bootstrap-wizard-tab3" data-bs-toggle="tab" data-wizard-step="3">
                        <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-cog"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Mecanica</span></div>
                    </a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#bootstrap-wizard-tab4" data-bs-toggle="tab" data-wizard-step="4">
                        <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-user"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Propietario</span></div>
                    </a></li>
                <li class="nav-item"><a class="nav-link fw-semibold" href="#bootstrap-wizard-tab5" data-bs-toggle="tab" data-wizard-step="5">
                        <div class="text-center d-inline-block"><span class="nav-item-circle-parent"><span class="nav-item-circle"><span class="fas fa-user"></span></span></span><span class="d-none d-md-block mt-1 fs-9">Comprador</span></div>
                    </a></li>
            </ul>
        </div>
    </div>
    <div id="panelFormulario">
        <form id="formTramitePaso1" method="POST" action="<?php echo base_url("Inmatriculacion/TramitesRunt/SaveEditdelete/UpdatePaso1")?>">
            <input hidden name="idtramite" id="idtramite" value="<?php echo $idtramite?>">
            <div class="row pb-2">
            <div class="col-4">
                <label class="form-label fw-bold">1. Tipo Vehiculo Tramite</label>
                <select class="form-select form-control-sm" name="tipoVehiculoTramite">
                    <option selected disabled>Seleccione tipo vehiculo</option>
                    <option value="1">1. Nuevo</option>
                    <option value="2">2. Semi Nuevo</option>
                </select>
            </div>
            <div class="col-5">
                <label class="form-label fw-bold">2. Organismo de Tránsito</label>
                <input type="text" class="form-control" name="organismoTramite" disabled placeholder="Ejemplo: SIM Bogotá">
            </div>
            <div class="col-3">
                <label class="form-label fw-bold">3. Placa</label>
                <input type="text" class="form-control" name="placa" placeholder="Ejemplo: ABC123">
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <label class="form-label fw-bold">4. Trámite Solicitado</label>
                <select class="form-select" name="idtipoTramite">
                    <?php
                    $cont=0;
                    foreach($tipoTramite as $tt){
                        $cont++;
                        ?>
                        <option value="<?php echo $tt["idtipoTramite"]?>"><?php echo $cont.". ".$tt["descripcion"]?></option>
                    <?php }?>
                </select>
                <small class="text-muted">Usa Ctrl (o Cmd en Mac) para seleccionar varios trámites si es necesario.</small>
            </div>
        </div>
        <div class="row pb-2">
            <div class="col-12">
                <label class="form-label fw-bold">5. Clase de Vehículo</label>
                <select class="form-select" name="claseVehiculo" required>
                    <option selected disabled>Seleccione una clase</option>
                    <?php
                    $count=0;
                    foreach($tipoVehiculo as $tv){
                        $count++;
                        ?>
                        <option value="<?php echo $tv["idtipoVehiculo"]?>"><?php echo $count.". ".$tv["descripcion"]?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="mb-3">
            <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary btn-sm">Siguiente</button>
        </div>
        </form>
    </div>
</div>