<?php
$contador=0;
foreach($detailTransporte as $dt){
    $contador++;
    ?>
    <tr style="vertical-align: middle">
        <td><?=$contador?></td>
        <td><?=$dt["documento"]?></td>
        <td><?=$dt["razonSocial"]?></td>
        <td>
            <button class="btn btn-sm btn-outline-danger btnOpcTrans" data-idtransportista="<?php echo $dt["idtransportista"]?>"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>