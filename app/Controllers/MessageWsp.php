<?php
namespace App\Controllers;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
class MessageWsp extends BaseController {
    private $clientUrl = 'http://localhost:5000'; // URL del servidor Node.js
    // Función para obtener el código QR de una sesión específica
    public function get_qr($sessionId) {
        // Llamar al servidor Node.js para obtener el QR
        $ch = curl_init("http://localhost:5000/get-qr/".$sessionId);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        // Ejecutar la petición y almacenar la respuesta
        $response = curl_exec($ch);

        // Verificar si ocurrió un error
        if (curl_errno($ch)) {
            echo 'Error cURL: ' . curl_error($ch);
        }

        // Cerrar la sesión cURL
        curl_close($ch);

        // Si la respuesta está en formato JSON, decodificarla
        $data = json_decode($response, true);

        var_dump($data);
        // Verificar si la respuesta contiene el campo "qr"
        if (isset($data['qr'])) {
            echo json_encode(['qr' => $data['qr']]);
        } else {
            echo json_encode(['error' => 'No se pudo obtener el QR']);
        }
    }

    // Nueva función para verificar si la sesión está activa
    public function check_session() {
        // Llamar al servidor Node.js para verificar si la sesión está activa
        $ch = curl_init('http://localhost:5000/get-qr/session');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error cURL: ' . curl_error($ch);
        }

        curl_close($ch);

        $data = json_decode($response, true);

        // Si hay QR, entonces hay una sesión activa
        if (isset($data['qr'])) {
            echo json_encode(['qr' => $data['qr']]); // Sesión activa
        } else {
            echo json_encode(['qr' => null]); // No hay sesión activa
        }
    }

    // Función para iniciar una sesión
    public function start_session() {
        // Recibir el sessionId desde la solicitud
        $sessionId = $this->request->getPost('sessionId');

        // Llamar al servidor Node.js para iniciar la sesión
        $url = "{$this->clientUrl}/start-session";
        $data = ['sessionId' => $sessionId];

        // Usar cURL para enviar datos a Node.js
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);
        curl_close($ch);

        echo $response;
    }

    // Función para enviar un mensaje
    public function send_message() {
        // Recibir los datos de la solicitud AJAX
        $phoneNumber = $_POST["phoneNumber"];
        $message = $_POST["message"];
        $sessionId = $_POST["sessionId"]; // Ahora se incluye el sessionId

        // Llamar al servidor Node.js para enviar el mensaje
        $url = "{$this->clientUrl}/send-message";
        $data = array(
            'phoneNumber' => $phoneNumber,
            'message' => $message,
            'sessionId' => $sessionId // Incluir sessionId
        );

        // Usar cURL para enviar datos a Node.js
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $response = curl_exec($ch);
        curl_close($ch);

        echo $response;
    }
}
