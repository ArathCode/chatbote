<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../models/Mensaje.php';
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../models/Conversacion.php';
require_once __DIR__ . '/../services/WhatsAppService.php';

try {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (!$data || !isset($data['cliente_id']) || !isset($data['conversacion_id']) || !isset($data['mensaje'])) {
        throw new Exception('Datos incompletos');
    }
    
    $cliente_id = (int)$data['cliente_id'];
    $conversacion_id = (int)$data['conversacion_id'];
    $mensaje = trim($data['mensaje']);
    
    if (empty($mensaje)) {
        throw new Exception('Mensaje vacío');
    }
    
    // Guardar mensaje en BD
    Mensaje::crear($cliente_id, $conversacion_id, $mensaje, 'admin');
    
    // Obtener teléfono del cliente
    $cliente = Cliente::obtenerPorId($cliente_id);
    if (!$cliente) {
        throw new Exception('Cliente no encontrado');
    }
    
    // Enviar por WhatsApp vía Twilio
    $resultado = enviarPorWhatsApp($cliente['telefono'], $mensaje);
    
    if (!$resultado['success']) {
        throw new Exception('Error enviando por WhatsApp: ' . $resultado['error']);
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Mensaje enviado correctamente'
    ]);
    
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
