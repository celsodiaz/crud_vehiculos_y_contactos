-- Creación de base de datos
CREATE DATABASE IF NOT EXISTS encuestas_anonimas;
USE encuestas_anonimas;

-- Tabla de encuestas
CREATE TABLE encuestas (
    id_encuesta INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de preguntas
CREATE TABLE preguntas (
    id_pregunta INT AUTO_INCREMENT PRIMARY KEY,
    id_encuesta INT NOT NULL,
    texto_pregunta TEXT NOT NULL,
    tipo ENUM('opcion_unica','multiple','texto') NOT NULL,
    FOREIGN KEY (id_encuesta) REFERENCES encuestas(id_encuesta) ON DELETE CASCADE
);

-- Tabla de opciones
CREATE TABLE opciones (
    id_opcion INT AUTO_INCREMENT PRIMARY KEY,
    id_pregunta INT NOT NULL,
    texto_opcion VARCHAR(255) NOT NULL,
    FOREIGN KEY (id_pregunta) REFERENCES preguntas(id_pregunta) ON DELETE CASCADE
);

-- Tabla de respuestas
CREATE TABLE respuestas (
    id_respuesta INT AUTO_INCREMENT PRIMARY KEY,
    id_pregunta INT NOT NULL,
    id_opcion INT NULL,
    respuesta_texto TEXT NULL,
    fecha_respuesta DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pregunta) REFERENCES preguntas(id_pregunta) ON DELETE CASCADE,
    FOREIGN KEY (id_opcion) REFERENCES opciones(id_opcion) ON DELETE CASCADE
);
