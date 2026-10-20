<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enviar Mensajes - WhatsApp Web</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        .hidden {
            display: none;
        }
        #message-container {
            margin-top: 20px;
        }
        #message-result {
            margin-top: 10px;
            font-weight: bold;
        }
        #received-messages {
            margin-top: 20px;
            padding: 10px;
            background-color: #f0f0f0;
            border-radius: 5px;
        }
    </style>
</head>
<body>
<h1>Enviar Mensajes de WhatsApp desde número <?php echo $numeroSession?></h1>
<strong id="textAlert"></strong><br>
<div id="status"></div>

<div id="message-container">
    <h2>Enviar un mensaje</h2>
    <input type="text" id="recipient" placeholder="Número de destino (ej. 51987654321)" />
    <input type="text" id="message" placeholder="Escribe tu mensaje..." />
    <button id="sendMessageBtn" disabled>Enviar mensaje</button>
    <div id="message-result"></div>
</div>

<!-- Área para mostrar mensajes recibidos -->
<div id="received-messages">
    <h3>Mensajes recibidos:</h3>
    <ul id="messages-list"></ul>
</div>

<script>
    const sessionPhoneNumber = '<?=$numeroSession?>'; // Número de WhatsApp asociado a la sesión
    const tokenSession='<?=$token?>';
    const socket = new WebSocket('ws://localhost:8080');
    let sessionReady = false;

    // Conectar al WebSocket y asociar el número de teléfono
    socket.onopen = function() {
        console.log('Conectado al servidor WebSocket');
        // Asociar este WebSocket con el número de teléfono
        socket.send(JSON.stringify({ type: 'associate_number', phoneNumber: sessionPhoneNumber,operationType:'agent',token:tokenSession }));
    };

    socket.onmessage = function(event) {
        const data = JSON.parse(event.data);
        console.log(data);
        // Recibir el estado de la sesión cuando esté lista
        if (data.type === 'ready') {
            $('#status').text(data.message);
            sessionReady = true;
            $('#sendMessageBtn').attr("disabled", true);  // Habilitar el botón para enviar mensajes
            $('#textAlert').text('La sesión de WhatsApp está lista.'); // Notificar que la sesión está lista
        }

        if(data.type === 'qr'){
            // Si el QR está pendiente, deshabilitar el botón de enviar mensaje
            $('#textAlert').text('Por favor, escanea el código QR para continuar.');
        }

        // Mostrar error si algo sale mal
        if (data.type === 'error') {
            $('#message-result').text('Error: ' + data.message);
        }

        // Mensaje cuando el número ha sido asociado correctamente
        if (data.type === 'associated') {
            sessionReady = true;
            $('#sendMessageBtn').attr("disabled", false);
            $('#status').text(data.message);
            $('#textAlert').text('La sesión de WhatsApp ha sido asociada correctamente.');
        }

        // Mostrar mensajes recibidos
        if (data.type === 'message_received') {
            const { from, body, typeMessage, mediaUrl, media } = data;

            if (typeMessage === 'image_received') {
                // Mostrar imagen recibida
                const base64Image = media.data; // Asegúrate que el campo `data` contiene la cadena base64
                const imageSrc = "data:" + media.mimetype + ";base64," + base64Image;
                $('#messages-list').append(`<li><strong>${from}</strong>: <br><img src="${imageSrc}" alt="Imagen recibida" style="max-width: 300px; max-height: 300px;"></li>`);
            } else if (typeMessage === 'sticker_received') {
                // Mostrar sticker recibido
                const base64Sticker = media.data; // Similar a la imagen
                const stickerSrc = "data:" + media.mimetype + ";base64," + base64Sticker;
                $('#messages-list').append(`<li><strong>${from}</strong>: <br><img src="${stickerSrc}" alt="Sticker recibido" style="max-width: 150px; max-height: 150px;"></li>`);
            } else if (typeMessage === 'document_received') {
                // Mostrar documento recibido (puedes cambiar la visualización según el tipo de documento)
                // El documento está en base64
                const base64Document = media.data;  // El contenido del documento en base64
                const documentName = media.filename || 'documento';  // Usa un nombre por defecto si no se proporciona
                // Crear un Blob a partir del base64
                const byteCharacters = atob(base64Document);  // Decodificar la cadena base64
                const byteArray = new Uint8Array(byteCharacters.length);
                for (let i = 0; i < byteCharacters.length; i++) {
                    byteArray[i] = byteCharacters.charCodeAt(i);
                }
                const blob = new Blob([byteArray], { type: media.mimetype });  // Crear el archivo desde el Blob
                // Crear una URL de descarga para el Blob
                const downloadUrl = URL.createObjectURL(blob);
                // Mostrar el enlace de descarga
                $('#messages-list').append(`
                <li>
                    <strong>${from}</strong>: <br>
                    <span>${documentName}</span><br>
                    <a href="${downloadUrl}" download="${documentName}">Haz clic para descargar el documento</a><br>
                </li>
            `);
            } else if (typeMessage === 'video_received') {
                // El video está en base64
                const base64Video = media.data;  // El contenido del video en base64
                const videoName = media.filename || 'video.mp4';  // Usar el filename enviado o un valor por defecto
                const mimeType = media.mimetype || 'video/mp4';  // Usar el tipo MIME enviado o un valor por defecto

                // Crear un Blob a partir del base64
                const byteCharacters = atob(base64Video);  // Decodificar la cadena base64
                const byteArray = new Uint8Array(byteCharacters.length);
                for (let i = 0; i < byteCharacters.length; i++) {
                    byteArray[i] = byteCharacters.charCodeAt(i);
                }
                const blob = new Blob([byteArray], { type: mimeType });  // Crear el archivo desde el Blob

                // Crear una URL de descarga para el Blob
                const downloadUrl = URL.createObjectURL(blob);

                // Mostrar el enlace de descarga del video
                $('#messages-list').append(`
                <li>
                    <strong>${from}</strong>: <br>
                    <video width="320" height="240" controls>
                        <source src="${downloadUrl}" type="${mimeType}">
                        Tu navegador no soporta el elemento de video.
                    </video>

                </li>
            `);
            } else {
                // Mostrar mensaje de texto
                $('#messages-list').append(`<li><strong>${from}</strong>: ${body}</li>`);
            }
        }
    };

    socket.onerror = function(error) {
        console.log('Error en WebSocket:', error);
    };

    socket.onclose = function() {
        console.log('Desconectado del servidor WebSocket');
    };

    // Enviar mensaje a través de la sesión de WhatsApp
    $('#sendMessageBtn').click(function() {
        if (sessionReady) {
            const message = $('#message').val();
            const recipient = $('#recipient').val();
            if (message && recipient) {
                socket.send(JSON.stringify({
                    type: 'send_message',
                    phoneNumber: sessionPhoneNumber,
                    to: recipient,  // Número del destinatario
                    body: message
                }));
                $('#message').val('');  // Limpiar el campo de mensaje
                $('#recipient').val('');  // Limpiar el campo de destinatario
                $('#message-result').text('Mensaje enviado con éxito');
            } else {
                alert('Por favor ingresa tanto el número de destino como el mensaje.');
            }
        } else {
            alert('La sesión de WhatsApp no está lista aún.');
        }
    });
</script>
</body>
</html>
