<script>
    $("#formUploadExcel").on("submit", function (event) {
        event.preventDefault(); // Evita el comportamiento por defecto del formulario
        // Crear un objeto FormData
        var formData = new FormData(this);
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: formData,
            contentType: false, // Evita que jQuery configure el Content-Type
            processData: false, // Evita que jQuery procese los datos
            beforeSend: function () {
                Preloader("Subiendo Archivo Excel...");
                $("#btnUploadFile").attr("disabled", true); // Desactivar el botón durante la carga
                $("#btnProcesarCarga").attr("disabled", true);
                $("#marcaAfectada").attr("disabled",true);
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status, dato.title, dato.message);

                if (dato.status === "success") {
                    $("#idmarcaAfectada").val(dato.idmarca);
                    $("#idmarcaAfectada").html(dato.idmarca);
                    $("#marcaAfectada").attr("disabled",true);
                    $("#selectPestanha").html(dato.info);
                    $("#rutaExcel").val(dato.nombreExcel);
                    $("#rutaExcel").html(dato.nombreExcel);
                    // Aquí puedes manejar la respuesta de éxito
                    $("#selectPestanha").attr("disabled", false);
                    $("#btnUploadFile").attr("disabled", true); // Desactivar el botón durante la carga
                    $("#btnProcesarCarga").attr("disabled", false);
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false); // Rehabilitar el botón en caso de error
                Notificacion("danger", "Error en Carga", "Hubo un problema al cargar el archivo.");
            }
        });

        return false; // Evitar que el formulario se envíe de forma tradicional
    });
</script>
<script>
    $("#formProcesar").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Cargando Datos...");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
</script>