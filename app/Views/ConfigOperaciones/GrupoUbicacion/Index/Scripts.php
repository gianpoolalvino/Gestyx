<script>
    $(document).on('click', '#btnCreateGrupoUbi', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateGrupoUbicacion();
    });

    function CreateGrupoUbicacion()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/GrupoUbicacion/CreateViewEdit/CreateGrupoUbicacion")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalOpcionesRegla.show();
                    $("#BodyOpcionesRegla").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndex();
    });

    function DetailIndex()
    {
        var filtro = $("#filtro").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/GrupoUbicacion/Index/DetailIndex")?>",
            data: {filtro:filtro},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    $("#tbodyGestionar").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    $(document).on('click', '#btnAddUbicacion', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateUbicacion();
    });

    $(document).on('click', '#btnAddBoxUbicacion', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateBoxUbicacion();
    });

    $(document).on('click', '.btnOpcGrupo', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var opcion = $(this).attr("data-opcion");
        var idgrupoUbicacion = $(this).attr("data-idgrupoUbicacion");

        if(opcion=="add"){
            ViewGrupoUbicacion(idgrupoUbicacion);
        }else if(opcion=="edit"){
            EditGrupo(idgrupoUbicacion);
        }else if(opcion=="delete"){
            // Mostrar el cuadro de confirmación con Alertify
            //  alertify.set('title', 'Confirmación de operación');
            alertify.confirm("Confirmacion de Operacion","¿Estás seguro de que deseas iniciar el grupo de reglas?",
                function() {
                    // Si el usuario hace clic en "Aceptar", ejecutar la función
                    DeleteGrupoUbicacion(idgrupoUbicacion);
                },
                function() {
                    // Si el usuario hace clic en "Cancelar", no hacer nada
                    alertify.error('Operación cancelada');
                }
            ).set('labels', {ok: 'Aceptar', cancel: 'Cancelar'});
        }
    });


    $(document).on('click', '.btnOpcGrupo', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var opcion = $(this).attr("data-opcion");
        var idgrupoUbicacion = $(this).attr("data-idgrupoUbicacion");

        if(opcion=="add"){
            ViewGrupoUbicacion(idgrupoUbicacion);
        }else if(opcion=="edit"){
            EditGrupo(idgrupoUbicacion);
        }else if(opcion=="delete"){
            // Mostrar el cuadro de confirmación con Alertify
            //  alertify.set('title', 'Confirmación de operación');
            alertify.confirm("Confirmacion de Operacion","¿Estás seguro de que deseas iniciar el grupo de reglas?",
                function() {
                    // Si el usuario hace clic en "Aceptar", ejecutar la función
                    DeleteGrupoUbicacion(idgrupoUbicacion);
                },
                function() {
                    // Si el usuario hace clic en "Cancelar", no hacer nada
                    alertify.error('Operación cancelada');
                }
            ).set('labels', {ok: 'Aceptar', cancel: 'Cancelar'});
        }
    });

    function DeleteGrupoUbicacion()
    {

    }

    function ViewGrupoUbicacion(idgrupoUbicacion)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/GrupoUbicacion/CreateViewEdit/ViewGrupoUbicacion")?>",
            data: {idgrupoUbicacion:idgrupoUbicacion},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalInfoCondiciones.show();
                    $("#BodyInfoCondiciones").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    function EditGrupo(idgrupoUbicacion)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/GrupoUbicacion/CreateViewEdit/EditGrupoUbicacion")?>",
            data: {idgrupoUbicacion:idgrupoUbicacion},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalOpcionesRegla.show();
                    $("#BodyOpcionesRegla").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    $(document).on('click', '.btnOpcBxUb', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var opcion = $(this).attr("data-opcion");
        var idboxUbicacion = $(this).attr("data-idboxUbicacion");
        var idubicacion = $(this).attr("data-idubicacion");
        if(opcion=="edit"){
            EditBoxUbicacion(idboxUbicacion);
        }else if(opcion=="delete"){
            // Mostrar el cuadro de confirmación con Alertify
            //  alertify.set('title', 'Confirmación de operación');
            alertify.confirm("Confirmacion de Operacion","¿Estás seguro de que deseas iniciar el grupo de reglas?",
                function() {
                    // Si el usuario hace clic en "Aceptar", ejecutar la función
                    DeleteBoxUbicacion(idboxUbicacion,idubicacion);
                },
                function() {
                    // Si el usuario hace clic en "Cancelar", no hacer nada
                    alertify.error('Operación cancelada');
                }
            ).set('labels', {ok: 'Aceptar', cancel: 'Cancelar'});
        }
    });

    $(document).on('click', '.btnOpcUbi', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var opcion = $(this).attr("data-opcion");
        var idubicacion = $(this).attr("data-idubicacion");

        if(opcion=="view"){
            ViewUbicacion(idubicacion);
        }else if(opcion=="edit"){
            EditUbicacion(idubicacion);
        }else if(opcion=="delete"){
            // Mostrar el cuadro de confirmación con Alertify
            //  alertify.set('title', 'Confirmación de operación');
            alertify.confirm("Confirmacion de Operacion","¿Estás seguro de que deseas iniciar el grupo de reglas?",
                function() {
                    // Si el usuario hace clic en "Aceptar", ejecutar la función
                    DeleteUbicacion(idubicacion);
                },
                function() {
                    // Si el usuario hace clic en "Cancelar", no hacer nada
                    alertify.error('Operación cancelada');
                }
            ).set('labels', {ok: 'Aceptar', cancel: 'Cancelar'});
        }
    });

    function ViewUbicacion(idubicacion)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/GrupoUbicacion/CreateViewEdit/ViewUbicacion")?>",
            data: {idubicacion:idubicacion},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    $("#tbodyBox").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    function EditUbicacion(idubicacion)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/GrupoUbicacion/CreateViewEdit/EditUbicacion")?>",
            data: {idubicacion:idubicacion},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalOpcionesRegla.show();
                    $("#BodyOpcionesRegla").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    function DeleteUbicacion(idubicacion)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/GrupoUbicacion/SaveEditDelete/DeleteUbicacion")?>",
            data: {idubicacion:idubicacion},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    DetailIndexUbicacion();
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    function DetailIndexUbicacion()
    {
        var idgrupoUbicacion = $("#idgrupoUbicacionGeneralView").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/GrupoUbicacion/CreateViewEdit/DetailIndexUbicacion")?>",
            data: {idgrupoUbicacion:idgrupoUbicacion},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    $("#tbodyUbicacion").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    function EditBoxUbicacion(idboxUbicacion)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/GrupoUbicacion/CreateViewEdit/EditBoxUbicacion")?>",
            data: {idboxUbicacion:idboxUbicacion},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalOpcionesRegla.show();
                    $("#BodyOpcionesRegla").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    function DeleteBoxUbicacion(idboxUbicacion,idubicacion)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/GrupoUbicacion/SaveEditDelete/DeleteBoxUbicacion")?>",
            data: {idboxUbicacion:idboxUbicacion},
            beforeSend: function() {
                Preloader("Cargando Interface...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                   ViewUbicacion(idubicacion);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    function CreateUbicacion()
    {
        var idgrupoUbicacion = $("#idgrupoUbicacionGeneralView").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/GrupoUbicacion/CreateViewEdit/CreateUbicacion")?>",
            data: {idgrupoUbicacion:idgrupoUbicacion},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalOpcionesRegla.show();
                    $("#BodyOpcionesRegla").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    function CreateBoxUbicacion()
    {
        var idgrupoUbicacion = $("#idgrupoUbicacionGeneralView").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/GrupoUbicacion/CreateViewEdit/CreateBoxUbicacion")?>",
            data: {idgrupoUbicacion:idgrupoUbicacion},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=="success"){
                    ModalOpcionesRegla.show();
                    $("#BodyOpcionesRegla").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }
</script>