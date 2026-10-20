<script>
    $('#boxNuevo').select2({
        tags: true,
        dropdownParent: $('#ModalOpcionesAdicionales')
    });
    $("#formSaveBox").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader('Registrando cambios...')
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
                ClosePreloader();
                if(dato.status=="success"){
                    location.reload();
                    ModalOpcionesAdicionales.hide();
                }
            },
            error: function (xhr) {
                ClosePreloader();
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });

</script>
<script>
    $('#boxNuevo').on('change', function () {
        var id = $(this).val();
            VerificarDisponibilidad(id);
    });

    function VerificarDisponibilidad(idboxUbicacion)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/VerificarDisponibilidad")?>",
            data: {idboxUbicacion:idboxUbicacion},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=="danger"){
                    $("#btnProcesarBx").prop("disabled",true);
                }else{
                    $("#btnProcesarBx").prop("disabled",false);
                }
                $("#alertBox").html(dato.message);
            },
            error: function(xhr) {

            }
        });
    }
</script>