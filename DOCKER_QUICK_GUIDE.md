# 🐳 Guía Rápida Docker - PostgreSQL Persistente

## ✅ Configuración Validada

Tu `docker-compose.yml` incluye:

### 📦 Servicios

- **PostgreSQL 13**: Puerto 5432, datos persistentes
- **pgAdmin**: Puerto 8080 (opcional)
- **PHP App**: Puerto 8000 (opcional)

### 💾 Persistencia de Datos

```yaml
volumes:
  postgres_data:
    driver: local
```

Los datos se almacenan en el volumen Docker `php_crud_postgresql_postgres_data` y persisten entre reinicios.

## 🚀 Comandos Básicos

### Iniciar solo PostgreSQL

```bash
docker-compose up -d postgres
```

### Iniciar todos los servicios

```bash
docker-compose up -d
```

### Ver servicios en ejecución

```bash
docker-compose ps
```

### Ver logs

```bash
docker-compose logs -f postgres
```

### Detener servicios

```bash
docker-compose down
```

### Acceder a PostgreSQL

```bash
docker exec -it php_crud_postgres psql -U postgres -d persona_db
```

## 🔧 Scripts Helper (Windows)

Usa `docker.bat` para gestión fácil:

```bash
docker.bat start    # Iniciar todos
docker.bat db-only  # Solo PostgreSQL
docker.bat stop     # Detener todos
docker.bat status   # Ver estado
docker.bat logs     # Ver logs
```

## 📊 Información de Conexión

### PostgreSQL

- **Host**: localhost
- **Puerto**: 5432
- **Base de datos**: persona_db
- **Usuario**: postgres
- **Contraseña**: password

### pgAdmin (Web)

- **URL**: http://localhost:8080
- **Email**: admin@example.com
- **Contraseña**: admin123

## 🧪 Verificación de Persistencia

✅ **Probado**: Los datos persisten después de:

- Reiniciar contenedores
- Reiniciar Docker
- Reiniciar el sistema

Los datos se mantienen en el volumen Docker hasta que lo elimines explícitamente con:

```bash
docker-compose down -v  # ⚠️ ELIMINA LOS DATOS
```

## 📁 Estructura de Datos

La tabla `personas` se crea automáticamente con:

- Migración automática al inicio
- Índices optimizados
- Validaciones de datos
- Timestamps automáticos
