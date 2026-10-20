<!DOCTYPE html>
<html>
<head>
    <title>Vista Principal</title>
    <!-- Incluir jQuery desde un CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function cargarContenido() {
                // Crear una nueva solicitud XMLHttpRequest
                var xhr = new XMLHttpRequest();

                // Configurar la solicitud GET al método del controlador
                xhr.open('GET', '<?= base_url('Moduloelectronico/OrdenCompra/Index/cargarContenido') ?>', true);

                // Configurar la respuesta para actualizar el div mientras llega el contenido
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.LOADING || xhr.readyState === XMLHttpRequest.DONE) {
                        $('#contenido').html(xhr.responseText);
                    }
                };

                // Enviar la solicitud
                xhr.send();
            }

            // Llamar a la función al hacer clic en el botón
            $('#cargarBtn').click(function() {
                cargarContenido();
            });
        });
    </script>
</head>
<body>
<h1>Vista Principal</h1>
<!-- Botón para cargar contenido dinámicamente -->
<button id="cargarBtn">Cargar Contenido</button>

<!-- Área donde se mostrará el contenido cargado -->
<div id="contenido"></div>
</body>
</html>