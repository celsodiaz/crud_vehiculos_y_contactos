-- Tabla de encuestas
CREATE TABLE encuestas (
    id_encuesta INTEGER PRIMARY KEY AUTOINCREMENT,
    titulo TEXT NOT NULL,
    descripcion TEXT,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de preguntas
CREATE TABLE preguntas (
    id_pregunta INTEGER PRIMARY KEY AUTOINCREMENT,
    id_encuesta INTEGER NOT NULL,
    texto_pregunta TEXT NOT NULL,
    tipo TEXT NOT NULL CHECK(tipo IN ('opcion_unica','multiple','texto')),
    FOREIGN KEY (id_encuesta) REFERENCES encuestas(id_encuesta) ON DELETE CASCADE
);

-- Tabla de opciones
CREATE TABLE opciones (
    id_opcion INTEGER PRIMARY KEY AUTOINCREMENT,
    id_pregunta INTEGER NOT NULL,
    texto_opcion TEXT NOT NULL,
    FOREIGN KEY (id_pregunta) REFERENCES preguntas(id_pregunta) ON DELETE CASCADE
);

-- Tabla de respuestas
CREATE TABLE respuestas (
    id_respuesta INTEGER PRIMARY KEY AUTOINCREMENT,
    id_pregunta INTEGER NOT NULL,
    id_opcion INTEGER NULL,
    respuesta_texto TEXT NULL,
    fecha_respuesta DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_pregunta) REFERENCES preguntas(id_pregunta) ON DELETE CASCADE,
    FOREIGN KEY (id_opcion) REFERENCES opciones(id_opcion) ON DELETE CASCADE
);
