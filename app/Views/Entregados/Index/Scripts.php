
<script>
    var cont =$("#countReg").val();
    var rango =$("#totalRegistros").val();
    var idIterval = setInterval(function(){
        DetailIndexScroll();
        if(cont == rango)
        {
            clearInterval(idIterval);
            $("#cargarData").fadeOut();
        }
    }, 1000);

    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        clearInterval(idIterval);
        DetailIndexFilt();
    });

    $(document).on('click', '#btnDeleteFilt', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        location.reload();
    });

    function DetailIndexFilt()
    {
        var start = $("#start").val();
        var countReg = 0;
        var total = $("#totalRegistros").val();
        var tipoFiltr = $("#tipoFiltro").val();
        var filtro = $("#filtro").val();
        var fechaInicio = $("#fechaInicio").val();
        var fechaFinal = $("#fechaFinal").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Entregados/Index/DetailIndex")?>",
            data: {start:start,countReg:countReg,total:total,tipoFiltr:tipoFiltr,filtro:filtro,fechaInicio:fechaInicio,fechaFinal:fechaFinal},
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
                $("#totalRegLabel").html(dato.countReg);
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
        var fechaInicio = $("#fechaInicio").val();
        var fechaFinal = $("#fechaFinal").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Entregados/Index/DetailIndex")?>",
            data: {start:start,countReg:countReg,total:total,tipoFiltr:tipoFiltr,filtro:filtro,fechaInicio:fechaInicio,fechaFinal:fechaFinal},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                $("#tbodyAlistamiento").append(dato.tbody);
                $("#start").val(dato.start);
                $("#start").html(dato.start);
                $("#countReg").val(dato.countReg);
                $("#totalRegLabel").html(dato.countReg);
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