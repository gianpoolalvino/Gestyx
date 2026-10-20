<script>
    $('#agente').select2({
        dropdownParent: $('#ModalOpcionesAdicionales .modal-body')
    });


    $('#ModalOpcionesAdicionales').on('shown.bs.modal', function () {
        $('#agente').select2({
            placeholder: "Selecciona un Agente...",
            dropdownParent:$('#BodyOpcionesAdicionales')
        });
    });
</script>

<script>
    $(document).on('click', '.btnTrashAgent', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        // Obtener el ID del usuario
        var idusuario = $(this).attr("data-idusuario");
        // Mostrar un cuadro de confirmación antes de proceder
        var confirmDelete = confirm("¿Estás seguro de que deseas eliminar este agente de WhatsApp?");

        if (confirmDelete) {
            // Si el usuario confirma la acción, realizar la solicitud de eliminación al backend
            $.ajax({
                url: '<?php echo base_url("Administrador/ConfigurarWhatsapp/SaveEditDelete/DeleteAgentWhatsapp")?>', // Reemplaza con la URL de tu backend
                method: 'POST',
                data: {
                    idusuario: idusuario
                },
                beforeSend: function () {
                    Preloader("Registrando Agente...");
                },
                success: function (data) {
                    let dato = $.parseJSON(data);
                    ClosePreloader();
                    Notificacion(dato.status,dato.title,dato.message);
                    var idsessionWhatsapp = $("#idsessionWhatsapp").val();
                    DetailIndex(idsessionWhatsapp);
                },
                error: function () {
                    ClosePreloader();
                    alert("Hubo un error al procesar la solicitud.");
                }
            });
        }
    });
</script>

<script>
    $("#formSaveWsp").bind("submit", function () {
        var idsessionWhatsapp = $("#idsessionWhatsapp").val();
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                Preloader("Registrando Agente...");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                DetailIndex(idsessionWhatsapp);
            },
            error: function (xhr) {
                ClosePreloader();
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });

    function DetailIndex(idsessionWhatsapp){
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/ConfigurarWhatsapp/CreateViewEdit/DetailAgente")?>",
            data: {idsessionWhatsapp:idsessionWhatsapp},
            beforeSend: function() {
                Preloader("Cargando Interface...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#tbodyAgents").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>