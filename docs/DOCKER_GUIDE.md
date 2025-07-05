# Guía Docker - PHP CRUD PostgreSQL API

## 🐳 Configuración Docker

Este proyecto incluye una configuración completa de Docker que permite ejecutar la aplicación y la base de datos en contenedores.

## 📋 Servicios Incluidos

### 1. PostgreSQL Database

- **Puerto**: 5432
- **Base de datos**: persona_db
- **Usuario**: postgres
- **Contraseña**: password
- **Datos persistentes**: Sí (volumen Docker)

### 2. pgAdmin (Opcional)

- **Puerto**: 8080
- **URL**: http://localhost:8080
- **Email**: admin@example.com
- **Contraseña**: admin123

### 3. PHP Application (Opcional)

- **Puerto**: 8000
- **URL**: http://localhost:8000
- **Entorno**: Desarrollo

## 🚀 Inicio Rápido

### Opción 1: Solo Base de Datos

```bash
# Iniciar solo PostgreSQL
docker-compose up -d postgres

# O usar el script helper
./docker.sh db-only     # Linux/Mac
docker.bat db-only      # Windows
```

### Opción 2: Todos los Servicios

```bash
# Iniciar todos los servicios
docker-compose up -d

# O usar el script helper
./docker.sh start       # Linux/Mac
docker.bat start        # Windows
```

## 📊 Gestión de Servicios

### Scripts Helper

**Linux/Mac:**

```bash
chmod +x docker.sh
./docker.sh {comando}
```

**Windows:**

```cmd
docker.bat {comando}
```

### Comandos Disponibles

| Comando   | Descripción                  |
| --------- | ---------------------------- |
| `start`   | Iniciar todos los servicios  |
| `stop`    | Detener todos los servicios  |
| `restart` | Reiniciar servicios          |
| `logs`    | Ver logs en tiempo real      |
| `db-only` | Solo PostgreSQL              |
| `reset`   | Reiniciar BD (elimina datos) |
| `status`  | Estado de servicios          |
| `shell`   | Conectar a PostgreSQL CLI    |

## 🗄️ Persistencia de Datos

Los datos de PostgreSQL se almacenan en un volumen Docker nombrado `postgres_data`, lo que garantiza que:

- ✅ Los datos persisten entre reinicios de contenedores
- ✅ Los datos no se pierden al actualizar imágenes
- ✅ Se pueden hacer backups del volumen

### Gestión de Volúmenes

```bash
# Ver volúmenes
docker volume ls

# Inspeccionar volumen de datos
docker volume inspect php_crud_postgresql_postgres_data

# Backup del volumen (ejemplo)
docker run --rm -v php_crud_postgresql_postgres_data:/data -v $(pwd):/backup alpine tar czf /backup/postgres_backup.tar.gz -C /data .

# Restaurar backup
docker run --rm -v php_crud_postgresql_postgres_data:/data -v $(pwd):/backup alpine tar xzf /backup/postgres_backup.tar.gz -C /data
```

## 🔧 Configuración Personalizada

### Variables de Entorno

Puedes personalizar la configuración creando un archivo `.env.docker`:

```env
# Base de datos
DB_HOST=postgres
DB_PORT=5432
DB_NAME=mi_base_datos
DB_USER=mi_usuario
DB_PASS=mi_password

# Aplicación
APP_ENV=production
APP_DEBUG=false
```

### Puertos Personalizados

Modifica el `docker-compose.yml` para cambiar puertos:

```yaml
services:
  postgres:
    ports:
      - "5433:5432" # PostgreSQL en puerto 5433

  pgadmin:
    ports:
      - "8081:80" # pgAdmin en puerto 8081

  php_app:
    ports:
      - "8001:8000" # API en puerto 8001
```

## 🐚 Acceso a Servicios

### PostgreSQL CLI

```bash
# Conectar a la base de datos
docker-compose exec postgres psql -U postgres -d persona_db

# Ejecutar consultas SQL
docker-compose exec postgres psql -U postgres -d persona_db -c "SELECT * FROM personas;"
```

### Logs de Aplicación

```bash
# Logs de todos los servicios
docker-compose logs -f

# Logs de un servicio específico
docker-compose logs -f postgres
docker-compose logs -f php_app
```

### Shells de Contenedores

```bash
# Shell del contenedor PostgreSQL
docker-compose exec postgres sh

# Shell del contenedor PHP
docker-compose exec php_app sh
```

## 🔍 Solución de Problemas

### Error: Puerto ya en uso

```bash
# Verificar qué está usando el puerto
netstat -tulpn | grep :5432

# Detener servicio local de PostgreSQL
sudo systemctl stop postgresql  # Linux
brew services stop postgresql   # Mac
```

### Error: Volumen corrupto

```bash
# Eliminar volúmenes y recrear
docker-compose down -v
docker-compose up -d
```

### Error: Memoria insuficiente

```bash
# Verificar uso de memoria
docker stats

# Limpiar contenedores no utilizados
docker system prune -a
```

## 🚀 Desarrollo con Docker

### Hot Reload

El contenedor PHP está configurado para recargar automáticamente los cambios:

```yaml
volumes:
  - .:/var/www/html # Sincroniza código en tiempo real
```

### Debugging

Para debugging, puedes conectar tu IDE al contenedor:

```bash
# Instalar Xdebug en el contenedor
docker-compose exec php_app pecl install xdebug
```

## 📈 Producción

Para producción, considera:

1. **Usar imágenes específicas** (no `latest`)
2. **Configurar secretos** para contraseñas
3. **Usar reverse proxy** (nginx)
4. **Configurar logs externos**
5. **Implementar health checks**

### Ejemplo de configuración de producción:

```yaml
services:
  postgres:
    image: postgres:13.8-alpine # Versión específica
    environment:
      POSTGRES_PASSWORD_FILE: /run/secrets/db_password
    secrets:
      - db_password

secrets:
  db_password:
    file: ./secrets/db_password.txt
```
