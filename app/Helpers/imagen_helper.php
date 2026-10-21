<?php

/**
 * Imagenes de Gestyx: se guardan en disco (public/resource/...) y la BD solo
 * guarda la ruta relativa. Las filas antiguas aun pueden traer el base64 dentro
 * de la columna, asi que estas funciones resuelven ambos casos.
 */

if (!function_exists('imagen_es_ruta')) {
    /**
     * true si $valor es una ruta relativa a public/ (resource/... o controlcalidad/...)
     * y false si es contenido base64 heredado.
     */
    function imagen_es_ruta($valor): bool
    {
        return is_string($valor)
            && strlen($valor) < 400
            && preg_match('#^(resource|controlcalidad)/[^\s"\'<>]+\.[A-Za-z0-9]{2,5}$#', $valor) === 1;
    }
}

if (!function_exists('imagen_src')) {
    /**
     * Valor para el atributo src de un <img>: URL si esta en disco, data URI si es base64.
     */
    function imagen_src($valor, $tipo = 'jpeg'): string
    {
        if (imagen_es_ruta($valor)) {
            return base_url($valor);
        }
        return 'data:image/' . $tipo . ';base64,' . $valor;
    }
}

if (!function_exists('imagen_a_webp')) {
    /**
     * Convierte una imagen (JPG/PNG/GIF/WebP, en bytes) a WebP, la reduce a
     * $maxLado px por el lado mayor y corrige la orientacion EXIF de los celulares.
     * Devuelve los bytes WebP, o null si GD no puede (sin soporte WebP, formato raro...).
     */
    function imagen_a_webp(string $bytes, int $maxLado = 1600, int $calidad = 80): ?string
    {
        if (!function_exists('imagewebp') || !function_exists('imagecreatefromstring')) {
            return null;
        }
        $img = @imagecreatefromstring($bytes);
        if ($img === false) {
            return null;
        }

        // Fotos de celular/tablet: respetar la rotacion guardada en EXIF
        if (function_exists('exif_read_data') && str_starts_with($bytes, "\xFF\xD8")) {
            $mem = fopen('php://temp', 'r+');
            fwrite($mem, $bytes);
            rewind($mem);
            $exif = @exif_read_data($mem);
            fclose($mem);
            $giro = [3 => 180, 6 => -90, 8 => 90][$exif['Orientation'] ?? 1] ?? 0;
            if ($giro !== 0 && ($rot = imagerotate($img, $giro, 0)) !== false) {
                $img = $rot;
            }
        }

        $w = imagesx($img);
        $h = imagesy($img);
        if (max($w, $h) > $maxLado) {
            $k = $maxLado / max($w, $h);
            $esc = imagescale($img, max(1, (int) round($w * $k)), max(1, (int) round($h * $k)));
            if ($esc !== false) {
                $img = $esc;
            }
        }

        imagepalettetotruecolor($img);
        imagealphablending($img, false);
        imagesavealpha($img, true);   // conserva transparencia de los PNG

        ob_start();
        $ok = imagewebp($img, null, $calidad);
        $out = ob_get_clean();
        return ($ok && $out !== '') ? $out : null;
    }
}

if (!function_exists('imagen_guardar')) {
    /**
     * Guarda un archivo subido en public/resource/<subdir>/ y devuelve la ruta
     * relativa a public/ (la que se guarda en la BD), o null si falla.
     * Las imagenes se convierten a WebP reducido; si no se puede (PDF, GD sin WebP)
     * se guarda el archivo original tal cual.
     */
    function imagen_guardar(string $tmp, string $subdir, string $prefijo, string $ext): ?string
    {
        $subdir  = trim(preg_replace('#[^A-Za-z0-9_/\-]#', '', $subdir), '/');
        $ext     = strtolower(preg_replace('/[^A-Za-z0-9]/', '', $ext));
        $prefijo = preg_replace('/[^A-Za-z0-9_\-]/', '', $prefijo);
        if ($subdir === '' || $ext === '') {
            return null;
        }

        $dir = FCPATH . 'resource/' . $subdir . '/';
        if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
            return null;
        }

        $base = $prefijo . '_' . bin2hex(random_bytes(6));

        if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp'], true)) {
            $webp = imagen_a_webp((string) file_get_contents($tmp));
            if ($webp !== null && file_put_contents($dir . $base . '.webp', $webp) !== false) {
                return 'resource/' . $subdir . '/' . $base . '.webp';
            }
        }

        $nombre = $base . '.' . $ext;
        if (!move_uploaded_file($tmp, $dir . $nombre)) {
            return null;
        }
        return 'resource/' . $subdir . '/' . $nombre;
    }
}
