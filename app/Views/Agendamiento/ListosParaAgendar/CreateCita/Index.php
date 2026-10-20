<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h6>Agendar Cita para Vin (<?php echo $vin ?>)</h6>
        </div>
    </div>
    <hr>
    <form method="POST" id="formSave" action="<?php echo base_url("Agendamiento/CalendarioCita/SaveEditDelete/SaveAgenda") ?>">
        <div class="row" style="padding-bottom: 8px">
            <input hidden name="vinAgendado" value="<?php echo $vin ?>">
            <div class="col-12">
                <div class="input-group">
                    <div class="form-floating">
                        <select class="form-select" id="idagencias" name="agenciaAgenda"
                                aria-label="Seleccione un Asesor de Entrega">
                            <option selected="">Seleccione una Agencia</option>
                            <?php foreach ($agencia as $ag) { ?>
                                <option value="<?php echo $ag["idagencia"] ?>"><?php echo $ag["descripcion"] ?></option>
                            <?php } ?>
                        </select>
                        <label for="idagencias">Agencias de Entrega</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="input-group" style="width: 100%">
                    <div class="input-group-prepend" style="width: 60%">
                        <div class="input-group" style="width: 100% !important">
                            <div class="form-floating" style="width:60% !important">
                                <select class="form-select" disabled id="asesores" required name="idasesorAgenda"
                                        aria-label="Asesor de Entregas">
                                </select>
                                <label for="asesores">Seleccione un Asesor de Entrega</label>
                            </div>
                            <div class="input-group-append" style="width: 40% !important">
                                <div class="form-floating">
                                    <input class="form-control is-valid" id="fechaCita" type="date" name="fechaAgenda"
                                           min="<?php echo $hoy ?>" placeholder="<?php echo $hoy ?>"
                                           value="<?php echo $hoy ?>"/>
                                    <label for="fechaCita">Fecha Agenda</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group-append" style="width: 40%">
                        <div class="input-group" style="width: 100% !important">
                            <div class="form-floating" style="width: 50% !important">
                                <select class="form-select" disabled id="horaInicio" name="horaAgendaInicio"
                                        aria-label="Hora Inicial">
                                </select>
                                <label for="horaInicio">Hora Inicial</label>
                            </div>
                            <div class="input-group-append" style="width: 50% !important">
                                <div class="form-floating">
                                    <select class="form-select" disabled id="horaFin" name="horaAgendaFin"
                                            aria-label="Hora Final">
                                    </select>
                                    <label for="horaFin">Hora Final</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <h6>- Opciones de Placa -</h6>
            </div>
        </div>
        <?php if ($VinInfo[0]["idtipoPlaca"] != 2) { ?>
            <div class="row">
                <div class="col-12">
                    <input hidden name="checkTipoPlaca" required id="checkTipoPlaca">
                    <div class="input-group">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkTipoPlaca" disabled data-idcheck="1"
                                   id="flexRadioDefault1" type="radio" name="idtipoPlaca"/>
                            <label class="form-check-label" for="flexRadioDefault1">Utilizar Placa Rotativa para
                                Entrega</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input checkTipoPlaca" disabled data-idcheck="4"
                                   id="flexRadioDefault2" type="radio" name="idtipoPlaca"/>
                            <label class="form-check-label" for="flexRadioDefault2">Realizar entrega sin Placa</label>
                        </div>
                        <div class="input-group-append">
                            <div id="placaRota" style="display:none">
                                <select class="form-control form-control-sm" id="placaAgendaRotativa" name="placa">
                                    <option value="">Seleccione Placa Rotativa</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div><br>
        <?php } else { ?>
            <div class="row">
                <div class="col-12">
                    <label class="form-label spanlabel">Tipo de
                        Placa: </label><br><strong><?php echo "Permanente" ?></strong><br>
                    <label class="form-label spanlabel">Placa: </label><br><strong><?php echo $VinInfo[0]["placa"] ?></strong><br>
                </div>
            </div>
            <input hidden name="checkTipoPlaca" required id="checkTipoPlaca" value="2">
            <input hidden name="placa" required value="<?php echo $VinInfo[0]["placa"] ?>">
        <?php } ?>
        <div class="row">
            <div class="col-12">
                <h6>Comentarios de Entrega</h6>
                <textarea class="form-control form-control-sm" required rows="5" name="comentarioEntrega"
                          placeholder="Ingrese Comentarios..."></textarea>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm" type="submit" id="procesarCita">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal" type="button">Cancelar</button>
            </div>
        </div>
    </form>
</div>