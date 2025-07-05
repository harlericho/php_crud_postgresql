-- Migración para crear la tabla personas
-- Ejecutar en PostgreSQL

CREATE TABLE IF NOT EXISTS personas (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    edad INTEGER NOT NULL CHECK (edad >= 0 AND edad <= 150),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Índice para búsquedas por email
CREATE INDEX IF NOT EXISTS idx_personas_email ON personas(email);

-- Función para actualizar updated_at automáticamente
CREATE OR REPLACE FUNCTION update_updated_at_column()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ language 'plpgsql';

-- Trigger para actualizar updated_at automáticamente
CREATE TRIGGER update_personas_updated_at 
    BEFORE UPDATE ON personas 
    FOR EACH ROW 
    EXECUTE FUNCTION update_updated_at_column();

-- Datos de ejemplo (opcional)
INSERT INTO personas (nombre, apellido, email, edad) VALUES
    ('Juan', 'Pérez', 'juan.perez@email.com', 30),
    ('María', 'García', 'maria.garcia@email.com', 25),
    ('Carlos', 'López', 'carlos.lopez@email.com', 35),
    ('Ana', 'Martínez', 'ana.martinez@email.com', 28)
ON CONFLICT (email) DO NOTHING;
