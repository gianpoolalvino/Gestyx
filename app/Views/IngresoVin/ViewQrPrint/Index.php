<style>
    body{
        margin: 0px;
        padding: 0px;
    }
</style>
        <table class="table fs-9 mb-0 border-top border-translucent table-hover" style="width: 302px">
            <?php
            $contador = 0;
            echo "<tr style='width: 151px;height: 151px'>"; // Comienza la primera fila
            foreach ($vins as $vn) {
                $contador++;
                ?>
                <td style="text-align: center;vertical-align: middle">
                    <strong style="font-size: 8px"><?php echo $vn["vin"] ?></strong><br>
                    <img src="<?php echo base_url($vn["rutaImagenQr"]); ?>" style="width: 110px" class="img-fluid"><br>
                    <strong style="font-size: 7px;letter-spacing: 0px"><?php echo $vn["marca"].' - '.$vn["modelo"] ?></strong>
                </td>
                <?php
                // Cada vez que llegamos a 2 elementos, cerramos la fila y comenzamos una nueva
                if ($contador % 2 == 0) {
                    echo "</tr><tr style='width: 151px;height: 151px'>"; // Cierra la fila actual y comienza una nueva
                }
            }
            // Si quedan elementos sin cerrar la fila, cerramos la última fila
            if ($contador % 2 != 0) {
                echo "</tr>";
            }
            ?>
        </table>
