# PHP CRUD PostgreSQL API

API REST desarrollada en PHP 7.4+ con PostgreSQL siguiendo principios SOLID.

## Estructura del Proyecto

```
├── src/
│   ├── Config/         # Configuración de base de datos
│   ├── Controllers/    # Controladores (Capa de presentación)
│   ├── Models/         # Modelos de datos
│   ├── Repositories/   # Repositorios (Acceso a datos)
│   ├── Services/       # Servicios de negocio
│   └── Interfaces/     # Contratos/Interfaces
├── public/             # Punto de entrada público
├── migrations/         # Migraciones de base de datos
└── tests/             # Pruebas unitarias
```

## Instalación

### Opción 1: Usando Docker (Recomendado) 🐳

**Requisitos:**

- Docker
- Docker Compose

**Instalación rápida:**

```bash
# Clonar o descargar el proyecto
# Iniciar servicios con Docker
docker-compose up -d

# O usar el script helper
./docker.sh start        # Linux/Mac
docker.bat start         # Windows
```

**Servicios disponibles:**

- **PostgreSQL**: `localhost:5432`
- **pgAdmin**: `http://localhost:8080` (admin@example.com / admin123)
- **API PHP**: `http://localhost:8000`

**Comandos útiles:**

```bash
docker-compose logs -f              # Ver logs
docker-compose down                 # Detener servicios
docker-compose down -v              # Detener y eliminar datos
docker-compose exec postgres psql -U postgres -d persona_db  # Conectar a BD
```

### Opción 2: Instalación Local

**Requisitos:**

- PHP 7.4 o superior
- PostgreSQL 9.6 o superior
- Composer
- Extensión PHP PDO y PDO_PGSQL

**Pasos de instalación:**

1. **Instalar dependencias**:
   ```bash
   composer install
   ```
2. **Configurar variables de entorno**:
   - Copiar `.env.example` a `.env`
   - Modificar las variables de base de datos en `.env`
3. **Crear la base de datos PostgreSQL**:
   ```sql
   CREATE DATABASE persona_db;
   ```
4. **Ejecutar las migraciones**:
   ```bash
   psql -U tu_usuario -d persona_db -f migrations/001_create_personas_table.sql
   ```
5. **Iniciar el servidor de desarrollo**:
   ```bash
   cd public
   php -S localhost:8000
   ```

### Scripts de Instalación Automática

**Para Windows:**

- Ejecutar `install.bat` para instalación local
- Ejecutar `docker.bat start` para Docker

**Para Linux/Mac:**

- Ejecutar `chmod +x install.sh && ./install.sh` para instalación local
- Ejecutar `chmod +x docker.sh && ./docker.sh start` para Docker

## Endpoints

- `GET /api/personas` - Listar todas las personas
- `GET /api/personas/{id}` - Obtener una persona por ID
- `POST /api/personas` - Crear nueva persona
- `PUT /api/personas/{id}` - Actualizar persona
- `DELETE /api/personas/{id}` - Eliminar persona

## Estructura de Persona

```json
{
  "id": 1,
  "nombre": "Juan",
  "apellido": "Pérez",
  "email": "juan@email.com",
  "edad": 30
}
```
