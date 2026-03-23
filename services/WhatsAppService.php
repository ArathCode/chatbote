<?php

/**
 * Responder via webhook (para mensajes que llegan de Twilio)
 */
function responder($mensaje, $fotos = []) {

    $mensaje_safe = htmlspecialchars($mensaje, ENT_XML1, 'UTF-8');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        header("Content-Type: text/xml; charset=utf-8");

        echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
        echo "<Response>";

        // 🔥 Si hay fotos → manda texto + UNA imagen
        if (!empty($fotos) && is_array($fotos)) {

            $foto_safe = htmlspecialchars($fotos[0], ENT_XML1, 'UTF-8');

            echo "<Message>";
            echo "<Body>$mensaje_safe</Body>";
            echo "<Media>$foto_safe</Media>";
            echo "</Message>";

        } else {
            // Solo texto
            echo "<Message>$mensaje_safe</Message>";
        }

        echo "</Response>";

    } else {
        // Debug navegador
        header("Content-Type: text/plain; charset=utf-8");

        echo $mensaje;

        if (!empty($fotos)) {
            echo "\n\nFotos:\n";
            foreach ($fotos as $foto) {
                echo "- $foto\n";
            }
        }
    }
}

/**
 * Enviar mensaje a través de Twilio API
 * Útil para respuestas manuales desde el panel admin
 */
function enviarPorWhatsApp($telefonoDestino, $mensaje) {
    
    // Asegurar que el teléfono tenga formato de Twilio
    if (strpos($telefonoDestino, 'whatsapp:') === false) {
        $telefonoDestino = 'whatsapp:' . $telefonoDestino;
    }
    
    // El número de Twilio debe estar configurado (número oficial del servicio)
    $numeroTwilio = 'whatsapp:+525512345678'; // Cambiar por el número real de Twilio
    
    $url = 'https://api.twilio.com/2010-04-01/Accounts/' . TWILIO_ACCOUNT_SID . '/Messages.json';
    
    $data = [
        'From' => $numeroTwilio,
        'To' => $telefonoDestino,
        'Body' => $mensaje
    ];
    
    $ch = curl_init($url);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_USERPWD, TWILIO_ACCOUNT_SID . ':' . TWILIO_AUTH_TOKEN);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 201 || $httpCode === 200) {
        return [
            'success' => true,
            'message' => 'Mensaje enviado exitosamente'
        ];
    } else {
        $responseData = json_decode($response, true);
        return [
            'success' => false,
            'error' => $responseData['message'] ?? 'Error desconocido en Twilio',
            'code' => $httpCode
        ];
    }
}