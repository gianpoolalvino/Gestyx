<script>
    $("#formSaveAccesorioEq").bind("submit", function () {
        var vin = $("#vinEquipamiento").val();
        var idtipoEquipamiento = $("#idtipoEquipamientoEq").val();
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                Preloader('Cargando Equipamiento...');
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    PanelEquipamientoSimple(vin,idtipoEquipamiento);
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