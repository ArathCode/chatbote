<?php
require_once __DIR__ . '/../database/conexion.php';

class Conversacion {
    
    public static function obtenerOCrear($cliente_id) {
        $db = conectarDB();
        
        // Buscar conversación abierta
        $stmt = $db->prepare("
            SELECT id FROM conversaciones 
            WHERE cliente_id = :cliente_id AND estado = 'abierta'
            ORDER BY fecha_inicio DESC
            LIMIT 1
        ");
        
        $stmt->execute([':cliente_id' => $cliente_id]);
        $conv = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($conv) {
            return $conv['id'];
        }
        
        // Crear nueva conversación
        $stmt = $db->prepare("
            INSERT INTO conversaciones (cliente_id, estado)
            VALUES (:cliente_id, 'abierta')
        ");
        
        $stmt->execute([':cliente_id' => $cliente_id]);
        return $db->lastInsertId();
    }
    
    public static function obtenerTodas($limit = 100) {
        $db = conectarDB();
        
        $stmt = $db->prepare("
            SELECT 
                c.id,
                c.cliente_id,
                c.estado,
                c.fecha_inicio,
                cl.nombre,
                cl.telefono,
                (SELECT COUNT(*) FROM mensajes WHERE conversacion_id = c.id AND leido = 0 AND remitente = 'cliente') as no_leidos,
                (SELECT contenido FROM mensajes WHERE conversacion_id = c.id ORDER BY fecha_envio DESC LIMIT 1) as ultimo_mensaje,
                (SELECT fecha_envio FROM mensajes WHERE conversacion_id = c.id ORDER BY fecha_envio DESC LIMIT 1) as ultimo_mensaje_fecha
            FROM conversaciones c
            JOIN clientes cl ON c.cliente_id = cl.id
            WHERE c.estado = 'abierta'
            ORDER BY ultimo_mensaje_fecha DESC
            LIMIT :limit
        ");
        
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function obtenerPorId($id) {
        $db = conectarDB();
        
        $stmt = $db->prepare("
            SELECT 
                c.id,
                c.cliente_id,
                c.estado,
                c.fecha_inicio,
                cl.nombre,
                cl.telefono,
                cl.estado as estado_cliente
            FROM conversaciones c
            JOIN clientes cl ON c.cliente_id = cl.id
            WHERE c.id = :id
        ");
        
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function cambiarEstado($conversacion_id, $estado) {
        $db = conectarDB();
        
        $campo = $estado === 'cerrada' ? 'fecha_fin' : 'NULL';
        $sql = "UPDATE conversaciones SET estado = :estado" . 
               ($estado === 'cerrada' ? ", fecha_fin = NOW()" : "") . 
               " WHERE id = :id";
        
        $stmt = $db->prepare($sql);
        
        return $stmt->execute([
            ':estado' => $estado,
            ':id' => $conversacion_id
        ]);
    }
}
