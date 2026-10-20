<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Confirmacion - Llamada Bienvenida (VIN: <?php echo $vin ?>)</h5>
            <input hidden name="sessionwsp" id="sessionwsp" value="<?php echo session("idusuario") ?>">
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#tab-home"
                                        role="tab" aria-controls="tab-home" aria-selected="true">General</a></li>
                <li class="nav-item"><a class="nav-link" id="timeline-tab" data-bs-toggle="tab" href="#tab-timeline"
                                        role="tab" aria-controls="tab-timeline" aria-selected="true">Linea de Tiempo</a>
                </li>
                <li class="nav-item"><a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#tab-profile"
                                        role="tab" aria-controls="tab-profile" aria-selected="false">Llamada
                        Bienvenida</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div id="panelVinInfo">

                    </div>
                </div>
                <div class="tab-pane fade" id="tab-timeline" role="tabpanel" aria-labelledby="timeline-tab">
                    <div id="time">
                        <div class="card theme-wizard mb-5" data-theme-wizard="data-theme-wizard">
                            <div class="card-header bg-body-highlight pt-3 pb-2 border-bottom-0">
                                <ul class="nav justify-content-between nav-wizard" role="tablist">
                                    <li class="nav-item" role="presentation"><a class="nav-link active fw-semibold"
                                                                                href="#bootstrap-wizard-tab1"
                                                                                data-bs-toggle="tab"
                                                                                data-wizard-step="1"
                                                                                aria-selected="true" role="tab">
                                            <div class="text-center d-inline-block"><span
                                                        class="nav-item-circle-parent">
                                                    <span class="nav-item-circle">
                                                        <i class="fas fa-phone"></i>
                                                    </span></span><span
                                                        class="d-none d-md-block mt-1 fs-9">Bienvenida</span></div>
                                        </a></li>
                                </ul>
                            </div>
                            <div class="card-body pt-4 pb-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" role="tabpanel" aria-labelledby="bootstrap-wizard-tab1"
                                         id="bootstrap-wizard-tab1">

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">Llamada
                    Bienvenida
                    <form action="<?php echo base_url("Confirmacion/LlamadaBienvenida/SaveEditDelete/SaveLlamada") ?>"
                          id="formSave" method="POST">
                        <?php if (($infoVin[0]["telefonoCliente"] == '') || is_null($infoVin[0]["telefonoCliente"])) { ?>

                        <?php } ?>
                        <input hidden name="vinLlamada" value="<?php echo $vin ?>">
                        <div class="input-group" style="padding-bottom: 2px">
                            <div class="form-floating">
                                <select class="form-control form-control-sm" id="selectLlamada" required
                                        name="estadoLlamada"
                                        data-choices="data-choices"
                                        aria-label="Floating label select example">
                                    <option value="1">Realizada</option>
                                    <option value="2">Realizada con Observaciones</option>
                                    <option value="3">Error en Hoja de Pedido</option>
                                </select>
                                <label for="floatingSelect">Llamada de Bienvenida</label>
                            </div>
                            <div class="input-group-prepend">
                                <div class="input-group">
                                    <div class="form-floating">
                                        <input class="form-control form-control-sm" id="telefonoCliente"
                                               name="telefonoCliente"
                                               value="<?php echo $infoVin[0]["telefonoCliente"] ?>"
                                               required/>
                                        <label for="floatingSelect">Nro Telefono</label>
                                    </div>
                                    <div class="input-group-prepend">
                                        <button class="btn btn-subtle-primary me-1 mb-1" type="button" id="btnSendVeri"
                                                style="height:48px"><i class="fas fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group-append">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="fechaLlamada" name="fechaLlamada"
                                           value="<?php echo $hoy ?>"
                                           max="<?php echo $hoy ?>"
                                           required type="date"/>
                                    <label for="floatingInput">Fecha Aplica.</label>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-12">
                                <div class="form-floating">
                                    <textarea class="form-control form-control-sm" style="height: 80px" id="message">¡Buen día!☀
Señor, <?php echo $infoVin[0]['nombreCliente']?>.
Es un placer darle la bienvenida a nuestra familia Autoniza 🚗.
Queremos agradecerle por elegir nuestra marca para la adquisición de su próximo vehículo.

Nos complace informarle que su vehículo:
✅ Modelo : <?php echo $infoVin[0]['marca']." - ".$infoVin[0]['modelo']?>

✅ Año : <?php echo $infoVin[0]['anhoModelo']?>

✅ Color : <?php echo $infoVin[0]['color']?>
                                        
Se encuentra actualmente en proceso de alistamiento .

Recuerde que, ante cualquier duda o inquietud, estaré atenta para ayudarle. Mi nombre es German Torres Avalos, programadora de entregas.

¡Gracias por confiar en nosotros!</textarea>
                                    <label for="floatingSelect">Correo</label>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-12">
                                <div class="input-group" style="width: 100%">
                                    <div class="form-floating">
                                        <input class="form-control form-control-sm" type="email" id="correoCliente"
                                               name="correoCliente"
                                               value="<?php echo $infoVin[0]["correoCliente"] ?>"
                                               required/>
                                        <label for="floatingSelect">Correo</label>
                                    </div>
                                    <div class="input-group-prepend" style="width: 65%">
                                        <div class="form-floating">
                                            <input class="form-control form-control-sm" id="direccionCliente"
                                                   name="direccionCliente"
                                                   value="<?php echo $infoVin[0]["direccionCliente"] ?>"
                                                   required/>
                                            <label for="floatingSelect">Direccion</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-2">
                            <div class="col-12">
                                <table class="table table-hover table-sm table-responsive table-condensed fs-9 mb-0 border-top border-translucent">
                                    <?php foreach ($equipamientoVin as $eq) { ?>
                                        <tr>
                                            <td style="padding-left: 4px"><?php echo $eq["codigoEquipamiento"] ?></td>
                                            <td><?php echo $eq["equipamiento"] ?></td>
                                            <td>
                                                Por Instalar
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12">
                                <div class="form-floating">
                                <textarea class="form-control form-control-sm" style="height: 100px"
                                          name="comentarioLlamada"
                                          required
                                          placeholder="Ingrese Comentarios"></textarea>
                                    <label for="floatingTextarea2">Comentarios de
                                        Llamada de Bienvenida</label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="form-row">
                            <div class="col-12">
                                <button type="submit" id="btnProcesarAccess" class="btn btn-primary btn-sm">PROCESAR
                                </button>
                                <button type="button" class="btn btn-outline-danger btn-sm" data-bs-dismiss="modal">
                                    CANCELAR
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>