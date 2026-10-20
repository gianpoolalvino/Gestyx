<script>
    $("#createMarcas").change(function(){
        var idmarca = $("#createMarcas").val();

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/CreateViewEdit/SelectModelo")?>",
            data: {idmarca:idmarca},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#createModelo").html(dato.selectModelo);
            },
            error: function(xhr) {

            }
        });
    });

    function Repuesto(idmarca)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/CreateViewEdit/Repuesto")?>",
            data: {idmarca:idmarca},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#selectRepuesto").attr("disabled",false);
                $("#selectRepuesto").html(dato.selectRepuesto);
                $("#btnAddRepuesto").attr("disabled",false);
                $("#btnSavePlan").attr("disabled",true);
                $(".inputGeneral").attr("disabled",true);
                $("#btnProcesarPlan").attr("disabled",false);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnAddRepuesto', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idrepuesto = $("#selectRepuesto").val();
        var idplanmantenimientofamilia = $("#idplanMto").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/CreateViewEdit/ViewRepuesto")?>",
            data: {idrepuesto:idrepuesto,idplanmantenimientofamilia:idplanmantenimientofamilia},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {
            }
        });
    });

    $(document).on('click', '#btnSavePlan', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idmarca = $("#createMarcas").val();
        var idmodelo = $("#createModelo").val();
        var frecuencia = $("#frecuencia").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/SaveEditDelete/GenerarPlantilla")?>",
            data: {idmarca:idmarca,idmodelo:idmodelo,frecuencia:frecuencia},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
                $("#idplanMto").val(dato.idplanmantenimientofamilia);
                $("#idplanMto").html(dato.idplanmantenimientofamilia);
                Repuesto(idmarca);
            },
            error: function(xhr) {

            }
        });
    });
</script>