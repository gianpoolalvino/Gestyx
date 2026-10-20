<script>
    //funcion que permite visualizar los paneles para condicones siempre que sean didferentes de 1
    $(document).on('change', '#tipoRegla', function() {
        let tipoRegla = $(this).val();
        if(tipoRegla==1){
            $("#panelCondiciones").css("display","none");
        }else{
            $("#panelCondiciones").css("display","block");
        }
    });

    //funcion que muestra las condiciones de las reglas
    function DetailCreateRegla()
    {
        var idreglaVehiculo = $("#idreglaVehiculo").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/ReglasVehiculo/CreateViewEdit/DetailCondiciones")?>",
            data: {
                idreglaVehiculo:idreglaVehiculo,
            },
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#tbodyTare").html(dato.info);
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

    //Funcion que almacena las condiciones de cada regla
    $(document).on('click', '#btnSaveCondicion', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idreglaVehiculo = $("#idreglaVehiculo").val();
        var operadorRegla = $("#operadorRegla").val();
        var valorRegla = $("#valorRegla").val();
        var diasRegla = $("#diasRegla").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/ReglasVehiculo/SaveEditDelete/SaveCondicional")?>",
            data: {
                idreglaVehiculo:idreglaVehiculo,
                operadorRegla:operadorRegla,
                valorRegla:valorRegla,
                diasRegla:diasRegla
            },
            beforeSend: function() {
                Preloader("Cargando Interface...")
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                DetailCreateRegla();
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    });

    $("#formSaveRegla").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            beforeSend: function () {
                Preloader('Grabando Regla...');
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    Notificacion(dato.status,dato.title,dato.message);
                    ModalInfoCondiciones.hide();
                    DetalleReglas();
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }
            },
            error: function (xhr) {
                $("#btnValidarAccesos").attr("disabled", false);
            }
        });
        return false;
    });

    $(document).on('click', '.btnOpcCondicion', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idcondicionRegla = $(this).attr("data-idcondicionRegla");
        alertify.confirm("Confirmacion de Operacion","¿Realmente desea eliminar la condicion?",
            function() {
                DeleteCondicionRegla(idcondicionRegla);
            },
            function() {
                alertify.error('Operación cancelada');
            }
        ).set('labels', {ok: 'Aceptar', cancel: 'Cancelar'});
    });

    function DeleteCondicionRegla(idcondicionRegla)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("ConfigOperaciones/ReglasVehiculo/SaveEditDelete/DeleteCondicion")?>",
            data: {idcondicionRegla:idcondicionRegla},
            beforeSend: function() {
                Preloader("Cargando Interface...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                DetailCreateRegla();
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }


</script>