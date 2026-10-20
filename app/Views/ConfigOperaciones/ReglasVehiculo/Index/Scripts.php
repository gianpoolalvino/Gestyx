<script>
    $(document).on('click', '#btnCreateRegla', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        ViewCreateRegla()
    });


    function ViewCreateRegla()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/ReglasVehiculo/CreateViewEdit/CreateGrupo")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    $(document).on('click', '.btnOpcRegla', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var opcion = $(this).attr("data-opcion");
        var idgrupoRegla = $(this).attr("data-idgrupoRegla");

        if(opcion=="addRegla"){
            CreateReglaChild(idgrupoRegla);
        }else if(opcion=="viewReglas"){
            DetailReglas(idgrupoRegla);
        }else if(opcion=="play"){
            // Mostrar el cuadro de confirmación con Alertify
            //  alertify.set('title', 'Confirmación de operación');
            alertify.confirm("Confirmacion de Operacion","¿Estás seguro de que deseas iniciar el grupo de reglas?",
                function() {
                    // Si el usuario hace clic en "Aceptar", ejecutar la función
                    StartGrupoRegla(idgrupoRegla);
                },
                function() {
                    // Si el usuario hace clic en "Cancelar", no hacer nada
                    alertify.error('Operación cancelada');
                }
            ).set('labels', {ok: 'Aceptar', cancel: 'Cancelar'});
        }
    });

    function StartGrupoRegla(idgrupoRegla)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/ReglasVehiculo/SaveEditDelete/PlayGrupo")?>",
            data: {idgrupoRegla:idgrupoRegla},
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

    function DetailReglas(idgrupoRegla)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/ReglasVehiculo/CreateViewEdit/ViewGrupoRegla")?>",
            data: {idgrupoRegla:idgrupoRegla},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    function CreateReglaChild(idgrupoRegla)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/ReglasVehiculo/CreateViewEdit/Create")?>",
            data: {idgrupoRegla:idgrupoRegla},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    ModalInfoCondiciones.show();
                    $("#BodyInfoCondiciones").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    $(document).on('click', '#btnAddCondicion', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idreglaVehiculo = $("#idreglaVehiculo").val();
        CreateCondiciones(idreglaVehiculo)
    });



    function CreateCondiciones(idreglaVehiculo)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/ReglasVehiculo/CreateViewEdit/CreateCondicion")?>",
            data: {idreglaVehiculo:idreglaVehiculo},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
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

<script>
    $(document).on('click', '.btnOpcReglaVe', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var opcion = $(this).attr("data-opcion");
        var idreglaVehiculo = $(this).attr("data-idreglaVehiculo");

        if(opcion=="ViewCondicion"){
            ViewDetailRegla(idreglaVehiculo);
        }else if(opcion=="viewReglas"){

        }
    });

    function ViewDetailRegla(idreglaVehiculo)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/ReglasVehiculo/CreateViewEdit/ViewRegla")?>",
            data: {idreglaVehiculo:idreglaVehiculo},
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    ModalInfoCondiciones.show();
                    $("#BodyInfoCondiciones").html(dato.info);
                }
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }
</script>
<script>
    $(document).on('click', '#btnStartGestion', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

    });
</script>
