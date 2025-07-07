# COMANDOS PARA MIGRACIONES

## Para nueva migración (cuando Docker ya está corriendo):

docker-compose restart postgres

## Para verificar que funcionó:

docker exec php_crud_postgres psql -U postgres -d persona_db -c "\dt"

## Para ver los datos:

docker exec php_crud_postgres psql -U postgres -d persona_db -c "SELECT 'personas', COUNT(_) FROM personas UNION SELECT 'categorias', COUNT(_) FROM categorias UNION SELECT 'roles', COUNT(\*) FROM roles;"

## Para reset completo (si hay problemas):

docker-compose down && docker-compose up -d
