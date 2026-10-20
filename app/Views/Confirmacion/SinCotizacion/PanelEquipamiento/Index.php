<?php
    if($status=='success'){
?>

<?php
$codigo = [];
$descripcionLami = '';
foreach ($equipamientoActual as $eq) {
    if (stristr($eq["equipamiento"],'LAMINA')){
        $descripcionLami = $eq["equipamiento"];
    }
    $codigo[] = $eq["codigoEquipamiento"];
}

$codigoAct = [];
$descripcionLa = '';
foreach ($equipamiento as $eqss) {
    $descripcionLa = $eqss->equipamiento;
    $codigoAct[] = $eqss->codigoEquipamiento;
}

?>
<style>
    .tdAutoniza{
        font-size:12px !important
    }
</style>
<div class="alert alert-subtle-success alert-dismissible fade show" role="alert">
    <strong><i class="far fa-info-circle"></i>&nbsp;Valido</strong>&nbsp;&nbsp;El numero de pedido se encontro en el ERP.
</div>
<?php if($gps==1){?>
<span class="badge badge-phoenix badge-phoenix-danger">GPS</span>
<?php }?>
<?php if($gas==1){?>
<span class="badge badge-phoenix badge-phoenix-danger">Requiere Conversion <?php echo $modeloGas?></span>
<?php }?>
<input hidden name="gps" value="<?php echo $gps?>">
<input hidden name="gas" value="<?php echo $gas?>">
        <?php
            if(!empty($equipamiento)){
        ?>
<table class="table table-sm table-hover table-bordered tdAutoniza">
    <thead>
    <tr>
        <th>Cant.</th>
        <th>Codigo</th>
        <th>Equipamiento</th>
        <th>Accion</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($equipamiento as $eqs) {
        if (in_array($eqs->codigoEquipamiento, $codigo)) {
            ?>
            <?php if (stristr($eqs->equipamiento,'LAMINA')){ ?>
                <?php if($eqs->equipamiento!=$descripcionLami){?>
                    <tr>
                        <td>
                            <input hidden name="codigoEquipamiento[]" value="<?php echo $eqs->codigoEquipamiento?>">
                            <input hidden name="equipamiento[]" value="<?php echo $eqs->equipamiento?>">
                            <input hidden name="cantidad[]" value="<?php echo $eqs->cantidad?>">
                            <input hidden name="idtipoEquipamiento[]" value="<?php echo $eqs->idtipoEquipamiento?>">
                            <input hidden name="idestadoEquipamiento[]" value="<?php echo $eqs->idestadoEquipamiento?>">
                            <input hidden name="accionEquipamiento[]" value="Update">
                            <input hidden name="precioTotal[]" value="<?php echo $eqs->precioTotal?>">
                            <input hidden name="subTotal[]" value="<?php echo $eqs->subTotal?>">
                            <input hidden name="igv[]" value="<?php echo $eqs->igv?>">
                            <input hidden name="tipoFacturacionEquipamiento[]" value="<?php echo $eqs->tipoFacturacionEquipamiento?>">
                            <?php echo $eqs->cantidad ?></td>
                        <td><?php echo $eqs->codigoEquipamiento ?></td>
                        <td><?php echo $eqs->equipamiento?></td>
                        <td><i class="fa-sharp fa-solid fa-upload text-primary"></i>&nbsp;Actualizar</td>
                    </tr>
                <?php }else{?>
                    <tr>
                        <td>
                            <input hidden name="codigoEquipamiento[]" value="<?php echo $eqs->codigoEquipamiento?>">
                            <input hidden name="equipamiento[]" value="<?php echo $eqs->equipamiento?>">
                            <input hidden name="cantidad[]" value="<?php echo $eqs->cantidad?>">
                            <input hidden name="idtipoEquipamiento[]" value="<?php echo $eqs->idtipoEquipamiento?>">
                            <input hidden name="idestadoEquipamiento[]" value="<?php echo $eqs->idestadoEquipamiento?>">
                            <input hidden name="accionEquipamiento[]" value="SinAccion">
                            <input hidden name="precioTotal[]">
                            <input hidden name="subTotal[]">
                            <input hidden name="igv[]">
                            <input hidden name="tipoFacturacionEquipamiento[]">
                            <?php echo $eqs->cantidad ?></td>
                        <td><?php echo $eqs->codigoEquipamiento ?></td>
                        <td><?php echo $eqs->equipamiento ?></td>
                        <td><i class="fa-sharp fa-solid fa-equals text-success"></i>&nbsp;Sin accion</td>
                    </tr>
                <?php }?>
            <?php }else{?>
                <tr>
                    <td>
                        <input hidden name="codigoEquipamiento[]" value="<?php echo $eqs->codigoEquipamiento?>">
                        <input hidden name="equipamiento[]" value="<?php echo $eqs->equipamiento?>">
                        <input hidden name="cantidad[]" value="<?php echo $eqs->cantidad?>">
                        <input hidden name="idtipoEquipamiento[]" value="<?php echo $eqs->idtipoEquipamiento?>">
                        <input hidden name="idestadoEquipamiento[]" value="<?php echo $eqs->idestadoEquipamiento?>">
                        <input hidden name="accionEquipamiento[]" value="SinAccion">
                        <input hidden name="precioTotal[]">
                        <input hidden name="subTotal[]">
                        <input hidden name="igv[]">
                        <input hidden name="tipoFacturacionEquipamiento[]">
                        <?php echo $eqs->cantidad ?></td>
                    <td><?php echo $eqs->codigoEquipamiento ?></td>
                    <td><?php echo $eqs->equipamiento ?></td>
                    <td><i class="fa-sharp fa-solid fa-equals text-success"></i>&nbsp;Sin accion</td>
                </tr>
            <?php }?>
        <?php } ?>
    <?php } ?>
    <?php foreach ($equipamiento as $eqs) {
        if (!in_array($eqs->codigoEquipamiento, $codigo)) {
            ?>
            <tr>
                <td>
                    <input hidden name="codigoEquipamiento[]" value="<?php echo $eqs->codigoEquipamiento?>">
                    <input hidden name="equipamiento[]" value="<?php echo $eqs->equipamiento?>">
                    <input hidden name="cantidad[]" value="<?php echo $eqs->cantidad?>">
                    <input hidden name="idtipoEquipamiento[]" value="<?php echo $eqs->idtipoEquipamiento?>">
                    <input hidden name="idestadoEquipamiento[]" value="<?php echo $eqs->idestadoEquipamiento?>">
                    <input hidden name="accionEquipamiento[]" value="Add">
                    <input hidden name="precioTotal[]" value="<?php echo $eqs->precioTotal?>">
                    <input hidden name="subTotal[]" value="<?php echo $eqs->subTotal?>">
                    <input hidden name="igv[]" value="<?php echo $eqs->igv?>">
                    <input hidden name="tipoFacturacionEquipamiento[]" value="<?php echo $eqs->tipoFacturacionEquipamiento?>">
                    <?php echo $eqs->cantidad ?></td>
                <td><?php echo $eqs->codigoEquipamiento ?></td>
                <td><?php echo $eqs->equipamiento ?></td>
                <td><i class="fa-solid fa-plus text-success"></i>&nbsp;Agregar</td>
            </tr>
        <?php } ?>
    <?php } ?>
    <?php foreach ($equipamientoActual as $eqsv2) {
        if (!in_array($eqsv2["codigoEquipamiento"], $codigoAct)) {
            ?>
            <tr>
                <td>
                    <input hidden name="codigoEquipamiento[]" value="<?php echo $eqs->codigoEquipamiento?>">
                    <input hidden name="equipamiento[]" value="<?php echo $eqs->equipamiento?>">
                    <input hidden name="cantidad[]" value="<?php echo $eqs->cantidad?>">
                    <input hidden name="idtipoEquipamiento[]" value="<?php echo $eqs->idtipoEquipamiento?>">
                    <input hidden name="idestadoEquipamiento[]" value="<?php echo $eqs->idestadoEquipamiento?>">
                    <input hidden name="accionEquipamiento[]" value="Delete">
                    <input hidden name="precioTotal[]" value="<?php echo $eqs->precioTotal?>">
                    <input hidden name="subTotal[]" value="<?php echo $eqs->subTotal?>">
                    <input hidden name="igv[]" value="<?php echo $eqs->igv?>">
                    <input hidden name="tipoFacturacionEquipamiento[]" value="<?php echo $eqs->tipoFacturacionEquipamiento?>">
                    <?php echo $eqsv2["cantidad"] ?></td>
                <td><?php echo $eqsv2["codigoEquipamiento"]?></td>
                <td><?php echo $eqsv2["equipamiento"]?></td>
                <td><i class="fa-sharp fa-regular fa-minus text-danger"></i>&nbsp;Eliminar</td>
            </tr>
        <?php } ?>
    <?php } ?>
    </tbody>
</table>
<?php }?>
<?php }else{?>
        <div class="alert alert-subtle-<?php echo $status?> alert-dismissible fade show" role="alert">
            <strong><i class="far fa-info-circle"></i>&nbsp;<?php echo $title?></strong>&nbsp;&nbsp;<?php echo $message?>
            <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
<?php }?>
