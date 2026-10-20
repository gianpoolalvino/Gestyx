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
    <div class="row">
        <div class="col-12">
            <h5 class="text-primary">AGENDAMIENTO DE VIN (<?php echo $viewCita[0]["vin"] ?>)</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#tab-home"
                                        role="tab" aria-controls="tab-home" aria-selected="true">Datos de
                        Agendamiento</a></li>
                <li class="nav-item"><a class="nav-link" id="cancel-tab" data-bs-toggle="tab" href="#tab-cancel"
                                        role="tab" aria-controls="tab-cancel" aria-selected="false">Cancelar
                        Agendamiento</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class="col-12">
                            <h5>- Datos de Cliente -</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <label class="form-label spanlabel">Documento</label><br>
                            <strong><?php echo $viewCita[0]["documentoCliente"] ?></strong><br>
                            <label class="form-label spanlabel"
                                   for="exampleFormControlInput">Cliente</label><br>
                            <strong><?php echo $viewCita[0]["nombreCliente"] ?></strong>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label class="form-label spanlabel"
                                   for="exampleFormControlInput">Telefono</label><br>
                            <strong><?php echo $viewCita[0]["telefonoCliente"] ?></strong><br>
                            <label class="form-label spanlabel"
                                   for="exampleFormControlInput">Correo</label><br>
                            <strong><?php echo $viewCita[0]["correoCliente"] ?></strong>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <h5>- Datos de Agendamiento -</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-sm-12">
                            <label class="form-label spanlabel">Agencia Entrega</label><br>
                            <strong><?php echo $viewCita[0]["agenciaEntrega"] ?></strong><br>
                            <label class="form-label spanlabel"
                                   for="exampleFormControlInput">Asesor</label><br>
                            <strong><?php echo $viewCita[0]["asesor"] ?></strong>
                        </div>
                        <div class="col-lg-6 col-sm-12">
                            <label class="form-label spanlabel">Fecha Entrega</label><br>
                            <strong><?php echo $viewCita[0]["fecha"] ?></strong><br>
                            <label class="form-label spanlabel"
                                   for="exampleFormControlInput">Hora Entrega</label><br>
                            <strong><?php echo $viewCita[0]["horaAgendaInicio"] . " - " . $viewCita[0]["horaAgendaFin"] ?></strong>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-outline-danger btn-sm"  data-bs-dismiss="modal">CERRAR</button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">

                </div>
                <div class="tab-pane fade" id="tab-cancel" role="tabpanel" aria-labelledby="cancel-tab">
                    <form method="POST" id="formSaveCancel" action="<?php echo base_url("Agendamiento/CalendarioCita/SaveEditDelete/SaveCancelar") ?>">
                        <input hidden name="idcitaCancel" value="<?php echo $idcita?>">
                        <input hidden name="vinCancel" value="<?php echo $vin?>">
                        <div class="row">
                            <div class="col-12">
                                <label class="spanlabel rowf">Motivo de Cancelacion</label>
                                <textarea name="sustentoCancelacion" required class="form-control form-control-sm"
                                          rows="4"></textarea>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-outline-primary btn-sm">Procesar</button>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
