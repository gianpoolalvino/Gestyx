<div class="offcanvas-header">
    <h5 id="offcanvasRightLabel"></h5><button class="btn-close text-reset" type="button" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</div>
<div class="offcanvas-body">
    <div class="row">
        <div class="col-6 col-md-6">
            <h5 class="text-primary">Campañas Activas</h5>
        </div>
        <div class="col-6 col-md-6" style="text-align: right">
            <button class="btn btn-outline-primary btn-sm" id="btnCreateCampanha">Nueva Campaña</button>
        </div>
    </div><hr>
    <div class="row">
        <div class="col-12">
            <table class="table table-sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Cantidad Vins</th>
                    <th scope="col">Opc.</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    $contador=0;
                    foreach($detailCampanha as $dc){
                        $contador++;
                        ?>
                        <tr>
                            <td><?php echo $contador?></td>
                            <td><?php echo $dc["nombre"]?></td>
                            <td></td>
                            <td>
                                <button class="btn btn-outline-primary btn-sm"><i class="fas fa-upload"></i></button>
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>