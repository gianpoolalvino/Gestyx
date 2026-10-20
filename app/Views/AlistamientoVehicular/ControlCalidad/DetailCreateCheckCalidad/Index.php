<?php
$contado2 = 0;
foreach ($detalleCalidad as $ccls) {
    $contado2++;
    ?>
    <table class="table fs-9 mb-0 border-top border-translucent table-hover">
        <thead>
        <tr>
            <th scope="col">Marcar</th>
            <th scope="col">Check List</th>
            <th scope="col">Opc</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if($ccls["detalleCalidad"]!=''){
        $subq = explode("@@", $ccls["detalleCalidad"]);
        $conter = 0;
        foreach ($subq as $ssb) {
            $conter++;
            $ssbci = explode("##", $ssb);
            ?>
            <tr>
                <td>
                    <input hidden name="estadoRevisado[]"
                           value="<?php echo $ssbci[3] ?>">
                    <input hidden name="idDetCheckCalidad[]" value="<?php echo $ssbci[2] ?>">
                    <div class="form-check">
                        <input class="form-check-input"
                               id="flexCheckChecked<?php echo $ssbci[0] ?>"
                               disabled <?php echo ($ssbci[3] != 3) ? 'checked' : '' ?>
                               type="checkbox"/>
                        <label class="form-check-label"
                               for="flexCheckChecked<?php echo $ssbci[0] ?>"><?php echo ($ssbci[3] != 3) ? 'Realizado' : 'Pendiente' ?></label>
                    </div>
                </td>
                <td><?php echo $ssbci[4] ?><br>
                    <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo $ssbci[6]?>"><span class="badge-label"><?php echo $ssbci[5]?></span><span class="ms-1" data-feather="package" style="height:12.8px;width:12.8px;"></span></span>
                </td>
                <td>
                    <?php if ($ssbci[3] == 3 || $ssbci[3]==5) { ?>
                        <button class="btn btn-subtle-primary btn-sm btn btnEditProceso"
                                data-vin="<?php echo $vin ?>"
                                data-iddetalleCheck="<?php echo $ssbci[2] ?>">
                            <i class="far fa-paperclip"></i>
                        </button>
                    <?php } ?>
                </td>
            </tr>
        <?php } } ?>
        </tbody>
    </table><br>
<?php } ?>
<?php if($tipoProceso==2){?>
<button class="btn btn-outline-primary btn-sm btnAddCalidad" data-vin="<?php echo $vin ?>" data-idgrupoCalidad="<?php echo $idgrupoCheckCalidad?>"><i class="fas fa-check"></i>&nbsp;Agregar Campo</button><br><br>
<?php }?>
