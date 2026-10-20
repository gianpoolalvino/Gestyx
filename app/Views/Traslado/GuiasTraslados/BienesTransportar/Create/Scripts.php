<script>
    $('#ModalAdicionales').on('shown.bs.modal', function () {
        $('#selectVinGuia').select2({
            placeholder: "Selecciona un Vin...",
            dropdownParent:$('#BodyAdicionales')
        });
    });
    $(document).on('click', function (e) {
        if (!$(e.target).closest('.select2-container').length) {
            $('#selectVinGuia').select2('close');
        }
    });


    $(document).on('change', '#selectVinGuia', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin = $("#selectVinGuia").val();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url('Traslado/GuiasTraslados/CreateViewEdit/ViewVinGuia'); ?>",
                data: { vin: vin },
                beforeSend: function() {
                    Preloader("Cargando Vista<br>Espere un momento...");
                },
                success: function(data) {
                    let dato = JSON.parse(data);
                    ClosePreloader();
                    $("#panelVinGuia").html(dato.info);
                },
                error: function(xhr) {
                    console.error("Error en la solicitud:", xhr); // Manejo de errores
                    ClosePreloader(); // Cierra el preloader en caso de error
                }
            });
    });
</script>
<script>
    $("#formVinGuia").bind("submit", function () {
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
                    ModalAdicionales.hide();
                    DetailVinGuia();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
</script>