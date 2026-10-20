<script>
    $("#FormSendCot").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader('Enviando a ERP...')
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalOpcionesAdicionales.hide();
                DetailIndex();
                ModalAdicionales.show();
                $('#BodyAdicionales').html(dato.info);

            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
</script>