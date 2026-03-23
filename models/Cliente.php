<?php
require_once __DIR__ . '/../database/conexion.php';

class Cliente {
    
    public static function obtenerOCrear($telefono, $nombre = 'Usuario') {
        $db = conectarDB();
        
        // Buscar cliente existente
        $stmt = $db->prepare("SELECT id FROM clientes WHERE telefono = :telefono");
        $stmt->execute([':telefono' => $telefono]);
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($cliente) {
            return $cliente['id'];
        }
        
        // Crear nuevo cliente
        $stmt = $db->prepare("
            INSERT INTO clientes (telefono, nombre, estado) 
            VALUES (:telefono, :nombre, 'activo')
        ");
        $stmt->execute([
            ':telefono' => $telefono,
            ':nombre' => $nombre
        ]);
        
        return $db->lastInsertId();
    }
    
    public static function obtenerTodos() {
        $db = conectarDB();
        $stmt = $db->prepare("
            SELECT id, telefono, nombre, estado, ultima_interaccion, fecha_registro
            FROM clientes
            ORDER BY ultima_interaccion DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public static function obtenerPorId($id) {
        $db = conectarDB();
        $stmt = $db->prepare("
            SELECT * FROM clientes WHERE id = :id
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function obtenerPorTelefono($telefono) {
        $db = conectarDB();
        $stmt = $db->prepare("
            SELECT id FROM clientes WHERE telefono = :telefono
        ");
        $stmt->execute([':telefono' => $telefono]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public static function actualizar($id, $datos) {
        $db = conectarDB();
        $campos = [];
        $valores = [':id' => $id];
        
        foreach ($datos as $campo => $valor) {
            $campos[] = "$campo = :$campo";
            $valores[":$campo"] = $valor;
        }
        
        $sql = "UPDATE clientes SET " . implode(', ', $campos) . " WHERE id = :id";
        $stmt = $db->prepare($sql);
        return $stmt->execute($valores);
    }
}
