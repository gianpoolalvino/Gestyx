<script>
    $(document).on('click', '#btnCloseReporte', function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();
        ModalAdicionales.hide();
    });
</script>
<script>
    $('#vinReportar').selectpicker();
</script>