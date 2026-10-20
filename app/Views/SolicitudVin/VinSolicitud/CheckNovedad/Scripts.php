<script>
    $("#formCheckForm").bind("submit", function () {
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