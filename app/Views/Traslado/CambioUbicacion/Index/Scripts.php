<script>


    $(document).on('change', '#tipoFiltro', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var tipoFiltro = $("#tipoFiltro").val();
        if(tipoFiltro!=''){

        }
    } );



    $(document).on('click', '.btnRebox', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin= $(this).attr("data-vin");
        VinBoxChange(vin);
    });

    function tool_tip() {
        $('[data-toggle="tooltip"]').tooltip();
    }

    $('#boxNuevo').select2({
        dropdownParent: $('#ModalOpcionesAdicionales')
    });

    // Do this before you initialize any of your modals


    function VinBoxChange(vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/CreateTrasladoBox")?>",
            data: {vin:vin},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnTransportista', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/Transportista")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Interface...");
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
    });

    $(document).on('click', '#btnNewTransportista', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/CreateTransportista")?>",
            data: {},
            beforeSend: function() {
                Preloader("Cargando Interface...");
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


    $(document).on('click', '#btnNewTraslado', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/CreateTraslado")?>",
            data: {},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    });

    $(document).on('click', '#btnMasivo', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/CreateUbicacionBoxMasivo")?>",
            data: {},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalAdicionales.show();
                $("#BodyAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    });

    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        DetailIndexFilt();
    });

    $(document).on('click', '#btnDeleteFilt', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        location.reload();
    });

    $(document).on('click', '.btnOpcubica', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin= $(this).attr("data-vin");
        ViewVinProceso(vin);
    });

    $(document).on('click', '.btnReUbi', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin= $(this).attr("data-vin");
        VinLiberaUbicacion(vin);
    });

    function VinLiberaUbicacion(vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/ChangeGrupoUbicacion")?>",
            data: {vin:vin},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }


    <?php if(isset($_GET["vin"])){?>
        $(document).ready(function(){
            let vin = '<?php echo $_GET["vin"]?>';
            ViewVinProceso(vin);
        });
    <?php }?>

    function ViewVinProceso(vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/CreateViewEdit/ChangeUbicacion")?>",
            data: {vin:vin},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalOpcionesAdicionales.show();
                $("#BodyOpcionesAdicionales").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    function VinInfo(vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("InfoVin")?>",
            data: {vin:vin},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#panelVinInfo").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }

    function DetailIndexFilt()
    {
        var start = $("#start").val();
        var countReg = 0;
        var total = $("#totalRegistros").val();
        var tipoFiltr = $("#tipoFiltro").val();
        var filtro = $("#filtro").val();
        var estadoVin = $("#estadovin").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/Index/DetailIndex")?>",
            data: {start:start,countReg:countReg,total:total,tipoFiltr:tipoFiltr,filtro:filtro,estadoVin:estadoVin},
            beforeSend: function() {
                Preloader("Cargando Datos...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyAlistamiento").html(dato.tbody);
                $("#start").val(dato.start);
                $("#start").html(dato.start);
                $("#countReg").val(dato.countReg);
                $("#countReg").html(dato.countReg);
                tool_tip();
                ClosePreloader();
            },
            error: function(xhr) {

            }
        });
    }


    function DetailIndexScroll()
    {
        var start = $("#start").val();
        var countReg = $("#countReg").val();
        var total = $("#totalRegistros").val();
        var tipoFiltr = $("#tipoFiltro").val();
        var filtro = $("#filtro").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Traslado/CambioUbicacion/Index/DetailIndex")?>",
            data: {start:start,countReg:countReg,total:total,tipoFiltr:tipoFiltr,filtro:filtro},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyAlistamiento").append(dato.tbody);
                $("#start").val(dato.start);
                $("#start").html(dato.start);
                $("#countReg").val(dato.countReg);
                $("#countReg").html(dato.countReg);

                if(dato.total==dato.countReg){
                  //  clearInterval(idIterval);
                    $("#cargarData").fadeOut();
                }
            },
            error: function(xhr) {

            }
        });
    }
</script>