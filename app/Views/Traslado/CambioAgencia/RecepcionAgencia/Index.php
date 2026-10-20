<?php
date_default_timezone_set("America/Lima");
$hoy = date("Y-m-d");
?>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <h5>Recepcion Vehicular - Agencia (VIN: <?php echo $vin ?>)</h5>
        </div>
    </div>
    <hr>
    <?php
    $bloqueado='';
    if($vinInfo[0]["idregionAnteriorBodega"]==null){
        $bloqueado='disabled';
    }else{
        if($vinInfo[0]["idregionAnteriorBodega"]==$vinInfo[0]["idregionActualBodega"]){
            $bloqueado='disabled';
        }else{
            $bloqueado='';
        }
    }
    ?>
    <form id="formSaveRecep" method="POST"
          action="<?php echo base_url("Traslado/CambioAgencia/SaveEditDelete/SaveRecepcion") ?>">
        <input hidden name="vinRecep" id="vinRecep" value="<?php echo $vin?>">
        <input hidden name="idtrasladoVin" id="idtrasladoVinRecep" value="<?php echo $vinInfo[0]["idtrasladoVin"]?>">
        <div class="row pb-2">
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select" id="agenciaAnterior" name="agenciaAnterior" aria-label="Floating label select example">
                        <option selected
                                value="<?php echo $vinInfo[0]["codigoAgenciaOrigen"] ?>"><?php echo $vinInfo[0]["agenciaOrigen"] ?></option>
                    </select>
                    <label for="floatingSelect">Agencia Anterior</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select" required id="agenciaNueva" name="agenciaNueva" aria-label="Floating label select example">
                            <option selected value="<?php echo $vinInfo[0]["codigoAgenciaDestino"] ?>"><?php echo $vinInfo[0]["agenciaDestino"] ?></option>
                    </select>
                    <label for="floatingSelect">Agencia Nueva</label>
                </div>
            </div>
        </div>
        <hr>
        <div class="row pb-2">
            <div class="col-12">
                <table class="table fs-9 mb-0 border-top border-translucent table-hover">
                    <tbody  id="tbodyObs">
                    <?php
                    $contador=0;
                    foreach($detalleRecepcion as $dt){
                        $contador++;
                        ?>
                        <tr style="vertical-align: middle">
                            <td style="width: 10%" class="ps-2"><?php echo $contador?></td>
                            <td style="width: 20%" class="ps-2">
                                <img style="width: 100%" src="<?php echo base_url($dt["rutaImagen"])?>">
                            </td>
                            <td style="width: 60%" class="ps-2"><?php echo $dt["descripcion"]?></td>
                            <td style="width: 10%" class="ps-2 pe-2">
                                <button class="btn btn-danger btn-sm btpDelObs" data-iddetalleRecepion="<?php echo $dt["iddetalleRecepcionVin"]?>"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    <?php }?>
                    </tbody>

                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12" style="text-align: right">
                <button class="btn btn-outline-primary btn-sm" type="button" id="btnaddobs">Agregar Observacion</button>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <button class="btn btn-primary btn-sm"  type="submit">Procesar</button>
                <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </form>
</div>