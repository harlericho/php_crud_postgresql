#!/bin/bash

# Script de instalación para PHP CRUD PostgreSQL API

echo "🚀 Iniciando instalación de PHP CRUD PostgreSQL API..."

# Verificar si Composer está instalado
if ! command -v composer &> /dev/null; then
    echo "❌ Composer no está instalado. Por favor instala Composer primero."
    exit 1
fi

# Verificar si PostgreSQL está instalado
if ! command -v psql &> /dev/null; then
    echo "❌ PostgreSQL no está instalado. Por favor instala PostgreSQL primero."
    exit 1
fi

# Instalar dependencias de Composer
echo "📦 Instalando dependencias de Composer..."
composer install

# Copiar archivo de configuración
if [ ! -f .env ]; then
    echo "⚙️  Copiando archivo de configuración..."
    cp .env.example .env
    echo "✅ Archivo .env creado. Por favor configura las variables de base de datos."
else
    echo "⚠️  El archivo .env ya existe."
fi

# Crear base de datos (opcional)
read -p "¿Deseas crear la base de datos automáticamente? (y/n): " create_db
if [ "$create_db" = "y" ] || [ "$create_db" = "Y" ]; then
    read -p "Ingresa el nombre de usuario de PostgreSQL: " db_user
    read -p "Ingresa el nombre de la base de datos: " db_name
    
    echo "🗄️  Creando base de datos..."
    psql -U $db_user -c "CREATE DATABASE $db_name;"
    
    echo "📋 Ejecutando migraciones..."
    psql -U $db_user -d $db_name -f migrations/001_create_personas_table.sql
fi

echo "✅ Instalación completada!"
echo ""
echo "📝 Próximos pasos:"
echo "1. Configura las variables en el archivo .env"
echo "2. Asegúrate de que PostgreSQL esté ejecutándose"
echo "3. Inicia el servidor web en la carpeta 'public'"
echo "4. Prueba la API en: http://localhost/api/personas"
echo ""
echo "🛠️  Para desarrollo, puedes usar el servidor incorporado de PHP:"
echo "   cd public && php -S localhost:8000"
