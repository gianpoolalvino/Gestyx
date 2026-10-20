<script>
    $(document).on('click', '#btnSearchDoc', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var documento = $("#documentoExterno").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("OpcionesGenerales/ConsultaResponsable")?>",
            data: {documento:documento},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    $("#nombreExterno").val(dato.nombre);
                    $("#telefonoExterno").val(dato.telefono);
                    $("#direccionExterno").val(dato.direccion);
                    $(".bloqueo").attr("readonly",true);
                }else{
                    $(".bloqueo").attr("readonly",false);
                }

                Notificacion(dato.status,dato.title,dato.message);
            },
            error: function(xhr) {

            }
        });
    });

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
                    ModalInfoVehiculo.hide();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });

    $("#formSeminuevo").bind("submit", function () {
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
                    ModalInfoVehiculo.hide();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
</script>