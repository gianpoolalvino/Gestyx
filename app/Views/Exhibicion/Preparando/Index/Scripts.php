<script>
    $(document).on('click', '.btnRetornChasis', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idexhibicionVin = $(this).attr("data-idexhibicionVin");
        var vin= $(this).attr("data-vin");
        SendExhibicion(idexhibicionVin,vin);
    });

    function SendExhibicion(idexhibicionVin,vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Exhibicion/Preparando/CreateViewEdit/CreateRetorno")?>",
            data: {vin:vin,idexhibicionVin:idexhibicionVin},
            beforeSend: function() {
                Preloader("Cargando Vista...")
            },
            success: function(data) {
                ClosePreloader();
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }else{
                    Notificacion(dato.status,dato.title,dato.message);
                }
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        DetailIndexFilt();
    });

    function DetailIndexFilt()
    {
        var tipoFiltro = $("#tipoFiltro").val();
        var filtro = $("#filtro").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Exhibicion/Preparando/Index/DetailIndex")?>",
            data: {tipoFiltro:tipoFiltro,filtro:filtro},
            beforeSend: function() {
                Preloader("Buscando Datos...");
            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ClosePreloader();
                $("#tbodyAlistamiento").html(dato.tbody);
                $("#countReg").val(dato.countReg);
                $("#countReg").html(dato.countReg);
            },
            error: function(xhr) {

            }
        });
    }
</script>