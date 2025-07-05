@echo off
title Instalacion PHP CRUD PostgreSQL API

echo 🚀 Iniciando instalacion de PHP CRUD PostgreSQL API...
echo.

REM Verificar si Composer esta instalado
composer --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ Composer no esta instalado. Por favor instala Composer primero.
    pause
    exit /b 1
)

REM Verificar si PostgreSQL esta instalado
psql --version >nul 2>&1
if %errorlevel% neq 0 (
    echo ❌ PostgreSQL no esta instalado. Por favor instala PostgreSQL primero.
    pause
    exit /b 1
)

REM Instalar dependencias de Composer
echo 📦 Instalando dependencias de Composer...
composer install

REM Copiar archivo de configuracion
if not exist .env (
    echo ⚙️  Copiando archivo de configuracion...
    copy .env.example .env
    echo ✅ Archivo .env creado. Por favor configura las variables de base de datos.
) else (
    echo ⚠️  El archivo .env ya existe.
)

echo.
set /p create_db="¿Deseas crear la base de datos automaticamente? (y/n): "
if /i "%create_db%"=="y" (
    set /p db_user="Ingresa el nombre de usuario de PostgreSQL: "
    set /p db_name="Ingresa el nombre de la base de datos: "
    
    echo 🗄️  Creando base de datos...
    psql -U %db_user% -c "CREATE DATABASE %db_name%;"
    
    echo 📋 Ejecutando migraciones...
    psql -U %db_user% -d %db_name% -f migrations/001_create_personas_table.sql
)

echo.
echo ✅ Instalacion completada!
echo.
echo 📝 Proximos pasos:
echo 1. Configura las variables en el archivo .env
echo 2. Asegurate de que PostgreSQL este ejecutandose
echo 3. Inicia el servidor web en la carpeta 'public'
echo 4. Prueba la API en: http://localhost/api/personas
echo.
echo 🛠️  Para desarrollo, puedes usar el servidor incorporado de PHP:
echo    cd public ^&^& php -S localhost:8000
echo.
pause
