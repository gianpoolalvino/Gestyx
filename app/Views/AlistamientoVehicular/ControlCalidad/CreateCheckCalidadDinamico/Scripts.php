<script>
    $(document).on('click', '#btnCloseAdicional', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        ModalAdicionales.hide();
    });

    $("#formSaveCheckCalidadDina").bind("submit", function () {
        var idgrupoCheckCC = $("#grupoCheckId").val();
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
            //    Preloader("Cargando Data....");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    PanelCheckList(idgrupoCheckCC)
                    ModalAdicionales.hide();
                }
            },
            error: function (xhr) {
                $("#btnValidarAccesos").attr("disabled", false);
            }
        });
        return false;
    });
</script>