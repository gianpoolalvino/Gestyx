<script>
    $("#formRetornVinExhi").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                Preloader('Retornando Vin a Inventario...');
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    Notificacion(dato.status,dato.title,dato.message);
                    location.reload();
                    ModalInfoVehiculo.hide();
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }
            },
            error: function (xhr) {
                $("#btnValidarAccesos").attr("disabled", false);
            }
        });
        return false;
    });
</script>