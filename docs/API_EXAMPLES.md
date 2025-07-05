# Ejemplos de uso de la API

## 1. Obtener todas las personas

```bash
curl -X GET http://localhost:8000/api/personas
```

## 2. Obtener una persona por ID

```bash
curl -X GET http://localhost:8000/api/personas/1
```

## 3. Crear una nueva persona

```bash
curl -X POST http://localhost:8000/api/personas \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Pedro",
    "apellido": "González",
    "email": "pedro.gonzalez@email.com",
    "edad": 32
  }'
```

## 4. Actualizar una persona

```bash
curl -X PUT http://localhost:8000/api/personas/1 \
  -H "Content-Type: application/json" \
  -d '{
    "nombre": "Pedro",
    "apellido": "González",
    "email": "pedro.gonzalez@email.com",
    "edad": 33
  }'
```

## 5. Actualización parcial

```bash
curl -X PUT http://localhost:8000/api/personas/1 \
  -H "Content-Type: application/json" \
  -d '{
    "edad": 34
  }'
```

## 6. Eliminar una persona

```bash
curl -X DELETE http://localhost:8000/api/personas/1
```

## Respuestas de ejemplo

### Éxito (200/201)

```json
{
  "success": true,
  "data": {
    "id": 1,
    "nombre": "Juan",
    "apellido": "Pérez",
    "email": "juan.perez@email.com",
    "edad": 30
  },
  "message": "Persona creada exitosamente"
}
```

### Error de validación (400)

```json
{
  "success": false,
  "message": "El campo 'email' es requerido"
}
```

### No encontrado (404)

```json
{
  "success": false,
  "message": "Persona no encontrada"
}
```

### Error interno (500)

```json
{
  "success": false,
  "message": "Error interno del servidor",
  "error": "Detalles del error (solo en modo debug)"
}
```
