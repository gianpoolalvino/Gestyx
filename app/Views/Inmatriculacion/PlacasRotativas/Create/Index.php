<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Generar Nueva Placa Rotativa</h5>
        </div>
    </div>
    <form method="POST" id="formStoragePlaca" action="<?php echo base_url('Inmatriculacion/PlacasRotativas/SaveEditDelete/SavePlaca') ?>">
    <div class="row" style="padding-bottom: 4px">
        <div class="col-4">
            <div class="input-group-append">
                <div class="form-floating">
                    <input class="form-control" id="placaRotativa" name="placaRotativa"
                           required type="text" autocomplete="off"/>
                    <label for="floatingInput">Placa</label>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="input-group-append">
                <div class="form-floating">
                    <input class="form-control" id="fechaInicio" name="fechaInicio"
                           required type="date" autocomplete="off"/>
                    <label for="floatingInput">Fecha Registro</label>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="input-group-append">
                <div class="form-floating">
                    <input class="form-control" id="fechaVencimiento" name="fechaVencimiento"
                           required type="date" autocomplete="off"/>
                    <label for="floatingInput">Fecha Vencimiento</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="padding-bottom: 4px">
        <div class="col-12">
            <div class="input-group-append">
                <div class="form-floating">
                    <select class="form-select" id="empresa" name="empresa">
                        <option value="" selected>Seleccione Empresa</option>
                        <?php foreach($empresa as $emp){?>
                            <option value="<?php echo $emp["idempresa"]?>"><?php echo $emp["descripcion"]?></option>
                        <?php }?>
                    </select>
                    <label for="floatingInput">Empresa</label>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="input-group-append">
                <div class="form-floating">
                    <select class="form-select" id="region" name="region">
                    </select>
                    <label for="floatingInput">Region</label>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-12">
            <button class="btn btn-primary btn-sm">Procesar</button>
            <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                Cerrar
            </button>
        </div>
    </div>
    </form>
</div>