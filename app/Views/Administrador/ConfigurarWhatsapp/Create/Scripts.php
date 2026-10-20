<script>


    // Función para conectar al WebSocket y solicitar el QR
    function connectAndRequestQR() {
        sessionPhoneNumber = $("#numeroSession").val(); // Obtener el número de teléfono ingresado
        tokenSession=$("#tokenSession").val();


        // Limpiar cualquier error previo
        $('#error').text('');
        $('#status').text('');
        $('#retryBtn').hide(); // Esconde el botón de reintentar

        // Conectar al WebSocket
        socketQr = new WebSocket('ws://localhost:8080');

        socketQr.onopen = function() {
            console.log('Conectado al servidor WebSocket');
            // Asociar este WebSocket con el número de teléfono
            socketQr.send(JSON.stringify({ type: 'associate_number', phoneNumber: sessionPhoneNumber, operationType: 'admin',token:tokenSession }));
        };

        socketQr.onmessage = function(event) {
            const data = JSON.parse(event.data);
            console.log(data);

            // Recibir el QR y mostrarlo en la interfaz
            if (data.type === 'qr') {
                Preloader("Obteniendo Qr...");
                ClosePreloader();
                $('#qr').html(`<img src="${data.qr}" alt="QR Code" />`);
                $("#numeroSession").prop("readonly",true);
                $("#btnresetNumber").prop("disabled",false);
                $('#retryBtn').hide(); // Esconde el botón de reintentar si se genera un nuevo QR
            }

            // Mostrar el estado cuando la sesión esté lista
            if (data.type === 'authenticated') {

                $('#status').text(data.message);
                $("#saveWspQr").prop("disabled",false);
            }

            // Mensaje cuando el número ha sido asociado correctamente
            if (data.type === 'associated') {
                ClosePreloader();
                $('#status').text(data.message);
            }

            // Mostrar un error si el número no coincide
            if (data.type === 'error') {
                ClosePreloader();
                $('#error').text(data.message);  // Mostrar error de número incorrecto
                // Mostrar botón para reintentar
                $('#retryBtn').show();
                $('#status').text('Errores Detectados...');
            }

            // Confirmación de corrección de número
            if (data.type === 'number_corrected') {
                ClosePreloader();
                $('#status').text(data.message);
            }
        };

        socketQr.onerror = function(error) {
            console.log('Error en WebSocket:', error);
            $('#error').text('Error de conexión con el servidor WebSocket');
        };

        socketQr.onclose = function() {
            console.log('Desconectado del servidor WebSocket');
        };
    }

    // Función para reintentar solicitar el QR
    $(document).on('click', '#retryBtn', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $('#retryBtn').hide(); // Esconde el botón de reintentar al hacer clic
        connectAndRequestQR(); // Llamar nuevamente la función para solicitar un nuevo QR
    });

    // Función para inicializar la solicitud de QR al hacer clic en el botón
    $(document).on('click', '#requestNewQRBtn', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        Preloader("Obteniendo Qr...");
        connectAndRequestQR();
    });

    $(document).on('click', '#btnresetNumber', function(e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        if (socketQr && socketQr.readyState === WebSocket.OPEN) {
            socketQr.close();
            console.log('Conexión WebSocket cerrada');
            $("#numeroSession").val("");
            $("#numeroSession").prop("readonly",false);
            $("#saveWspQr").prop("disabled",true);
            $('#status').text('Ingrese un nuevo numero para inicializar...');
        }
    });

    // Función para cerrar la conexión WebSocket con el botón #btnDestroy
    $(document).on('click', '#btnDestroy', function(e) {
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
