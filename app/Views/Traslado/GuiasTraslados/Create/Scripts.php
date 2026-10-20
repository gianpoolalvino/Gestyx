<script>
    $(document).ready(function() {
        $('#motivoTraslado').click(function() {
            // Cambiar el valor del select
            var motivoTraslado = $('#motivoTraslado').val();
            if(motivoTraslado==10){
                $("#panelOpcional").css("display","block");
                $("#btnActoresList").attr("disabled",false);
            }else{
                $("#panelOpcional").css("display","none");
                $("#btnActoresList").attr("disabled",true);
            }
            // Para mostrar el cambio (opcional)
        });
    });

    $(document).ready(function() {
        $('#empresa').change(function() {
            var idempresa = $(this).val();  // Obtener el valor seleccionado
            ChangeEmpresa(idempresa);
        });
    });
    function ChangeEmpresa(idempresa)
    {
        var idguiaRemision = $("#idguiaRemision").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/ChangeEmpresa")?>",
            data: {idguiaRemision:idguiaRemision,idempresa:idempresa},
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                if(dato.status=='success'){
                    $("#BodyGuiaRemision").html(dato.info);
                }

            },
            error: function(xhr) {

            }
        });
    }

</script>
<script>
    $(document).on('click', '#btnRelDocAd', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DocumentoRelacionado();
    });

    function DocumentoRelacionado()
    {
        var idguiaRemision = $("#idguiaRemision").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/DocRelacionado")?>",
            data: {idguiaRemision:idguiaRemision},
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
</script>
<script>

    $(document).on('click', '#btnAddDestino', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateDestino();
    });

    $(document).on('click', '#btnTransporte', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateTransportista();
    });

    function CreateTransportista()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/CreateTransportista")?>",
            data: {
                idguiaRemision:'<?php echo $idguiaRemision?>'
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    function CreateDestino()
    {
        var idempresa = $("#empresa").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/DestinoGuia")?>",
            data: {
                idguiaRemision:'<?php echo $idguiaRemision?>',idempresa:idempresa
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnAddOrigen', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateOrigen();
    });

    function CreateOrigen()
    {
        var idempresa = $("#empresa").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/OrigenGuia")?>",
            data: {
                idguiaRemision:'<?php echo $idguiaRemision?>',idempresa:idempresa
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

</script>

<script>
    $("#formGuia").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=="success"){

                    $("#idguiaRemision").val(dato.idguiaRemision);
                    $("#idguiaRemision").html(dato.idguiaRemision);
                    $("#idprocesoGuia").val(dato.idestadoGuia);
                    $("#idprocesoGuia").html(dato.idestadoGuia);
                    if(dato.idestadoGuia==2){
                        $("#actores-tab").addClass('active');
                    }else if(dato.idestadoGuia==3){
                        $("#actores-tab").addClass('active');
                        $("#documentosrelacionados-tab").addClass('active');
                        ViewDocRelacionado(dato.idguiaRemision);
                    }
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });

    $(document).on('click', '#btnActoresList', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        ActoresGuia();
    });

    function ActoresGuia()
    {
        var idempresa = $("#empresa").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/Actores")?>",
            data: {
                idguiaRemision:'<?php echo $idguiaRemision?>',idempresa:idempresa
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnAddVin', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        CreateVinTras();
    });

    function CreateVinTras()
    {
        var idguiaRemision = $("#idguiaRemision").val();
        var idempresa = $("#empresa").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/CreateVinGuia")?>",
            data: {
                idguiaRemision:idguiaRemision,idempresa:idempresa
            },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    function DetailVinGuia()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('Traslado/GuiasTraslados/CreateViewEdit/DetailBienesTransportar'); ?>",
            data: { idguiaRemision: '<?=$idguiaRemision?>' },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = JSON.parse(data);
                ClosePreloader();
                $("#tbodyVinGuia").html(dato.info);
            },
            error: function(xhr) {
                console.error("Error en la solicitud:", xhr); // Manejo de errores
                ClosePreloader(); // Cierra el preloader en caso de error
            }
        });
    }

    $(document).on('click', '.btnOpcDetGuia', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var iddetalleGuiaRemision = $(this).attr("data-iddetalleGuia");
        var vin = $(this).attr("data-vin");
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url('Traslado/GuiasTraslados/CreateViewEdit/DeleteVinGuia'); ?>",
            data: { idguiaRemision: '<?=$idguiaRemision?>',iddetalleGuiaRemision:iddetalleGuiaRemision,vin:vin },
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = JSON.parse(data);
                ClosePreloader();
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {
                console.error("Error en la solicitud:", xhr); // Manejo de errores
                ClosePreloader(); // Cierra el preloader en caso de error
            }
        });
    });
</script>
<script>
    $(document).on('click', '.btnGuiaNext', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idestadoGuia = $("#idprocesoGuia").val();
        var idguiaRemision = $("#idguiaRemision").val();

        if ($('#unidadMedidaGuia').length === 0) {
            var unidadMedidaGuia = $('#unidadMedidaGuia').val();
        }else{
            var unidadMedidaGuia = '';
        }
        if ($('#pesoGuia').length === 0) {
            var pesoGuia = $('#pesoGuia').val();
        }else{
            var pesoGuia = '';
        }
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/SaveEditDelete/ValidarProceso")?>",
            data: {idguiaRemision:idguiaRemision,idestadoGuia:idestadoGuia,unidadMedidaGuia:unidadMedidaGuia,pesoGuia:pesoGuia},
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=='success'){
                    $("#actores-tab").addClass('active');
                    $("#documentosrelacionados-tab").addClass('active');
                    $("#bienestransportar-tab").addClass('active');
                    $("#idprocesoGuia").val(dato.idestadoGuia);
                    $("#idprocesoGuia").html(dato.idestadoGuia);
                    BienesTransportar(dato.idguiaRemision);
                }
            },
            error: function(xhr) {

            }
        });
    });
</script>

<script>



    //Adicionales
    $(document).on('click', '.btnDeleteDoc', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var iddocumentoRelacionadoGuia = $(this).attr("data-iddocRelGuia");
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/GuiasTraslados/CreateViewEdit/DeleteDocRelacionado")?>",
            data: {iddocumentoRelacionadoGuia:iddocumentoRelacionadoGuia},
            beforeSend: function() {
                Preloader("Cargando Vista<br>Espere un momento...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    });


</script>