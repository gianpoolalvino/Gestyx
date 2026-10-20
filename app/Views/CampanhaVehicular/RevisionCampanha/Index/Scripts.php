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

    $(document).on('change', '#tipoFiltro', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var tipoFiltro = $("#tipoFiltro").val();
        if(tipoFiltro!=''){
            clearInterval(idIterval);
        }
    } );

    $(document).on('click', '#btnSearch', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        clearInterval(idIterval);
        DetailIndexFilt();
    });

    $(document).on('click', '.btnAddCampanha', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin = $(this).attr("data-vin");
        AsociarCampanha(vin);
    });

    function AsociarCampanha(vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("CampanhaVehicular/RevisionCampanha/CreateViewEdit/CreateAplicarCampanha")?>",
            data: {vin:vin},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status='success'){
                    ModalAdicionales.show();
                    $("#BodyAdicionales").html(dato.info);
                }
            },
            error: function(xhr) {

            }
        });
    }

    $(document).on('click', '#btnIndexCcampanhas', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("CampanhaVehicular/RevisionCampanha/Index/IndexCampanha")?>",
            data: {},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status='success'){
                    $("#ModalRight").html(dato.info);
                }

            },
            error: function(xhr) {

            }
        });
    });

    $(document).on('click', '#btnDeleteFilt', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        location.reload();
    });

    $(document).on('click', '.btnApliCampanha', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idvinCampanha = $(this).attr("data-idvinCampanha");
        var estado = $(this).attr("data-estado");
        var vin = $(this).attr("data-vin");
        var idcampanha = $(this).attr("data-idcampanha");

        if(estado==1 || estado==4){
            Notificacion('warning', 'Aplicada', 'La Campaña ya se encuentra aplicada');
        }else{
            AplicarCampanha(idvinCampanha,vin,idcampanha);
        }
    });

    function AplicarCampanha(idvinCampanha,vin,idcampanha)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("CampanhaVehicular/AplicacionCampanha/CreateViewEdit/AplicarCampanha")?>",
            data: {idvinCampanha:idvinCampanha,vin:vin,idcampanha:idcampanha},
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
    }

    $(document).on('click', '.vinAccesorios', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var opcion = $(this).attr("data-opcion");
        var vin= $(this).attr("data-vin");

        if(opcion=="Proceso"){
            ViewVinProceso(vin)
        }
    });

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

    function ViewVinProceso(vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("CampanhaVehicular/RevisionCampanha/CreateViewEdit/Create")?>",
            data: {vin:vin},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                ModalInfoVehiculo.show();
                $("#bodyInfoVehicular").html(dato.info);
                if(dato.status=='success'){
                    VinInfo(vin);
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
        var campanha = $("#filtroCampanha").val();
        var filtro = $("#filtro").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("CampanhaVehicular/RevisionCampanha/Index/DetailIndexFiltro")?>",
            data: {campanha:campanha,start:start,countReg:countReg,total:total,tipoFiltr:tipoFiltr,filtro:filtro},
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
        var campanha = $("#filtroCampanha").val();
        var filtro = $("#filtro").val();
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("CampanhaVehicular/RevisionCampanha/Index/DetailIndex")?>",
            data: {campanha:campanha,start:start,countReg:countReg,total:total,tipoFiltr:tipoFiltr,filtro:filtro},
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