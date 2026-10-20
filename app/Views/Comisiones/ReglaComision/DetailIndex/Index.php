<?php
$contador=0;

foreach($detailIndex as $dt){?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $dt["marca"]?></td>
        <td><?php echo $dt["fechaCreacion"]?></td>
        <td>
            <?php $for=explode("@@",$dt["conceptos"]);
            foreach($for as $fr){
                $dat=explode("##",$fr); ?>
                <?php echo $dat[0]." - ".number_format($dat[1],0,'.',',')."%"."<br>"?>
            <?php }
            ?>
        </td>
        <td>
            <?php $for=explode("@@",$dt["categoria"]);
            foreach($for as $fr){
                $dat=explode("##",$fr); ?>
                <button class="btn btn-outline-secondary btn-sm btnCategoria" data-idcategoria="<?php echo $dat[0]?>"><?php echo $dat[1]?></button>
            <?php }
            ?>
        </td>
        <td>
            <button class="btn btn-outline-primary btn-sm"><i class="fas fa-edit"></i></button>
            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
        </td>
    </tr>
<?php }?>
