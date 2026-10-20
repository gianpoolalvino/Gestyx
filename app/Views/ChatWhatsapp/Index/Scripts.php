<script>
    const sessionPhoneNumber = '<?=session("numeroSessionWhatsapp")?>'; // Número de WhatsApp asociado a la sesión
    const tokenSession='<?=session("tokenSeguridad")?>';
    const socket = new WebSocket('ws://localhost:8080');
    let sessionReady = false;
    let activeContactId = null;
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

          //  socket.send(JSON.stringify({ type: 'get_active_chats', phoneNumber: sessionPhoneNumber}));
        }

        if(data.type === 'contact_data'){
            console.log('Datos de contacto:', data.contactData);
            displayContacts(data.contactData);
        }

        if (data.type === 'chat_history') {
            const messages = data.messages; // Suponiendo que los mensajes vienen en un array
            const header = data.chatHeader;
            $('#panelChat').empty();
            console.log(header.contactName);
           $("#nombreCabeceraContacto").html(header.contactName);
            hidePreloader();
            messages.forEach(message => {
                const { from, body, typeMessage, type, media, timestamp } = message;

                // Crear el contenedor del mensaje
                let messageHtml = '';

                // Función para procesar los diferentes tipos de contenido (imagen, video, sticker, documento)
                const processMedia = (media, type) => {
                    let mediaHtml = '';
                    if (type === 'image') {
                        const imageSrc = "data:" + media.mimetype + ";base64," + media.data;
                        mediaHtml = `<img src="${imageSrc}" alt="Imagen" style="max-width: 300px; max-height: 300px;">`;
                    } else if (type === 'sticker') {
                        const stickerSrc = "data:" + media.mimetype + ";base64," + media.data;
                        mediaHtml = `<img src="${stickerSrc}" alt="Sticker" style="max-width: 150px; max-height: 150px;">`;
                    } else if (type === 'document') {
                        const documentName = media.filename || 'documento';
                        const byteCharacters = atob(media.data);
                        const byteArray = new Uint8Array(byteCharacters.length);
                        for (let i = 0; i < byteCharacters.length; i++) {
                            byteArray[i] = byteCharacters.charCodeAt(i);
                        }
                        const blob = new Blob([byteArray], { type: media.mimetype });
                        const downloadUrl = URL.createObjectURL(blob);
                        mediaHtml = `
                    <span>${documentName}</span><br>
                    <a href="${downloadUrl}" download="${documentName}">Haz clic para descargar el documento</a>
                `;
                    } else if (type === 'video') {
                        const videoSrc = "data:" + media.mimetype + ";base64," + media.data;
                        mediaHtml = `
                    <video width="320" height="240" controls>
                        <source src="${videoSrc}" type="${media.mimetype}">
                        Tu navegador no soporta el elemento de video.
                    </video>
                `;
                    }
                    return mediaHtml;
                };
                // Crear el HTML según el tipo de mensaje (received/send)
                if (typeMessage === 'received') {
                    // Mensaje recibido
                    messageHtml = `
            <div class="d-flex chat-message">
                <div class="d-flex mb-2 flex-1">
                    <div class="w-100 w-xxl-75">
                        <div class="d-flex hover-actions-trigger">
                            <div class="avatar avatar-m me-3 flex-shrink-0">
                                <img class="rounded-circle" src="../assets/img/team/20.webp" alt="">
                            </div>
                            <div class="chat-message-content received me-2">
                                <div class="mb-1 received-message-content border rounded-2 p-3">
                                    <p class="mb-0">${body}</p>
                                    ${media ? processMedia(media, type) : ''}
                                </div>
                            </div>
                            <div class="d-none d-sm-flex">
                                <div class="hover-actions position-relative align-self-center me-2">
                                    <button class="btn p-2 fs-10"><span class="fa-solid fa-reply"></span></button>
                                    <button class="btn p-2 fs-10"><span class="fa-solid fa-trash"></span></button>
                                    <button class="btn p-2 fs-10"><span class="fa-solid fa-share"></span></button>
                                    <button class="btn p-2 fs-10"><span class="fa-solid fa-face-smile"></span></button>
                                </div>
                            </div>
                        </div>
                        <p class="mb-0 fs-10 text-body-tertiary text-opacity-85 fw-semibold ms-7">${new Date(timestamp).toLocaleString()}</p>
                    </div>
                </div>
            </div>`;
                } else if (typeMessage === 'send') {
                    // Mensaje enviado
                    messageHtml = `
            <div class="d-flex chat-message">
                <div class="d-flex mb-2 justify-content-end flex-1">
                    <div class="w-100 w-xxl-75">
                        <div class="d-flex flex-end-center hover-actions-trigger">
                            <div class="d-none d-sm-flex">
                                <div class="hover-actions position-relative align-self-center">
                                    <button class="btn p-2 fs-10"><span class="fa-solid fa-reply text-primary"></span></button>
                                    <button class="btn p-2 fs-10"><span class="fa-solid fa-pen-to-square text-primary"></span></button>
                                    <button class="btn p-2 fs-10"><span class="fa-solid fa-share text-primary"></span></button>
                                    <button class="btn p-2 fs-10"><span class="fa-solid fa-trash text-primary"></span></button>
                                    <button class="btn p-2 fs-10"><span class="fa-solid fa-face-smile text-primary"></span></button>
                                </div>
                            </div>
                            <div class="chat-message-content me-2">
                                <div class="mb-1 sent-message-content bg-primary rounded-2 p-3 text-white" data-bs-theme="light">
                                    <p class="mb-0">${body}</p>
                                    ${media ? processMedia(media, type) : ''}
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <p class="mb-0 fs-10 text-body-tertiary text-opacity-85 fw-semibold">${new Date(timestamp).toLocaleString()}</p>
                        </div>
                    </div>
                </div>
            </div>`;
                }

                // Agregar el mensaje al contenedor de mensajes
                $('#panelChat').append(messageHtml);
                $('#panelChat').scrollTop($('#panelChat')[0].scrollHeight);
            });
        }

        // Mostrar mensajes recibidos
        if (data.type === 'message_received') {
            var numberClient=$("#recipient").val();
            const { from, body, typeMessage, media } = data;
            console.log(typeMessage);
            // Crear el contenedor del mensaje
            if(from===numberClient){

            let messageHtml = `
        <div class="d-flex chat-message">
            <div class="d-flex mb-2 flex-1">
                <div class="w-100 w-xxl-75">
                    <div class="d-flex hover-actions-trigger">
                        <div class="avatar avatar-m me-3 flex-shrink-0">
                            <img class="rounded-circle" src="../assets/img/team/20.webp" alt="">
                        </div>
                        <div class="chat-message-content received me-2">
                            <div class="mb-1 received-message-content border rounded-2 p-3">`;

            // Procesar según el tipo de mensaje
            if (typeMessage === 'image_received') {
                const base64Image = media.data;
                const imageSrc = "data:" + media.mimetype + ";base64," + base64Image;
                messageHtml += `<p class="mb-0"><br><img src="${imageSrc}" alt="Imagen recibida" style="max-width: 300px; max-height: 300px;"></p>`;
            } else if (typeMessage === 'sticker_received') {
                const base64Sticker = media.data;
                const stickerSrc = "data:" + media.mimetype + ";base64," + base64Sticker;
                messageHtml += `<p class="mb-0"><br><img src="${stickerSrc}" alt="Sticker recibido" style="max-width: 150px; max-height: 150px;"></p>`;
            } else if (typeMessage === 'document_received') {
                const base64Document = media.data;
                const documentName = media.filename || 'documento';
                const byteCharacters = atob(base64Document);
                const byteArray = new Uint8Array(byteCharacters.length);
                for (let i = 0; i < byteCharacters.length; i++) {
                    byteArray[i] = byteCharacters.charCodeAt(i);
                }
                const blob = new Blob([byteArray], { type: media.mimetype });
                const downloadUrl = URL.createObjectURL(blob);
                messageHtml += `
            <p class="mb-0"><br>
            <span>${documentName}</span><br>
            <a href="${downloadUrl}" download="${documentName}">Haz clic para descargar el documento</a></p>
        `;
            } else if (typeMessage === 'video_received') {
                const base64Video = media.data;
                const videoName = media.filename || 'video.mp4';
                const mimeType = media.mimetype || 'video/mp4';
                const byteCharacters = atob(base64Video);
                const byteArray = new Uint8Array(byteCharacters.length);
                for (let i = 0; i < byteCharacters.length; i++) {
                    byteArray[i] = byteCharacters.charCodeAt(i);
                }
                const blob = new Blob([byteArray], { type: mimeType });
                const downloadUrl = URL.createObjectURL(blob);
                messageHtml += `
            <p class="mb-0"><br>
            <video width="320" height="240" controls>
                <source src="${downloadUrl}" type="${mimeType}">
                Tu navegador no soporta el elemento de video.
            </video></p>
        `;
            } else {
                messageHtml += `<p class="mb-0">${body}</p>`;
            }

            // Cerrar el contenedor del mensaje
            messageHtml += `
                            </div>
                        </div>
                        <div class="d-none d-sm-flex">
                            <div class="hover-actions position-relative align-self-center me-2">
                                <button class="btn p-2 fs-10"><svg class="svg-inline--fa fa-reply fa-w-16" aria-hidden="true" focusable="false" data-prefix="fa-solid" data-icon="reply" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M8.31 189.9l176-151.1c15.41-13.3 39.69-2.509 39.69 18.16v80.05C384.6 137.9 512 170.1 512 322.3c0 61.44- 39.59 122.3-83.34 154.1c-13.66 9.938-33.09-2.531-28.06-18.62c45.34-145-21.5-183.5-176.6-185.8v87.92c0 20.7-24.31 31.45-39.69 18.16l-176-151.1C-2.753 216.6-2.784 199.4 8.31 189.9z"></path></svg></button>
                                <button class="btn p-2 fs-10"><svg class="svg-inline--fa fa-trash fa-w-14" aria-hidden="true" focusable="false" data-prefix="fa-solid" data-icon="trash" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM394.8 466.1C393.2 492.3 372.3 512 346.9 512H101.1C75.75 512 54.77 492.3 53.19 466.1L31.1 128H416L394.8 466.1z"></path></svg></button>
                                <button class="btn p-2 fs-10"><svg class="svg-inline--fa fa-share fa-w-16" aria-hidden="true" focusable="false" data-prefix="fa-solid" data-icon="share" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M503.7 226.2l-176 151.1c-15.38 13.3-39.69 2.545-39.69-18.16V272.1C132.9 274.3 66.06 312.8 111.4 457.8c5.031 16.09-14.41 28.56-28.06 18.62C39.59 444.6 0 383.8 0 322.3c0-152.2 127.4-184.4 288-186.3V56.02c0-20.67 24.28-31.46 39.69-18.16l176 151.1C514.8 199.4 514.8 216.6 503.7 226.2z"></path></svg></button>
                                <button class="btn p-2 fs-10"><svg class="svg-inline--fa fa-face-smile fa-w-16" aria-hidden="true" focusable="false" data-prefix="fa-solid" data-icon="face-smile" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M0 256C0 114.6 114.6 0 256 0C397.4 0 512 114.6 512 256C512 397.4 397.4 512 256 512C114.6 512 0 397.4 0 256zM164.1 325.5C158.3 318.8 148.2 318.1 141.5 323.9C134.8 329.7 134.1 339.8 139.9 346.5C162.1 372.1 200.9 400 255.1 400C311.1 400 349.8 372.1 372.1 346.5C377.9 339.8 377.2 329.7 370.5 323.9C363.8 318.1 353.7 318 .8 347.9 325.5C329.9 346.2 299.4 368 255.1 368C212.6 368 182 346.2 164.1 325.5H164.1zM176.4 176C158.7 176 144.4 190.3 144.4 208C144.4 225.7 158.7 240 176.4 240C194 240 208.4 225.7 208.4 208C208.4 190.3 194 176 176.4 176zM336.4 240C354 240 368.4 225.7 368.4 208C368.4 190.3 354 176 336.4 176C318.7 176 304.4 190.3 304.4 208C304.4 225.7 318.7 240 336.4 240z"></path></svg></button>
                            </div>
                        </div>
                    </div>
                    <p class="mb-0 fs-10 text-body-tertiary text-opacity-85 fw-semibold ms-7">Ahora, ${new Date().toLocaleString()}</p>
                </div>
            </div>
        </div>
    `;
            $('#panelChat').scrollTop($('#panelChat')[0].scrollHeight);
            // Agregar el mensaje al contenedor de mensajes
            $('#panelChat').append(messageHtml);
            }
                socket.send(JSON.stringify({ type: 'get_active_chats', phoneNumber: sessionPhoneNumber}));

        }
    };

    socket.onerror = function(error) {
        console.log('Error en WebSocket:', error);
    };

    socket.onclose = function() {
        console.log('Desconectado del servidor WebSocket');
    };


    function displayContacts(contacts) {
        var contactList = document.getElementById("panelContactos");
        contactList.innerHTML = '';  // Limpiar el panel de contactos antes de mostrar los nuevos contactos

        // Recorrer los contactos y añadirlos a la lista
        contacts.forEach(contact => {
            // Crear el contador de mensajes no leídos (si existe)
            const unreadCount = contact.unreadCount > 0 ?
                `<span class="bg-primary rounded-circle top-0 end-0 position-absolute text-white d-flex flex-center fs-10 fw-semibold d-none d-sm-flex d-xl-none lh-1" style="height: 1rem; width: 1rem;">${contact.unreadCount}</span>`
                : '';

            // Concatenar las cadenas correctamente y usar las variables dentro de la cadena
            var contc = `<li class="nav-item ${contact.unreadCount > 0 ? 'unread' : ''}" role="presentation">
        <a class="nav-link d-flex align-items-center justify-content-center p-2 unread btnChatProfile"
            data-idchat="${contact.chatId}"
            data-numeroCliente="${contact.phoneNumber}"
            data-bs-toggle="tab"
            data-chat-thread="data-chat-thread"
            href="#tab-thread-4"
            role="tab"
            aria-selected="false"
            tabindex="-1">
            <div class="avatar avatar-xl status-online position-relative me-2 me-sm-0 me-xl-2">
                <img class="rounded-circle border border-2 border-light-subtle" src="${contact.image}" alt=""/>
                ${unreadCount}
            </div>
            <div class="flex-1 d-sm-none d-xl-block">
            <div class="d-flex justify-content-between align-items-center">
            <h5 class="text-body fw-normal name text-nowrap">${contact.name}</h5>
            <p class="fs-10 text-body-tertiary text-opacity-85 mb-0 text-nowrap">Yesterday, 10 PM</p>
            </div>
            <div class="d-flex justify-content-between">
            <p class="fs-9 mb-0 line-clamp-1 text-body-tertiary text-opacity-85 message">${contact.lastMessage}</p>
            ${contact.unreadCount > 0 ?
                `<span class="badge badge-phoenix badge-phoenix-primary px-1 unread-badge">${contact.unreadCount}+</span>`
                : ''}
            </div>
            </div>
            </a>
        </li>`;

            // Añadir el contacto a la lista
            contactList.innerHTML += contc;

            // Si el contacto es el que estaba activo, añadirle la clase 'active'
            if (activeContactId === contact.chatId) {
                contactList.querySelector(`[data-idchat="${contact.chatId}"]`).classList.add('active');
            }

            console.log("Contacto: " + contact.name);
        });

        // Agregar evento de click a cada contacto para marcarlo como activo
        const contactItems = document.querySelectorAll('.btnChatProfile');

        contactItems.forEach(item => {
            item.addEventListener('click', function() {
                // Quitar la clase 'active' de todos los elementos
                contactItems.forEach(i => i.classList.remove('active'));

                // Añadir la clase 'active' al contacto seleccionado
                this.classList.add('active');

                // Actualizar el contacto activo
                activeContactId = this.getAttribute('data-idchat');
            });
        });
    }

    $(document).on('click', '.btnChatProfile', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        showPreloader();
        var idchat = $(this).attr("data-idchat");
        var numeroCliente = $(this).attr("data-numeroCliente");
        $("#recipient").val(numeroCliente);
        $("#recipient").html(numeroCliente);

        socket.send(JSON.stringify({ type: 'get_chat_history',chatId:idchat, phoneNumber: sessionPhoneNumber}));
    });


    // Enviar mensaje a través de la sesión de WhatsApp
    $('#sendMessageBtn').click(function() {
        if (sessionReady) {
            const message = $('#message').text().trim(); // Obtiene el mensaje del campo de texto
            const recipient = $('#recipient').val().trim(); // Obtiene el destinatario

            if (message && recipient) {
                // Enviar el mensaje a través del socket
                socket.send(JSON.stringify({
                    type: 'send_message',
                    phoneNumber: sessionPhoneNumber,
                    to: recipient,  // Número del destinatario
                    body: message
                }));

                // Crear el HTML para el mensaje enviado
                let messageHtml = `
            <div class="d-flex chat-message">
                <div class="d-flex mb-2 justify-content-end flex-1">
                    <div class="w-100 w-xxl-75">
                        <div class="d-flex flex-end-center hover-actions-trigger">
                            <div class="d-sm-none hover-actions align-self-center me-2 start-0">
                                <div class="bg-body-emphasis rounded-pill d-flex align-items-center border px-2 actions">
                                    <button class="btn p-2" type="button">
                                        <span class="fa-solid fa-reply text-primary"></span>
                                    </button>
                                    <button class="btn p-2" type="button">
                                        <span class="fa-solid fa-pen-to-square text-primary"></span>
                                    </button>
                                    <button class="btn p-2" type="button">
                                        <span class="fa-solid fa-trash text-primary"></span>
                                    </button>
                                    <button class="btn p-2" type="button">
                                        <span class="fa-solid fa-share text-primary"></span>
                                    </button>
                                    <button class="btn p-2" type="button">
                                        <span class="fa-solid fa-face-smile text-primary"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="d-none d-sm-flex">
                                <div class="hover-actions position-relative align-self-center">
                                    <button class="btn p-2 fs-10">
                                        <span class="fa-solid fa-reply text-primary"></span>
                                    </button>
                                    <button class="btn p-2 fs-10">
                                        <span class="fa-solid fa-pen-to-square text-primary"></span>
                                    </button>
                                    <button class="btn p-2 fs-10">
                                        <span class="fa-solid fa-share text-primary"></span>
                                    </button>
                                    <button class="btn p-2 fs-10">
                                        <span class="fa-solid fa-trash text-primary"></span>
                                    </button>
                                    <button class="btn p-2 fs-10">
                                        <span class="fa-solid fa-face-smile text-primary"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="chat-message-content me-2">
                                <div class="mb-1 sent-message-content bg-primary rounded-2 p-3 text-white" data-bs-theme="light">
                                    <p class="mb-0">${message}</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <p class="mb-0 fs-10 text-body-tertiary text-opacity-85 fw-semibold">${new Date().toLocaleString()}</p>
                        </div>
                    </div>
                </div>
            </div>`;

                // Agregar el mensaje al contenedor de mensajes
                $('#panelChat').append(messageHtml);
                socket.send(JSON.stringify({ type: 'get_active_chats', phoneNumber: sessionPhoneNumber}));
                // Limpiar el campo de mensaje y destinatario
                $('#message').text('');
                // Mostrar mensaje de éxito
                $('#message-result').text('Mensaje enviado con éxito');
                socket.send(JSON.stringify({ type: 'get_active_chats', phoneNumber: sessionPhoneNumber}));
                // Asegurarse de que el scroll se mueva hacia el final
                $('#panelChat').scrollTop($('#panelChat')[0].scrollHeight);
            } else {
                alert('Por favor ingresa tanto el número de destino como el mensaje.');
            }
        } else {
            alert('La sesión de WhatsApp no está lista aún.');
        }

    });
</script>
<script>
    // Mostrar el preloader con el mensaje
    function showPreloader(message = "Cargando, por favor espere...") {
        const preloaderElement = document.getElementById('preloader');
        const messageElement = document.getElementById('loadingMessage');

        // Mostrar el preloader y el mensaje
        preloaderElement.style.display = 'flex';
        messageElement.textContent = message;  // Establecer el mensaje dinámicamente
    }

    // Ocultar el preloader
    function hidePreloader() {
        document.getElementById('preloader').style.display = 'none';
    }
</script>