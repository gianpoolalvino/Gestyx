<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\VinModel;
use CodeIgniter\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Config\Database;

class ChatWsp extends BaseController
{

    public function Index()
    {
        echo view('ChatWhatsapp/Layouts/Head');
        echo view('ChatWhatsapp/Index/Index');
        echo view('ChatWhatsapp/Layouts/Footer');
        echo view('ChatWhatsapp/Index/Scripts');
    }
}