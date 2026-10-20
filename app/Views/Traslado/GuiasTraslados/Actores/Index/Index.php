<div class="modal-body" style="border: 0.5px solid #a2a2a2;border-radius: 5px">
    <div class="row pb-2">
        <div class="col-12">
            <strong class="text-primary">Actores</strong>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item" role="presentation"><a class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                                            href="#tab-home" role="tab" aria-controls="tab-home"
                                                            aria-selected="true">Destinatario</a></li>
                <li class="nav-item" style="display:none" role="presentation"><a class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                            href="#tab-profile" role="tab" aria-controls="tab-profile"
                                                            aria-selected="false" tabindex="-1">Proveedor</a></li>
                <li class="nav-item" style="display:none" role="presentation"><a class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                                            href="#tab-contact" role="tab" aria-controls="tab-contact"
                                                            aria-selected="false" tabindex="-1">Comprador</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade active show" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row pb-2">
                        <div class="col-12">
                            <strong>¿El Destinatario es el mismo Remitente?</strong><br>
                            <div class="form-check">
                                <input class="form-check-input checkDestinata" id="checkDestinatario1" type="radio"
                                       value="1"
                                       name="flexRadioDefault" <?php echo ($guiaRem[0]["idtipoDestinatario"] == 1) ? 'checked' : '' ?> />
                                <label class="form-check-label" for="checkDestinatario1">Si</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input checkDestinata" id="checkDestinatario2" type="radio"
                                       value="2"
                                       name="flexRadioDefault" <?php echo ($guiaRem[0]["idtipoDestinatario"] == 2) ? 'checked' : '' ?> />
                                <label class="form-check-label" for="checkDestinatario2">No</label>
                            </div>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-12">
                            <strong>Destinatario</strong>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-12">
                            <table class="table table-bordered table-sm" id="tableDestinatario">
                                <tr>
                                    <td class="ps-3">
                                        <input hidden name="documentoDestinatario"
                                               value="<?php echo $guiaRem[0]["rucDestinatario"] ?>">
                                        <input hidden name="nombreDestinatario"
                                               value="<?php echo $guiaRem[0]["razonSocialDestinatario"] ?>">
                                        <?php echo $guiaRem[0]["rucDestinatario"] ?></td>
                                    <td class="ps-3"><?php echo $guiaRem[0]["razonSocialDestinatario"] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row pb-2">
                        <div class="col-12">

                            <button class="btn btn-primary btn-sm" <?php echo ($guiaRem[0]["idtipoDestinatario"] == 1) ? 'disabled' : (($guiaRem[0]["rucDestinatario"]!='')?'disabled':'') ?>
                                    id="btnAddDest" type="button">Agregar Destinatario
                            </button>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">Food truck
                    fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore
                    velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft
                    beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco
                    ad vinyl cillum PBR. Homo nostrud organic.
                </div>
                <div class="tab-pane fade" id="tab-contact" role="tabpanel" aria-labelledby="contact-tab">Etsy mixtape
                    wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack
                    lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone
                    skateboard locavore carles etsy salvia banksy hoodie helvetica. DIY synth PBR banksy irony. Leggings
                    gentrify squid 8-bit cred pitchfork.
                </div>
            </div>
        </div>
    </div>
    <div class="row pb-2">
        <div class="col-12">
            <button class="btn btn-light btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
        </div>
    </div>
</div>