<?php foreach($detalleTaller as $dtn){?>
    <tr>
        <td><?php echo $dtn['tipoNovedad']?></td>
        <td><?php echo $dtn["comentario"]?></td>
        <td><?php echo $dtn['fechaIngreso']?></td>
        <td>
            <?php if($dtn['idestadoNovedad']==1){?>
                <button class="btn btn-outline-primary btn-sm btnOpcNovedad" data-idtipoNovedad="<?php echo $dtn["idtipoNovedad"]?>" data-vin="<?php echo $vin?>" data-idtrasladoVin="<?php echo $identradaTaller?>" data-iddetalleTaller="<?php echo $dtn['iddetalleEnvioTaller']?>"><i class="fas fa-check-circle"></i></button>
            <?php }else{?>
                Solucionado
            <?php }?>
        </td>
    </tr>
<?php }?>