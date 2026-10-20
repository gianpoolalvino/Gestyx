<script>

    $('#marcaCreate').change(function() {
        var marcaCreate = $(this).val();

    });




    $('#tipoCreacion').change(function() {
        var selectedValue = $(this).val();
       if(selectedValue=='qr'){
            $("#panelCamera").css("display","block");
            $("#panelManual").css("display","none");
       }else if(selectedValue=='manual'){
           $("#panelManual").css("display","block");
           $("#panelCamera").css("display","none");
       }
    });

    $(document).on('click', '#btnVerifiVin', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var vin = $("#vinVerifica").val().trim();
        if (vin.length !== 17) {
            Notificacion("danger","Error en Vin","En Vin debe contener 17 digitos alfanumericos");
            return;
        }
        VinValidaa(vin);
    });

    function VinValidaa(vin){
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/ValidarVin")?>",
            data: {vin:vin},
            beforeSend: function() {
                Preloader("Buscando Vehiculo...<br>No cambie de ventana... :)");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                $("#vinValidado").val(vin);
                $("#vinValidado").html(vin);
                $("#btnProcessCrea").attr("disabled",false);
            },
            error: function(xhr) {

            }
        });
    }

</script>



<script type="text/javascript">
    let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });

    // Ya no escuchamos el evento 'scan'
    // scanner.addListener('scan', function (content) { ... }); // <== eliminado

    Instascan.Camera.getCameras().then(function (cameras) {
        const select = document.getElementById('camerasSelect');

        if (cameras.length > 0) {
            cameras.forEach(function(camera, index) {
                let option = document.createElement('option');
                option.value = index;
                option.text = camera.name || `Cámara ${index + 1}`;
                select.appendChild(option);
            });

            // Escuchar cambio de cámara
            select.addEventListener('change', function() {
                const selectedIndex = parseInt(select.value);
                if (!isNaN(selectedIndex)) {
                    scanner.start(cameras[selectedIndex]).then(() => {
                        let videoElement = document.getElementById('preview');
                        videoElement.style.transform = 'rotate(0deg)';
                        videoElement.style.width = '100%';
                        videoElement.style.height = 'auto';
                    }).catch(function (e) {
                        console.error("Error al iniciar cámara: ", e);
                    });
                }
            });

            // Opcional: seleccionar la primera por defecto
            if (select.value === "") {
                select.value = "0";
                select.dispatchEvent(new Event("change"));
            }
        } else {
            console.error('No se encontraron cámaras.');
        }
    }).catch(function (e) {
        console.error('Error al obtener cámaras:', e);
    });

    $('#btnVolverCapture').on('click', function () {
        $("#previewPanelCapture").css("display","none");
        $("#capturePanel").css("display","block");
    });

    // Capturar imagen del video cuando se presione el botón
    $('#btnCapture').on('click', function () {
        const video = document.getElementById('preview');
        const canvas = document.getElementById('snapshot');
        const hiddenInput = $('#capturedImage');

        const width = video.videoWidth;
        const height = video.videoHeight;

        if (width === 0 || height === 0) {
            alert("La cámara aún no está lista.");
            return;
        }

        // Dibujar imagen en canvas
        canvas.width = width;
        canvas.height = height;

        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, width, height);

        // Obtener imagen en base64
        const imageData = canvas.toDataURL('image/png');
        hiddenInput.val(imageData);

        // Mostrar preview opcional
        $('#previewImg').attr('src', imageData).show();
        $("#previewPanelCapture").css("display","block");
        $("#capturePanel").css("display","none");
    });

</script>
<script>
    $("#formCreadoGestyx").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                Preloader("Cargando Data....");
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=='success'){
                    location.reload();
                }
            },
            error: function (xhr) {
                $("#btnValidarAccesos").attr("disabled", false);
            }
        });
        return false;
    });
</script>