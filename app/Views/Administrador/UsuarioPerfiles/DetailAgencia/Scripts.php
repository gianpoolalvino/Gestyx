

<script>
    $(document).on('click', '.btnOpcionAgen', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idusuarioSede = $(this).attr("data-idusuarioSede");
        var opcion = $(this).attr("data-opcion");
        if(opcion=='delete'){
            DeleteRol(idusuarioSede);
        }
    });

    function DeleteRol(idusuarioSede)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/DeleteAgencia")?>",
            data: {idusuarioSede:idusuarioSede},
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