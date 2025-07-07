-- Migración para crear la tabla roles
-- Ejecutar en PostgreSQL

CREATE TABLE IF NOT EXISTS roles (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL UNIQUE,
    descripcion TEXT,
    permisos TEXT[], -- Array de permisos para flexibilidad
    activo BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- Índice para búsquedas por nombre
CREATE INDEX IF NOT EXISTS idx_roles_nombre ON roles(nombre);

-- Índice para filtrar por estado activo
CREATE INDEX IF NOT EXISTS idx_roles_activo ON roles(activo);

-- Índice para búsquedas en permisos usando GIN
CREATE INDEX IF NOT EXISTS idx_roles_permisos ON roles USING GIN(permisos);

-- Trigger para actualizar updated_at automáticamente (reutiliza la función existente)
CREATE TRIGGER update_roles_updated_at 
    BEFORE UPDATE ON roles 
    FOR EACH ROW 
    EXECUTE FUNCTION update_updated_at_column();

-- Datos de ejemplo (opcional)
INSERT INTO roles (nombre, descripcion, permisos, activo) VALUES
    ('Administrador', 'Acceso completo al sistema', ARRAY['crear', 'leer', 'actualizar', 'eliminar', 'gestionar_usuarios'], TRUE),
    ('Editor', 'Puede crear y editar contenido', ARRAY['crear', 'leer', 'actualizar'], TRUE),
    ('Moderador', 'Puede moderar contenido y usuarios', ARRAY['leer', 'actualizar', 'moderar'], TRUE),
    ('Usuario', 'Acceso básico de solo lectura', ARRAY['leer'], TRUE),
    ('Invitado', 'Acceso muy limitado', ARRAY['leer_publico'], TRUE)
ON CONFLICT (nombre) DO NOTHING;
