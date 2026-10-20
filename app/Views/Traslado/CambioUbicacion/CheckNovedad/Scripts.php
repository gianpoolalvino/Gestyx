<script>
    $("#formCheck").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader('Enviando Datos....');
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                ModalAdicionales.hide();
                if(dato.status=="success"){
                    DetailNovedadesTaller();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });

</script>