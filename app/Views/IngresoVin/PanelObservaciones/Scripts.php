<script>
    $(document).ready(function(){
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
<script>

    $(document).on('click', '.btnOpcObs', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idobs = $(this).attr("data-idobs");
        var opcion = $(this).attr("data-opcion");

        if(opcion=='delete'){
            TrashObs(idobs);
        }else if(opcion=='edit'){
            ViewObs(idobs);
        }else if(opcion=='pdf'){

        }else if(opcion=='send'){
            SendObs(idobs);
        }else if(opcion=='view'){
            ViewObs(idobs);
        }
    });

    function SendObs(idobs)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/ProcesarObservacion")?>",
            data: {idobs:idobs},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
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

    function TrashObs(idobs)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/DeleteObservacion")?>",
            data: {idobs:idobs},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
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

    function ViewObs(idobs)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/ViewEditObservacion")?>",
            data: {idobs:idobs},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
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

    $(document).on('click', '#btnAddObsr', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var idingresoVin = $("#idingresoVinPrin").val();
        var vin = $("#vinIngresoPrin").val();
        CreateObs(idingresoVin,vin);

    });

    function CreateObs(idingresoVin,vin)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("IngresoVin/CreateViewEdit/CreateObservacion")?>",
            data: {idingresoVin:idingresoVin,vin:vin},
            beforeSend: function() {
                Preloader("Cargando Interface<br>Espere un momento...")
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
</script>