<div class="row pb-2">
    <div class="col-6">
        <span>Chasis</span><br>
        <strong><?php echo $vinView[0]["vin"]?></strong>
    </div>
</div>
<div class="row pb-2">
    <div class="col-6">
        <span>Modelo</span><br>
        <strong><?php echo $vinView[0]["familia"]?></strong><br>
        <span>Color</span><br>
        <strong><?php echo $vinView[0]["color"]?></strong><br>
        <span>Marca</span><br>
        <strong><?php echo $vinView[0]["marca"]?></strong>
    </div>
    <div class="col-6">
        <span>Bodega</span><br>
        <strong><?php echo $vinView[0]["bodega"]?></strong><br>
        <span>Agencia</span><br>
        <strong><?php echo ($vinView[0]["agencia"]!='')?$vinView[0]["agencia"]:'No Tiene'?></strong><br>
        <span>Ubicacion</span><br>
        <strong><?php echo $vinView[0]["ubicacion"]?></strong>
    </div>
</div>