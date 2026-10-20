<script>
    $(document).ready(function() {
        // Limita la entrada a solo letras y números, y no más de 6 caracteres
        $('#placaRotativa').on('input', function() {
            var valor = $(this).val();
            // Filtra solo letras y números, y limita a 6 caracteres
            $(this).val(valor.replace(/[^a-zA-Z0-9]/g, '').slice(0, 6));
        });
    });

    $("#empresa").change(function(){
        selectGrupoUbicacion();
    });

    function selectGrupoUbicacion()
    {
        var empresa = $("#empresa").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Inmatriculacion/PlacasRotativas/CreateViewEdit/SelectRegion")?>",
            data: {empresa:empresa},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#region").html(dato.info);
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

</script>