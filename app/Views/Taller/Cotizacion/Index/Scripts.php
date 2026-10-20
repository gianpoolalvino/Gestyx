<script>
    $(document).on('click', '#btnCreateCoti', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/Cotizacion/CreateViewEdit/VerificarTipoCambio")?>",
            data: {},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    CreateCotizacion();
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }
            },
            error: function(xhr) {

            }
        });
    });

    function CreateCotizacion()
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/Cotizacion/CreateViewEdit/Create")?>",
            data: {},
            beforeSend: function() {
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
            },
            error: function(xhr) {

            }
        });
    }
    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndex();
    });

    $(document).ready(function() {
        DetailIndex();
    });

    function DetailIndex()
    {
        var idmarca=$("#selectMarca").val();
        var fechaInicio=$("#fechaInicio").val();
        var fechaFin=$("#fechaFin").val();
        var filtro=$("#filtro").val();
        var search=$("#search").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/Cotizacion/Index/DetailIndex")?>",
            data: {idmarca:idmarca,fechaInicio:fechaInicio,fechaFin:fechaFin,filtro:filtro,search:search},
            beforeSend: function() {
                Preloader("Cargando Datos...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyAlistamiento").html(dato.info);
                ClosePreloader();
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }

</script>
<script>
    $(document).on('click', '.btnSendErp', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idcotizacion = $(this).attr("data-idcotizacion");
        SendErp(idcotizacion)
    });

    function SendErp(idcotizacion)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Taller/Cotizacion/CreateViewEdit/SendERP")?>",
            data: {idcotizacion:idcotizacion},
            beforeSend: function() {
                Preloader("Enviando a Erp...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                ModalOpcionesAdicionales.show();
                $('#BodyOpcionesAdicionales').html(dato.info);
            },
            error: function(xhr) {
                ClosePreloader();
            }
        });
    }
</script>
<script>
    $(document).on('click', '.btnPdfOp', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idcotizacion = $(this).attr("data-idcotizacion");
        PdfCot(idcotizacion)
    });

    function PdfCot(idcotizacion)
    {
        var form = document.createElement("form");
        var element1 = document.createElement("input");
        var w = 1060;
        var h = 764;
        var dualScreenLeft = window.screenLeft != undefined ? window.screenLeft : screen.left;
        var dualScreenTop = window.screenTop != undefined ? window.screenTop : screen.top;
        width = window.innerWidth ? window.innerWidth : document.documentElement.clientWidth ? document.documentElement.clientWidth : screen.width;
        height = window.innerHeight ? window.innerHeight : document.documentElement.clientHeight ? document.documentElement.clientHeight : screen.height;
        var left = ((width / 2) - (w / 2)) + dualScreenLeft;
        var top = ((height / 2) - (h / 2)) + dualScreenTop;
        form.method = "POST";
        form.id = "formPrintPdfCMPjs";
        form.action = "<?php echo base_url("Taller/Cotizacion/CreateViewEdit/Pdf") ?>";
        form.target = "print_popup";
        element1.value=idcotizacion;
        element1.hidden=true;
        element1.name="idcotizacion";
        form.appendChild(element1);
        document.body.appendChild(form);
        form.submit(window.open('about:blank','print_popup','width=' + w + ', height=' + h + ', top=' + top + ', left=' + left));
        $("#formPrintPdfCMPjs").remove();
    }
</script>