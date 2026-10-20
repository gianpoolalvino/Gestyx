<script>
    $(document).on('click', '#btnCargaMysql', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idplanmantenimientofamilia = $("#idplanMto").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/CreateViewEdit/ViewMysql")?>",
            data: {idplanMantenimientoFamilia:idplanmantenimientofamilia},
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


    $('#selectRepuesto').select2({
        dropdownParent: $('#ModalInfoVehiculo .modal-body')
    });
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

    $(document).on('click', '.btnDetailRepuesto', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var iddetallePlanMantenimientoFam = $(this).attr("data-iddetallePlanMtoFam");
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/CreateViewEdit/DeleteDetailFamiliaRepuesto")?>",
            data: {iddetallePlanMantenimientoFam:iddetallePlanMantenimientoFam},
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

    function DetailViewPlan()
    {
        var idplanmantenimientofamilia = $("#idplanMto").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/CreateViewEdit/ViewDetailPlanFamilia")?>",
            data: {idplanmantenimientofamilia:idplanmantenimientofamilia},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyPlanMto").html(dato.info);
            },
            error: function(xhr) {
            }
        });
    }

    $("#tipoProceso").change(function(){
        var tipoProceso = $("#tipoProceso").val();
        if(tipoProceso==''){
            $("#btnProcesarPlan").attr("disabled",true);
        }else{
            $("#btnProcesarPlan").attr("disabled",false);
        }
    });

</script>
<script>
    $("#formPlanMtoFam").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Guardando Plan de Mantenimiento...<br>No cierres la ventana hasta finalizar el proceso");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    ModalInfoVehiculo.hide();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
</script>