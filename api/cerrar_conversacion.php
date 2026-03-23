<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Conversacion.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data || !isset($data['conversacion_id'])) {
        throw new Exception('ID de conversación requerido');
    }
    
    $conversacion_id = (int)$data['conversacion_id'];
    
    // Cambiar estado a cerrada
    $resultado = Conversacion::cambiarEstado($conversacion_id, 'cerrada');
    
    if (!$resultado) {
        throw new Exception('Error al cerrar la conversación');
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Conversación cerrada'
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
