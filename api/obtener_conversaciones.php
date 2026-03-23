<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Conversacion.php';

try {
    $conversaciones = Conversacion::obtenerTodas(100);
    
    // Enriquecer datos
    $resultado = array_map(fn($conv) => array_merge($conv, [
        'no_leidos' => (int)$conv['no_leidos'],
        'estado_cliente' => $conv['estado_cliente'] ?? 'activo'
    ]), $conversaciones);
    
    echo json_encode([
        'success' => true,
        'conversaciones' => $resultado
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
