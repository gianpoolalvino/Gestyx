<script>
    $('#vinCalidad').selectpicker();

    $("#btnCloseAgendamiento").on( "click", function() {
        ModalInfoVehiculo.hide();
    });

    $('#vinCalidad').on('change', function() {
        var vin = $("#vinCalidad").val();
        var horaAgenda = $("#horaAgenda").val();
        var fechaAgenda = $("#fechaAgenda").val();
        var idasesorAgenda = $("#idasesorAgenda").val();
        if(vin!=''){
            AgendamientoVin(vin,horaAgenda,fechaAgenda,idasesorAgenda);
        }else{
            Notificacion('danger','Sin Liberar','El Vin no se encuentra liberado');
            $("#panelVinPlaca").html('');
        }
    });

    function AgendamientoVin(vin,horaAgenda,fechaAgenda,idasesorAgenda)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Agendamiento/CalendarioCita/CreateViewEdit/VinInfoPlaca")?>",
            data: {vin:vin,horaAgenda:horaAgenda,fechaAgenda:fechaAgenda,idasesorAgenda:idasesorAgenda},
            beforeSend: function() {
                Preloader("Cargando Datos...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#panelVinPlaca").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $("#formSave").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Guardando Cita...");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    location.reload();
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