<script>
    $(document).ready(function() {
        $('body').on('mouseleave', function(e) {
            Notificacion('warning','Bloqueo de Sistema','Si sale de la aplicacion mientras un proceso se esta ejecutando, no se guardaran los cambios correctamente')
            // Aquí puedes agregar cualquier acción que desees realizar
        });
    });
</script>
<script>
    $(document).ready(function() {
        $(document).on('contextmenu', function(e) {
            e.preventDefault(); // Prevenir el menú contextual del clic derecho
        });
    });
    $(document).ready(function() {
        $(document).on('keydown', function(e) {
            // Ctrl+R
            if (e.ctrlKey && e.keyCode === 82) {
                e.preventDefault(); // Prevenir la acción por defecto
                Notificacion('warning','Bloqueo de Sistema','La Recarga Manual se encuentra bloqueada en este modulo')

            }
            // F5
            if (e.keyCode === 116) {
                e.preventDefault(); // Prevenir la acción por defecto
                Notificacion('warning','Bloqueo de Sistema','La Recarga Manual se encuentra bloqueada en este modulo')

            }
            // Fn+F5 (puede variar según el teclado y navegador)
            if (e.keyCode === 116 && e.location === KeyboardEvent.DOM_KEY_LOCATION_FN) {
                e.preventDefault(); // Prevenir la acción por defecto
                Notificacion('warning','Bloqueo de Sistema','La Recarga Manual se encuentra bloqueada en este modulo')

            }
        });
    });


</script>
<script>
    var cont =$("#countReg").val();
    var rango =$("#totalRegistros").val();


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

    $(document).on('click', '.btnStartEntrega', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idcitaEntrega = $(this).attr("data-idcitaEntrega");
        var vin = $(this).attr("data-vin");
        StartEntrega(idcitaEntrega,vin);
    });

    $(document).on('click', '.btnRestoreEntrega', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idcitaEntrega = $(this).attr("data-idcitaEntrega");
        var vin = $(this).attr("data-vin");
        IniciarProceso(idcitaEntrega,vin);
    });

    function FormPdfActa(idcitaEntrega,vin)
    {
        var form = document.createElement("form");
        var element1 = document.createElement("input");
        var element2=document.createElement("input");
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
        form.action = "<?php echo base_url("Agendamiento/Pdf/ActaEntrega") ?>";
        form.target = "print_popup";
        element1.value=vin;
        element1.hidden=true;
        element1.name="vin";
        element2.value=idcitaEntrega;
        element2.hidden=true;
        element2.name="idcitaEntrega";
        form.appendChild(element1);
        form.appendChild(element2);
        document.body.appendChild(form);
        form.submit(window.open('about:blank','print_popup','width=' + w + ', height=' + h + ', top=' + top + ', left=' + left));
        $("#formPrintPdfCMPjs").remove();
    }

    function IniciarProceso(idcitaEntrega,vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Agendamiento/Agendados/CreateViewEdit/IniciarProceso")?>",
            data: {idcitaEntrega:idcitaEntrega,vin:vin},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                    ModalInfoVehiculo.hide();
                }
            },
            error: function(xhr) {

            }
        });
    }

    function StartEntrega(idcitaEntrega,vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Agendamiento/Agendados/CreateViewEdit/StartEntrega")?>",
            data: {idcitaEntrega:idcitaEntrega,vin:vin},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    ModalInfoVehiculo.show();
                    $("#bodyInfoVehicular").html(dato.info);
                }
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
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Agendamiento/Agendados/Index/DetailIndex")?>",
            data: {start:start,countReg:countReg,total:total,tipoFiltr:tipoFiltr,filtro:filtro},
            beforeSend: function() {
                $("#cargarData").fadeIn();
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyAlistamiento").html(dato.tbody);
                $("#start").val(dato.start);
                $("#start").html(dato.start);
                $("#countReg").val(dato.countReg);
                $("#countReg").html(dato.countReg);
                $("#cargarData").fadeOut();
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
            url: "<?php echo base_url("Agendamiento/Agendados/Index/DetailIndex")?>",
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
                    clearInterval(idIterval);
                    $("#cargarData").fadeOut();
                }
            },
            error: function(xhr) {

            }
        });
    }

</script>