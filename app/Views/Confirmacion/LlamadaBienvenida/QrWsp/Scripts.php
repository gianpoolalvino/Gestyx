<script>
    $(document).ready(function() {
        let currentSessionId = null;
        let sessionId = '<?=session('idusuario')?>';
        destroySession(sessionId);
        startSession(sessionId);

        // Función para destruir la sesión activa
        function destroySession(sessionId) {
            $.ajax({
                url: 'http://localhost:5000/destroy-session',  // Ruta para destruir la sesión
                type: 'POST',
                data: JSON.stringify({ sessionId: sessionId }),
                contentType: 'application/json',
                success: function(response) {
                    console.log('Sesión destruida correctamente');
                    // Después de destruir la sesión, iniciar una nueva
                    startSession(sessionId);
                },
                error: function(xhr, status, error) {
                    alert('Error al destruir la sesión');
                    console.log(xhr.responseText);
                    // En caso de error, intentar iniciar la nueva sesión directamente
                    startSession(sessionId);
                }
            });
        }

        // Función para manejar el evento de sesión autenticada
        function handleAuthenticated() {
            // Muestra notificación
            alert('¡QR escaneado correctamente!');
            // Cerrar el modal
            ModalOpcionesAdicionales.hide();
        }

        // Escuchar la autenticación en el cliente (Cuando el QR es escaneado y autenticado)
        $(document).on('sessionAuthenticated', function() {
            handleAuthenticated();
        });

        // Función para iniciar una nueva sesión
        function startSession(sessionId) {
            $.ajax({
                url: 'http://localhost:5000/start-session',
                type: 'POST',
                data: JSON.stringify({ sessionId: sessionId }),
                contentType: 'application/json',
                beforeSend: function() {
                    Preloader('Gnerando QR Wsp...');
                },
                success: function(response) {
                    ClosePreloader();
                    if (response.qr) {
                        $('#qrCode').html(`<img src="${response.qr}" alt="QR Code">`);
                        currentSessionId = sessionId;
                    } else {
                        alert('QR no disponible');
                    }
                },
                error: function(xhr, status, error) {
                    alert('Error al iniciar sesión o al generar el QR');
                    console.log(xhr.responseText);
                }
            });
        }

        // Solicitar el QR para una sesión
        $('#startSessionBtn').click(function() {
            const sessionId = $('#sessionId').val();
            // Si ya hay una sesión activa, destrúyela antes de iniciar una nueva
            if (sessionId) {
                destroySession(sessionId);  // Destruir la sesión anterior
            } else {
                startSession(sessionId);  // Iniciar una nueva sesión si no hay sesión activa
            }
        });
    });
</script>
