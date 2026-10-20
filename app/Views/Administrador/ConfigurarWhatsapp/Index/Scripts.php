<script>
    $(document).on('click', '.btnSessionWhatsapp', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idsessionWhatsapp=$(this).attr("data-idsessionWhatsapp");
        var opcion = $(this).attr("data-opcion");
        if(opcion==='escan'){
            ViewQr(idsessionWhatsapp);
        }else if(opcion==='delete'){

        }else if(opcion==='associate'){
            AsociarAgente(idsessionWhatsapp);
        }

    });

    function AsociarAgente(idsessionWhatsapp)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/ConfigurarWhatsapp/CreateViewEdit/AsociarAgente")?>",
            data: {idsessionWhatsapp:idsessionWhatsapp},
            beforeSend: function() {
                Preloader("Cargando Interface...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    function ViewQr(idsessionWhatsapp)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/ConfigurarWhatsapp/CreateViewEdit/ViewQr")?>",
            data: {idsessionWhatsapp:idsessionWhatsapp},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }



    $(document).on('click', '#btnNewWhatsapp', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        NuevoWhatsapp()
    });
    function NuevoWhatsapp()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/ConfigurarWhatsapp/CreateViewEdit/Create")?>",
            data: {},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>
<script>
    // Variables globales
    let socketQr;
    let sessionPhoneNumber;
    let tokenSession;
    let isQrRequested = false; // Variable para controlar si ya se ha solicitado un QR
</script>
