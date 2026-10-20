<html>
<head>
    <style>
        @page {
            margin: 0cm 0cm;
        }

        body {
            margin-top: 0.1cm !important;
            margin-left: 40px !important;
            margin-right: 40px !important;
            margin-bottom: 40px !important;
            padding: 0px 0px 0px 0px !important;
        }
        .fuente{
            font-family:Roboto, 'Open Sans', Lato, 'Helvetica Neue', Arial, sans-serif !important;
            font-size:10pt
        }
        .fontSm{
            font-size: 14px;
        }
        header {
            position: fixed;
            top: 0cm;
            left: 40px;
            right: 40px;
            height: 3cm;
        }
        footer {
            position: fixed;
            bottom: -42px;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }
    </style>
    <title><?php echo $nombreFile ?></title>
</head>
<body>
<table style="width: 100%">
    <tr>
        <td style="width: 40%;text-align: center">
            <img style="height: 70px" src="<?php echo $logo ?>">
        </td>
        <td style="width: 60%;text-align:center">
            <h2 style="font-family: Arial, Helvetica, sans-serif;">ACTA DE ENTREGA DE VEHICULO NUEVO</h2>
        </td>
    </tr>
</table>
<table style="width: 100%">
    <?php
    date_default_timezone_set("America/Lima");
    $hoy=date("Y-m-d");
    $hora=date("H:i:s");

    $fechaEntrega=($viewCitaEntrega[0]["fechaEntregaSistema"]!='')?$viewCitaEntrega[0]["fechaEntregaSistema"]:$hoy;
    $horaEntrega=($viewCitaEntrega[0]["horaEntregaSistema"]!='')?$viewCitaEntrega[0]["horaEntregaSistema"]:$hora;
    ?>
    <tr>
        <td style="width: 100%;text-align: left">
            <span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px">Fecha de entrega: <?php echo date("d/m/Y", strtotime($fechaEntrega)) . " " . date("g:i A", strtotime($horaEntrega)); ?></span>
        </td>
    </tr>
</table>
<table style="width: 100%;height: 50px">

</table>
<table style="width: 100%">
    <tr>
        <td style="width: 100%">
            <span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px">DETALLES DE VEHICULO:</span>
        </td>
    </tr>
</table>
<table style="width: 100%">
    <tr>
        <td style="width: 60%;vertical-align: top;text-align: left">
            <table>
                <tr>
                    <td><strong style="font-family: Arial, Helvetica, sans-serif;font-size: 14px"><?php echo ($viewCitaEntrega[0]["placa"]!='')?'Placa':'Sin Placa'?>: </strong></td>
                    <td><span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px"><?php echo ($viewCitaEntrega[0]["placa"]!='')?$viewCitaEntrega[0]["placa"]:''?></span></td>
                </tr>
                <tr>
                    <td><strong style="font-family: Arial, Helvetica, sans-serif;font-size: 14px">Marca: </strong></td>
                    <td><span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px"><?php echo $viewCitaEntrega[0]["marca"]?></span></td>
                </tr>
                <tr>
                    <td><strong style="font-family: Arial, Helvetica, sans-serif;font-size: 14px">Modelo: </strong></td>
                    <td><span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px"><?php echo $viewCitaEntrega[0]["familia"]?></span></td>
                </tr>
                <tr>
                    <td><strong style="font-family: Arial, Helvetica, sans-serif;font-size: 14px">Año Modelo: </strong></td>
                    <td><span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px"><?php echo $viewCitaEntrega[0]["anhoModelo"]?></span></td>
                </tr>
            </table>
        </td>
        <td style="width: 40%;vertical-align: top;text-align: left">
            <table>
                <?php if($viewCitaEntrega[0]["tipoPlaca"]=="Placa Rotativa"){?>
                    <tr>
                        <td><strong style="font-family: Arial, Helvetica, sans-serif;font-size: 14px">Placa Rotativa: </strong></td>
                        <td><span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px">SI</span></td>
                    </tr>
                <?php }?>
                <tr>
                    <td><strong style="font-family: Arial, Helvetica, sans-serif;font-size: 14px">Color: </strong></td>
                    <td><span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px"><?php echo $viewCitaEntrega[0]["color"]?></span></td>
                </tr>
                <tr>
                    <td><strong style="font-family: Arial, Helvetica, sans-serif;font-size: 14px">VIN/Serie: </strong></td>
                    <td><span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px"><?php echo $viewCitaEntrega[0]["vin"]?></span></td>
                </tr>
                <tr>
                    <td><strong style="font-family: Arial, Helvetica, sans-serif;font-size: 14px">Nro Motor: </strong></td>
                    <td><span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px"><?php echo $viewCitaEntrega[0]["numeroMotor"]?></span></td>
                </tr>
            </table>
        </td>
    </tr>
</table>
<table style="width: 100%;height: 280px">
</table>
<table style="width: 100%">
    <tr>
        <td style="width: 50%;vertical-align: top;text-align: center">
            <span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px">FIRMA CLIENTE</span>
        </td>
        <td style="width: 50%;vertical-align: top;text-align: center">
            <span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px">FIRMA ASESOR DE ENTREGA</span>
        </td>
    </tr>
</table>
<table style="width: 100%;height: 140px">
</table>
<table style="width: 100%">
    <tr>
        <td style="width: 45%;vertical-align: top;text-align: center;border-top: solid 1px black">
            <span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px"><?php echo $viewCitaEntrega[0]["nombreCliente"]?></span><br>
            <span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px"><?php echo "DNI / RUC: ".$viewCitaEntrega[0]["documentoCliente"]?></span>
        </td>
        <td style="width: 10%"></td>
        <td style="width: 45%;vertical-align: top;text-align: center;border-top: solid 1px black">
            <span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px"><?php echo $viewCitaEntrega[0]["nombreAsesor"]?></span><br>
            <span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px"><?php echo "DNI / RUC: "?></span>
        </td>
    </tr>
</table>
<table style="height: 40px"></table>
<table style="width: 100%">
    <tr>
        <td style="width: 100%;text-align: left">
            <span style="font-family: Arial, Helvetica, sans-serif;font-size: 14px">* El Vehiculo se entrega bajo inventario fisico y a conformidad del cliente</span>
        </td>
    </tr>
</table>
</body>