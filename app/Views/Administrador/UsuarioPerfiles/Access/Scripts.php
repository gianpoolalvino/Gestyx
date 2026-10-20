<script>
    $(document).on('click', '#btnProcesarClon', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        if (confirm("Este proceso eliminará los perfiles del usuario y generara nuevos basado en la duplicacion del usuario origen")) {
           // ClosePreloader();
            ClonarPerfiles()
        } else {
            // Desmarcar el checkbox si se cancela
         //   $(this).prop('checked', false);
         //   ClosePreloader();
        }
    });

    $(document).on('click', '#btnAddTipoSo', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idusuario = $("#idusSoli").val();
        var idtipoSolicitud = $("#idtipoSoli").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/SaveEditDelete/SaveTipoSolicitud")?>",
            data: {idusuario:idusuario,idtipoSolicitud:idtipoSolicitud},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                    DetailIndexTipoSolicitud();
            },
            error: function(xhr) {

            }
        });
    });

    $(document).on('click', '.btnDeletTipoSo', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idtipoSolicitudUsuario = $(this).attr("data-idtipoSolicitudUsuario");
        if (confirm("Este proceso eliminará los perfiles del usuario y generara nuevos basado en la duplicacion del usuario origen")) {
            // ClosePreloader();
            DeleteTipoSolicitud(idtipoSolicitudUsuario);
        } else {
            // Desmarcar el checkbox si se cancela
            //   $(this).prop('checked', false);
            //   ClosePreloader();
        }
    });

    function DeleteTipoSolicitud(idtipoSolicitudUsuario)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/SaveEditDelete/DeleteTipoSolicitudUsuario")?>",
            data: {idtipoSolicitudUsuario:idtipoSolicitudUsuario},
            beforeSend: function() {
                Preloader("Borrando...<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                DetailIndexTipoSolicitud();
            },
            error: function(xhr) {

            }
        });
    }


    function DetailIndexTipoSolicitud()
    {
        var idusuario = $("#idusSoli").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/DetailTipoSolicitud")?>",
            data: {idusuario:idusuario},
            beforeSend: function() {
                Preloader("Cargando Datos<br>Espere un momento...");
            },
            success: function(data) {
                var dato = $.parseJSON(data);
                $("#tbodyTipoSol").html(dato.info);
                ClosePreloader();
               // $("#tbodyTipoSolicitudes").html('');
                Notificacion(dato.status,dato.title,dato.message);

            },
            error: function(xhr) {

            }
        });
    }



    function ClonarPerfiles()
    {
        var idusuarioDestino=$("#idusuarioGen").val();
        var idusuarioOrigen=$("#selectDuplicarPerfil").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/SaveEditDelete/DuplicarPerfiles")?>",
            data: {idusuarioDestino:idusuarioDestino,idusuarioOrigen:idusuarioOrigen},
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



    $(document).ready(function() {
        $('#checkAsesorEntrega').change(function() {
            var checkAsesor='';
            if ($(this).is(':checked')) {
                // Checkbox está marcado
                checkAsesor=1;
                CheckAsesorEntrega(checkAsesor);
            } else {
                // Checkbox está desmarcado
                checkAsesor=2;
                CheckAsesorEntrega(checkAsesor);
            }
        });

        $('#checkGestorVehicular').change(function() {
            var checkAsesor='';
            if ($(this).is(':checked')) {
                // Checkbox está marcado
                checkSolicitud=1;
                CheckGestorSolicitudVehiculo(checkSolicitud);
            } else {
                // Checkbox está desmarcado
                checkSolicitud=2;
                CheckGestorSolicitudVehiculo(checkSolicitud);
            }
        });

        function CheckGestorSolicitudVehiculo(checkSolicitud){
            var idusuario = $("#idusuarioGen").val();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url("Administrador/UsuarioPerfiles/SaveEditDelete/CheckGestorSolicitud")?>",
                data: {idusuario:idusuario,checkSolicitud:checkSolicitud},
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

        $('#checkAuditoria').change(function() {
            var checkAsesor='';
            if ($(this).is(':checked')) {
                // Checkbox está marcado
                checkAudit=1;
                CheckAuditoriaVehicular(checkAudit);
            } else {
                // Checkbox está desmarcado
                checkAudit=2;
                CheckAuditoriaVehicular(checkAudit);
            }
        });

        function CheckAuditoriaVehicular(checkAudit){
            var idusuario = $("#idusuarioGen").val();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url("Administrador/UsuarioPerfiles/SaveEditDelete/CheckAuditoriaUsuario")?>",
                data: {idusuario:idusuario,checkAudit:checkAudit},
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

        function CheckAsesorEntrega(checkAsesor) {
            // Aquí va la lógica para habilitar funciones de Asesor
            var idusuario = $("#idusuarioGen").val();
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url("Administrador/UsuarioPerfiles/SaveEditDelete/CheckAsesorEntrega")?>",
                data: {idusuario:idusuario,checkAsesor:checkAsesor},
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



    $(document).on('click', '#btnLogOut', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idusuario = $("#idusuarioGen").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/LogOutRemoto")?>",
            data: {idusuario:idusuario},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalOpcionesAdicionales.show();
                    $("#BodyOpcionesAdicionales").html(dato.info);
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }
            },
            error: function(xhr) {

            }
        });
    });


    $(document).on('click', '#btnAddModulo', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idusuario = $("#idusGmdMd").val();
        var idgrupoModulo = $("#idgrupoModuloUs").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/AsociarModulo")?>",
            data: {idusuario:idusuario,idgrupoModulo:idgrupoModulo},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalOpcionesAdicionales.show();
                    $("#BodyOpcionesAdicionales").html(dato.info);
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }
            },
            error: function(xhr) {

            }
        });
    });

    $(document).on('click', '#btnAddBodega', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idusuario = $("#idusEmpAg").val();
        var idempresa = $("#idselectBodegaUs").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/AsociarBodega")?>",
            data: {idusuario:idusuario,idempresa:idempresa},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalOpcionesAdicionales.show();
                    $("#BodyOpcionesAdicionales").html(dato.info);
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }
            },
            error: function(xhr) {

            }
        });
    });

    $(document).on('click', '#btnAddUbicacion', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idusuario = $("#idusEmpAg").val();
        var idempresa = $("#idselectUbicacionUs").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/AsociarUbicacion")?>",
            data: {idusuario:idusuario,idempresa:idempresa},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalOpcionesAdicionales.show();
                    $("#BodyOpcionesAdicionales").html(dato.info);
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }
            },
            error: function(xhr) {

            }
        });
    });

    $(document).on('click', '#btnAddSede', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idusuario = $("#idusEmpAg").val();
        var idempresa = $("#idselectEmpresaAg").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/AsociarAgencia")?>",
            data: {idusuario:idusuario,idempresa:idempresa},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalOpcionesAdicionales.show();
                    $("#BodyOpcionesAdicionales").html(dato.info);
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }
            },
            error: function(xhr) {

            }
        });
    });

    $("#idselectEmpresaAg").change(function(){
        DetailAgencia();
    });

    $("#idgrupoModuloUs").change(function(){
        DetailRol();
    });

    $("#idselectBodegaUs").change(function(){
        DetailBodega();
    });

    $("#idselectUbicacionUs").change(function(){
        DetailUbicacion();
    });

    function DetailUbicacion()
    {
        var idempresa = $("#idselectUbicacionUs").val();
        var idusuario = '<?=$idusuario?>';
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/DetailUsuarioUbicacion")?>",
            data: {idusuario:idusuario,idempresa:idempresa},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    $("#tbodyUbicacion").html(dato.info);
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }
            },
            error: function(xhr) {

            }
        });
    }



    function DetailBodega()
    {
        var idempresa = $("#idselectBodegaUs").val();
        var idusuario = '<?=$idusuario?>';
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/DetailUsuarioBodega")?>",
            data: {idusuario:idusuario,idempresa:idempresa},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    $("#tbodyBodega").html(dato.info);
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }
            },
            error: function(xhr) {

            }
        });
    }



    function DetailRol()
    {
        var idgrupoModulo = $("#idgrupoModuloUs").val();
        var idusuario = '<?=$idusuario?>';
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/DetailRolUsuario")?>",
            data: {idusuario:idusuario,idgrupoModulo:idgrupoModulo},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    $("#tbodyModulo").html(dato.info);
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }
            },
            error: function(xhr) {

            }
        });
    }

    function DetailAgencia()
    {
        var idempresa = $("#idselectEmpresaAg").val();
        var idusuario = '<?=$idusuario?>';
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Administrador/UsuarioPerfiles/CreateViewEdit/DetailUsuarioAgencia")?>",
            data: {idusuario:idusuario,idempresa:idempresa},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    $("#tbodyAgencia").html(dato.info);
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }
            },
            error: function(xhr) {

            }
        });
    }

</script>