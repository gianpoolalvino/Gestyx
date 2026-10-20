<script type="text/javascript">
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

    scanner.addListener('scan', function (content) {
        // Dividir el contenido usando el guion (-)
        let dataArray = content;

        // Asegurarse de que se tienen 3 elementos

            let vin = dataArray; // 3GCUD9ED8PG330349


                // Crear un formulario HTML de manera dinámica
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?php echo base_url('VinAdministrador/Operaciones')?>'; // Aquí coloca la URL de destino
                // Agregar los campos necesarios al formulario
                let inputVin = document.createElement('input');
                inputVin.type = 'hidden';
                inputVin.name = 'vin';
                inputVin.value = vin;
                form.appendChild(inputVin);
                // Enviar el formulario
                document.body.appendChild(form);
                form.submit();

    });

    // Obtener las cámaras disponibles
    Instascan.Camera.getCameras().then(function (cameras) {
        const select = document.getElementById('camerasSelect');

        if (cameras.length > 0) {
            // Si hay cámaras, agregar opciones al select
            cameras.forEach(function(camera, index) {
                let option = document.createElement('option');
                option.value = index; // Usar el índice de la cámara
                option.text = camera.name; // Usar el nombre de la cámara
                select.appendChild(option);
            });

            // Iniciar el escaneo con la cámara seleccionada
            select.addEventListener('change', function() {
                const selectedIndex = select.value;
                if (selectedIndex !== "") {
                    scanner.start(cameras[selectedIndex]).then(() => {
                        let videoElement = document.getElementById('preview');
                        videoElement.style.transform = 'rotate(0deg)'; // Asegurarse que no esté rotado
                        videoElement.style.width = '100%';  // Controla el tamaño del video
                        videoElement.style.height = 'auto';  // Controla el tamaño del video
                    }).catch(function (e) {
                        console.error(e);
                    });
                }
            });
        } else {
            console.error('No se encontraron cámaras.');
        }
    }).catch(function (e) {
        console.error(e);
    });
</script>