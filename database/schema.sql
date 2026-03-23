-- Tabla de clientes
CREATE TABLE IF NOT EXISTS clientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    telefono VARCHAR(20) UNIQUE NOT NULL,
    nombre VARCHAR(100),
    estado ENUM('activo', 'inactivo', 'contactado') DEFAULT 'activo',
    ultima_interaccion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de conversaciones
CREATE TABLE IF NOT EXISTS conversaciones (
    id INT PRIMARY KEY AUTO_INCREMENT,
    cliente_id INT NOT NULL,
    asunto VARCHAR(255),
    estado ENUM('abierta', 'cerrada', 'en_espera') DEFAULT 'abierta',
    fecha_inicio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_fin TIMESTAMP NULL,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE
);

-- Tabla de mensajes
CREATE TABLE IF NOT EXISTS mensajes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    conversacion_id INT NOT NULL,
    cliente_id INT NOT NULL,
    remitente ENUM('cliente', 'admin', 'bot') DEFAULT 'cliente',
    contenido TEXT NOT NULL,
    tipo ENUM('texto', 'imagen', 'archivo') DEFAULT 'texto',
    archivos JSON,
    leido BOOLEAN DEFAULT FALSE,
    fecha_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    respuesta_manual BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (conversacion_id) REFERENCES conversaciones(id) ON DELETE CASCADE,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    INDEX idx_conversacion (conversacion_id),
    INDEX idx_cliente (cliente_id),
    INDEX idx_fecha (fecha_envio)
);

-- Tabla de respuestas predefinidas
CREATE TABLE IF NOT EXISTS respuestas_predefinidas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(150) NOT NULL,
    contenido TEXT NOT NULL,
    emoji VARCHAR(50),
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insertar respuestas predefinidas de ejemplo
INSERT INTO respuestas_predefinidas (titulo, contenido, emoji) VALUES
    ('Bienvenida', '👋 ¡Bienvenido a Inmobiliaria Serrano! ¿En qué podemos ayudarte?', '👋'),
    ('Contacto Asesor', '👔 Un asesor se pondrá en contacto contigo en breves momentos. ¡Gracias!', '👔'),
    ('Más tarde', '⏳ Vuelve a escribir más tarde, un asesor te atenderá. Gracias por tu paciencia.', '⏳'),
    ('Cierre', '✅ Gracias por comunicarte con nosotros. ¡Que tengas un excelente día!', '✅');
