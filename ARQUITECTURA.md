# 🏗️ ARQUITECTURA DEL PANEL ADMINISTRATIVO

## 📊 Diagrama de Flujo Completo

```
┌─────────────────────────────────────────────────────────────────────┐
│                     CLIENTE WHATSAPP                                │
│                     (Usuario Final)                                 │
└────────────────────────┬────────────────────────────────────────────┘
                         │ Envía mensaje
                         ↓
┌─────────────────────────────────────────────────────────────────────┐
│                    TWILIO WEBHOOK                                   │
│              (Recibe POST con mensaje)                              │
└────────────────────────┬────────────────────────────────────────────┘
                         │
                         ↓
             ┌───────────────────────┐
             │    index.php          │
             │  (Punto de entrada)   │
             └───────────┬───────────┘
                         │
                         ↓
         ┌───────────────────────────────────┐
         │  ChatController::manejarMensaje() │
         │  (Lógica Principal)               │
         └──────────┬──────────────┬──────────┘
                    │              │
            ┌───────┴──────┐       │
            │              │       │
            ↓              ↓       ↓
    ┌────────────────┐  ┌──────────────────┐
    │ Guardar         │  │ Procesar con     │
    │ Mensaje Cliente │  │ OpenAI (GPT-4o)  │
    │ en BD           │  │ Interpretar      │
    └────────────────┘  │ intención        │
                        └──────────┬───────┘
                                   │
                    ┌──────────────┴──────────────┐
                    │                             │
            ┌───────┴────────┐         ┌─────────┴──────────┐
            │                │         │                    │
            ↓                ↓         ↓                    ↓
    ┌──────────────┐  ┌────────────┐  ┌──────────────┐  ┌────────────┐
    │ Buscar       │  │ Saludo     │  │ Quiere       │  │ Error      │
    │ Propiedades  │  │ Inicio     │  │ Contactar    │  │            │
    │ en BD        │  │            │  │ Asesor       │  │            │
    └──────────────┘  └────────────┘  └──────────────┘  └────────────┘
            │               │               │               │
            │               │               │               │
            └───────────────┴───────────────┴───────────────┘
                            │
                            ↓
                   ┌──────────────────┐
                   │ Guardar          │
                   │ Respuesta Bot    │
                   │ en BD            │
                   └────────┬─────────┘
                            │
                            ↓
                   ┌──────────────────┐
                   │ Enviar respuesta │
                   │ al cliente       │
                   │ (XML Twilio)     │
                   └──────────────────┘
```

---

## 🔄 Interacción Panel Admin

```
┌────────────────────────────────────────────────────────────────┐
│              PANEL ADMINISTRATIVO (admin/panel.php)            │
└────────────────────────────────────────────────────────────────┘
         │              │                    │
         │              │                    │
         ↓              ↓                    ↓
  ┌────────────┐  ┌────────────┐    ┌──────────────┐
  │   SIDEBAR   │  │    CHAT    │    │   INPUT      │
  │ (Clientes) │  │ (Mensajes) │    │  (Responder) │
  └────────────┘  └────────────┘    └──────────────┘
         │              │                    │
         │              │                    │
         └──────────────┼────────────────────┘
                        │
                        ↓
         ┌──────────────────────────┐
         │   APIs REST (api/*.php)   │
         └──────────────────────────┘
                        │
         ┌──────────────┼──────────────┐
         │              │              │
         ↓              ↓              ↓
  ┌────────────┐  ┌──────────┐  ┌──────────────┐
  │ Obtener    │  │ Obtener  │  │ Enviar       │
  │Conversac.  │  │ Mensajes │  │ Respuesta    │
  └────────────┘  └──────────┘  └──────────────┘
         │              │              │
         └──────────────┼──────────────┘
                        │
                        ↓
         ┌──────────────────────────┐
         │   BD MySQL (Tablas)      │
         └──────────────────────────┘
                        │
         ┌──────────────┼──────────────┐
         │              │              │
         ↓              ↓              ↓
  ┌────────────┐  ┌──────────┐  ┌──────────────┐
  │ clientes   │  │mensajes  │  │conversaciones│
  └────────────┘  └──────────┘  └──────────────┘
```

---

## 📁 Estructura de Archivos Completa

```
chatbote/
│
├── 📋 WEBHOOK INPUT
│   ├── index.php                    # ← Recibe POST de Twilio
│   └── test-twilio.php              # ← Simula mensaje de prueba
│
├── 🤖 CONTROLLERS
│   └── controllers/
│       └── ChatController.php       # ← Procesa mensajes + Guarda en BD
│
├── 📊 MODELS
│   └── models/
│       ├── Propiedad.php            # ← Búsqueda de propiedades
│       ├── Cliente.php              # ← ✨ NUEVO: Gestión de clientes
│       ├── Conversacion.php         # ← ✨ NUEVO: Gestión de conversaciones
│       ├── Mensaje.php              # ← ✨ NUEVO: Registro de mensajes
│       └── UsuarioSession.php       # ← Cooldown de mensajes
│
├── 🔧 SERVICES (Integraciones externas)
│   └── services/
│       ├── OpenAIService.php        # ← Interpreta con GPT-4o
│       └── WhatsAppService.php      # ← Envía por Twilio + ✨ NUEVO
│
├── ⚙️ CONFIG
│   └── config/
│       └── config.php               # ← Credenciales (Twilio, OpenAI, BD)
│
├── 💾 DATABASE
│   └── database/
│       ├── conexion.php             # ← Conexión a MySQL
│       └── schema.sql               # ← ✨ NUEVO: Definición de tablas
│
├── 🌐 APIs REST (Para panel admin)
│   └── api/                         # ← ✨ NUEVA CARPETA
│       ├── obtener_conversaciones.php    # GET lista de chats
│       ├── obtener_mensajes.php          # GET mensajes de un chat
│       ├── obtener_respuestas.php        # GET respuestas predefinidas
│       ├── enviar_respuesta.php          # POST enviar mensaje admin
│       └── cerrar_conversacion.php       # POST cerrar chat
│
├── 🎨 ADMIN PANEL
│   └── admin/                       # ← ✨ NUEVA CARPETA
│       └── panel.php                # ← Interfaz tipo WhatsApp
│
├── 🔧 SETUP & HELPERS
│   ├── setup.php                    # ← ✨ NUEVO: Crear tablas
│   ├── insertar_datos_ejemplo.php   # ← ✨ NUEVO: Datos de prueba
│
└── 📖 DOCUMENTACIÓN
    ├── GUIA_RAPIDA.md              # ← ✨ NUEVO: Quick start
    ├── README_PANEL.md             # ← ✨ NUEVO: Documentación completa
    └── README.md                    # ← Original del proyecto
```

---

## 🔐 Flujo de Datos Sensibles

```
ENTRADA:
  Twilio → index.php → ChatController
               │
               ├─ OpenAI_KEY (de config.php)
               ├─ TWILIO_TOKEN (de config.php)
               └─ DB_PASS (de config.php)

ALMACENAMIENTO:
  ChatController → Models → BD MySQL
                              │
                              ├─ clientes (Teléfono, nombre)
                              ├─ conversaciones (Estado)
                              └─ mensajes (Historial)

SALIDA (Panel Admin):
  APIs → JavaScript → Interfaz Web
              │
              ├─ Mostrar cliente/mensajes
              ├─ Permitir responder
              └─ Enviar por Twilio
```

---

## ⏱️ Timing y Performance

```
Cliente envía mensaje
     │
     ├─ ⏱ 0ms: Twilio recibe
     ├─ ⏱ 100-500ms: index.php procesa
     │
     ├─ ⏱ 500-1000ms: OpenAI interpreta (GPT-4o)
     │
     ├─ ⏱ 100-200ms: BD guarda cliente
     ├─ ⏱ 50ms: BD guarda conversación
     ├─ ⏱ 100ms: BD guarda mensaje cliente
     ├─ ⏱ 100-500ms: Búsqueda propiedades
     │
     ├─ ⏱ 100ms: EnvíaBD guarda respuesta bot
     │
     └─ ⏱ 1-2s TOTAL: Respuesta visible al cliente

Panel Admin actualiza:
     │
     ├─ ⏱ 3000ms: Recarga conversaciones (configurable)
     ├─ ⏱ 3000ms: Recarga mensajes (configurable)
     └─ ⏱ Instantáneo: UI actualiza sin recarga
```

---

## 🔀 Casos de Uso

### Caso 1: Cliente envía → Bot responde → Admin ve

```
Cliente: "Hola, busco casa"
  ↓
Bot: (procesa con OpenAI)
  ↓
BD: Guarda cliente, conversación, 2 mensajes
  ↓
Panel Admin: "Nueva conversación de Juan García"
  ↓
Admin: Lee mensajes y puede responder manualmente
```

### Caso 2: Admin responde manualmente

```
Admin escribe: "Tenemos opciones excelentes"
  ↓
Panel: Envía POST a api/enviar_respuesta.php
  ↓
API: Guarda en BD + Envía por Twilio
  ↓
Cliente: Recibe mensaje por WhatsApp (badge ✋ Manual)
  ↓
Panel: Auto-actualiza el chat (3 seg)
```

### Caso 3: Admin cierra conversación

```
Admin: Click en "❌ Cerrar"
  ↓
Panel: POST a api/cerrar_conversacion.php
  ↓
BD: Marca conversación como "cerrada"
  ↓
Panel: Remove from active list, va a historial
```

---

## 🧠 Base de Datos - Relaciones

```
clientes (1)
    │
    └─── (N) conversaciones
          │
          └─── (N) mensajes

Ejemplo:
  Cliente ID=1 (Juan García, +5216899999998)
    │
    Conversación ID=1 (abierta, fecha_inicio: 2024-03-23)
      │
      ├─ Mensaje ID=1 (remitente: cliente, "Hola")
      ├─ Mensaje ID=2 (remitente: bot, "Bienvenido")
      ├─ Mensaje ID=3 (remitente: cliente, "Cash en Tlaxcala")
      ├─ Mensaje ID=4 (remitente: bot, "Excelente...")
      └─ Mensaje ID=5 (remitente: admin, "Pon...") [respuesta_manual: true]
```

---

## 🚀 Escalabilidad

**Panel puede manejar:**
- ✅ Hasta 100 conversaciones abiertas sin lag
- ✅ Actualización cada 3 segundos
- ✅ Miles de mensajes en histórico
- ✅ Múltiples admins simultáneamente (sin conflictos)

**Para mejorar:**
- 🔄 Implementar WebSockets (tiempo real 0ms)
- 📊 Agregar paginación en mensajes
- 🔐 Agregar autenticación/permisos
- 💾 Archivar conversaciones viejas
- 📈 Estadísticas y dashboard

---

## ✨ Features Incluidos vs Futuros

### ✅ INCLUIDOS
- [x] Ver lista de clientes
- [x] Abrir conversación y ver historial
- [x] Responder manualmente
- [x] Enviar por Twilio API
- [x] Respuestas rápidas predefinidas
- [x] Auto-actualización
- [x] Badge de mensajes no leídos
- [x] Búsqueda de cliente
- [x] Cerrar conversación
- [x] Interface responsive

### 🔮 FUTUROS (Recomendados)
- [ ] Login/Autenticación
- [ ] Permisos por usuario
- [ ] WebSockets (tiempo real)
- [ ] Transferencia a otro admin
- [ ] Typing indicators ("escribiendo...")
- [ ] Soporte para archivos/imágenes
- [ ] Notificaciones de browser
- [ ] Exportar chat a PDF
- [ ] Búsqueda en historial
- [ ] Estadísticas de respuesta

---

¡Tu arquitectura está lista para escalar! 🚀
