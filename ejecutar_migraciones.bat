@echo off
echo ========================================
echo    EJECUTANDO NUEVAS MIGRACIONES
echo ========================================

echo.
echo 1. Deteniendo contenedor de PostgreSQL...
docker-compose stop postgres

echo.
echo 2. Iniciando contenedor de PostgreSQL con nuevas migraciones...
docker-compose up -d postgres

echo.
echo 3. Esperando que PostgreSQL este listo...
timeout /t 10 /nobreak > nul

echo.
echo 4. Verificando estado de la base de datos...
docker exec php_crud_postgres psql -U postgres -d persona_db -c "\dt"

echo.
echo 5. Mostrando resumen de datos:
echo.
echo === PERSONAS ===
docker exec php_crud_postgres psql -U postgres -d persona_db -c "SELECT COUNT(*) as total_personas FROM personas;"

echo.
echo === CATEGORIAS ===
docker exec php_crud_postgres psql -U postgres -d persona_db -c "SELECT COUNT(*) as total_categorias FROM categorias;"

echo.
echo === ROLES ===
docker exec php_crud_postgres psql -U postgres -d persona_db -c "SELECT COUNT(*) as total_roles FROM roles;"

echo.
echo ========================================
echo    MIGRACIONES COMPLETADAS
echo ========================================
pause
