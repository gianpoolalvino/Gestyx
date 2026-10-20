<script>
    $(document).ready(function() {
        $('.checkDestinata').change(function() {
            var tipoDestinatario = $(this).val();
            TipoDestinatario(tipoDestinatario)
        });
    });

    function TipoDestinatario(tipoDestinatario)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/ChangeDestinatario")?>",
            data: {
                idguiaRemision:'<?php echo $idguiaRemision?>',tipoDestinatario:tipoDestinatario,idempresa:'<?=$idempresa?>'
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#tableDestinatario").html(dato.info);
                $("#btnAddDest").prop("disabled",dato.button);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnAddDest', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateDestinatario();
    });

    function CreateDestinatario()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/CreateDestinatario")?>",
            data: {idguiaRemision:'<?=$idguiaRemision?>'},
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>