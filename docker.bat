@echo off
title Gestion Docker - PHP CRUD PostgreSQL API

if "%1"=="start" goto start
if "%1"=="stop" goto stop
if "%1"=="restart" goto restart
if "%1"=="logs" goto logs
if "%1"=="db-only" goto db-only
if "%1"=="reset" goto reset
if "%1"=="status" goto status
if "%1"=="shell" goto shell
goto help

:start
echo 🚀 Iniciando servicios Docker...
docker-compose up -d
echo ✅ Servicios iniciados:
echo    - PostgreSQL: localhost:5432
echo    - pgAdmin: http://localhost:8080 (admin@example.com / admin123)
echo    - API PHP: http://localhost:8000
echo.
echo 📋 Para ver los logs:
echo    docker-compose logs -f
goto end

:stop
echo 🛑 Deteniendo servicios Docker...
docker-compose down
echo ✅ Servicios detenidos
goto end

:restart
echo 🔄 Reiniciando servicios...
docker-compose down
docker-compose up -d
echo ✅ Servicios reiniciados
goto end

:logs
echo 📋 Mostrando logs...
docker-compose logs -f
goto end

:db-only
echo 🗄️ Iniciando solo PostgreSQL...
docker-compose up -d postgres
echo ✅ PostgreSQL iniciado en localhost:5432
goto end

:reset
echo ⚠️  ADVERTENCIA: Esto eliminara todos los datos!
set /p confirm="¿Estas seguro? (y/N): "
if /i "%confirm%"=="y" (
    docker-compose down -v
    docker-compose up -d
    echo ✅ Base de datos reiniciada
) else (
    echo ❌ Operacion cancelada
)
goto end

:status
echo 📊 Estado de los servicios:
docker-compose ps
goto end

:shell
echo 🐚 Conectando a PostgreSQL...
docker-compose exec postgres psql -U postgres -d persona_db
goto end

:help
echo 🐳 Gestion Docker para PHP CRUD PostgreSQL API
echo.
echo Uso: %0 {comando}
echo.
echo Comandos disponibles:
echo   start     - Iniciar todos los servicios
echo   stop      - Detener todos los servicios
echo   restart   - Reiniciar todos los servicios
echo   logs      - Ver logs en tiempo real
echo   db-only   - Iniciar solo PostgreSQL
echo   reset     - Reiniciar base de datos (ELIMINA DATOS)
echo   status    - Ver estado de los servicios
echo   shell     - Conectar a PostgreSQL CLI
echo.
echo Ejemplos:
echo   %0 start
echo   %0 db-only
echo   %0 logs

:end
pause
