<?php foreach($checkListPdi as $chp){?>
    <tr>
        <td style="vertical-align: middle;">
            <div class="form-check">
                <input class="form-check-input" id="flexCheckCheck<?php echo $chp["idresultadoFormularioPdi"] ?>" disabled="disabled" <?php echo (is_null($chp["idestadoResultado"]))?'':'checked'?> type="checkbox">
                <label class="form-check-label" for="flexCheckCheck<?php echo $chp["idresultadoFormularioPdi"] ?>"><?php echo (is_null($chp["idestadoResultado"]))?'Pendiente':'Finalizado'?></label>
            </div>
        </td>
        <td style="vertical-align: middle;"><?php echo $chp["descripcion"]?>
        </td>
        <td>
            <?php if(is_null($chp["rutaImagen"])){?>
                <button class="btn btn-subtle-secondary btn-sm viewCameraActive" data-idresultadoFormularioPdi="<?php echo $chp["idresultadoFormularioPdi"] ?>" data-vin="<?php echo $vin ?>" data-idprocesoPdi="<?php echo $chp["idprocesoPdi"]?>" data-idgrupoCheckListFormularioPdi="<?php echo $chp["idgrupoCheckListFormularioPdi"]?>"><i class="fas fa-camera"></i></button>
            <?php }else{?>
                <button class="btn btn-subtle-success btn-sm viewCameraActive" data-idresultadoFormularioPdi="<?php echo $chp["idresultadoFormularioPdi"] ?>" data-vin="<?php echo $vin ?>" data-idprocesoPdi="<?php echo $chp["idprocesoPdi"]?>" data-idgrupoCheckListFormularioPdi="<?php echo $chp["idgrupoCheckListFormularioPdi"]?>"><i class="fas fa-camera"></i></button>
            <?php }?>
        </td>
        <td style="vertical-align: middle;">
            <?php if(is_null($chp["idestadoResultado"])){?>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <select class="form-select form-control-sm changeEstadoPdi" id="estadoCheckPdi<?php echo $chp["idresultadoFormularioPdi"]?>"
                                data-idprocesoPdi="<?php echo $chp["idprocesoPdi"]?>"
                                data-idgrupoCheckListFormularioPdi="<?php echo $chp["idgrupoCheckListFormularioPdi"]?>"
                                data-vin="<?php echo $vin ?>"
                                data-idresultadoFormularioPdi="<?php echo $chp["idresultadoFormularioPdi"] ?>" required name="estadoCheckPdi">
                            <option value="">Seleccione un Estado</option>
                            <option value="1">CONFORME</option>
                            <option value="2">NO CONFORME</option>
                        </select>
                    </div>
                </div>
            <?php }else{?>
                <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo ($chp["idestadoResultado"]==1)?'success':'warning'?>"><?php echo ($chp["idestadoResultado"]==1)?'Conforme':'Con Obs.'?></span>
            <?php }?>
        </td>
    </tr>
<?php }?>