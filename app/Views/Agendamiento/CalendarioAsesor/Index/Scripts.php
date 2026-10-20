<script>
    $(document).ready(function() {
        // Inicializa Sortable para la tabla usando jQuery
        var tableBody = $('#tableAlistamiento tbody');  // Seleccionar el cuerpo de la tabla

        // Configurar el drag-and-drop utilizando SortableJS
        new Sortable(tableBody[0], {
            animation: 150, // Animación suave al mover los elementos
            handle: '.sticky-col', // La columna "sticky" será el "mango" para arrastrar
            onEnd: function(evt) {
                // Lógica cuando el drag termina
                var movedItem = $(evt.item); // El elemento que fue movido
                var newIndex = evt.newIndex;  // El nuevo índice en el que fue colocado el elemento

                console.log('Arrastre finalizado. Elemento movido:', movedItem);
                console.log('Nuevo índice:', newIndex);

                // Llamar a la función para actualizar el backend si es necesario
                updateBackend(movedItem);
            }
        });

        // Función para actualizar el backend
        function updateBackend(movedItem) {
            var vin = movedItem.data('vin');   // Obtener VIN desde el atributo 'data-vin'
            var fecha = movedItem.data('fecha');  // Obtener fecha
            var hora = movedItem.data('hora');   // Obtener hora

            // Realiza la solicitud AJAX para actualizar los datos en el backend
            $.ajax({
                url: 'your-server-endpoint',  // Reemplaza con tu endpoint de servidor
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify({
                    vin: vin,
                    fecha: fecha,
                    hora: hora
                }),
                success: function(response) {
                    console.log('Datos actualizados exitosamente:', response);
                },
                error: function(error) {
                    console.error('Error al actualizar los datos:', error);
                }
            });
        }
    });
</script>