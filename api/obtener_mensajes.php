<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Mensaje.php';

try {
    $conversacion_id = $_GET['conversacion_id'] ?? 0;
    
    if (!$conversacion_id) {
        throw new Exception('ID de conversación requerido');
    }
    
    $mensajes = Mensaje::obtenerPorConversacion($conversacion_id, 100);
    
    echo json_encode([
        'success' => true,
        'mensajes' => $mensajes
    ]);
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
