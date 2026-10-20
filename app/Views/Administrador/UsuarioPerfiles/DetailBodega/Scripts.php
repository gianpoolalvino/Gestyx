<script>
    $(document).on('click', '.btnOpcionBodg', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idusuarioBodega = $(this).attr("data-idusuarioBodega");
        var opcion = $(this).attr("data-opcion");
        if(opcion=='delete'){
            DeleteRol(idusuarioBodega);
        }
    });

    function DeleteRol(idusuarioBodega)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/DeleteBodega")?>",
            data: {idusuarioBodega:idusuarioBodega},
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