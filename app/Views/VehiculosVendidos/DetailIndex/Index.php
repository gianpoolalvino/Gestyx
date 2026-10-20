<?php
$contador=$countReg;
$color='';
foreach($detailIndex as $dt){
    if($dt["saldoPendiente"]>0){
        $color='table-danger';
    }
    $contador++;
    ?>
    <tr class="<?php echo $color?>" id="<?php echo $contador?>">
        <td class="sticky-column"><?php echo $contador?></td>
        <td class="sticky-column vin"><a href="#" class="vinAccesorios" data-opcion="Proceso" data-vin="<?php echo $dt["vin"]?>"><?php echo $dt["vin"]?></a>&nbsp;
            <a href="<?php echo base_url("VinAdministrador/Operaciones?vin=").$dt["vin"]?>"><i class="fas fa-share"></i></a></td>
        <td><?php echo $dt["fechaProximaEntrega"]?></td>
        <td class="marca"><?php echo $dt["marca"]?></td>
        <td><?php
            $parte_despues_del_guion = substr(strstr($dt["modelo"], '-'), 1);
            echo ($parte_despues_del_guion=='')?$dt["modelo"]:$parte_despues_del_guion; ?></td>
        <td><?php echo $dt["color"]?></td>
        <td><?php echo $dt["agencia"]?></td>
        <td>
            <?php if(!is_null($dt["urgente"])){?>
                <?php if($dt["urgente"]==1){?>
                    <span class="badge badge-phoenix badge-phoenix-danger">Urgente</span>
                <?php }else if($dt["urgente"]==2){?>
                    <span class="badge badge-phoenix badge-phoenix-warning">Moderado</span>
                <?php }else{?>
                    <span class="badge badge-phoenix badge-phoenix-info">Baja</span>
                <?php }?>
            <?php }else{?>
                <span class="badge badge-phoenix badge-phoenix-info">Baja</span>
            <?php }?>
        </td>
        <td><?php echo $dt["documentoCliente"]?></td>
        <td><?php echo $dt["nombreCliente"]?></td>
        <td><?php echo $dt["tipoNegocio"]?></td>
        <td>

                <a class="badge badge-phoenix badge-phoenix-info"><?php echo $dt["eventoActual"]?></a>

        </td>
        <td>
            <?php if($dt["liberadoCartera"]==2){?>
                <h5><span class="badge badge-phoenix badge-phoenix-warning">No</span></h5>
            <?php }else{?>
                <h5><span class="badge badge-phoenix badge-phoenix-success">Si</span></h5>
            <?php }?>
        </td>
        <td>
            <?php if($dt["revisionCampanha"]==1){?>
                <h5><span class="badge badge-phoenix badge-phoenix-success">Si</span></h5>
            <?php }else{?>
                <h5><span class="badge badge-phoenix badge-phoenix-warning">No</span></h5>
            <?php }?>
        </td>
        <td>
            <?php echo $dt["bodega"]?>
        </td>
        <td>
            <?php echo $dt["ubicacionActual"]?>
        </td>
        <td>
            <?php if(!is_null($dt["gps"])){?>
                    <?php if($dt["gps"]==1){?>
                        <h5><span class="badge badge-phoenix badge-phoenix-warning">No Instalado</span></h5>
                    <?php }else{?>
                        <h5><span class="badge badge-phoenix badge-phoenix-success">Instalado</span></h5>
                    <?php }?>
            <?php }else{?>
                <h5><span class="badge badge-phoenix badge-phoenix-danger">No Requiere</span></h5>
            <?php }?>
        </td>
        <td>
            <?php if(!is_null($dt["gas"])){?>
                <?php if($dt["gas"]==1){?>
                    <h5><span class="badge badge-phoenix badge-phoenix-warning">No Instalado</span></h5>
                <?php }else{?>
                    <h5><span class="badge badge-phoenix badge-phoenix-success">Instalado</span></h5>
                <?php }?>
            <?php }else{?>
                <h5><span class="badge badge-phoenix badge-phoenix-danger">No Requiere</span></h5>
            <?php }?>
        </td>
        <td><?php echo $dt["nombreVendedor"]?></td>
        <td>
            <?php echo $dt["fechaAgendado"]." ".$dt["horaAgendado"]?>
        </td>
        <td>
            <?php echo ($dt["tipoPlaca"]!='')?$dt["tipoPlaca"]:'Sin Placa'?>
        </td>
        <td>
            <?php echo $dt["placa"]?>
        </td>
        <td><?php echo $dt["fechaFactura"]?></td>
        <td>
            <?php echo $dt["numeroFactura"]?>
        </td>
        <td>
            <?php echo $dt["fechaCancelado"]?>
        </td>
        <td>
            <?php
            $estadoVin='';
            if($dt["fechaCancelado"]!=''){
                $estadoVin='<h5><span class="badge badge-phoenix badge-phoenix-success">Cancelado</span></h5>';
            }else{
                $estadoVin='<h5><span class="badge badge-phoenix badge-phoenix-danger">'.$dt["saldoPendiente"].'</span></h5>';
            }
            echo $estadoVin;
            ?>
        </td>
        <td><?php echo $dt["numeroPedido"]?></td>
        <td><?php echo $dt["fechaCompra"]?></td>
        <td><?php echo ($dt["canceladoProveedor"]==1)?'Cancelado':'Pendiente Pago'?></td>
    </tr>
    <?php
    $color='';
}?>