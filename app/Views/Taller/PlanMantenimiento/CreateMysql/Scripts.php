<script>
    $(document).on('click', '#btnProcesarCl', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idplanMantenimientoFamilia = $("#idplanMantenimientoFamProcess").val();
        DeleteMasivoPlan(idplanMantenimientoFamilia);
        $("#btnProcesarCl").prop("disabled",true);
        $("#btnCloseMd").prop("disabled",true);

    });

    function DeleteMasivoPlan(idplanMantenimientoFamilia)
    {
        $("#panelPrincipal").css("display","none");
        $("#panelErrorCarga").css("display","none");
        $("#panelProcesoCarga").css("display","block");
        $("#spanPreloader").html("Eliminando los Planes Anteriores 1/5");

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/SaveEditDelete/DeletePlanFamiliaMasivo")?>",
            data: {idplanMantenimientoFamilia:idplanMantenimientoFamilia},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    $("#panelErrorCarga").css("display","none");
                    $("#panelPrincipal").css("display","none");
                    $("#panelProcesoCarga").css("display","block");
                    $("#spanPreloader").html(dato.message);
                    UpdatePlanFam(idplanMantenimientoFamilia);
                }else{
                    $("#panelPrincipal").css("display","none");
                    $("#panelErrorCarga").css("display","block");
                    $("#panelProcesoCarga").css("display","none");
                    $("#titleError").html(dato.title);
                    $("#spanError").html(dato.message);
                    $("#btnProcesarCl").prop("disabled",false);
                    $("#btnCloseMd").prop("disabled",false);
                }
            },
            error: function(xhr) {
            }
        });
    }

    function UpdatePlanFam(idplanMantenimientoFamilia)
    {
        $("#panelPrincipal").css("display","none");
        $("#panelErrorCarga").css("display","none");
        $("#panelProcesoCarga").css("display","block");
        $("#spanPreloader").html("Actualizando el Plan General 2/5");
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/SaveEditDelete/UpdatePlanGeneralSql")?>",
            data: {idplanMantenimientoFamilia:idplanMantenimientoFamilia},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    $("#panelErrorCarga").css("display","none");
                    $("#panelPrincipal").css("display","none");
                    $("#panelProcesoCarga").css("display","block");
                    $("#spanPreloader").html(dato.message);
                    StorageDetallePlanMtoFam(idplanMantenimientoFamilia);
                }else{
                    $("#panelPrincipal").css("display","none");
                    $("#panelErrorCarga").css("display","block");
                    $("#panelProcesoCarga").css("display","none");
                    $("#titleError").html(dato.title);
                    $("#spanError").html(dato.message);
                    $("#btnProcesarCl").prop("disabled",false);
                    $("#btnCloseMd").prop("disabled",false);
                }
            },
            error: function(xhr) {
            }
        });
    }

    function StorageDetallePlanMtoFam(idplanMantenimientoFamilia)
    {
        $("#panelPrincipal").css("display","none");
        $("#panelErrorCarga").css("display","none");
        $("#panelProcesoCarga").css("display","block");
        $("#spanPreloader").html("Insertando Repuesto a Plan General 3/5");
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/SaveEditDelete/StorageDetallePlanMtoGeneralSql")?>",
            data: {idplanMantenimientoFamilia:idplanMantenimientoFamilia},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    $("#panelErrorCarga").css("display","none");
                    $("#panelPrincipal").css("display","none");
                    $("#panelProcesoCarga").css("display","block");
                    $("#spanPreloader").html(dato.message);
                    StoragePlanMto(idplanMantenimientoFamilia);
                }else{
                    $("#panelPrincipal").css("display","none");
                    $("#panelErrorCarga").css("display","block");
                    $("#panelProcesoCarga").css("display","none");
                    $("#titleError").html(dato.title);
                    $("#spanError").html(dato.message);
                    $("#btnProcesarCl").prop("disabled",false);
                    $("#btnCloseMd").prop("disabled",false);
                }
            },
            error: function(xhr) {
            }
        });
    }

    function StoragePlanMto(idplanMantenimientoFamilia)
    {
        $("#panelPrincipal").css("display","none");
        $("#panelErrorCarga").css("display","none");
        $("#panelProcesoCarga").css("display","block");
        $("#spanPreloader").html("Generando Planes de Mantenimiento 4/5");
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/SaveEditDelete/StoragePlanMtoSql")?>",
            data: {idplanMantenimientoFamilia:idplanMantenimientoFamilia},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    $("#panelErrorCarga").css("display","none");
                    $("#panelPrincipal").css("display","none");
                    $("#panelProcesoCarga").css("display","block");
                    $("#spanPreloader").html(dato.message);
                    StorageDetallePlanMto(idplanMantenimientoFamilia)
                }else{
                    $("#panelPrincipal").css("display","none");
                    $("#panelErrorCarga").css("display","block");
                    $("#panelProcesoCarga").css("display","none");
                    $("#titleError").html(dato.title);
                    $("#spanError").html(dato.message);
                    $("#btnProcesarCl").prop("disabled",false);
                    $("#btnCloseMd").prop("disabled",false);
                }
            },
            error: function(xhr) {
            }
        });
    }

    function StorageDetallePlanMto(idplanMantenimientoFamilia)
    {
        $("#panelPrincipal").css("display","none");
        $("#panelErrorCarga").css("display","none");
        $("#panelProcesoCarga").css("display","block");
        $("#spanPreloader").html("Insertando Repuestos a los planes de mantenimiento 5/5");
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/SaveEditDelete/StorageDetallePlanMtoSql")?>",
            data: {idplanMantenimientoFamilia:idplanMantenimientoFamilia},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    $("#panelPrincipal").css("display","block");
                    $("#titleFinal").html(dato.title);
                    $("#panelErrorCarga").css("display","none");
                    $("#panelProcesoCarga").css("display","none");
                    $("#btnProcesarCl").css("display","none");
                    $("#btnCloseMd").prop("disabled",false);
                }else{
                    $("#panelPrincipal").css("display","none");
                    $("#panelErrorCarga").css("display","block");
                    $("#panelProcesoCarga").css("display","none");
                    $("#titleError").html(dato.title);
                    $("#spanError").html(dato.message);
                    $("#btnProcesarCl").prop("disabled",false);
                    $("#btnCloseMd").prop("disabled",false);
                }
            },
            error: function(xhr) {
            }
        });
    }
</script>