<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - Inmobiliaria Serrano</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Helvetica, Arial, sans-serif;
            background: #fff9f0;
            color: #333;
        }

        .container {
            display: flex;
            height: 100vh;
            background: #f5f5f5;
        }

        /* SIDEBAR - Lista de clientes */
        .sidebar {
            width: 350px;
            background: #fff;
            border-right: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .sidebar-header {
            padding: 16px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar-header h1 {
            font-size: 18px;
            font-weight: 600;
        }

        .search-box {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }

        .search-box input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 20px;
            font-size: 14px;
            background: #f5f5f5;
            outline: none;
            transition: all 0.3s;
        }

        .search-box input:focus {
            background: #fff;
            border-color: #667eea;
        }

        .conversations-list {
            flex: 1;
            overflow-y: auto;
        }

        .conversation-item {
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .conversation-item:hover {
            background: #f9f9f9;
        }

        .conversation-item.active {
            background: #f0f8ff;
            border-left: 4px solid #667eea;
        }

        .avatar {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 18px;
            flex-shrink: 0;
        }

        .conversation-info {
            flex: 1;
            min-width: 0;
        }

        .conversation-header {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 4px;
        }

        .conversation-name {
            font-weight: 600;
            font-size: 14px;
            color: #333;
        }

        .conversation-time {
            font-size: 12px;
            color: #999;
        }

        .conversation-preview {
            font-size: 13px;
            color: #666;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .badge {
            background: #667eea;
            color: white;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
        }

        /* CHAT AREA */
        .chat-area {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #fff;
        }

        .chat-header {
            padding: 16px;
            border-bottom: 1px solid #ddd;
            background: #fff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .chat-title-section h2 {
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .chat-title-section p {
            font-size: 13px;
            color: #999;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-badge.activo {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .status-badge.inactivo {
            background: #ffebee;
            color: #c62828;
        }

        .chat-actions {
            display: flex;
            gap: 8px;
        }

        .btn-action {
            background: #f5f5f5;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 8px 16px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .btn-action:hover {
            background: #efefef;
        }

        .messages-container {
            flex: 1;
            overflow-y: auto;
            padding: 16px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .message-group {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
            align-items: flex-end;
        }

        .message-group.outgoing {
            justify-content: flex-end;
        }

        .message-group.outgoing .message {
            background: #667eea;
            color: white;
            border-radius: 18px 18px 4px 18px;
        }

        .message-group.incoming .message {
            background: #f0f0f0;
            border-radius: 18px 18px 18px 4px;
        }

        .message {
            max-width: 70%;
            padding: 10px 16px;
            word-wrap: break-word;
            font-size: 14px;
            line-height: 1.4;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .message.admin {
            background: #fff3cd;
            color: #333;
            border-left: 3px solid #ffc107;
        }

        .message-time {
            font-size: 12px;
            color: #999;
            margin-top: 4px;
        }

        .message-badge {
            font-size: 11px;
            margin-left: 8px;
            padding: 2px 6px;
            background: rgba(0,0,0,0.1);
            border-radius: 4px;
            display: inline-block;
        }

        /* INPUT AREA */
        .input-area {
            padding: 16px;
            border-top: 1px solid #ddd;
            background: #fff;
        }

        .input-wrapper {
            display: flex;
            gap: 8px;
            margin-bottom: 12px;
        }

        .input-wrapper textarea {
            flex: 1;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 20px;
            font-size: 14px;
            font-family: inherit;
            resize: none;
            max-height: 100px;
            outline: none;
            transition: all 0.2s;
        }

        .input-wrapper textarea:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .btn-send {
            background: #667eea;
            color: white;
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            transition: all 0.2s;
        }

        .btn-send:hover {
            background: #5568d3;
            transform: scale(1.05);
        }

        .btn-send:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        .quick-replies {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .quick-reply {
            background: #f5f5f5;
            border: 1px solid #ddd;
            padding: 8px 12px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.2s;
        }

        .quick-reply:hover {
            background: #efefef;
            border-color: #667eea;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            color: #999;
            text-align: center;
            gap: 16px;
        }

        .empty-state-icon {
            font-size: 64px;
            opacity: 0.3;
        }

        /* Scrollbar personalizado */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #ddd;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #bbb;
        }

        .no-conversations {
            padding: 24px;
            text-align: center;
            color: #999;
        }

        .loader {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #667eea;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- SIDEBAR -->
        <div class="sidebar">
            <div class="sidebar-header">
                <span>💬</span>
                <h1>Mensajes</h1>
            </div>
            <div class="search-box">
                <input type="text" id="searchInput" placeholder="Buscar cliente...">
            </div>
            <div class="conversations-list" id="conversationsList">
                <div class="no-conversations">Cargando conversaciones...</div>
            </div>
        </div>

        <!-- CHAT AREA -->
        <div class="chat-area">
            <div id="emptyChatState" class="empty-state">
                <div class="empty-state-icon">💬</div>
                <p>Selecciona una conversación para comenzar</p>
            </div>

            <div id="chatContent" style="display: none; flex: 1; display: flex; flex-direction: column;">
                <!-- Chat Header -->
                <div class="chat-header">
                    <div class="chat-title-section">
                        <h2 id="chatName"></h2>
                        <p id="chatPhone"></p>
                    </div>
                    <div class="chat-actions">
                        <span class="status-badge activo" id="statusBadge"></span>
                        <button class="btn-action" id="btnClose">❌ Cerrar</button>
                    </div>
                </div>

                <!-- Messages -->
                <div class="messages-container" id="messagesContainer"></div>

                <!-- Input Area -->
                <div class="input-area">
                    <div class="quick-replies" id="quickReplies"></div>
                    <div class="input-wrapper">
                        <textarea id="messageInput" placeholder="Escribe un mensaje..." rows="1"></textarea>
                        <button class="btn-send" id="btnSend">📤</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentConversationId = null;
        let currentClientId = null;
        let conversations = [];
        let quickReplies = [];

        // Cargar conversaciones
        async function loadConversations() {
            try {
                const response = await fetch('../api/obtener_conversaciones.php');
                const data = await response.json();
                conversations = data.conversaciones || [];
                renderConversations();
            } catch (error) {
                console.error('Error al cargar conversaciones:', error);
            }
        }

        // Cargar respuestas predefinidas
        async function loadQuickReplies() {
            try {
                const response = await fetch('../api/obtener_respuestas.php');
                const data = await response.json();
                quickReplies = data.respuestas || [];
                renderQuickReplies();
            } catch (error) {
                console.error('Error al cargar respuestas:', error);
            }
        }

        // Renderizar conversaciones
        function renderConversations() {
            const list = document.getElementById('conversationsList');
            if (conversations.length === 0) {
                list.innerHTML = '<div class="no-conversations">No hay conversaciones</div>';
                return;
            }

            list.innerHTML = conversations.map(conv => `
                <div class="conversation-item ${conv.id == currentConversationId ? 'active' : ''}" 
                     onclick="selectConversation(${conv.id}, ${conv.cliente_id})">
                    <div class="avatar">${conv.nombre.charAt(0).toUpperCase()}</div>
                    <div class="conversation-info">
                        <div class="conversation-header">
                            <span class="conversation-name">${conv.nombre}</span>
                            <span class="conversation-time">${formatTime(conv.ultimo_mensaje_fecha)}</span>
                        </div>
                        <div class="conversation-preview">${conv.ultimo_mensaje || 'Sin mensajes'}</div>
                    </div>
                    ${conv.no_leidos > 0 ? `<div class="badge">${conv.no_leidos}</div>` : ''}
                </div>
            `).join('');
        }

        // Seleccionar conversación y cargar mensajes
        async function selectConversation(convId, clientId) {
            currentConversationId = convId;
            currentClientId = clientId;

            const conv = conversations.find(c => c.id == convId);
            if (!conv) return;

            document.getElementById('emptyChatState').style.display = 'none';
            document.getElementById('chatContent').style.display = 'flex';
            document.getElementById('chatName').textContent = conv.nombre;
            document.getElementById('chatPhone').textContent = conv.telefono;
            document.getElementById('statusBadge').textContent = conv.estado_cliente || 'activo';

            renderConversations();
            loadMessages();
        }

        // Cargar mensajes de la conversación
        async function loadMessages() {
            if (!currentConversationId) return;

            try {
                const response = await fetch(`../api/obtener_mensajes.php?conversacion_id=${currentConversationId}`);
                const data = await response.json();
                renderMessages(data.mensajes || []);
                scrollToBottom();
            } catch (error) {
                console.error('Error al cargar mensajes:', error);
            }
        }

        // Renderizar mensajes
        function renderMessages(mensajes) {
            const container = document.getElementById('messagesContainer');
            container.innerHTML = mensajes.map(msg => {
                const isOutgoing = msg.remitente === 'admin';
                const isBot = msg.remitente === 'bot';
                let className = isOutgoing ? 'outgoing' : 'incoming';
                if (isBot) className = 'incoming';

                return `
                    <div class="message-group ${className}">
                        <div class="message ${isBot ? 'admin' : ''}">
                            ${msg.contenido}
                            <div class="message-time">${formatDateTime(msg.fecha_envio)}
                                ${isBot ? '<span class="message-badge">🤖 Bot</span>' : ''}
                                ${msg.respuesta_manual ? '<span class="message-badge">✋ Manual</span>' : ''}
                            </div>
                        </div>
                    </div>
                `;
            }).join('');
        }

        // Renderizar respuestas rápidas
        function renderQuickReplies() {
            const container = document.getElementById('quickReplies');
            if (quickReplies.length === 0) return;

            container.innerHTML = quickReplies.map(reply => `
                <div class="quick-reply" onclick="insertQuickReply('${reply.contenido.replace(/'/g, "\\'")}')">${reply.emoji} ${reply.titulo}</div>
            `).join('');
        }

        // Insertar respuesta rápida
        function insertQuickReply(contenido) {
            const input = document.getElementById('messageInput');
            input.value = contenido;
            input.focus();
        }

        // Enviar mensaje
        document.getElementById('btnSend').addEventListener('click', async () => {
            const input = document.getElementById('messageInput');
            const mensaje = input.value.trim();

            if (!mensaje || !currentConversationId || !currentClientId) return;

            const btn = document.getElementById('btnSend');
            btn.disabled = true;
            btn.textContent = '⏳';

            try {
                const response = await fetch('../api/enviar_respuesta.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        cliente_id: currentClientId,
                        conversacion_id: currentConversationId,
                        mensaje: mensaje
                    })
                });

                const data = await response.json();
                if (data.success) {
                    input.value = '';
                    loadMessages();
                } else {
                    alert('Error: ' + data.error);
                }
            } catch (error) {
                console.error('Error al enviar:', error);
                alert('Error al enviar mensaje');
            } finally {
                btn.disabled = false;
                btn.textContent = '📤';
            }
        });

        // Cerrar conversación
        document.getElementById('btnClose').addEventListener('click', async () => {
            if (!confirm('¿Cerrar esta conversación?')) return;

            try {
                const response = await fetch('../api/cerrar_conversacion.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ conversacion_id: currentConversationId })
                });

                const data = await response.json();
                if (data.success) {
                    currentConversationId = null;
                    document.getElementById('chatContent').style.display = 'none';
                    document.getElementById('emptyChatState').style.display = 'flex';
                    loadConversations();
                }
            } catch (error) {
                console.error('Error:', error);
            }
        });

        // Buscar cliente
        document.getElementById('searchInput').addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase();
            const filtered = conversations.filter(c => 
                c.nombre.toLowerCase().includes(query) ||
                c.telefono.includes(query)
            );
            
            const list = document.getElementById('conversationsList');
            if (filtered.length === 0) {
                list.innerHTML = '<div class="no-conversations">No se encontraron clientes</div>';
                return;
            }

            list.innerHTML = filtered.map(conv => `
                <div class="conversation-item ${conv.id == currentConversationId ? 'active' : ''}" 
                     onclick="selectConversation(${conv.id}, ${conv.cliente_id})">
                    <div class="avatar">${conv.nombre.charAt(0).toUpperCase()}</div>
                    <div class="conversation-info">
                        <div class="conversation-header">
                            <span class="conversation-name">${conv.nombre}</span>
                            <span class="conversation-time">${formatTime(conv.ultimo_mensaje_fecha)}</span>
                        </div>
                        <div class="conversation-preview">${conv.ultimo_mensaje || 'Sin mensajes'}</div>
                    </div>
                    ${conv.no_leidos > 0 ? `<div class="badge">${conv.no_leidos}</div>` : ''}
                </div>
            `).join('');
        });

        // Auto-resize textarea
        document.getElementById('messageInput').addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = Math.min(this.scrollHeight, 100) + 'px';
        });

        // Enviar con Ctrl+Enter
        document.getElementById('messageInput').addEventListener('keydown', (e) => {
            if (e.ctrlKey && e.key === 'Enter') {
                document.getElementById('btnSend').click();
            }
        });

        // Scroll al bottom
        function scrollToBottom() {
            const container = document.getElementById('messagesContainer');
            setTimeout(() => {
                container.scrollTop = container.scrollHeight;
            }, 100);
        }

        // Utilidades
        function formatTime(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            const now = new Date();
            const diff = now - date;

            if (diff < 60000) return 'Ahora';
            if (diff < 3600000) return Math.floor(diff / 60000) + 'm';
            if (diff < 86400000) return date.getHours() + ':' + String(date.getMinutes()).padStart(2, '0');
            return date.getDate() + '/' + (date.getMonth() + 1);
        }

        function formatDateTime(dateStr) {
            if (!dateStr) return '';
            const date = new Date(dateStr);
            return date.getHours() + ':' + String(date.getMinutes()).padStart(2, '0');
        }

        // Actualizar cada 3 segundos
        setInterval(() => {
            if (currentConversationId) {
                loadMessages();
            }
            loadConversations();
        }, 3000);

        // Inicial load
        loadConversations();
        loadQuickReplies();
    </script>
</body>
</html>
