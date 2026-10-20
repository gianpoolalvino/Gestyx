<script>

    // Función para conectar al WebSocket y solicitar el QR
    function connectAndRequestQR(sessionPhoneNumber,tokenSession) {
        // Limpiar cualquier error previo
        $('#error').text('');
        $('#status').text('');
        $('#retryBtn').hide(); // Esconde el botón de reintentar

        // Conectar al WebSocket
        socketQr = new WebSocket('ws://localhost:8080');

        socketQr.onopen = function () {
            console.log('Conectado al servidor WebSocket');
            // Asociar este WebSocket con el número de teléfono
            socketQr.send(JSON.stringify({
                type: 'associate_number',
                phoneNumber: sessionPhoneNumber,
                operationType: 'admin',
                token:tokenSession
            }));
        };

        socketQr.onmessage = function (event) {
            const data = JSON.parse(event.data);
            console.log(data);
            // Recibir el QR y mostrarlo en la interfaz
            if (data.type === 'qr') {
                Preloader("Obteniendo Qr...");
                ClosePreloader();
                $('#qr').html(`<img src="${data.qr}" alt="QR Code" />`);
                $("#numeroSession").prop("readonly", true);
                $("#btnresetNumber").prop("disabled", false);
                $('#retryBtn').hide(); // Esconde el botón de reintentar si se genera un nuevo QR
            }

            // Mostrar el estado cuando la sesión esté lista
            if (data.type === 'authenticated') {
                $('#status').text(data.message);
                $("#saveWspQr").prop("disabled", false);
                /*
                setTimeout(() => {
                    socketQr.send(JSON.stringify({
                        type: 'get_chat_history_sync',
                        phoneNumber: sessionPhoneNumber,
                        operationType: 'admin',
                        token: tokenSession
                    }));
                }, 2000); // Ajusta el tiempo según lo que necesites

                 */
            }

            // Mensaje cuando el número ha sido asociado correctamente
            if (data.type === 'associated') {
                Preloader("Obteniendo Qr...");
                $('#status').text(data.message);
            }

            if(data.type==='session_exists'){
                ClosePreloader();
                $('#error').text(data.message);  // Mostrar error de número incorrecto
                $("#requestNewQRBtn").prop("disabled",true);
                // Mostrar botón para reintentar
                $('#retryBtn').show();
                $('#status').text('');
            }

            // Mostrar un error si el número no coincide
            if (data.type === 'error') {
                ClosePreloader();
                $('#qr').html('');
                $('#error').text(data.message);  // Mostrar error de número incorrecto
                // Mostrar botón para reintentar
                $('#retryBtn').show();
                $('#status').text('Errores Detectados:');
            }

            // Confirmación de corrección de número
            if (data.type === 'number_corrected') {
                $('#status').text(data.message);
            }

            // Confirmación cuando la sesión es cerrada correctamente
            if (data.type === 'session_closed') {
                $('#status').text(data.message);  // Mostrar mensaje de confirmación
            }
        };

        socketQr.onerror = function (error) {
            console.log('Error en WebSocket:', error);
            $('#error').text('Error de conexión con el servidor WebSocket');
        };

        socketQr.onclose = function () {
            console.log('Desconectado del servidor WebSocket');
        };
    }

    $(document).ready(function() {
        // Esta función se ejecutará cuando la página haya terminado de cargarse
        sessionPhoneNumber = '<?=$whatsapp[0]["numero"]?>';// Obtener el número de teléfono ingresado
        tokenSession='<?=$whatsapp[0]["token"]?>';
        connectAndRequestQR(sessionPhoneNumber,tokenSession);// Llamada a tu función
    });

    // Función para reintentar solicitar el QR
    $(document).on('click', '#retryBtn', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $('#retryBtn').hide(); // Esconde el botón de reintentar al hacer clic
        sessionPhoneNumber = '<?=$whatsapp[0]["numero"]?>';// Obtener el número de teléfono ingresado
        tokenSession=$("#tokenSession").val();

        connectAndRequestQR(sessionPhoneNumber,tokenSession); // Llamar nuevamente la función para solicitar un nuevo QR
    });

    // Función para inicializar la solicitud de QR al hacer clic en el botón
    $(document).on('click', '#requestNewQRBtn', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        Preloader("Obteniendo Qr...");
        sessionPhoneNumber = '<?=$whatsapp[0]["numero"]?>';// Obtener el número de teléfono ingresado
        tokenSession=$("#tokenSession").val();

        connectAndRequestQR(sessionPhoneNumber,tokenSession);

    });

    $(document).on('click', '#btnresetNumber', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        if (socketQr && socketQr.readyState === WebSocket.OPEN) {
            socketQr.close();
            console.log('Conexión WebSocket cerrada');
            $("#numeroSession").val("");
            $("#numeroSession").prop("readonly", false);
            $("#saveWspQr").prop("disabled", true);
            $('#status').text('Ingrese un nuevo numero para inicializar...');
        }
    });

    // Función para cerrar sesión cuando el usuario haga clic en el botón "Cerrar sesión"
    $(document).on('click', '#btnCerrarSession', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        const sessionPhoneNumber = '<?=$whatsapp[0]["numero"]?>';  // Obtener el número de teléfono de la sesión
        const token = '<?=$whatsapp[0]["token"]?>';  // Obtener el token asociado

        // Enviar solicitud para cerrar sesión
        socketQr.send(JSON.stringify({
            type: 'close_session',
            phoneNumber: sessionPhoneNumber,
            operationType:'admin',
            token: token
        }));
    });

    // Función para cerrar la conexión WebSocket con el botón #btnDestroy
    $(document).on('click', '#btnDestroy', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        // Cerrar la conexión WebSocket si está abierta
        if (socketQr && socketQr.readyState === WebSocket.OPEN) {
            socketQr.close();
            console.log('Conexión WebSocket cerrada');
            ModalOpcionesAdicionales.hide();
            $('#status').text('Conexión WebSocket cerrada');
        } else {
            ModalOpcionesAdicionales.hide();
            console.log('No hay conexión WebSocket activa');
            $('#status').text('No hay conexión WebSocket activa');
        }
    });
</script>