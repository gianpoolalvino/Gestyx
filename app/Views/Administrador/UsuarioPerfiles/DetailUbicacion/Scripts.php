<script>
    $(document).on('click', '.btnOpcionUbic', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idusuarioGrupoUbicacion = $(this).attr("data-idusuarioGrupoUbicacion");
        var opcion = $(this).attr("data-opcion");
        if(opcion=='delete'){
            DeleteUbi(idusuarioGrupoUbicacion);
        }
    });

    function DeleteUbi(idusuarioGrupoUbicacion)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/DeleteUbicacion")?>",
            data: {idusuarioGrupoUbicacion:idusuarioGrupoUbicacion},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalOpcionesAdicionales.show();
                    $("#BodyOpcionesAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }
</script>