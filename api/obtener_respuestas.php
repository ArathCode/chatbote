<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../database/conexion.php';

try {
    $db = conectarDB();
    $stmt = $db->prepare("SELECT id, emoji, titulo, contenido FROM respuestas_predefinidas ORDER BY id");
    $stmt->execute();
    $respuestas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'respuestas' => $respuestas
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}
