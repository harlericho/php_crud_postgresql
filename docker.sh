#!/bin/bash

# Script para gestionar el entorno Docker

case "$1" in
    "start")
        echo "🚀 Iniciando servicios Docker..."
        docker-compose up -d
        echo "✅ Servicios iniciados:"
        echo "   - PostgreSQL: localhost:5432"
        echo "   - pgAdmin: http://localhost:8080 (admin@example.com / admin123)"
        echo "   - API PHP: http://localhost:8000"
        echo ""
        echo "📋 Para ver los logs:"
        echo "   docker-compose logs -f"
        ;;
    
    "stop")
        echo "🛑 Deteniendo servicios Docker..."
        docker-compose down
        echo "✅ Servicios detenidos"
        ;;
    
    "restart")
        echo "🔄 Reiniciando servicios..."
        docker-compose down
        docker-compose up -d
        echo "✅ Servicios reiniciados"
        ;;
    
    "logs")
        echo "📋 Mostrando logs..."
        docker-compose logs -f
        ;;
    
    "db-only")
        echo "🗄️ Iniciando solo PostgreSQL..."
        docker-compose up -d postgres
        echo "✅ PostgreSQL iniciado en localhost:5432"
        ;;
    
    "reset")
        echo "⚠️  ADVERTENCIA: Esto eliminará todos los datos!"
        read -p "¿Estás seguro? (y/N): " confirm
        if [[ $confirm == [yY] ]]; then
            docker-compose down -v
            docker-compose up -d
            echo "✅ Base de datos reiniciada"
        else
            echo "❌ Operación cancelada"
        fi
        ;;
    
    "status")
        echo "📊 Estado de los servicios:"
        docker-compose ps
        ;;
    
    "shell")
        echo "🐚 Conectando a PostgreSQL..."
        docker-compose exec postgres psql -U postgres -d persona_db
        ;;
    
    *)
        echo "🐳 Gestión Docker para PHP CRUD PostgreSQL API"
        echo ""
        echo "Uso: $0 {comando}"
        echo ""
        echo "Comandos disponibles:"
        echo "  start     - Iniciar todos los servicios"
        echo "  stop      - Detener todos los servicios"
        echo "  restart   - Reiniciar todos los servicios"
        echo "  logs      - Ver logs en tiempo real"
        echo "  db-only   - Iniciar solo PostgreSQL"
        echo "  reset     - Reiniciar base de datos (ELIMINA DATOS)"
        echo "  status    - Ver estado de los servicios"
        echo "  shell     - Conectar a PostgreSQL CLI"
        echo ""
        echo "Ejemplos:"
        echo "  $0 start"
        echo "  $0 db-only"
        echo "  $0 logs"
        ;;
esac
