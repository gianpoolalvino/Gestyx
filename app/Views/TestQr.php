<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escanear QR - WhatsApp Web</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        #qr {
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 10px;
        }
        #status {
            margin-top: 10px;
            font-weight: bold;
        }
        #error {
            color: red;
            margin-top: 10px;
            font-weight: bold;
        }
        #retryBtn {
            display: none;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<h1>Escanear QR de WhatsApp</h1>
<div id="qr">
    <p>Esperando que se genere el código QR...</p>
</div>

<button id="requestNewQRBtn">Solicitar Nuevo QR</button>
<input id="numeroSession" placeholder="Ingrese numero para sesión..." />
<div id="status"></div>
<div id="error"></div> <!-- Aquí se mostrarán los errores -->
<button id="retryBtn">Reintentar Escanear QR</button>

<script>
    // Variables globales
    let socket;
    let sessionPhoneNumber;
    let isQrRequested = false; // Variable para controlar si ya se ha solicitado un QR

    // Función para conectar al WebSocket y solicitar el QR
    function connectAndRequestQR() {
        sessionPhoneNumber = $("#numeroSession").val(); // Obtener el número de teléfono ingresado
        if (!sessionPhoneNumber) {
            alert('Por favor, ingresa un número de teléfono para la sesión.');
            return; // Si el número no está ingresado, no continuar
        }

        // Limpiar cualquier error previo
        $('#error').text('');
        $('#status').text('');
        $('#retryBtn').hide(); // Esconde el botón de reintentar

        // Conectar al WebSocket
        socket = new WebSocket('ws://localhost:8080');

        socket.onopen = function() {
            console.log('Conectado al servidor WebSocket');
            // Asociar este WebSocket con el número de teléfono
            socket.send(JSON.stringify({ type: 'associate_number', phoneNumber: sessionPhoneNumber,operationType:'admin_autoniza' }));
        };

        socket.onmessage = function(event) {
            const data = JSON.parse(event.data);

            // Recibir el QR y mostrarlo en la interfaz
            if (data.type === 'qr') {
                $('#qr').html(`<img src="${data.qr}" alt="QR Code" />`);
                $('#retryBtn').hide(); // Esconde el botón de reintentar si se genera un nuevo QR
            }

            // Mostrar el estado cuando la sesión esté lista
            if (data.type === 'authenticated') {
                $('#status').text(data.message);
            }

            // Mensaje cuando el número ha sido asociado correctamente
            if (data.type === 'associated') {
                $('#status').text(data.message);
            }

            // Mostrar un error si el número no coincide
            if (data.type === 'error') {
                $('#error').text(data.message);  // Mostrar error de número incorrecto
                // Mostrar botón para reintentar
                $('#retryBtn').show();
                $('#status').text('Por favor, reintenta escanear el QR.');
            }

            // Confirmación de corrección de número
            if (data.type === 'number_corrected') {
                $('#status').text(data.message);
            }
        };

        socket.onerror = function(error) {
            console.log('Error en WebSocket:', error);
            $('#error').text('Error de conexión con el servidor WebSocket');
        };

        socket.onclose = function() {
            console.log('Desconectado del servidor WebSocket');
        };
    }

    // Función para reintentar solicitar el QR
    $('#retryBtn').click(function() {
        $('#retryBtn').hide(); // Esconde el botón de reintentar al hacer clic
        connectAndRequestQR(); // Llamar nuevamente la función para solicitar un nuevo QR
    });

    // Función para inicializar la solicitud de QR al hacer clic en el botón
    $('#requestNewQRBtn').click(function() {
        connectAndRequestQR();
    });
</script>
</body>
</html>
