<script>
    $(document).on('click', '#btnPrintActa', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin = $(this).attr("data-vin");
        var idcitaEntrega = $(this).attr("data-idcitaEntrega");
        FormPdfActa(idcitaEntrega,vin)
    });

    $("#formSavePro").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Enviando Entregado a la Base ERP...<br>No Cierres la ventana ni refresques la pagina, hasta que finalice el proceso");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
                ClosePreloader();
                if(dato.status=="success"){
                    location.reload();
                    ModalAdicionales.hide();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
</script>