<script>
    $(document).on('click', '#btnCreatePlaca', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreatePlaca();
    });

    function CreatePlaca()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Inmatriculacion/PlacasRotativas/CreateViewEdit/Create")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Interface...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    $(document).on('click', '.btnOpcPlaca', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idplacaRotativa = $(this).attr("data-idplacaRotativa");
        EditarPlaca(idplacaRotativa);
    });

    function EditarPlaca(idplacaRotativa)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Inmatriculacion/PlacasRotativas/CreateViewEdit/ViewEdit")?>",
            data: {idplacaRotativa:idplacaRotativa},
            beforeSend: function() {
                Preloader("Cargando Interface...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

</script>