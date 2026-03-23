<?php
require_once __DIR__ . '/../database/conexion.php';

class Mensaje {
    
    public static function crear($cliente_id, $conversacion_id, $contenido, $remitente = 'cliente') {
        $db = conectarDB();
        
        $stmt = $db->prepare("
            INSERT INTO mensajes (cliente_id, conversacion_id, contenido, remitente, leido)
            VALUES (:cliente_id, :conversacion_id, :contenido, :remitente, 0)
        ");
        
        return $stmt->execute([
            ':cliente_id' => $cliente_id,
            ':conversacion_id' => $conversacion_id,
            ':contenido' => $contenido,
            ':remitente' => $remitente
        ]);
    }
    
    public static function obtenerPorConversacion($conversacion_id, $limit = 50) {
        $db = conectarDB();
        
        $stmt = $db->prepare("
            SELECT id, cliente_id, remitente, contenido, tipo, leido, fecha_envio, respuesta_manual
            FROM mensajes
            WHERE conversacion_id = :conversacion_id
            ORDER BY fecha_envio ASC
            LIMIT :limit
        ");
        
        $stmt->bindParam(':conversacion_id', $conversacion_id, PDO::PARAM_INT);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function marcarComoLeido($mensaje_id) {
        $db = conectarDB();
        
        $stmt = $db->prepare("
            UPDATE mensajes SET leido = 1 WHERE id = :id
        ");
        
        return $stmt->execute([':id' => $mensaje_id]);
    }
    
    public static function obtenerNoLeidos($cliente_id) {
        $db = conectarDB();
        
        $stmt = $db->prepare("
            SELECT COUNT(*) as total FROM mensajes
            WHERE cliente_id = :cliente_id AND leido = 0 AND remitente = 'cliente'
        ");
        
        $stmt->execute([':cliente_id' => $cliente_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
}
