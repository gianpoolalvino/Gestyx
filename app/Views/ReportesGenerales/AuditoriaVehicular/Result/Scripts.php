<script>
    $(document).on('click', '#btnControlCalidad', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin= $("#vinUbicacion").val();
        ViewControlCalidad(vin);
    });

    function ViewControlCalidad(vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ReportesGenerales/AuditoriaVehicular/ViewControlCalidad")?>",
            data: {vin:vin},
            beforeSend: function() {
                Preloader("Cargando Datos...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnEventos', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin= $(this).attr("data-vin");
        ViewEventos(vin)
    });

    function ViewEventos(vin)
    {

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ReportesGenerales/AuditoriaVehicular/AuditoriaEventos")?>",
            data: {vin:vin},
            beforeSend: function() {
                Preloader("Cargando Datos...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>