<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <form id="formSendVinExhi" action="<?php echo base_url("Exhibicion/Enviar/SaveEditDelete/SaveSend") ?>"
          method="POST">
        <div class="row">
            <div class="col-12">
                <h5>Envio Exhibicion - (VIN: <?php echo $vin ?>)</h5>
            </div>
        </div><br>
        <div class="row" style="padding-bottom: 4px">
            <h6>Datos de Solicitud</h6>
        </div>
        <div class="row" style="padding-bottom: 4px">
            <div class="col-8">
                <label>Solicitante</label><br>
                <strong><?php echo $viewExhibicion[0]["solicitante"]?></strong>
            </div>
            <div class="col-4">
                <label>Agencia Solicitante</label><br>
                <strong><?php echo $viewExhibicion[0]["agencia"]?></strong>
            </div>
        </div>
        <div class="row" style="padding-bottom: 4px">
            <div class="col-4">
                <label>Estado Pedido</label><br>
                <strong><?php echo ($viewExhibicion[0]["idestadoExhibicion"]==2)?'Pendiente Envio':''?></strong>
            </div>
            <div class="col-4">
                <label>Fecha Estimada Envio</label><br>
                <strong><?php echo $viewExhibicion[0]["fechaEstimadaEnvioExhibicion"]?></strong>
            </div>
            <div class="col-4">
                <label>Fecha Estimada Retorno</label><br>
                <strong><?php echo $viewExhibicion[0]["fechaEstimadaRetornoExhibicion"]?></strong>
            </div>
        </div>
        <?php
            if(!empty($equipamiento)){
        ?>
        <div class="row" style="padding-bottom: 4px">
            <div class="col-12">
                <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cant.</th>
                            <th>Codigo</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyEquipamientoExhibicion">
                        <?php
                        $contador=0;
                        foreach($equipamiento as $dt){
                            $contador++;
                            ?>
                            <tr>
                                <td style="padding-left: 8px"><?php echo $contador?></td>
                                <td style="padding-left: 8px"><?php echo $dt["cantidad"]?></td>
                                <td style="padding-left: 8px"><?php echo $dt["codigoEquipamiento"]?></td>
                                <td style="padding-left: 8px"><?php echo $dt["equipamiento"]?></td>
                                <td style="padding-left: 8px">
                                    <?php
                                    if($dt['idestadoEquipamiento']==2){
                                        echo "Instalado";
                                    }else if($dt['idestadoEquipamiento']==2){
                                        echo "Sin Instalar";
                                    }else{
                                        echo "Pendiente Instalar";
                                    }?>
                                </td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php }?><hr>
        <div class="row" style="padding-bottom: 4px">
            <h6>Datos de Envio</h6>
        </div>
        <input hidden name="idexhibicionVin" value="<?php echo $idexhibicionVin?>">
        <input hidden name="vin" value="<?php echo $vin?>">
        <div class="row" style="padding-bottom: 4px">
            <div class="col-4" style="padding-right: 2px">
                <div class="form-floating">
                <input class="form-control form-control-sm"
                          name="fechaEnvio"
                          type="date"
                       value="<?php echo $hoy?>"
                       max="<?php echo $hoy?>"
                          required
                          data-choices="data-choices"
                          aria-label="Floating label select example">
                    <label for="floatingSelect">Fecha Envio</label>
                </div>
            </div>
            <div class="col-8" style="padding-left: 2px">
                <div class="form-floating">
                    <input class="form-control form-control-sm"
                           disabled
                           data-choices="data-choices"
                           value="<?php echo session("nombres")?>"
                           aria-label="Floating label select example">
                    <label for="floatingSelect">Usuario</label>
                </div>
            </div>
        </div>
        <div class="row" style="padding-bottom: 4px">
            <div class="col-12">
                <div class="form-floating">
                <textarea class="form-control form-control-sm"
                          name="comentarioEnvio"
                          data-choices="data-choices"
                          style="height: 100px"
                          aria-label="Floating label select example"></textarea>
                    <label for="floatingSelect">Comentarios Envio</label>
                </div>
            </div>
        </div>
        <div class="form-row" style="padding-bottom: 4px">
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