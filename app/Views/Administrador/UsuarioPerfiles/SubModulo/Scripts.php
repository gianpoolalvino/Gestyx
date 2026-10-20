<script>
    $(document).ready(function() {
        $('.subModAdd').change(function () {
            var checkSubMod = '';
            var idusuario = $(this).attr("data-idusuario");
            var idsubModulo = $(this).attr("data-idsubModulo");
            if ($(this).is(':checked')) {
                // Checkbox está marcado
                checkSubMod = 1;
                CheckSubModulo(checkSubMod,idusuario,idsubModulo);
            } else {
                // Checkbox está desmarcado
                checkSubMod = 2;
                CheckSubModulo(checkSubMod,idusuario,idsubModulo);
            }
        });

        function CheckSubModulo(checkSubMod,idusuario,idsubModulo)
        {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url("Administrador/UsuarioPerfiles/SaveEditDelete/CheckSubModulo")?>",
                data: {idusuario:idusuario,checkSubMod:checkSubMod,idsubModulo:idsubModulo},
                beforeSend: function() {
                    Preloader("Cargando Datos<br>Espere un momento...")
                },
                success: function(data) {
                    let dato = $.parseJSON(data);
                    ClosePreloader();
                    if(dato.status=="success"){
                        Notificacion(dato.status,dato.title,dato.message);
                    }else{
                        Notificacion(dato.status,dato.title,dato.message);
                    }
                },
                error: function(xhr) {

                }
            });
        }
    });
</script>