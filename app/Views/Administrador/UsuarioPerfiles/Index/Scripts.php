<script>
    $(document).on('click', '.btnOpcionUser', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idusuario = $(this).attr("data-idusuario");
        var opcion = $(this).attr("data-opcion");

        if(opcion=='edit'){
            ViewUsuario(idusuario);
        }else if(opcion=='access'){
            Access(idusuario);
        }else if(opcion=='delete'){
            alertify.confirm("Confirmacion de Operacion","¿Estás seguro de que deseas deshabilitar el usuario?",
                function() {
                    // Si el usuario hace clic en "Aceptar", ejecutar la función
                    DeshabilitarUsuario(idusuario);
                },
                function() {
                    // Si el usuario hace clic en "Cancelar", no hacer nada
                    alertify.error('Operación cancelada');
                }
            ).set('labels', {ok: 'Aceptar', cancel: 'Cancelar'});
        }else if(opcion=='password'){
            Password(idusuario);
        }else if(opcion=='send'){
            SendMail(idusuario);
        }
    });

    function SendMail(idusuario)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/SendMailCorreo")?>",
            data: {idusuario:idusuario},
            beforeSend: function() {
                Preloader("Enviando Correo<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnNewIngreso', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateUser();
    });

    function CreateUser()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/CreateUsuario")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalInfoVehiculo.show();
                    $("#bodyInfoVehicular").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }



    function Password(idusuario)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/Password")?>",
            data: {idusuario:idusuario},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }


    function Access(idusuario)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/Access")?>",
            data: {idusuario:idusuario},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalInfoVehiculo.show();
                    $("#bodyInfoVehicular").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }

    $(document).ready(function() {
        // Capturar las pulsaciones de teclado en el campo de búsqueda
        $('#filtro').on('keyup', function() {
            DetailIndex();
        });
    });

    function DetailIndex()
    {
        var filtro = $("#filtro").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/Index/DetailIndex")?>",
            data: {filtro:filtro},
            beforeSend: function() {
                //Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    $("#tbodyAlistamiento").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }



    function DeshabilitarUsuario(idusuario)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/SaveEditDelete/DeshabilitarUsuario")?>",
            data: {idusuario:idusuario},
            beforeSend: function() {
                Preloader('Enviando datos...');
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                location.reload();
                Notificacion(dato.status,dato.title,dato.message);
            },
            error: function(xhr) {

            }
        });
    }
</script>
