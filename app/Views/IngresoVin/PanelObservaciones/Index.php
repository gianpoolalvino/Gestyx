<div class="row">
    <div class="col-12">
        <table class="table table-bordered table-hover">
            <tbody>
            <?php if(isset($detailObservacion)){?>
                    <?php foreach($detailObservacion as $dio){?>
                        <tr>
                            <td style="width: 20%;padding-left: 10px">
                                <h5 style="margin-bottom: 1px"><?php echo $dio["tipoDanho"]?><br><span style="font-size: 12px;font-weight: normal"><?php echo $dio["nivelDanho"]?></span></h5>
                                <span style="font-size: 10px"><?php echo $dio["fechaRegistro"]?></span>
                            </td>
                            <td style="text-align: right; padding-right: 8px;padding-bottom: 4px;vertical-align: bottom">
                                <?php if($dio["idestadoObservacion"]==1){?>
                                <button class="btn btn-light btn-sm btnOpcObs" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Eliminar Observacion" data-opcion="delete" data-idobs="<?php echo $dio["idobservacionIngresoVin"]?>"><i class="fas fa-trash"></i></button>
                                <button class="btn btn-light btn-sm btnOpcObs" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Editar Observacion" data-opcion="edit" data-idobs="<?php echo $dio["idobservacionIngresoVin"]?>"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-light btn-sm btnOpcObs" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Procesar Observacion" data-opcion="send" data-idobs="<?php echo $dio["idobservacionIngresoVin"]?>"><i class="fas fa-paper-plane"></i></button>
                                <?php }else{?>
                                    <button class="btn btn-light btn-sm btnOpcObs" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver Observacion" data-opcion="view" data-idobs="<?php echo $dio["idobservacionIngresoVin"]?>"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-light btn-sm btnOpcObs" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Generar PDF" data-opcion="pdf" data-idobs="<?php echo $dio["idobservacionIngresoVin"]?>"><i class="fas fa-file-pdf"></i></button>
                                <?php }?>
                            </td>
                        </tr>
                    <?php }?>
            <?php }else{?>
                <tr>
                    <td class="text-center">No tiene ninguna Observacion <i class="far fa-smile-beam"></i></td>
                </tr>
            <?php }?>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-12 text-right" style="text-align: right">
        <button class="btn btn-outline-danger btn-sm" type="button" data-bs-dismiss="modal">Cerrar</button>
        <button class="btn btn-outline-secondary btn-sm" type="button" id="btnAddObsr">Agregar Observacion</button>
    </div>
</div>