# ⚡ GUÍA RÁPIDA - PANEL ADMINISTRATIVO

## 🎯 5 Pasos para Empezar

### 1️⃣ CREAR TABLAS (2 minutos)

Abre en tu navegador:
```
http://localhost/chatbote/setup.php
```

Haz clic en: **🚀 Ejecutar Setup**

**Espera** hasta ver ✅ "Setup completado exitosamente"

---

### 2️⃣ INSERTAR DATOS DE EJEMPLO (Opcional)

En terminal/CMD, ejecuta:
```bash
cd c:\xampp\htdocs\chatbote
php insertar_datos_ejemplo.php
```

Verás:
```
✅ Cliente agregado: Juan García
✅ Cliente agregado: María López
✅ Conversación agregada para: Juan García
✨ ¡Datos de ejemplo insertados correctamente!
```

---

### 3️⃣ ACCEDER AL PANEL

Abre en tu navegador:
```
http://localhost/chatbote/admin/panel.php
```

Deberías ver:
- 📋 **Izquierda**: Lista de clientes/conversaciones
- 💬 **Centro**: Chat vacío (selecciona un cliente)
- 📝 **Botones**: Cerrar, responder

---

### 4️⃣ USAR EL PANEL

**Para ver mensajes:**
1. Selecciona un cliente en la lista izquierda
2. Se abre el chat con todo el historial
3. Los mensajes se actualizan automáticamente

**Para responder manualmente:**
1. Escribe tu mensaje en el campo inferior
2. Presiona **📤** o **Ctrl+Enter**
3. El mensaje se envía por WhatsApp automáticamente
4. Aparece en el chat como "Respuesta Manual"

**Para usar respuestas rápidas:**
1. Haz clic en un botón de respuesta rápida
2. Se inserta automáticamente en el campo
3. Edita si es necesario
4. Envía

**Para cerrar una conversación:**
1. Haz clic en **❌ Cerrar**
2. Confirma en el popup
3. La conversación se marca como "cerrada"

---

### 5️⃣ CONFIGURAR PARA PRODUCCIÓN

**Actualizar número de Twilio:**

Abre: `services/WhatsAppService.php`

Busca (línea ~60):
```php
$numeroTwilio = 'whatsapp:+525512345678';
```

Reemplaza con tu número:
```php
$numeroTwilio = 'whatsapp:+TU_NUMERO_TWILIO';
```

---

## 🎨 INTERFAZ DEL PANEL

```
┌─────────────────────────────────────────────────────────────────┐
│                    💬 PANEL DE MENSAJES                         │
├────────────────────┬────────────────────────────────────────────┤
│ 📋 CONVERSACIONES  │ 💬 CHAT                                    │
│                    │                                            │
│ 🔍 [Buscar...]    │ Juan García | whatsapp:+5216899999998    │
│                    │ ❌ Cerrar                                  │
│ 👤 Juan García    │ ────────────────────────────────────────  │
│ ⏱ 5min ago       │                                            │
│ 📄 Casa en Tlaxc  │ 👤 Hola, busco una casa                   │
│ 🔴 3              │                                            │
│                    │ 🤖 ¡Bienvenido a Inmobiliaria Serrano!   │
│ 👤 María López    │                                            │
│ ⏱ 2h ago        │ 👤 Necesito algo en Tlaxcala               │
│ 📄 Información de  │                                            │
│ 🔴 1              │ 🤖 Excelente, tenemos varias opciones...  │
│                    │ ────────────────────────────────────────  │
│ 👤 Carlos Rodríg  │ 👋 Bienvenida  👔 Asesor  ⏳ Más tarde   │
│ ⏱ 1d ago        │ ✅ Cierre                                  │
│                    │                                            │
│                    │ ┌──────────────────────────────────────┐  │
│                    │ │ Escribe tu respuesta aquí...       📤│  │
│                    │ └──────────────────────────────────────┘  │
└────────────────────┴────────────────────────────────────────────┘
```

---

## 🔑 COLORES Y SIGNIFICADOS

| Color | Significado |
|-------|-----|
| 🔵 Azul | Mensaje del Admin (tú) |
| ⚫ Gris | Mensaje del Cliente |
| 🟡 Amarillo | Respuesta del Bot |
| 🔴 Rojo | Mensajes no leídos |

---

## 🧪 PROBAR SIN TWILIO

Si aún no tienes Twilio configurado, puedes:

1. **Simular un cliente** que envía mensaje
2. **Abrir el panel** y responder
3. El mensaje se **guarda en BD** pero no se **envía por WhatsApp**

Para enviar de verdad, necesitas:
- ✅ Cuenta Twilio configurada en `config.php`
- ✅ Número de Twilio actualizado en `WhatsAppService.php`
- ✅ Webhook de Twilio apuntando a tu URL

---

## ❓ PREGUNTAS FRECUENTES

**P: ¿Se actualizan los mensajes automáticamente?**
R: Sí, cada 3 segundos. Si quieres cambiar, edita el **setInterval(3000)** en panel.php

**P: ¿Cómo agrego más respuestas rápidas?**
R: Edita tabla `respuestas_predefinidas` en MySQL:
```sql
INSERT INTO respuestas_predefinidas (titulo, contenido, emoji) 
VALUES ('Mi respuesta', 'Contenido aquí', '💡');
```

**P: ¿Los mensajes se guardan para siempre?**
R: Sí, en tabla `mensajes`. Recomienda hacer **backups regulares**.

**P: ¿Funciona en móvil?**
R: Sí, es responsive. Se adapta a cualquier pantalla.

**P: ¿Necesito login?**
R: Actualmente NO (agregar si es producción). Usa IP privadas o VPN.

---

## 🚀 ¡LISTO!

Tu panel administrativo está funcionando y listo para:
- ✅ Ver mensajes de clientes
- ✅ Responder manualmente
- ✅ Cerrar conversaciones
- ✅ Usar respuestas rápidas

¿Problemas? Revisa **README_PANEL.md** o contacta soporte.

**¡Bienvenido al futuro del chatbot inmobiliario! 🎉**
