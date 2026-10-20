<script>
    document.getElementById('documentoCliente').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    document.getElementById('telefonoCliente').addEventListener('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '');
    });


    $("#createMarca").change(function(){
        var idmarca = $("#createMarca").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/PlanMantenimiento/CreateViewEdit/SelectModelo")?>",
            data: {idmarca:idmarca},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#createModelo").html(dato.selectModelo);
            },
            error: function(xhr) {

            }
        });
    });

    $("#createModelo").change(function(){
        var idmarca = $("#createMarca").val();
        var idmodelo = $("#createModelo").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/Cotizacion/CreateViewEdit/Kilometraje")?>",
            data: {idmarca:idmarca,idmodelo:idmodelo},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#kilometraje").html(dato.selectKilometraje);
            },
            error: function(xhr) {

            }
        });
    });

    $("#descuento").keyup(function(){
        DetailCreate()
    });

    $("#kilometraje").change(function(){
        DetailCreate()
    });

    $("#tipoMoneda").change(function(){
        DetailCreate()
    });

    function DetailCreate()
    {
        var idplanMantenimiento = $("#kilometraje").val();
        var tipoMoneda = $("#tipoMoneda").val();
        var descuento = $("#descuento").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/Cotizacion/CreateViewEdit/DetailCreate")?>",
            data: {idplanMantenimiento:idplanMantenimiento,tipoMoneda:tipoMoneda,descuento:descuento},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyCotizacion").html(dato.info);
                $("#cantidadManoObra").val(dato.cantidadManoObra);
                $("#costoManoObra").val(dato.costoManoObra);
                $("#totalManoObra").val(dato.costoManoObra);
                DescuentoManoObra();
                TotalSum();
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnSearchCli', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var documentoCliente = $("#documentoCliente").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/Cotizacion/CreateViewEdit/ObtenerCliente")?>",
            data: {documentoCliente:documentoCliente},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                Notificacion(dato.status,dato.title,dato.message);
                if(dato.status=='success'){
                    $("#nombreCliente").val(dato.nombreCliente);
                    $("#telefonoCliente").val(dato.telefonoCliente);
                    $("#direccionCliente").val(dato.direccionCliente);
                    $("#correoCliente").val(dato.correoCliente);
                }

            },
            error: function(xhr) {

            }
        });
        //  suma_total();
    });

    $(document).on('click', '.btnDeletDetCot', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var iddetalleMantenimiento = $(this).attr("data-iddetalleMantenimiento");
        $("#" + iddetalleMantenimiento).remove();
        TotalSum();
        //  suma_total();
    });


    $("#descuentoPorcentaje").keyup(function(){
        DescuentoManoObra();
    });


    function DescuentoManoObra()
    {
        var subTotal = $("#costoManoObra").val();
        var descuentoPorcentaje = $("#descuentoPorcentaje").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/Cotizacion/CreateViewEdit/DescuentoManoObra")?>",
            data: {subTotal:subTotal,descuentoPorcentaje:descuentoPorcentaje},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#descuentoMano").val(dato.descuentoMano);
                $("#totalManoObra").val(dato.total);
                TotalSum();
            },
            error: function(xhr) {

            }
        });
    }

    function TotalSum() {

        var total=0;
        var descuento=0;

        var totalMano = $("#totalManoObra").val();
        var descuentoMano = $("#descuentoMano").val();
        $("input[id^='precioTotalRepuesto']").each(function () {
            total += Number($(this).val());
        });

        $("input[id^='desctoRepuesto']").each(function () {
            descuento += Number($(this).val());
        });

        $("#descuentoRepuesto").val(descuento);
        $("#descuentoRepuesto").html(descuento);

        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/Cotizacion/CreateViewEdit/CalcularTotal")?>",
            data: {total:total,descuento:descuento,totalMano:totalMano,descuentoMano:descuentoMano},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#total").val(dato.total);
                $("#total").html(dato.total);

                $("#dscto").val(dato.descuentoTotal);
                $("#dscto").html(dato.descuentoTotal);

                $("#igv").val(dato.igv);
                $("#igv").html(dato.igv);

                $("#subTotal").val(dato.subTotal);
                $("#subTotal").html(dato.subTotal);

                $('#labelsubTotal').html(dato.subTotal);
                $('#labeligv').html(dato.igv);
                $('#labeldsctoTotal').html(dato.descuentoTotal);
                $('#labelTotal').html(dato.total);
            },
            error: function(xhr) {

            }
        });
    }

    $("#formCotizacion").bind("submit", function () {
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
                    ModalInfoVehiculo.hide();
                    DetailIndex();
                }
            },
            error: function (xhr) {
                $("#btnProcesarAccess").attr("disabled", false);
            }
        });
        return false;
    });
</script>