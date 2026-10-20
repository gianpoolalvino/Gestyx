<?php
namespace App\Config;

use CodeIgniter\Session\Handlers\DatabaseHandler;
use CodeIgniter\Config\BaseConfig;

class CustomSessionHandler extends BaseConfig
{
    public $handler = 'database'; // Usa 'database' para usar el controlador de base de datos
    public $savePath = 'session_db'; // Nombre de la base de datos de sesiones en la configuración de base de datos

    public $sessionDriver = 'CodeIgniter\Session\Handlers\DatabaseHandler';
    public $sessionSavePath = 'session_db'; // Utiliza la configuración de la base de datos secundaria
}