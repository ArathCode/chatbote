# 🤖 Chatbot WhatsApp - Guía de Instalación

## 📦 Características Nuevas

✨ **Panel Administrativo** tipo WhatsApp para gestionar conversaciones  
💬 **Ver Mensajes** de clientes en tiempo real  
👤 **Gestionar Clientes** con historial completo  
✍️ **Responder Manualmente** desde el panel  
🤖 **Integración Automática** con el bot existente  

---

## 🚀 Instalación Rápida

### 1️⃣ Crear Tablas en la BD

Accede a tu navegador y abre:
```
http://localhost/chatbote/setup.php
```

Haz clic en **"Ejecutar Setup"** para crear automáticamente todas las tablas.

### 2️⃣ Acceder al Panel

Una vez completado el setup, abre el panel:
```
http://localhost/chatbote/admin/panel.php
```

---

## 🎯 Cómo Usar el Panel

### 📩 Sección Izquierda - Conversaciones
- **Buscar clientes** por nombre o teléfono
- **Ver conversaciones abiertas** con sus últimos mensajes
- **Badge de mensajes no leídos** en cada cliente
- Click para abrirLa conversación

### 💬 Sección Centro - Chat
- **Historial completo** de mensajes
- **Diferenciar mensajes:** Cliente (gris), Bot (amarillo), Admin (azul)
- **Auto-scroll** al último mensaje
- **Actualización en tiempo real** cada 3 segundos

### ✍️ Responder Manualmente
1. Selecciona una conversación
2. Escribe tu mensaje en el campo inferior
3. Usa **Respuestas Rápidas** para respuestas predefinidas
4. O presiona **Enviar (📤)** o **Ctrl+Enter**
5. El mensaje se envía por WhatsApp automáticamente

### 🎯 Respuestas Rápidas Predefinidas
- 👋 Bienvenida
- 👔 Contacto Asesor
- ⏳ Más tarde
- ✅ Cierre

---

## 📊 Flujo de Datos

```
Cliente envía mensaje por WhatsApp
    ↓
Twilio webhook → index.php
    ↓
ChatController procesa:
    - Crea cliente si no existe
    - Crea/obtiene conversación
    - Guarda mensaje del cliente en BD
    - Bot llama OpenAI para interpretar
    - Busca propiedades
    - Responde al cliente
    - Guarda respuesta del bot en BD
    ↓
Panel Admin actualiza conversación en tiempo real
    ↓
Admin puede responder manualmente
    - Escribe mensaje
    - Se envía por Twilio API
    - Se guarda en BD
```

---

## 🔧 Configuración Adicional

### Número de Twilio para Respuestas
En `services/WhatsAppService.php`, actualiza:
```php
$numeroTwilio = 'whatsapp:+525512345678'; // Cambiar por tu número real
```

### Respuestas Predefinidas Personalizadas
Edita en la base de datos la tabla `respuestas_predefinidas`:
```sql
INSERT INTO respuestas_predefinidas (titulo, contenido, emoji) 
VALUES ('Mi Respuesta', 'Contenido...', '💡');
```

---

## 📁 Estructura de Archivos Nuevos

```
chatbote/
├── admin/
│   └── panel.php              # 🎨 Panel administrativo
├── api/
│   ├── obtener_conversaciones.php    # Obtener todas las conversaciones
│   ├── obtener_mensajes.php          # Obtener mensajes de una conversación
│   ├── obtener_respuestas.php        # Obtener respuestas predefinidas
│   ├── enviar_respuesta.php          # Enviar mensaje manual
│   └── cerrar_conversacion.php       # Cerrar conversación
├── models/
│   ├── Cliente.php            # Modelo para clientes
│   ├── Conversacion.php       # Modelo para conversaciones
│   └── Mensaje.php            # Modelo para mensajes
├── database/
│   └── schema.sql             # 📊 Definición de tablas
└── setup.php                  # 🔧 Script de instalación
```

---

## 🧪 Pruebas

### Enviar Mensaje de Prueba
```bash
# Modificar el contenido en test-twilio.php y ejecutar:
php test-twilio.php
```

### Verificar Mensajes Guardados
```sql
SELECT * FROM mensajes 
ORDER BY fecha_envio DESC 
LIMIT 10;
```

---

## ⚠️ Notas Importantes

1. **Seguridad:** El panel NO tiene autenticación (agregar login si es producción)
2. **Números Twilio:** Actualiza el número en `WhatsAppService.php`
3. **CORS:** Si el panel da problemas CORS, habilitar en `.htaccess`
4. **Base de Datos:** Hacer backups regulares de la tabla de mensajes
5. **Timeouts:** Panel actualiza cada 3 segundos (ajustable en JavaScript)

---

## 🐛 Troubleshooting

### El panel no carga conversaciones
```
1. Verificar que mysql está corriendo
2. Confirmar credenciales en config.php
3. Revisar console del navegador (F12) para errores
```

### Mensajes no se envían
```
1. Verificar credenciales de Twilio en config.php
2. Confirmar número de Twilio en WhatsAppService.php
3. Revisar logs de Twilio Dashboard
```

### La BD no tiene datos
```
1. Ejecutar setup.php nuevamente
2. Verificar que no hay errores SQL
3. Confirmar base de datos 'inmobiliaria' existe
```

---

## 🚀 Próximos Pasos Recomendados

- [ ] Agregar autenticación al panel
- [ ] Crear dashboard de estadísticas
- [ ] Implementar websockets para tiempo real
- [ ] Exportar conversaciones a PDF
- [ ] Integrar CRM adicional
- [ ] Agregar métricas de respuesta

---

¡Tu chatbot está listo para producción! 🎉
