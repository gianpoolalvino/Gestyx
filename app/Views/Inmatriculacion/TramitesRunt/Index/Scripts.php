<script>

    $(document).on('click', '#btnCreateTramite', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateTramite();
    });

    function CreateTramite()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Inmatriculacion/TramitesRunt/CreateViewEdit/Create")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Interface...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>