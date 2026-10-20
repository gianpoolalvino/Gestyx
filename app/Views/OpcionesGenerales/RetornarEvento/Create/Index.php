<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<style>
    .rowf {
        margin-bottom: 4px !important
    }
    .titleLabel {
        font-size: 12px
    }
    .spanlabel {
        padding-left: 0px
    }
</style>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Retornar Evento Anterior</h5>
        </div>
        <br>
    </div>
    <div class="form-row">
        <div class="col-12">
            <div class="alert alert-subtle-warning" role="alert">
                <strong>Advertencia</strong>&nbsp;Solo puede retornar Eventos principales (Inmatriculacion, Confirmacion de Saldo o Campañas), este proceso no incluye los vehiculos liberados con entrega anticipada o Urgente.
            </div>
        </div>
    </div>
    <form id="formRetorno" action="<?php echo base_url("OpcionesGenerales/ProcesarRetornoEvento") ?>" method="POST">
        <div class="form-row">
            <div class="col-12">
                <div class="input-group">
                    <div class="form-floating mb-3">
                        <input class="form-control" id="vinRetorno" name="vinRetorno" required/>
                        <label for="floatingInput">Verificar Vin</label>
                    </div>
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary btn-sm" id="btnCheckVin" style="height: 48px;"><i
                                    class="far fa-check-circle"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="panelEventos">

        </div>
        <div class="form-row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" id="btnProcesarRetorno" disabled>PROCESAR</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </form>
</div>