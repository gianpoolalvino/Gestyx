<script>
    $(document).ready(function() {
        $('.checkTipoTransportista').change(function() {
            var idtipoTransportista= $(this).val();
            TipoTransportista(idtipoTransportista)
        });
    });

    function TipoTransportista(idtipoTransportista)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/ChangeTransportista")?>",
            data: {
                idguiaRemision:'<?=$idguiaRemision?>',idtipoTransportista:idtipoTransportista
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#inputTipoTransportista").val(idtipoTransportista);
                $("#inputTipoTransportista").html(idtipoTransportista);
                $("#panelTransportista").html(dato.info);
                //  $("#tbodyEstablecimiento").html(dato.info);

            },
            error: function(xhr) {

            }
        });
    }


    $(document).on('click', '#btnProcesaTransport', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var inputTipoTransportista = $("#inputTipoTransportista").val();
        if(inputTipoTransportista==1){
            StorageTransportistaPublico();
        }else{
            StorageTransportista();
        }

    });

    function StorageTransportistaPublico()
    {
        var inputTipoTransportista = $("#inputTipoTransportista").val();
        var rucTransportista = $("#rucTransportista").val();
        var razonSocialTransportista = $("#razonSocialTransportista").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/SaveEditDelete/SaveTransportista")?>",
            data: {
                idguiaRemision:'<?=$idguiaRemision?>',
                inputTipoTransportista:inputTipoTransportista,
                rucTransportista:rucTransportista,
                razonSocialTransportista:razonSocialTransportista
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    ModalInfoVehiculo.hide();
                }
            },
            error: function(xhr) {

            }
        });
    }

    function StorageTransportista()
    {
        var inputTipoTransportista = $("#inputTipoTransportista").val();
        var rucTransportista = $("#rucTransportista").val();
        var razonSocialTransportista = $("#razonSocialTransportista").val();
        var idtipoDocumentoChofer = $("#tipoDocumentoChofer").val();
        var documentoChofer = $("#documentoChofer").val();
        var licenciaChofer = $("#licenciaChofer").val();
        var nombreChofer = $("#nombreChofer").val();
        var apellidoChofer = $("#apellidoChofer").val();
        var placaVehiculo = $("#placaVehiculo").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/SaveEditDelete/SaveTransportista")?>",
            data: {
                idguiaRemision:'<?=$idguiaRemision?>',
                inputTipoTransportista:inputTipoTransportista,
                rucTransportista:rucTransportista,
                razonSocialTransportista:razonSocialTransportista,
                idtipoDocumentoChofer:idtipoDocumentoChofer,
                documentoChofer:documentoChofer,
                licenciaChofer:licenciaChofer,
                nombreChofer:nombreChofer,
                apellidoChofer:apellidoChofer,
                placaVehiculo:placaVehiculo
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){
                    ModalInfoVehiculo.hide();
                }

                //  $("#tbodyEstablecimiento").html(dato.info);

            },
            error: function(xhr) {

            }
        });
    }
</script>