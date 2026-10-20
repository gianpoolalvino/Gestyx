<script>
    $(document).ready(function() {
        // Evento cuando cambia la ubicación
        $('#ubicacionNueva').on('change', function() {
            var idubicacion = $(this).val();
            // Realizar la solicitud AJAX
            $.ajax({
                url: '<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/Box")?>', // Reemplaza con la ruta a tu archivo PHP
                type: 'POST',
                dataType: 'json',
                data: {
                    idubicacion: idubicacion
                },
                success: function(response) {
                    // Verificar si la solicitud fue exitosa
                    if (response.status === 'success') {
                        // Actualizar el select de boxes
                        $('#boxNuevo').html(response.info);
                    } else {
                        // Manejar el error (opcional)
                        $('#boxNuevo').html('<option value="">Error al cargar los boxes</option>');
                    }
                },
                error: function(xhr, status, error) {
                    // Manejar el error de la solicitud (opcional)
                    $('#boxNuevo').html('<option value="">Error en la solicitud</option>');
                }
            });
        });
    });
</script>