-- Migración para crear la tabla categorias
-- Ejecutar en PostgreSQL

CREATE TABLE IF NOT EXISTS categorias (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Índice para búsquedas por nombre
CREATE INDEX IF NOT EXISTS idx_categorias_nombre ON categorias(nombre);

-- Índice para filtrar por estado activo
CREATE INDEX IF NOT EXISTS idx_categorias_activo ON categorias(activo);

-- Trigger para actualizar updated_at automáticamente (reutiliza la función existente)
CREATE TRIGGER update_categorias_updated_at 
    BEFORE UPDATE ON categorias 
    FOR EACH ROW 
    EXECUTE FUNCTION update_updated_at_column();

-- Datos de ejemplo (opcional)
INSERT INTO categorias (nombre, descripcion, activo) VALUES
    ('Tecnología', 'Productos y servicios relacionados con tecnología', TRUE),
    ('Educación', 'Cursos, libros y material educativo', TRUE),
    ('Salud', 'Productos y servicios de salud y bienestar', TRUE),
    ('Deportes', 'Equipamiento y servicios deportivos', TRUE),
    ('Hogar', 'Productos para el hogar y decoración', TRUE)
ON CONFLICT (nombre) DO NOTHING;
