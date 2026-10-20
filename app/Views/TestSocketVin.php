<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta VIN - Marca y Modelo</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        input, button { padding: 8px; font-size: 16px; }
        pre { background: #f0f0f0; padding: 10px; }
    </style>
</head>
<body>
<h2>Consulta de Marca y Modelo por VIN</h2>
<input type="text" id="vinInput" placeholder="Ingresa VIN completo" />
<button onclick="enviarVIN()">Consultar</button>
<h3>Resultado:</h3>
<pre id="respuesta">Esperando consulta...</pre>

<script>
    const ws = new WebSocket('ws://localhost:7476');

    ws.onopen = () => {
        console.log('✅ Conectado al WebSocket');
    };

    ws.onmessage = (event) => {
        document.getElementById('respuesta').textContent = event.data;
    };

    function enviarVIN() {
        const vin = document.getElementById('vinInput').value.trim();
        if (vin.length < 11) {
            alert('El VIN debe tener al menos 11 caracteres');
            return;
        }
        ws.send(vin);
        document.getElementById('respuesta').textContent = '⌛ Consultando...';
    }
</script>
</body>
</html>
