<?php
require_once 'config/config.php';

echo "=== DEBUG CREDENCIALES TWILIO ===\n\n";

echo "1. ACCOUNT SID:\n";
echo "   Valor: " . (defined('TWILIO_ACCOUNT_SID') ? TWILIO_ACCOUNT_SID : 'NO DEFINIDO') . "\n";
echo "   Largo: " . strlen(TWILIO_ACCOUNT_SID) . " caracteres\n";
echo "   Comienza con 'AC': " . (strpos(TWILIO_ACCOUNT_SID, 'AC') === 0 ? 'SÍ ✅' : 'NO ❌') . "\n\n";

echo "2. AUTH TOKEN:\n";
echo "   Valor: " . substr(TWILIO_AUTH_TOKEN, 0, 5) . "..." . substr(TWILIO_AUTH_TOKEN, -5) . "\n";
echo "   Largo: " . strlen(TWILIO_AUTH_TOKEN) . " caracteres\n";
echo "   Tiene caracteres especiales: " . (preg_match('/[^a-zA-Z0-9]/', TWILIO_AUTH_TOKEN) ? 'SÍ' : 'NO') . "\n\n";

echo "3. VERIFICAR ESPACIOS:\n";
echo "   Account SID tiene espacios: " . (trim(TWILIO_ACCOUNT_SID) !== TWILIO_ACCOUNT_SID ? 'SÍ ❌' : 'NO ✅') . "\n";
echo "   Auth Token tiene espacios: " . (trim(TWILIO_AUTH_TOKEN) !== TWILIO_AUTH_TOKEN ? 'SÍ ❌' : 'NO ✅') . "\n\n";

echo "4. TEST DE CONEXIÓN BÁSICA:\n";

// Intentar autenticación contra Twilio
$url = 'https://api.twilio.com/2010-04-01/Accounts/' . TWILIO_ACCOUNT_SID . '/Messages.json';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_USERPWD, TWILIO_ACCOUNT_SID . ':' . TWILIO_AUTH_TOKEN);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_POSTFIELDS, 'From=' . urlencode('whatsapp:+5215631580844') . '&To=' . urlencode('whatsapp:+5216899999998') . '&Body=Test');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

echo "   URL: " . $url . "\n";
echo "   HTTP Code: " . $httpCode . "\n";
echo "   Response: " . $response . "\n\n";

if ($httpCode === 401) {
    echo "❌ ERROR 401: Las credenciales son INVÁLIDAS\n";
    echo "\n⚠️ SOLUCIONES:\n";
    echo "1. Ve a: https://console.twilio.com/\n";
    echo "2. Copia tu Account SID (empieza con AC)\n";
    echo "3. Genera un nuevo Auth Token en 'Manage Tokens'\n";
    echo "4. Pega exactamente en config.php (sin espacios)\n";
    echo "5. Recarga esta página\n";
} elseif ($httpCode === 400 && strpos($response, 'Invalid') !== false) {
    echo "⚠️ Credenciales OK pero hay error en el mensaje\n";
    echo "Esto significa que tu Account SID y Auth Token están bien ✅\n";
} else {
    echo "✅ Parece que las credenciales funcionan\n";
}

?>
