<script>

    document.getElementById('telefonoCliente').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $("#formSave").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    location.reload();
                    ModalInfoVehiculo.hide();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });

    document.getElementById('btnSendVeri').addEventListener('click', ()=> {

        let numberClient=document.getElementById('telefonoCliente').value.trim();
        const welcomeCliente=document.getElementById('message').value.trim();

        if (!numberClient || !welcomeCliente) {
            Notificacion('warning', 'WhatsApp', 'Ingrese el número y el mensaje.');
            return;
        }

        window.open('https://wa.me/' + numberClient + '?text=' + encodeURIComponent(welcomeCliente), '_blank');
    });

</script>
