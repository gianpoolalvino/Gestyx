<script>
    $("#formUploadImage").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                Preloader("Cargando Data....");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    ModalAdicionales.hide();
                    var idingresoVin = $("#idingresoVinPrin").val();
                    var vin = $("#vinIngresoPrin").val();
                    PanelImagen(idingresoVin,vin);
                }
            },
            error: function (xhr) {
                $("#btnValidarAccesos").attr("disabled", false);
            }
        });
        return false;
    });
</script>