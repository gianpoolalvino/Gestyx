<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<style>
    .select2-container--default .select2-selection--single {
        height: 33px; /* Ajusta la altura como necesites */
        line-height: 33px; /* Centra el texto verticalmente */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
    }
    .select2-dropdown {
        z-index: 9999999 !important; /* Asegúrate de que tenga un valor mayor que el del modal */
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 33px;
        padding-top: 14px;
        font-size: 14px;
        padding-left: 15px;
    }
    .select2-container--default .select2-selection--single {
        height: 47px;
        line-height: 52px;
    }
</style>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h6>Nueva Grupo de Reglas</h6>
        </div>
    </div>
    <hr>
    <form id="formGrupoRegla" method="POST"
          action="<?php echo base_url("ConfigOperaciones/ReglasVehiculo/SaveEditDelete/SaveGrupoRegla") ?>">
        <div class="row" style="padding-bottom: 8px">
            <div class="col-12">
                <div class="form-floating">
                    <input class="form-control form-control-sm" required id="descripcionGrupo" name="descripcionGrupo"
                            aria-label="Floating label select example">
                    <label for="floatingSelect">Descripcion Regla</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 8px">
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-select" id="tipoAplica" required name="tipoAplica"
                            aria-label="Floating label select example">
                        <option value="">Proceso al que Aplica</option>
                        <?php foreach($selectAfecta as $cr){?>
                            <option value="<?php echo $cr["idtipoAplicaGrupoRegla"]?>"><?php echo $cr["descripcion"]?></option>
                        <?php }?>
                    </select>
                    <label for="floatingSelect">Proceso al que Aplica</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>