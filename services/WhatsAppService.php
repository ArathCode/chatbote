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
    
    // Validar que tengamos credenciales
    if (!defined('TWILIO_ACCOUNT_SID') || !TWILIO_ACCOUNT_SID) {
        return [
            'success' => false,
            'error' => 'TWILIO_ACCOUNT_SID no está configurado en config.php'
        ];
    }
    
    if (!defined('TWILIO_AUTH_TOKEN') || !TWILIO_AUTH_TOKEN) {
        return [
            'success' => false,
            'error' => 'TWILIO_AUTH_TOKEN no está configurado en config.php'
        ];
    }
    
    // Asegurar que el teléfono tenga formato de Twilio
    $telefonoOriginal = $telefonoDestino;
    if (strpos($telefonoDestino, 'whatsapp:') === false) {
        $telefonoDestino = 'whatsapp:' . $telefonoDestino;
    }
    
    // El número de Twilio debe estar configurado (número oficial del servicio)
    $numeroTwilio = 'whatsapp:+5215631580844'; // ← Tu número Twilio
    
    $url = 'https://api.twilio.com/2010-04-01/Accounts/' . TWILIO_ACCOUNT_SID . '/Messages.json';
    
    $data = [
        'From' => $numeroTwilio,
        'To' => $telefonoDestino,
        'Body' => $mensaje
    ];
    
    // LOG: Registrar intento de envío
    error_log('[TWILIO DEBUG] Intentando enviar mensaje');
    error_log('[TWILIO DEBUG] URL: ' . $url);
    error_log('[TWILIO DEBUG] From: ' . $numeroTwilio);
    error_log('[TWILIO DEBUG] To: ' . $telefonoDestino);
    error_log('[TWILIO DEBUG] Account SID: ' . substr(TWILIO_ACCOUNT_SID, 0, 5) . '...');
    
    $ch = curl_init($url);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_USERPWD, TWILIO_ACCOUNT_SID . ':' . TWILIO_AUTH_TOKEN);
    curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Para desarrollo local
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    // LOG: Registrar respuesta
    error_log('[TWILIO DEBUG] HTTP Code: ' . $httpCode);
    error_log('[TWILIO DEBUG] Response: ' . substr($response, 0, 500));
    
    if ($curlError) {
        error_log('[TWILIO ERROR] CURL Error: ' . $curlError);
        return [
            'success' => false,
            'error' => 'Error de conexión CURL: ' . $curlError
        ];
    }
    
    if ($httpCode === 201 || $httpCode === 200) {
        error_log('[TWILIO SUCCESS] Mensaje enviado correctamente');
        return [
            'success' => true,
            'message' => 'Mensaje enviado exitosamente',
            'code' => $httpCode
        ];
    } else {
        $responseData = json_decode($response, true);
        $errorMsg = '';
        
        if ($responseData && isset($responseData['message'])) {
            $errorMsg = $responseData['message'];
        } elseif ($responseData && isset($responseData['error_message'])) {
            $errorMsg = $responseData['error_message'];
        } else {
            $errorMsg = 'Error desconocido en Twilio (Code: ' . $httpCode . ')';
        }
        
        error_log('[TWILIO ERROR] ' . $errorMsg);
        
        return [
            'success' => false,
            'error' => $errorMsg,
            'code' => $httpCode,
            'full_response' => $response
        ];
    }
}