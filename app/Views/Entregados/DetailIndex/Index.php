<?php
$contador=$countReg;
foreach($detailIndex as $dit){
    $contador++;
    ?>
    <tr>
        <td><?php echo $contador?></td>
        <td><?php echo $dit["vin"]?></td>
        <td><?php echo $dit["marca"]?></td>
        <td><?php echo $dit["familia"]?></td>
        <td><?php echo $dit["color"]?></td>
        <td><?php echo $dit["agencia"]?></td>
        <td><?php echo $dit["vendedor"] ?></td>
        <td><?php echo $dit["nombreAsesor"]?></td>
        <td><?php echo $dit["numeroFactura"]?></td>
        <td><?php echo $dit["fechaFacturaLabel"]; ?></td>
        <td><?php echo $dit["fechaCanceladoLabel"]; ?></td>
        <td><?php echo $dit["fechaEntregaLabel"]; ?></td>
        <td>
            <?php
            $days='';
            if($dit["fechaCancelado"]!=''){
                $fechaFact=date("Y-m-d",strtotime($dit["fechaFactura"]));
                $fechaEnt=date("Y-m-d",strtotime($dit["fechaEntrega"]));
                $fecha1=date_create($fechaEnt);
                $fecha2=date_create($fechaFact);
                $diff=date_diff($fecha2,$fecha1);
                $days=str_replace('+','',$diff->format('%R%a'));
            }else{
                $fechaFact=date("Y-m-d",strtotime($dit["fechaCancelado"]));
                $fechaEnt=date("Y-m-d",strtotime($dit["fechaEntrega"]));
                $fecha1=date_create($fechaEnt);
                $fecha2=date_create($fechaFact);
                $diff=date_diff($fecha2,$fecha1);
                $days=str_replace('+','',$diff->format('%R%a'));
            }
            ?>
            <?php echo $days." Dias"?>
        </td>
        <td><?php echo $dit["documentoCliente"]?></td>
        <td><?php echo $dit["placa"]?></td>
        <td><?php echo $dit["nombreCliente"]?></td>
        <td><?php echo $dit["direccionCliente"]?></td>
        <td><?php echo $dit["correoCliente"]?></td>
        <td><?php echo $dit["telefonoCliente"]?></td>
        <td><?php echo $dit["tipoNegocio"]?></td>
        <td><?php echo $dit["numeroPedido"]?></td>
    </tr>
<?php }?>