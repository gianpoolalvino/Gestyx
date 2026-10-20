<script>
    $(document).on('click', '#btnNewTraslado', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateTraslado();
    });

    function CreateTraslado()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/Create")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalGuiaRemision.show();
                $("#BodyGuiaRemision").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>