<script>
    $("#formSaveCheckPdi").bind("submit", function () {
        var idgrupoCheckList = $("#grupoCheckIdPdi").val();
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                Preloader('Cargando Datos...');
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=='success'){
                    ModalAdicionales.hide();
                    PanelCheckList(idgrupoCheckList);
                }
            },
            error: function (xhr) {
                $("#btnValidarAccesos").attr("disabled", false);
            }
        });
        return false;
    });
</script>