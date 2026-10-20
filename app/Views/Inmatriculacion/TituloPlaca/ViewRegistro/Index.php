<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="form-row">
        <div class="col-12">
            <h5>Proceso Vehicular - Inmatriculacion (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <div class="form-row">
        <div class="col-12">
            <ul class="nav nav-underline fs-9" id="myTab" role="tablist">
                <li class="nav-item"><a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#tab-home"
                                        role="tab" aria-controls="tab-home" aria-selected="true">General</a></li>
                <li class="nav-item"><a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#tab-profile"
                                        role="tab" aria-controls="tab-profile" aria-selected="false">Inmatriculacion /
                        Registro</a></li>
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="tab-home" role="tabpanel" aria-labelledby="home-tab">
                    <div id="panelVinInfo">

                    </div>
                </div>
                <div class="tab-pane fade" id="tab-profile" role="tabpanel" aria-labelledby="profile-tab">Eventos de Inmatriculacion<hr>

                   <div class="row">
                       <div class="col-12">

                           <?php
                           $contador=0;
                           foreach($registro as $reg){
                               $contador++;
                                $collapse='';
                               if($contador==1){
                                    $collapse='show';
                               }
                               ?>
                               <div class="row">
                                   <a data-bs-toggle="collapse" href="#datosReg<?php echo $reg["idtimeLineEvento"]?>" role="button" aria-expanded="true"
                                      aria-controls="datosReg<?php echo $reg["idtimeLineEvento"]?>">
                                       <h6 class="form-label titleLabel text-primary">>- <?php echo $reg["eventoActual"]?> -<</h6></a>
                               </div>
                               <div class="collapse multi-collapse mb-3 <?php echo $collapse?> mb-sm-0 p-3" id="datosReg<?php echo $reg["idtimeLineEvento"]?>">
                                   <div class="row">
                                       <div class="col-lg-4 col-sm-12">
                                           <label class="form-label spanlabel">Fecha Inicio</label><br>
                                           <strong><?php echo $reg["fechaInicio"] ?></strong><br>
                                           <label class="form-label spanlabel"
                                                  for="exampleFormControlInput">Hora Inicio</label><br>
                                           <strong><?php echo $reg["horaInicio"] ?></strong><br>
                                           <label class="form-label spanlabel"
                                                  for="exampleFormControlInput">Usuario Inicio</label><br>
                                           <strong><?php echo $reg["usuarioInicia"]?></strong><br>
                                       </div>
                                       <div class="col-lg-4 col-sm-12">
                                           <label class="form-label spanlabel">Fecha Fin</label><br>
                                           <strong><?php echo $reg["fechaFin"] ?></strong><br>
                                           <label class="form-label spanlabel"
                                                  for="exampleFormControlInput">Hora Fin</label><br>
                                           <strong><?php echo $reg["horaFin"] ?></strong><br>
                                           <label class="form-label spanlabel"
                                                  for="exampleFormControlInput">Usuario Finaliza</label><br>
                                           <strong><?php echo $reg["usuarioFinaliza"]?></strong><br>
                                       </div>
                                       <div class="col-lg-4 col-sm-12">
                                           <label class="form-label spanlabel">Estado</label><br>
                                           <strong><?php echo ($reg["idestadoEvento"]==1)?'Pendiente':'Finalizado' ?></strong><br>
                                           <label class="form-label spanlabel"
                                                  for="exampleFormControlInput"><?php echo $reg["eventoActual"]?></label><br>
                                           <strong><?php echo $reg["comentarios"] ?></strong><br>
                                           <?php if($reg["tachaTitulo"]==1){?>
                                           <label class="form-label spanlabel"
                                                  for="exampleFormControlInput">Titulo Tachado</label><br>
                                           <strong>Si</strong><br>
                                           <?php }?>
                                       </div>
                                   </div>
                                   <hr>
                               </div>
                           <?php }?>
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
                </div>
            </div>
        </div>
    </div>
</div>