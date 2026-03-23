<?php
/**
 * Script para insertar datos de ejemplo
 * Ejecutar en terminal: php insertar_datos_ejemplo.php
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/database/conexion.php';

try {
    $db = conectarDB();
    
    echo "📝 Insertando datos de ejemplo...\n\n";
    
    // Clientes de ejemplo
    $clientes = [
        ['whatsapp:+5216899999998', 'Juan García'],
        ['whatsapp:+5216899999997', 'María López'],
        ['whatsapp:+5216899999996', 'Carlos Rodríguez'],
    ];
    
    foreach ($clientes as [$tel, $nombre]) {
        $stmt = $db->prepare("
            INSERT IGNORE INTO clientes (telefono, nombre, estado) 
            VALUES (:tel, :nombre, 'activo')
        ");
        $stmt->execute([':tel' => $tel, ':nombre' => $nombre]);
        echo "✅ Cliente agregado: $nombre\n";
    }
    
    // Conversaciones y mensajes de ejemplo
    $stmt = $db->prepare("SELECT id, nombre FROM clientes LIMIT 3");
    $stmt->execute();
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $conversaciones_ejemplo = [
        ['En busca de casa', 'Casa en Tlaxcala', 'cliente'],
        ['Información de terreno', 'Tengo interés en terrenos', 'cliente'],
        ['Contacto asesor', 'Quiero hablar con un asesor', 'cliente'],
    ];
    
    foreach ($clientes as $cliente) {
        $cliente_id = $cliente['id'];
        
        // Crear conversación
        $stmt = $db->prepare("
            INSERT INTO conversaciones (cliente_id, estado) 
            VALUES (:cliente_id, 'abierta')
        ");
        $stmt->execute([':cliente_id' => $cliente_id]);
        $conv_id = $db->lastInsertId();
        
        // Agregar mensajes de ejemplo
        $mensajes = [
            ['Hola, busco una casa', 'cliente'],
            ['¡Bienvenido a Inmobiliaria Serrano! Te ayudamos a encontrar la propiedad ideal.', 'bot'],
            ['Necesito algo en Tlaxcala', 'cliente'],
            ['Excelente, tenemos varias opciones en Tlaxcala con excelentes precios.', 'bot'],
        ];
        
        foreach ($mensajes as [$contenido, $remitente]) {
            $stmt = $db->prepare("
                INSERT INTO mensajes (cliente_id, conversacion_id, contenido, remitente) 
                VALUES (:cliente_id, :conv_id, :contenido, :remitente)
            ");
            $stmt->execute([
                ':cliente_id' => $cliente_id,
                ':conv_id' => $conv_id,
                ':contenido' => $contenido,
                ':remitente' => $remitente
            ]);
        }
        
        echo "✅ Conversación agregada para: {$cliente['nombre']}\n";
    }
    
    echo "\n✨ ¡Datos de ejemplo insertados correctamente!\n";
    echo "🌐 Accede a: http://localhost/chatbote/admin/panel.php\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
