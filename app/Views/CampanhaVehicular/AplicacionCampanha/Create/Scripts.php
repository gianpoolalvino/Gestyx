<script>
    $('#checkMarcCmp').on('change', function() {
        // From the other examples
        if (!this.checked) {
            $(".selectCmp").attr("disabled",false);
        }else{
            $(".selectCmp").attr("disabled",true);
        }
    });


</script>
<script>
    $("#formSave").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
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