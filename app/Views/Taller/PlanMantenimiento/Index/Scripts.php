<script>
    $(document).on('click', '#btnCreatePlan', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/CreateViewEdit/Create")?>",
            data: {},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    });


    $(document).on('click', '#btnViewPlan', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idmarca = $("#selectMarca").val();
        var idmodelo = $("#selectModelo").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/CreateViewEdit/ViewPlanFamilia")?>",
            data: {idmarca:idmarca,idmodelo:idmodelo},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    });

    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndex();
    });

    function DetailIndex()
    {
        var idmarca = $("#selectMarca").val();
        var idmodelo = $("#selectModelo").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/Index/DetailIndex")?>",
            data: {idmarca:idmarca,idmodelo:idmodelo},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tableAccess").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }


    $("#selectMarca").change(function(){
        var idmarca = $("#selectMarca").val();

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/CreateViewEdit/SelectModelo")?>",
            data: {idmarca:idmarca},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#selectModelo").html(dato.selectModelo);
            },
            error: function(xhr) {

            }
        });
    });
</script>
<script>

    $(document).on('click', '.btnSaveHora', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idplanMantenimiento = $(this).attr("data-idplanMantenimiento");
        var horaPlan=$("#inputHora"+idplanMantenimiento).val();
        var costoManoObra= $("#costoManoObraPlan").val();
        $.ajax({
            type: 'POST',
            // dataType:'json',
            url: '<?php echo base_url("Taller/PlanMantenimiento/SaveEditDelete/StorageHoraPlanMantenimiento")?>',
            data: {
                horaPlan:horaPlan,
                costoManoObra:costoManoObra,
                idplanMantenimiento:idplanMantenimiento,
            },
            beforeSend: function () {
                //    OpenPreloader("Buscando Datos...");
                //  $("#loading").fadeIn();
            },
            success: function (data) {
                //ClosePreloader();
                DetailIndex();
                let dato = $.parseJSON(data);
                $("#alertSocket").html('<div class="alert alert-success" role="alert">'+dato.message+'</div>');
                //   Alerts(dato.title,dato.message,dato.status);
                //  $("#tablePlanes").html(data);
            },
            error: function (xhr) {

                title = "Error de Sistema";
                message = "El Sistema detecto un error de carga comuniquese con Sistemas";
                status = "warning";
                Notificacion(status,title,message);
            }
        });
    });

    $(document).on('click', '.opcionRepuesto', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var iddetallePlanMantenimientoFamilia = $(this).attr("data-iddetallePlanMantenimientoFamilia");
        var idplanMantenimientoFamilia = $(this).attr("data-idplanMantenimientoFamilia");
        var idplanMantenimiento = $(this).attr("data-idplanMantenimiento");
        var opcion = $(this).attr("data-opcion");
        $.ajax({
            type: 'POST',
            // dataType:'json',
            url: '<?php echo base_url("Taller/PlanMantenimiento/SaveEditDelete/StoragePlanMantenimiento")?>',
            data: {
                iddetallePlanMantenimientoFamilia:iddetallePlanMantenimientoFamilia,
                idplanMantenimientoFamilia:idplanMantenimientoFamilia,
                idplanMantenimiento:idplanMantenimiento,
                opcion:opcion
            },
            beforeSend: function () {
                //    OpenPreloader("Buscando Datos...");
                //  $("#loading").fadeIn();
            },
            success: function (data) {
                //ClosePreloader();
                DetailIndex();
                let dato = $.parseJSON(data);
                if(opcion=="add"){
                    $("#alertSocket").html('<div class="alert alert-success" role="alert">'+dato.message+'</div>');
                }else{
                    $("#alertSocket").html('<div class="alert alert-danger" role="alert">'+dato.message+'</div>');
                }
                //   Alerts(dato.title,dato.message,dato.status);
                //  $("#tablePlanes").html(data);
            },
            error: function (xhr) {

                title = "Error de Sistema";
                message = "El Sistema detecto un error de carga comuniquese con Sistemas";
                status = "warning";
                Notificacion(status,title,message);
            }
        });
    });
</script>