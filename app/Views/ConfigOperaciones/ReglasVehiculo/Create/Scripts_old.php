<script>
    $(document).on('change', '#tipoRegla', function() {
        let tipoRegla = $(this).val();
        if(tipoRegla==1){
            $("#panelCondiciones").css("display","none");
        }else{
            $("#panelCondiciones").css("display","block");
        }

    });

    function DetailCreateRegla()
    {

    }
</script>