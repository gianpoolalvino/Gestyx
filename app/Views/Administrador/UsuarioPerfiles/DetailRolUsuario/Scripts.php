<script>
    $(document).on('click', '.btnOpcionRol', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idrol = $(this).attr("data-idrol");
        var idmodulo = $(this).attr("data-idmodulo");
        var opcion = $(this).attr("data-opcion");
        var idusuario = $(this).attr("data-idusuario");
        if(opcion=='delete'){
            DeleteRol(idrol);
        }else if(opcion=='subModulo'){
            SubModulo(idmodulo,idusuario);
        }
    });

    function SubModulo(idmodulo,idusuario)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/SubModulo")?>",
            data: {idmodulo:idmodulo,idusuario:idusuario},
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

    function DeleteRol(idrol)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/DeleteRol")?>",
            data: {idrol:idrol},
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