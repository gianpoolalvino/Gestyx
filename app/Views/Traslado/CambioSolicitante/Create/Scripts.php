<script>
    ////aqui me quede xD
    $('#grupoNuevo').change(function() {
        // Código que se ejecutará cuando cambie el valor del select
        var idgrupoUbicacion = $(this).val(); // Obtiene el valor seleccionado
        Ubicaciones(idgrupoUbicacion);
    });

    function Ubicaciones(idgrupoUbicacion)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("SolicitudVin/VinSolicitud/CreateViewEdit/SelectUbicacion")?>",
            data: {
                idgrupoUbicacion:idgrupoUbicacion,
            },
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#ubicacionNueva").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>
<script>
    $("#formSaveUbi").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Registrando Solicitud...");
            },
            success: function (data) {
                var dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=='success'){
                    ModalOpcionesAdicionales.hide();
                    location.reload();
                }
            },
            error: function (xhr) {
                $("#btnValidarAccesos").attr("disabled", false);
            }
        });
        return false;
    });

</script>