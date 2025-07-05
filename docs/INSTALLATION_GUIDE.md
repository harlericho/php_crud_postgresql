# Guía de Instalación Completa - PHP 7.4 CRUD PostgreSQL API

## ⚡ Instalación Rápida

### 1. Verificar Requisitos del Sistema

**PHP 7.4+**

```bash
php --version
```

**Composer**

```bash
composer --version
```

**PostgreSQL**

```bash
psql --version
```

### 2. Configurar el Proyecto

1. **Instalar dependencias**:

   ```bash
   composer install
   ```

2. **Configurar entorno**:
   - Copiar `.env.example` a `.env`
   - Editar `.env` con tus datos de PostgreSQL:
   ```env
   DB_HOST=localhost
   DB_PORT=5432
   DB_NAME=persona_db
   DB_USER=tu_usuario
   DB_PASS=tu_password
   ```

### 3. Configurar Base de Datos

1. **Crear base de datos**:

   ```sql
   CREATE DATABASE persona_db;
   ```

2. **Ejecutar migración**:
   ```bash
   psql -U tu_usuario -d persona_db -f migrations/001_create_personas_table.sql
   ```

### 4. Iniciar Servidor

```bash
cd public
php -S localhost:8000
```

## 🚀 Probar la API

### Test básico

Visita: http://localhost:8000/test.php

### Endpoints disponibles

1. **Listar personas**:

   ```bash
   curl http://localhost:8000/api/personas
   ```

2. **Crear persona**:

   ```bash
   curl -X POST http://localhost:8000/api/personas \
     -H "Content-Type: application/json" \
     -d '{
       "nombre": "Juan",
       "apellido": "Pérez",
       "email": "juan@email.com",
       "edad": 30
     }'
   ```

3. **Obtener persona por ID**:

   ```bash
   curl http://localhost:8000/api/personas/1
   ```

4. **Actualizar persona**:

   ```bash
   curl -X PUT http://localhost:8000/api/personas/1 \
     -H "Content-Type: application/json" \
     -d '{
       "nombre": "Juan Carlos",
       "edad": 31
     }'
   ```

5. **Eliminar persona**:
   ```bash
   curl -X DELETE http://localhost:8000/api/personas/1
   ```

## 🛠️ Solución de Problemas

### Error: ext-pgsql missing

```bash
# En Ubuntu/Debian
sudo apt-get install php7.4-pgsql

# En CentOS/RHEL
sudo yum install php74-php-pgsql

# En Windows con XAMPP
# Descomentar extension=pgsql en php.ini
```

### Error de conexión PostgreSQL

1. Verificar que PostgreSQL esté ejecutándose
2. Verificar credenciales en `.env`
3. Verificar que la base de datos existe

### Error de permisos

```bash
# Linux/Mac
chmod 755 public/
chmod 644 public/index.php
```

## 📁 Estructura del Proyecto

```
├── src/
│   ├── Config/         # Configuración y Container DI
│   ├── Controllers/    # Controladores REST
│   ├── Models/         # Modelos de datos
│   ├── Repositories/   # Acceso a datos
│   ├── Services/       # Lógica de negocio
│   └── Interfaces/     # Contratos SOLID
├── public/             # Punto de entrada web
├── migrations/         # Scripts SQL
├── docs/              # Documentación
└── vendor/            # Dependencias Composer
```

## 🎯 Principios SOLID Implementados

- **S** - Single Responsibility: Cada clase tiene una responsabilidad
- **O** - Open/Closed: Extensible sin modificar código existente
- **L** - Liskov Substitution: Interfaces intercambiables
- **I** - Interface Segregation: Interfaces específicas
- **D** - Dependency Inversion: Depende de abstracciones

## 📈 Próximos Pasos

1. Agregar autenticación JWT
2. Implementar paginación
3. Agregar filtros y búsqueda
4. Crear tests unitarios
5. Dockerizar la aplicación
