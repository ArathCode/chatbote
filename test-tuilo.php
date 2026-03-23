<?php
require_once 'config/config.php';
require_once 'services/WhatsAppService.php';

// Reemplaza con un número real
$resultado = enviarPorWhatsApp('whatsapp:+5212481557389', 'Test desde PHP');

echo "Resultado: ";
echo json_encode($resultado, JSON_PRETTY_PRINT);
?>