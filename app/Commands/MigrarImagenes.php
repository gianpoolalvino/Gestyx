<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/**
 * Migra las imagenes guardadas como base64 dentro de la BD a archivos en
 * public/resource/ y deja en la BD solo la ruta.
 *
 *   php spark imagenes:migrar --db=logistica_peru                      (simulacion)
 *   php spark imagenes:migrar --db=logistica_peru --aplicar            (migra todo)
 *   php spark imagenes:migrar --db=logistica_peru --tabla=ingresovin --limite=500 --aplicar
 *
 * Es reanudable: solo toma filas que aun no tienen ruta, y los nombres de archivo
 * son deterministas (<id>[_n].<ext>), asi que repetirlo no duplica nada.
 */
class MigrarImagenes extends BaseCommand
{
    protected $group       = 'Gestyx';
    protected $name        = 'imagenes:migrar';
    protected $description = 'Mueve las imagenes base64 de la BD a public/resource/ y guarda solo la ruta.';
    protected $usage       = 'imagenes:migrar --db=<base> [--tabla=<tabla>] [--limite=<n>] [--aplicar] [--conservar-blob]';
    protected $options     = [
        '--db'             => 'Base de datos a migrar (obligatorio, ej. logistica_peru).',
        '--tabla'          => 'Solo esa tabla. Por defecto las cuatro.',
        '--limite'         => 'Maximo de filas por tabla (para probar).',
        '--aplicar'        => 'Escribe archivos y actualiza la BD. Sin esto es solo simulacion.',
        '--conservar-blob' => 'No vaciar la columna blob original despues de migrar.',
        '--webp'           => 'Convierte las imagenes a WebP (max 1600 px, calidad 80). Con perdida: no se recupera el original.',
    ];

    /**
     * pk: clave primaria | vin: columna VIN o null | carpeta: subcarpeta bajo resource/
     * flag: [columna => valor] que marca "esta en disco" | cols: imagenes de la fila
     * Cada col: blob (columna con el base64), tipo (columna con la extension),
     * ruta (columna aparte para la ruta; null = la ruta se guarda en la misma columna blob).
     */
    private bool $webp = false;
    private string $dbName = '';

    private array $tablas = [
        'ingresovin' => [
            'pk' => 'idingresoVin', 'vin' => 'vin', 'carpeta' => 'ingresoVin/{vin}/Guia', 'flag' => [],
            'cols' => [['blob' => 'imagenGuia', 'tipo' => 'tipoImagen', 'ruta' => null]],
        ],
        'detalleingresovehiculoimagen' => [
            'pk' => 'iddetalleIngresoVehiculoImagen', 'vin' => 'vin', 'carpeta' => 'ingresoVin/{vin}', 'flag' => ['idtipoCarga' => 2],
            'cols' => [['blob' => 'imagenVehiculo', 'tipo' => 'tipoImagen', 'ruta' => null]],
        ],
        'detallechecklistcalidad' => [
            'pk' => 'iddetalleCheckListCalidad', 'vin' => null, 'carpeta' => 'controlCalidad/{db}', 'flag' => ['idtipoCarga' => 2],
            'cols' => [['blob' => 'imagenAdjunto', 'tipo' => 'tipoImagen', 'ruta' => 'rutaImagen']],
        ],
        'observacioningresovin' => [
            'pk' => 'idobservacionIngresoVin', 'vin' => 'vin', 'carpeta' => 'ingresoVin/{vin}/DetailObservacion', 'flag' => ['idtipoCargaImagen' => 2],
            'cols' => [
                ['blob' => 'imagenVehiculo1', 'tipo' => 'tipoImagen1', 'ruta' => 'rutaImagen1'],
                ['blob' => 'imagenVehiculo2', 'tipo' => 'tipoImagen2', 'ruta' => 'rutaImagen2'],
                ['blob' => 'imagenVehiculo3', 'tipo' => 'tipoImagen3', 'ruta' => 'rutaImagen3'],
            ],
        ],
    ];

    public function run(array $params)
    {
        ini_set('memory_limit', '1024M');
        set_time_limit(0);

        helper('imagen');
        $opts = CLI::getOptions();           // una bandera sin valor (--aplicar) llega como null
        $dbName = $opts['db'] ?? null;
        if (!$dbName) {
            CLI::error('Falta --db=<base de datos>');
            return EXIT_ERROR;
        }
        $aplicar   = array_key_exists('aplicar', $opts);
        $conservar = array_key_exists('conservar-blob', $opts);
        $this->webp = array_key_exists('webp', $opts);
        if ($this->webp && !function_exists('imagewebp')) {
            CLI::error('Este PHP no tiene soporte WebP en GD (php-gd). Instalalo o quita --webp.');
            return EXIT_ERROR;
        }
        $limite    = (int) ($opts['limite'] ?? 0);
        $soloTabla = $opts['tabla'] ?? null;

        if ($soloTabla && !isset($this->tablas[$soloTabla])) {
            CLI::error('Tabla no soportada. Opciones: ' . implode(', ', array_keys($this->tablas)));
            return EXIT_ERROR;
        }

        $this->dbName = preg_replace('/[^A-Za-z0-9_\-]/', '', $dbName);
        $cfg = (array) config('Database')->default;
        $cfg['database'] = $dbName;
        $db = \Config\Database::connect($cfg);

        CLI::write($aplicar ? 'MODO REAL: se escribiran archivos y se actualizara la BD.' : 'SIMULACION: no se escribe nada (usa --aplicar para migrar).', $aplicar ? 'red' : 'yellow');
        CLI::write("Base: {$dbName}   Destino: " . FCPATH . 'resource/');

        $total = ['filas' => 0, 'imagenes' => 0, 'bytes' => 0, 'omitidas' => 0];
        foreach ($this->tablas as $tabla => $def) {
            if ($soloTabla && $soloTabla !== $tabla) {
                continue;
            }
            $this->migrarTabla($db, $tabla, $def, $aplicar, $conservar, $limite, $total);
        }

        CLI::newLine();
        CLI::write(sprintf(
            'Resumen: %d filas, %d imagenes, %.1f MB %s, %d omitidas.',
            $total['filas'], $total['imagenes'], $total['bytes'] / 1048576,
            $aplicar ? 'escritos a disco' : 'por migrar', $total['omitidas']
        ), 'green');
        if ($aplicar && !$conservar) {
            CLI::write('Para recuperar el espacio en MariaDB ejecuta luego: OPTIMIZE TABLE <tabla>;', 'yellow');
        }
        return EXIT_SUCCESS;
    }

    private function migrarTabla($db, string $tabla, array $def, bool $aplicar, bool $conservar, int $limite, array &$total): void
    {
        CLI::newLine();
        CLI::write("== {$tabla}", 'cyan');

        // filas pendientes: alguna columna blob con contenido que no sea ya una ruta
        $pend = [];
        foreach ($def['cols'] as $c) {
            $pend[] = "(`{$c['blob']}` IS NOT NULL AND LENGTH(`{$c['blob']}`) > 0 AND LEFT(`{$c['blob']}`, 9) <> 'resource/' AND LEFT(`{$c['blob']}`, 15) <> 'controlcalidad/')";
        }
        $where = '(' . implode(' OR ', $pend) . ')';
        $pk = $def['pk'];

        $ultimo = 0;
        $hechas = 0;
        while (true) {
            $ids = $db->query("SELECT `{$pk}` AS id FROM `{$tabla}` WHERE {$pk} > ? AND {$where} ORDER BY `{$pk}` LIMIT 200", [$ultimo])->getResultArray();
            if (!$ids) {
                break;
            }
            foreach ($ids as $r) {
                $id = (int) $r['id'];
                $ultimo = $id;
                if ($limite > 0 && $hechas >= $limite) {
                    break 2;
                }
                $hechas++;
                $total['filas']++;
                $this->migrarFila($db, $tabla, $def, $id, $aplicar, $conservar, $total);
                if ($hechas % 100 === 0) {
                    CLI::write("   {$hechas} filas procesadas (ultimo id {$id})");
                }
            }
        }
        CLI::write("   {$hechas} filas en {$tabla}");
    }

    private function migrarFila($db, string $tabla, array $def, int $id, bool $aplicar, bool $conservar, array &$total): void
    {
        $campos = [];
        foreach ($def['cols'] as $c) {
            $campos[] = "`{$c['blob']}`";
            $campos[] = "`{$c['tipo']}`";
        }
        if ($def['vin']) {
            $campos[] = "`{$def['vin']}` AS _vin";
        }
        $row = $db->query('SELECT ' . implode(', ', $campos) . " FROM `{$tabla}` WHERE `{$def['pk']}` = ?", [$id])->getRowArray();
        if (!$row) {
            return;
        }

        $vin = $def['vin'] ? preg_replace('/[^A-Za-z0-9_\-]/', '', (string) $row['_vin']) : '';
        if ($def['vin'] && $vin === '') {
            $vin = 'sin_vin';
        }
        $carpeta = str_replace(['{vin}', '{db}'], [$vin, $this->dbName], $def['carpeta']);

        $set = [];
        foreach ($def['cols'] as $n => $c) {
            $valor = $row[$c['blob']];
            if ($valor === null || $valor === '' || imagen_es_ruta($valor)) {
                continue;
            }

            [$bytes, $ext] = $this->decodificar((string) $valor);
            if ($bytes === null) {
                CLI::write("   ! {$tabla} id {$id} ({$c['blob']}): formato no reconocido, se omite", 'yellow');
                $total['omitidas']++;
                continue;
            }

            // Con --webp se recomprime, pero solo si realmente queda mas liviana
            if ($this->webp && $ext !== 'pdf') {
                $liviana = imagen_a_webp($bytes);
                if ($liviana !== null && strlen($liviana) < strlen($bytes)) {
                    $bytes = $liviana;
                    $ext = 'webp';
                }
            }

            // <base>_<id>[_n].<ext>: el prefijo de base evita pisar archivos entre paises
            $rel = 'resource/' . $carpeta . '/' . $this->dbName . '_' . $id . (count($def['cols']) > 1 ? '_' . ($n + 1) : '') . '.' . $ext;
            $total['imagenes']++;
            $total['bytes'] += strlen($bytes);

            if (!$aplicar) {
                continue;
            }

            $dir = FCPATH . dirname($rel);
            if (!is_dir($dir) && !mkdir($dir, 0775, true)) {
                CLI::error("   No se pudo crear {$dir}");
                $total['omitidas']++;
                continue;
            }
            $destino = FCPATH . $rel;
            if (file_put_contents($destino, $bytes) !== strlen($bytes) || filesize($destino) !== strlen($bytes)) {
                CLI::error("   Escritura incompleta en {$rel}, se omite");
                @unlink($destino);
                $total['omitidas']++;
                continue;
            }

            if ($c['ruta'] === null) {
                $set[$c['blob']] = $rel;                     // la ruta reemplaza al base64 en la misma columna
            } else {
                $set[$c['ruta']] = $rel;
                $set[$c['blob']] = $conservar ? $valor : null;
            }
            $set[$c['tipo']] = $ext;                         // tipoImagen refleja el formato real del archivo
        }

        if ($aplicar && $set) {
            foreach ($def['flag'] as $col => $val) {
                $set[$col] = $val;
            }
            $db->table($tabla)->where($def['pk'], $id)->update($set);
        }
    }

    /** @return array{0:?string,1:string} bytes binarios y extension, o [null,''] si no se reconoce */
    private function decodificar(string $valor): array
    {
        $valor = preg_replace('#^data:[^,]*;base64,#', '', trim($valor));
        $bin = base64_decode($valor, true);
        if ($bin === false || $bin === '') {
            $bin = $valor; // quiza ya sea binario crudo
        }

        $ext = match (true) {
            str_starts_with($bin, "\xFF\xD8\xFF")         => 'jpg',
            str_starts_with($bin, "\x89PNG")              => 'png',
            str_starts_with($bin, '%PDF')                 => 'pdf',
            str_starts_with($bin, 'GIF8')                 => 'gif',
            str_starts_with($bin, 'RIFF') && substr($bin, 8, 4) === 'WEBP' => 'webp',
            default                                       => '',
        };
        if ($ext === '') {
            return [null, ''];
        }
        return [$bin, $ext];
    }
}
