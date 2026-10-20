<script>
    $("#frmSaveTrans").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader('Registrando cambios...');
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalAdicionales.hide();
                    DetailIndexTransportista();
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