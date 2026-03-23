<?php
/**
 * SETUP: Crear tablas en la Base de Datos
 * Acceder desde navegador: http://localhost/chatbote/setup.php
 */

header('Content-Type: text/html; charset=utf-8');

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/database/conexion.php';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup - Chatbot Inmobiliaria</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f9f9f9;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 { color: #667eea; }
        .log { 
            background: #f5f5f5; 
            padding: 15px; 
            border-left: 4px solid #667eea;
            margin: 15px 0;
            font-family: monospace;
            white-space: pre-wrap;
            border-radius: 4px;
        }
        .success { color: #2e7d32; font-weight: bold; }
        .error { color: #c62828; font-weight: bold; }
        .warn { color: #f57f17; font-weight: bold; }
        button {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
        }
        button:hover { background: #5568d3; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Setup - Chatbot Inmobiliaria</h1>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['setup'])) {
            echo '<div class="log">';
            
            try {
                $db = conectarDB();
                
                // Leer y ejecutar SQL
                $sql = file_get_contents(__DIR__ . '/database/schema.sql');
                
                // Dividir por ';' y ejecutar cada sentencia
                $statements = array_filter(array_map('trim', explode(';', $sql)));
                
                foreach ($statements as $statement) {
                    if (!empty($statement)) {
                        $db->exec($statement);
                        echo "<span class='success'>✅</span> " . substr($statement, 0, 50) . "...\n";
                    }
                }
                
                echo "\n<span class='success'>✅ ¡Setup completado exitosamente!</span>\n";
                echo "\n📍 Accede a tu panel aquí: <a href='admin/panel.php' style='color: #667eea;'>http://localhost/chatbote/admin/panel.php</a>\n";
                
            } catch (Exception $e) {
                echo "<span class='error'>❌ Error:</span> " . $e->getMessage() . "\n";
            }
            
            echo '</div>';
        } else {
            ?>
            <h2>📋 Checklist de Instalación</h2>
            
            <ul>
                <li>✅ Proyecto clonado en <code>xampp/htdocs/chatbote</code></li>
                <li>✅ Base de datos MySQL <code>inmobiliaria</code> creada</li>
                <li>✅ <code>config.php</code> configurado con credenciales</li>
            </ul>
            
            <h2>⚙️ Crear Tablas</h2>
            <p>Haz clic en el botón para crear automáticamente todas las tablas necesarias:</p>
            
            <form method="POST">
                <button type="submit" name="setup" value="1">🚀 Ejecutar Setup</button>
            </form>
            
            <h2>📚 Tablas que se crearán:</h2>
            <ul>
                <li><strong>clientes</strong> - Datos de clientes</li>
                <li><strong>conversaciones</strong> - Conversaciones abiertas</li>
                <li><strong>mensajes</strong> - Historial de mensajes</li>
                <li><strong>respuestas_predefinidas</strong> - Respuestas rápidas del admin</li>
            </ul>
            
            <?php
        }
        ?>
    </div>
</body>
</html>
