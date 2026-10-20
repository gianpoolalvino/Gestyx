<html>
<head>
    <style>
        @page {
            margin-top: 8px !important;
            margin-left: 26px !important;
            margin-right: 26px !important;
            margin-bottom: 2px !important;
            padding: 0px 0px 0px 0px !important;
        }

        .fuente {
            font-family: Roboto, 'Open Sans', Lato, 'Helvetica Neue', Arial, sans-serif !important
        }

        .fontSm {
            font-size: 12px;
        }

        footer {
            position: fixed;
            bottom: -42px;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

        .tablaBorder th{
            border: 1px solid;
        }

        .tablaBorder{
            border-collapse: collapse;
        }

    </style>
    <title></title>
</head>
<body>
<table style="width: 100%;border:1px solid">
    <tr>
        <td style="width: 40%;text-align: center">
            <?php
                $path = "resource/img/logoAutoniza.png";
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
            ?>

            <img style="height: 70px" src="<?php echo $base64?>">
        </td>
        <td style="width: 40%;text-align:left">
            <?php if(($viewCotizacion[0]["marca"]=='CHEVROLET') or ($viewCotizacion[0]["marca"]=='ISUZU')){?>
                <span class="fuente" style="font-size: 12px">AUTONIZA S.A.C</span><br>
                <span class="fuente" style="font-size: 12px">20601762219</span><br>
                <span class="fuente" style="font-size: 12px">AV. REPUBLICA DE PANAMA 4141</span><br>
            <?php }else{?>
                <span class="fuente" style="font-size: 12px">AUTONIZA PERU S.A.C</span><br>
                <span class="fuente" style="font-size: 12px">20610785116</span><br>
                <span class="fuente" style="font-size: 12px">AV. BENAVIDES NRO 4266</span><br>
            <?php }?>
        </td>
        <td style="width: 15%;vertical-align: bottom;text-align: right">
            <strong class="fuente" style="font-size: 12px">MONEDA: </strong><span class="fuente" style="font-size: 12px"><?php echo $viewCotizacion[0]["moneda"]?></span>
            <strong class="fuente" style="font-size: 12px">COTIZACION</strong>
        </td>
        <td style="width: 5%"></td>
    </tr>
</table>
<table style="height: 5px"></table>
<table style="width: 100%;border:1px solid">
    <tr>
        <td style="width: 5%">
            <span class="fuente" style="font-size: 10px">Cliente:</span>
        </td>
        <td style="width: 35%;text-align: left">
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["nombreCliente"]?></span>
        </td>
        <td style="width: 120px;text-align: left">
            <span class="fuente" style="font-size: 10px">COTIZACION NRO:</span>
        </td>
        <td>
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["numero"]?></span>
        </td>
    </tr>
    <tr>
        <td style="width: 5%">
            <span class="fuente" style="font-size: 10px">DNI/RUC:</span>
        </td>
        <td style="width: 35%;text-align: left">
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["documentoCliente"]?></span>
        </td>
        <td style="width: 120px;text-align: left">
            <span class="fuente" style="font-size: 10px">Fecha:</span>
        </td>
        <td>
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["fecha"]?></span>
        </td>
    </tr>
    <tr>
        <td style="width: 5%">
            <span class="fuente" style="font-size: 10px">Direccion:</span>
        </td>
        <td style="width: 35%;text-align: left">
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["direccionCliente"]?></span>
        </td>
        <td style="width: 120px;text-align: left">
            <span class="fuente" style="font-size: 10px">Vendedor:</span>
        </td>
        <td>
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["nombres"]." ".$viewCotizacion[0]["primerApellido"]." ".$viewCotizacion[0]["segundoApellido"] ?></span>
        </td>


    </tr>
    <tr>
        <td style="width: 5%">
            <span class="fuente" style="font-size: 10px">Telefonno:</span>
        </td>
        <td style="width: 35%;text-align: left">
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["telefonoCliente"]?></span>
        </td>
        <td style="width: 120px;text-align: left">
            <span class="fuente" style="font-size: 10px">Mail:</span>
        </td>
        <td>
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["correoCliente"] ?></span>
        </td>
    </tr>
    <tr>
        <td style="width: 5%">
            <span class="fuente" style="font-size: 10px">PLACA:</span>
        </td>
        <td style="width: 25%;text-align: left">
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["placaCliente"]?></span>
        </td>
        <td style="width: 5%">
            <span class="fuente" style="font-size: 10px">MODELO:</span>
        </td>
        <td style="width: 25%;text-align: left">
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["modelo"]." ".$viewCotizacion[0]["version"]?></span>
        </td>
        <td style="width: 5%">
            <span class="fuente" style="font-size: 10px">KILOMETRAJE:</span>
        </td>
        <td style="width: 25%;text-align: left">
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["kilometraje"]?></span>
        </td>
    </tr>
</table>
<table style="height: 5px"></table>
<table class="tablaBorder" style="width: 100%;">
    <tr>
        <th style="height: 30px;width: 20px"><span class="fuente" style="font-size: 10px">#</span></th>
        <th><span class="fuente" style="font-size: 10px">Descripcion</span></th>
        <th><span class="fuente" style="font-size: 10px">Disponibilidad</span></th>
        <th><span class="fuente" style="font-size: 10px">CANT.</span></th>
        <th><span class="fuente" style="font-size: 10px">VALOR UNITARIO</span></th>
        <th><span class="fuente" style="font-size: 10px">SUB TOTAL</span></th>
        <th><span class="fuente" style="font-size: 10px">% DSCTO</span></th>
        <th><span class="fuente" style="font-size: 10px">IMPORTE DESCONTADO</span></th>
        <th><span class="fuente" style="font-size: 10px">TOTAL</span></th>
    </tr>
    <tbody style="border:1px solid;">
    <tr>
        <td style="border-right: 1px solid;text-align: center;"><span class="fuente" style="font-size: 10px">1</span></td>
        <td style="border-right: 1px solid"><span class="fuente" style="font-size: 10px"><?php echo "Mantenimiento de ".$viewCotizacion[0]["kilometraje"]?></span></td>
        <td style="border-right: 1px solid"><span class="fuente" style="font-size: 10px"></span></td>
        <td style="text-align: center;border-right: 1px solid"><span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["tiempoManoObra"]?></span></td>
        <td style="text-align: center;border-right: 1px solid"><span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["precioUnitarioManoObra"]?></span></td>
        <td style="text-align: center;border-right: 1px solid"><span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["subTotalManoObra"]?></span></td>
        <td style="text-align: center;border-right: 1px solid"><span class="fuente" style="font-size: 10px"><?php
                echo $viewCotizacion[0]["descuentoPorcentajeManoObra"]
                ?></span></td>
        <td style="text-align: right;border-right: 1px solid"><span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["descuentoManoObra"]?></span></td>
        <td style="text-align: right"><span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["totalManoObra"]?></span></td>
    </tr>
    <?php
    $contador=1;
    foreach($detailCotizacion as $det){
        $contador++;
        ?>
        <tr>
            <td style="border-right: 1px solid;text-align: center;"><span class="fuente" style="font-size: 10px"><?php echo $contador?></span></td>
            <td style="border-right: 1px solid"><span class="fuente" style="font-size: 10px"><?php echo $det["repuesto"]?></span></td>
            <td style="border-right: 1px solid"><span class="fuente" style="font-size: 10px"></span></td>
            <td style="text-align: center;border-right: 1px solid"><span class="fuente" style="font-size: 10px"><?php echo $det["cantidad"]?></span></td>
            <td style="text-align: center;border-right: 1px solid"><span class="fuente" style="font-size: 10px">
                    <?php
                    echo $det["precioUnitario"]
                    ?>
                </span></td>
            <td style="text-align: center;border-right: 1px solid"><span class="fuente" style="font-size: 10px">
                    <?php
                    echo $det["precioSubTotal"]
                    ?>
                </span></td>
            <td style="text-align: center;border-right: 1px solid"><span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["descuentoAplicado"]?></span></td>
            <td style="text-align: right;border-right: 1px solid"><span class="fuente" style="font-size: 10px"><?php echo $det["descuento"]?></span></td>
            <td style="text-align: right"><span class="fuente" style="font-size: 10px"><?php echo $det["precioTotal"]?></span></td>
        </tr>
    <?php }?>
    </tbody>

</table>
<table style="height: 5px"></table>
<table style="width: 100%;border:1px solid;margin-bottom: 10px">
    <tr>
        <td style="width: 60%">

        </td>
        <td style="width: 20px">
            <span class="fuente" style="font-size: 10px;padding-bottom: 0px">SUBTOTAL</span><br>
            <span class="fuente" style="font-size: 10px">IGV 18%</span><br>
            <span class="fuente" style="font-size: 10px">TOTAL</span>
        </td>
        <td style="width: 10px">
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["codigoMoneda"]?></span><br>
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["codigoMoneda"]?></span><br>
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["codigoMoneda"]?></span>
        </td>
        <td style="width: 20%; text-align: right">
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["subTotal"]?></span><br>
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["igv"]?></span><br>
            <span class="fuente" style="font-size: 10px"><?php echo $viewCotizacion[0]["total"]?></span><br>
        </td>
    </tr>
</table>

<table style="width: 100%;border:1px solid">
    <tr>
        <td>
            <strong class="fuente" style="font-size: 10px">Observaciones:</strong><span class="fuente" style="font-size: 10px"><br><?php  echo $viewCotizacion[0]["observaciones"]?></span><br>
            <strong class="fuente" style="font-size: 10px">CONDICIONES:</strong><br>
            <span class="fuente" style="font-size: 10px">
            ✓ Cotización valida por 10 días y sujeta a disponibilidad de stock en piezas.<br>
            ✓ Los plazos de importación están sujetos a disponibilidad de stock en fábrica.<br>
            ✓ La importación de piezas está sujeta al pago del 100% del precio de venta por adelantado.<br>
            ✓ La disponibilidad de repuestos es limitada para vehículos con 10 años de antigüedad o más.<br>
            ✓ Los precios y reemplazo de piezas en la presente cotización pueden variar sin previo aviso.<br>
            ✓ Los descuentos promocionales incluidos en los paquetes se perderán si algún ítem es retirado por instrucciones del cliente.</span>
        </td>
    </tr>
</table>