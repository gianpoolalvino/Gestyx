<div class="form-row">
    <div class="col-12">
        Eventos Realizados<br>
        <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo ($vinInfo[0]["cotizacion"]==1)?'success':'secondary'?>"><span class="badge-label"><?php echo ($vinInfo[0]["cotizacion"]==1)?'<i class="far fa-check-circle"></i>':'<i class="far fa-times-circle"></i>'?>&nbsp;Sin Cotizacion</span><span
                    class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>
        <?php foreach ($badgeEvento as $be) { ?>
            <span class="badge badge-phoenix fs-10 badge-phoenix-<?php echo ($be["idestadoEvento"]==1)?'secondary':'success'?>"><span class="badge-label"><?php echo ($be["idestadoEvento"]==2)?'<i class="far fa-check-circle"></i>':'<i class="far fa-times-circle"></i>'?>&nbsp;<?php echo $be["eventoActual"]?></span><span
                        class="ms-1" data-feather="check" style="height:12.8px;width:12.8px;"></span></span>
        <?php } ?>
    </div>
</div>
<div class="form-row">
    <div class="col-12">
        Retornar al Evento<br>
        <select class="form-control form-control-sm" required name="ideventoRetorno">
            <option value="">Selecciones Evento</option>
            <option value="27">Sin Cotizacion</option>
            <?php foreach($selectEvento as $se){?>
                <?php if($se["idestadoEvento"]!=1){?>
                    <option value="<?php echo $se["ideventoActual"]?>"><?php echo $se["eventoActual"]?></option>
                <?php }?>
            <?php }?>
        </select>
    </div>
</div><br>
