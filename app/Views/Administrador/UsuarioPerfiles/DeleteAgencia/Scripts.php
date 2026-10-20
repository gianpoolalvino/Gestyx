<script>
    $("#formDeleteAgen").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                Preloader("Cargando Datos....");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=='success'){
                    ModalOpcionesAdicionales.hide();
                    $("#btnProcess").attr("disabled",true);
                    DetailAgencia();
                }
            },
            error: function (xhr) {
                $("#btnProcess").attr("disabled", false);
            }
        });
        return false;
    });
</script>