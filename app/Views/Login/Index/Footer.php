<!-- ===============================================-->
<!--    JavaScripts-->
<!-- ===============================================-->
<script src="<?php echo base_url('resource/plugin/jquery3/jquery3.js')?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/popper/popper.min.js")?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/bootstrap/bootstrap.min.js")?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/anchorjs/anchor.min.js")?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/is/is.min.js")?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/fontawesome/all.min.js")?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/lodash/lodash.min.js")?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/polyfill.io/v3/polyfill.min58be.js?features=window.scroll")?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/list.js/list.min.js")?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/feather-icons/feather.min.js")?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/vendors/dayjs/dayjs.min.js")?>"></script>
<script src="<?php echo base_url("resource/plugin/phoenixv1/assets/js/phoenix.js")?>"></script>
<script>
    $("#formAccess").bind("submit", function () {
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data: $(this).serialize(),
            beforeSend: function () {
                $("#btnIngresar").attr("disabled",true);
                $(".inputLogin").attr("disabled",true);
                $("#btnIngresar").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;Verificando...');
            },
            success: function (data) {
                let dato = $.parseJSON(data);
                AlertsLogin(dato.status,dato.title,dato.message);
                if(dato.status=='success'){
                    $("#btnIngresar").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbsp;Iniciando Sesion...');
                   <?php $urlRedireccion=session("urlRedireccion");?>
                    window.location.href='<?php echo $urlRedireccion?>';
                }else{
                    $("#btnIngresar").attr("disabled",false);
                    $(".inputLogin").attr("disabled",false);
                    $("#btnIngresar").html('Ingresar');
                }
            },
            error: function (xhr) {
            }
        });
        return false;
    });

    function AlertsLogin(status,title,message)
    {
        var classAlert='';
        if(status=='warning'){
            classAlert='alert-subtle-warning';
        }else if(status=='danger'){
            classAlert='alert-subtle-danger';
        }else{
            classAlert='alert-subtle-success';
        }
        $("#alertsLogin").html('<div class="alert '+classAlert+' alert-dismissible fade show" role="alert">' +
            '<strong>'+title+'</strong>&nbsp;'+message+
            '<button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close">' +
            '</button>' +
            '</div>');
        $("#alertsLogin").css("display","block");
    }

    $(document).ready(function() {
        // Seleccionar el elemento <select> por su id (reemplaza 'miSelect' con el id de tu elemento <select>)
        $('#database').change(function() {
            var operacionLogistica = $(this).val();
            Operacion(operacionLogistica);
        });
    });

    function Operacion(operacionLogistica)
    {
        $.ajax({
            type: 'POST',
            url: "<?php echo base_url("Index/SelectOperacion")?>",
            data: {operacionLogistica:operacionLogistica},
            beforeSend: function() {

            },
            success: function(data) {
                let dato = $.parseJSON(data);
                if(dato.status=='success'){
                    $("#email").html("");
                    $("#password").html("");
                    AlertsLogin(dato.status,dato.title,dato.message);
                }
            },
            error: function(xhr) {

            }
        });
    }

</script>
</body>
<!-- Mirrored from prium.github.io/phoenix/v1.14.0/pages/authentication/simple/sign-in.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 02 Jan 2024 17:37:51 GMT -->
</html>