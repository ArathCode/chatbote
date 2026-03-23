✅ CHECKLIST DE INSTALACIÓN - PANEL ADMINISTRATIVO

════════════════════════════════════════════════════════════════

🎯 FASE 1: VERIFICAR REQUISITOS (5 min)
════════════════════════════════════════════════════════════════

[ ] XAMPP está instalado y corriendo
    → Verifica: http://localhost = XAMPP Dashboard

[ ] MySQL está corriendo
    → Verifica en "Apache Friends" que MySQL está en "Running"

[ ] Base de datos 'inmobiliaria' existe
    → Verifica en phpMyAdmin: localhost/phpmyadmin

[ ] config.php está actualizado
    [ ] OPENAI_API_KEY correcto
    [ ] TWILIO_ACCOUNT_SID correcto
    [ ] TWILIO_AUTH_TOKEN correcto
    [ ] DB_HOST = localhost
    [ ] DB_NAME = inmobiliaria
    [ ] DB_USER = root
    [ ] DB_PASS = (contraseña correcta)

════════════════════════════════════════════════════════════════

🚀 FASE 2: CREAR TABLAS EN BD (2 min)
════════════════════════════════════════════════════════════════

[ ] Abre en navegador:
    http://localhost/xampp/htdocs/chatbote/setup.php

[ ] Haz clic en "🚀 Ejecutar Setup"

[ ] Espera hasta ver mensaje verde:
    ✅ ¡Setup completado exitosamente!

[ ] Verifica en phpMyAdmin que existen tablas:
    [ ] clientes
    [ ] conversaciones
    [ ] mensajes
    [ ] respuestas_predefinidas

════════════════════════════════════════════════════════════════

📊 FASE 3: INSERTAR DATOS DE EJEMPLO (1 min - OPCIONAL)
════════════════════════════════════════════════════════════════

[ ] Abre terminal/CMD en c:\xampp\htdocs\chatbote

[ ] Ejecuta:
    php insertar_datos_ejemplo.php

[ ] Deberías ver:
    ✅ Cliente agregado: Juan García
    ✅ Cliente agregado: María López
    ✅ Conversación agregada para: Juan García
    ✨ ¡Datos de ejemplo insertados correctamente!

[ ] Verifica en phpMyAdmin que hay datos en tablas

════════════════════════════════════════════════════════════════

🎨 FASE 4: ACCEDER AL PANEL (1 min)
════════════════════════════════════════════════════════════════

[ ] Abre en navegador:
    http://localhost/xampp/htdocs/chatbote/admin/panel.php

[ ] Deberías ver:
    [ ] Sidebar izquierdo con lista de clientes
    [ ] Centro vacío (selecciona un cliente)
    [ ] Campo de entrada en la parte inferior

[ ] Haz clic en un cliente para ver conversación

[ ] Botones correctos:
    [ ] 📤 Enviar mensaje
    [ ] ❌ Cerrar conversación
    [ ] 👋 Respuestas rápidas

════════════════════════════════════════════════════════════════

🧪 FASE 5: PROBAR FUNCIONALIDAD (5 min)
════════════════════════════════════════════════════════════════

PRUEBA 1: Ver conversación existente
[ ] Haz clic en "Juan García" en la lista
[ ] Deberías ver el historial de mensajes
[ ] Los colores deben ser:
    - Gris: Mensaje del cliente
    - Amarillo/naranja: Respuesta del bot

PRUEBA 2: Responder manualmente
[ ] Con un cliente abierto, escribe en el campo:
    "Perfecto, te envío más información"
[ ] Haz clic en 📤 o presiona Ctrl+Enter
[ ] El mensaje debe aparecer en azul en el chat
[ ] Verifica en phpMyAdmin tabla 'mensajes' que se guardó

PRUEBA 3: Respuestas rápidas
[ ] Haz clic en un botón de respuesta rápida (👋 Bienvenida)
[ ] El texto debe insertarse en el campo
[ ] Haz clic enviar
[ ] El mensaje se debe guardar

PRUEBA 4: Buscar cliente
[ ] Escribe en el campo de búsqueda (arriba a la izquierda)
[ ] La lista debe filtrar por nombre o teléfono
[ ] Borra el contenido y vuelve a ver todos

PRUEBA 5: Auto-refresh
[ ] Selecciona un cliente
[ ] Abre otra pestaña del navegador
[ ] En la otra pestaña, escribe un mensaje en test-twilio.php
[ ] Vuelve a la primera pestaña
[ ] (Espera 3 segundos) El nuevo mensaje debe aparecer

PRUEBA 6: Cerrar conversación
[ ] Selecciona una conversación
[ ] Haz clic en "❌ Cerrar"
[ ] Confirma en el popup
[ ] La conversación debe desaparecer de la lista

════════════════════════════════════════════════════════════════

⚙️ FASE 6: CONFIGURAR PARA TWILIO (3 min)
════════════════════════════════════════════════════════════════

[ ] Abre archivo: services/WhatsAppService.php

[ ] Busca la línea (alrededor de línea 60):
    $numeroTwilio = 'whatsapp:+525512345678';

[ ] Reemplaza con tu número oficial de Twilio:
    $numeroTwilio = 'whatsapp:+TU_NUMERO';

[ ] Guarda el archivo

[ ] Prueba enviando un mensaje desde el panel
    (Solo si Twilio está configurado)

[ ] Verifica en Twilio Dashboard que el mensaje se envió

════════════════════════════════════════════════════════════════

📖 FASE 7: LECTURA RECOMENDADA
════════════════════════════════════════════════════════════════

Lee estos archivos en orden (10 min total):

[ ] GUIA_RAPIDA.md (5 minutos)
    → Overview rápido de cómo usar

[ ] README_PANEL.md (10 minutos)
    → Documentación completa

[ ] ARQUITECTURA.md (5 minutos)
    → Entender cómo funciona todo junto

Opcional:
[ ] Ver código comments en admin/panel.php (JavaScript)
[ ] Ver código comments en api/*.php (endpoints)
[ ] Ver código comments en models/*.php (lógica de BD)

════════════════════════════════════════════════════════════════

🔐 FASE 8: SEGURIDAD (IMPORTANTE!)
════════════════════════════════════════════════════════════════

⚠️ ANTES DE IR A PRODUCCIÓN:

[ ] AGREGAR AUTENTICACIÓN
    → El panel actualmente NO tiene login
    → Cualquiera puede acceder si conoce la URL
    → Solución: Implementar login basic o session

[ ] RESTRICCIÓN DE IP
    → Usa .htaccess para permitir solo IPs confiables
    → O usa VPN para acceso remoto

[ ] BASES DE DATOS
    → Cambiar contraseña de MySQL
    → No usar 'root' sin contraseña

[ ] CREDENCIALES
    → Mover config.php a archivo .env
    → No guardar tokens directamente en código
    → Usar variables de entorno del servidor

[ ] HTTPS
    → Usar HTTPS si es acceso remoto
    → No enviar datos sin encriptación

[ ] BACKUPS
    → Hacer backup regular de BD
    → Guardar en lugar seguro

════════════════════════════════════════════════════════════════

✨ FASE 9: ¡LISTO PARA USAR!
════════════════════════════════════════════════════════════════

Si completaste todas las fases anteriores, tu panel está listo:

✅ Panel funcionando en: http://localhost/chatbote/admin/panel.php
✅ Base de datos sincronizada
✅ Mensajes guardándose automáticamente
✅ Respuestas manuales funcionando
✅ Auto-refresh cada 3 segundos
✅ Respuestas rápidas disponibles
✅ Integración con bot automática

════════════════════════════════════════════════════════════════

📞 SOPORTE & TROUBLESHOOTING
════════════════════════════════════════════════════════════════

❌ El panel no carga conversaciones
→ Verifica MySQL está corriendo
→ Confirma credenciales en config.php
→ Abre F12 consola y busca errores

❌ Los mensajes no se guardan
→ Verifica permisos de base de datos
→ Ejecuta setup.php nuevamente
→ Revisa tabla 'mensajes' en phpMyAdmin

❌ No puedo enviar mensajes por Twilio
→ Verifica número en WhatsAppService.php
→ Confirma Account SID y Auth Token en config.php
→ Prueba en Twilio Dashboard directamente

❌ El panel está muy lento
→ Reduce el intervalo de refresh (script.js)
→ Limpia tabla 'mensajes' de datos viejos
→ Usa paginación para historiales grandes

❌ CSS no carga correctamente
→ Limpia caché del navegador (Ctrl+Shift+Delete)
→ Abre DevTools y verifica rutas de archivos
→ Usa http:// no file://

════════════════════════════════════════════════════════════════

🎉 ¡FELICIDADES!

Tu chatbot inmobiliaria ahora tiene:

✨ Bot automático con OpenAI
✨ Panel administrativo tipo WhatsApp
✨ Gestión de conversaciones
✨ Respuestas manuales por Twilio
✨ Historial completo en BD
✨ Respuestas rápidas predefinidas

¡Listo para vender más propiedades! 🏡

════════════════════════════════════════════════════════════════
Fecha de completación: ___________
Nombre: ___________________________
Versión: 1.0 - Marzo 2024
════════════════════════════════════════════════════════════════
