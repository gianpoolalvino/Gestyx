<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\AccessModel;
use App\Models\AlistamientoVehicularModel;
use App\Models\ControlDemosModel;
use App\Models\VinModel;
use CodeIgniter\Controller;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\WriterInterface;


use Config\Database;


class Test extends BaseController
{
    public function TestIntegration()
    {

    }

    public function TestSocketVin()
    {
        echo view("TestSocketVin");
    }
    public function TestLectorQr()
    {
        echo view("Test/TestLectorQr/Index");
    }

    public function TestQr()
    {
        // Datos que quieres codificar en el QR
        $data = $_GET["vin"];

        // Crear el objeto QrCode
        $qrCode = new QrCode($data);

        // Configurar el tamaño del QR
        $qrCode->setSize(350); // Ajusta el tamaño aquí

        // Configurar el nivel de corrección de errores
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::High);

        // Configurar color y margen

        $qrCode->setMargin(2);  // Márgenes alrededor del QR

        // Crear el escritor PNG para generar la imagen
        $writer = new PngWriter();

        // Obtener el QR generado como string binario
        $result = $writer->write($qrCode);
        $qrImage = $result->getString(); // Aquí usamos getString() para obtener el binario de la imagen

        // Crear imagen desde el binario
        $qrImageResource = imagecreatefromstring($qrImage);

        // Definir el directorio donde quieres guardar la imagen
        $savePath = 'resource/qr/operaciones/'; // Asegúrate de que esta carpeta exista

        // Crear la carpeta si no existe
        if (!is_dir($savePath)) {
            mkdir($savePath, 0777, true);
        }

        // Nombre del archivo de imagen (con timestamp para evitar conflictos)
        $filename = '9BG148ZK0RC401163.png';

        // Ruta del logo que deseas agregar
        $logoPath = 'resource/img/logoQr.png'; // Cambia esto a la ruta de tu logo

        // Verifica que el logo exista
        if (file_exists($logoPath)) {
            // Crear una imagen a partir del logo
            $logo = imagecreatefrompng($logoPath);

            // Obtener dimensiones de la imagen QR y del logo
            $qrWidth = imagesx($qrImageResource);
            $qrHeight = imagesy($qrImageResource);
            $logoWidth = imagesx($logo);
            $logoHeight = imagesy($logo);

            // Determina el tamaño máximo que quieres para el logo
            $maxLogoWidth = $qrWidth / 4.5; // Redimensiona el logo al 20% del tamaño del QR
            $maxLogoHeight = $qrHeight / 4.5;

            // Mantener la relación de aspecto original
            $logoAspectRatio = $logoWidth / $logoHeight;

            // Calcular las nuevas dimensiones
            if ($logoWidth > $maxLogoWidth || $logoHeight > $maxLogoHeight) {
                if ($logoWidth / $maxLogoWidth > $logoHeight / $maxLogoHeight) {
                    $newLogoWidth = $maxLogoWidth;
                    $newLogoHeight = $maxLogoWidth / $logoAspectRatio;
                } else {
                    $newLogoHeight = $maxLogoHeight;
                    $newLogoWidth = $maxLogoHeight * $logoAspectRatio;
                }
            } else {
                $newLogoWidth = $logoWidth;
                $newLogoHeight = $logoHeight;
            }

            // Redimensionar el logo a las nuevas dimensiones
            $resizedLogo = imagescale($logo, $newLogoWidth, $newLogoHeight);

            // Calcular la posición del logo para centrarlo en la imagen QR
            $logoX = ($qrWidth - $newLogoWidth) / 2;
            $logoY = ($qrHeight - $newLogoHeight) / 2;

            // Combinar el logo con la imagen QR
            imagecopy($qrImageResource, $resizedLogo, $logoX, $logoY, 0, 0, $newLogoWidth, $newLogoHeight);

            // Liberar memoria del logo redimensionado
            imagedestroy($resizedLogo);
        }

        // Guardar la imagen final en el servidor
        imagepng($qrImageResource, $savePath . $filename);

        $img="<img src='".base_url($savePath . $filename)."'>";
        // Liberar memoria
        imagedestroy($qrImageResource);
        if (isset($logo)) {
            imagedestroy($logo);
        }

        // Mostrar el enlace al archivo generado
        echo $img;
    }


    public function NavBarTest()
    {
        $accessModel=New AccessModel();
        $idusuario=session("idusuario");

        $navGru=$accessModel->NavBarRol($idusuario,2);

        foreach($navGru as $nv){
            echo $nv["descripcion"]." - ".$nv["url"]."<br>";
        }

    }
    public function Index()
    {
        // Conectar a la base de datos 'sessionDB'
        $db = Database::connect('sesiones');
        // Verificar la conexión
        if ($db->connID) {
            echo "Conexión exitosa a la base de datos para sesiones.";
        } else {
            echo "No se pudo conectar a la base de datos para sesiones.";
        }

    }

    public function SocketClient(){

            echo view('ChatWhatsapp/Layouts/Head');
            echo view('ChatWhatsapp/Index/Index');
            echo view('ChatWhatsapp/Layouts/Footer');
            echo view('ChatWhatsapp/Index/Scripts');

    }

    public function Socket(){

        $dato=[
            'numeroSession'=>isset($_GET["numeroSession"])?$_GET["numeroSession"]:'',
            'token'=>isset($_GET["token"])?$_GET["token"]:''
        ];

        if($_GET["op"]==='admin'){
            echo view('TestQr');
        }else{
            echo view('Test',$dato);
        }

    }

    public function SendMailer()
    {

        // Cargar la vista que será utilizada como plantilla
        $message = view('NotificacionCorreo/SolicitudVehicular/RegistroSolicitud', ['name' => 'Usuario']);
        // Configuración de PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';                // Especificar el servidor SMTP
            $mail->SMTPAuth   = true;
            $mail->Username   = 'german.torres@autoniza.com';           // Tu dirección de correo
            $mail->Password   = 'Mylu2025!';                 // Tu contraseña de correo
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;                             // Puerto para TLS

            // Remitente y destinatarios
            $mail->setFrom('applogistica@gmail.com', 'App Logistica');
            $mail->addAddress('analistaoperaciones@autoniza.com', 'Marian Medina');  // Agregar un destinatario

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Correo de Prueba con Plantilla';
            $mail->Body    = $message;  // El contenido HTML de la plantilla
            $mail->AltBody = strip_tags($message);  // Texto alternativo en caso de que no se pueda leer el HTML

            // Enviar el correo
            $mail->send();
            return 'Correo enviado con éxito';
        } catch (Exception $e) {
            return "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    }

    public function IntegrationDms()
    {
        $ruta=env("CI_ENVIRONMENT");
        echo $ruta;
    }

    public function IntegrationTestPtesa()
    {
        $token=$this->GenerarTokenPtesa();
        // URL del endpoint
       // $compani=100025;
        $url = 'https://habilitacionfer.ptesa.com.co/api/fer/companies/242/billing-documents/searches';
        // $url='https://recepcion.ptesa.com.co/api/fer/companies/'.$compani.'/billingdocuments/searches';
        // Inicializa una sesión cURL
        $ch = curl_init($url);
// Establece los encabezados
        $headers = [
            'Authorization: Bearer '.$token,
            'Content-Type: application/json',
        ];
        // Configura las opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);


// Define los datos a enviar en la solicitud POST
        $data = [
            'issueDateRange' => [
                'startDate' => '2024-07-04T00:00:00-05:00',
                'endDate' => '2024-07-10T23:59:59-05:00'
            ],
        ];

// Convierte los datos a formato JSON
        $jsonData = json_encode($data);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

// Ejecuta la solicitud cURL
        $response = curl_exec($ch);
// Verifica si hubo errores en la solicitud
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            // Imprime el código de estado HTTP
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            echo 'HTTP Code: ' . $httpCode . PHP_EOL;

            // Imprime la respuesta del servidor
            echo "<pre>";
            print_r(json_decode($response));
          //  echo 'Response: ' . $response;
        }

// Cierra la sesión cURL
        curl_close($ch);
    }

    public function GenerarTokenPtesa(){
        // URL del endpoint para obtener el token
        $url = 'https://sso.ptesa.com.co/auth/realms/ptesa/protocol/openid-connect/token';
       // $url = 'https://accounts.ptesa.com.co/auth/realms/ptesa/protocol/openid-connect/token';
// Inicializa una sesión cURL
        $ch = curl_init($url);

// Configura las opciones de cURL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);

// Define los datos a enviar en la solicitud POST
        $data = [
            'client_id' => 'invoice-receipt-autoniza',
            'grant_type' => 'client_credentials',
            'client_secret' => '6c50282b-4755-498b-b150-bf3f12a5f901'
        ];
// Convierte los datos a formato URL-encoded
        $encodedData = http_build_query($data);
// Configura los campos de POST
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
// Configura los encabezados
        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// Ejecuta la solicitud cURL
        $response = curl_exec($ch);
// Verifica si hubo errores en la solicitud
        if (curl_errno($ch)) {
            echo 'cURL Error: ' . curl_error($ch);
        } else {
            // Imprime la respuesta del servidor
            return json_decode($response)->access_token;
        }
// Cierra la sesión cURL
        curl_close($ch);
    }
}

