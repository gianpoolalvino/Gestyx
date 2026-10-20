<script>
    $(document).on('click', '#btnIniciar', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        var vin = $("#vinIniciarEntrega").val();
        var idcitaEntrega = $("#idcitaEntrega").val();
        IniciarProceso(idcitaEntrega,vin);
        FormPdfActa(idcitaEntrega,vin);
    });
</script>