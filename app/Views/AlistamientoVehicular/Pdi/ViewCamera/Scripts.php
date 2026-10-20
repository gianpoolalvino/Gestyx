<script type="text/javascript">
    $(document).on('click', '#btnVolverCapture', function () {
        $("#previewPanelCapture").hide();
        $("#capturePanel").show();
        $("#btnProcessCrea").attr("disabled",true);
    });

    $(document).on('click', '#btnCapture', function () {
        const video = document.getElementById('preview');
        const canvas = document.getElementById('snapshot');
        const hiddenInput = $('#capturedImage');

        const width = video.videoWidth;
        const height = video.videoHeight;

        if (width === 0 || height === 0) {
            alert("La cámara aún no está lista.");
            return;
        }

        canvas.width = width;
        canvas.height = height;
        const ctx = canvas.getContext('2d');

        // Detectar si el video tiene espejo horizontal
        const isMirrored = getComputedStyle(video).transform.includes('matrix(-1');

        if (isMirrored) {
            // Aplica espejo en canvas
            ctx.translate(width, 0);
            ctx.scale(-1, 1);
        }

        ctx.drawImage(video, 0, 0, width, height);

        const imageData = canvas.toDataURL('image/png');
        hiddenInput.val(imageData);

        $('#previewImg').attr('src', imageData).show();
        $("#previewPanelCapture").show();
        $("#capturePanel").hide();
        $("#btnProcessCrea").attr("disabled", false);
    });
</script>

<script>
    $("#formCameraPdi").bind("submit", function () {
        var idgrupoCheckList = $("#grupoCheckIdPdi").val();
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
                    ModalAdicionales.hide();
                    PanelCheckList(idgrupoCheckList);
                }
            },
            error: function (xhr) {
                $("#btnValidarAccesos").attr("disabled", false);
            }
        });
        return false;
    });
</script>