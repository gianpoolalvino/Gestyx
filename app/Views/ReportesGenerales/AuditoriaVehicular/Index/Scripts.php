<script>
    $(document).ready(function() {
        $('#vinVehicular').on('input', function() {
            let query = $(this).val();
            if (query.length > 0) {
                $.ajax({
                    url: '<?php echo base_url("ReportesGenerales/AuditoriaVehicular/SelectVin")?>',
                    method: 'POST',
                    data: { query: query },
                    success: function(data) {
                        let dato = $.parseJSON(data);
                        $('#result').html(dato.info);
                    }
                });
            } else {
                $('#result').empty();
            }
        });

        // Manejo de selección
        $(document).on('click', '.result-item', function() {
            var vin = $(this).attr("data-vin");
            $('#vinVehicular').val($(this).text());
            $('#result').empty();
            Preloader('Realizando Consulta en Gestyx...');
            // Crear el formulario dinámicamente para enviar el VIN por POST
            var form = $('<form>', {
                action: '<?php echo base_url("ReportesGenerales/AuditoriaVehicular/ViewVin") ?>', // Aquí va la URL de tu otro controlador
                method: 'POST'
            });

            // Crear un campo oculto con el valor del VIN
            $('<input>').attr({
                type: 'hidden',
                name: 'vin',  // Asegúrate que el controlador espera el parámetro 'vin'
                value: vin
            }).appendTo(form);

            // Añadir el formulario al cuerpo y enviarlo
            form.appendTo('body').submit();
        });




        // Cerrar el cuadro de resultados al hacer clic fuera
        $(document).on('click', function(event) {
            if (!$(event.target).closest('#search').length && !$(event.target).closest('#result').length) {
                $('#result').empty();
            }
        });


        // Mostrar resultados al hacer clic en el input
        $('#vinVehicular').on('focus', function() {
            let query = $(this).val();
            if (query.length > 0) {
                $.ajax({
                    url: '<?php echo base_url("ReportesGenerales/AuditoriaVehicular/SelectVin")?>',
                    method: 'POST',
                    data: {query: query},
                    success: function (data) {
                        let dato = $.parseJSON(data);
                        $('#result').html(dato.info);
                    }
                });
            }
        });
    });
</script>