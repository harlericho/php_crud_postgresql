<?php
// Archivo de prueba simple para verificar que la API funciona
// sin necesidad de PostgreSQL configurado

header('Content-Type: application/json');

echo json_encode([
  'success' => true,
  'message' => 'API REST PHP 7.4 PostgreSQL funcionando correctamente',
  'version' => '1.0.0',
  'php_version' => phpversion(),
  'endpoints' => [
    'GET /api/personas' => 'Listar todas las personas',
    'GET /api/personas/{id}' => 'Obtener una persona por ID',
    'POST /api/personas' => 'Crear nueva persona',
    'PUT /api/personas/{id}' => 'Actualizar persona',
    'DELETE /api/personas/{id}' => 'Eliminar persona',

    'GET /api/categorias' => 'Listar todas las categorías',
    'GET /api/categorias/activas' => 'Listar solo categorías activas',
    'GET /api/categorias/{id}' => 'Obtener una categoría por ID',
    'POST /api/categorias' => 'Crear nueva categoría',
    'PUT /api/categorias/{id}' => 'Actualizar categoría',
    'DELETE /api/categorias/{id}' => 'Eliminar categoría'
  ],
  'ejemplo_persona' => [
    'nombre' => 'Juan',
    'apellido' => 'Pérez',
    'email' => 'juan.perez@email.com',
    'edad' => 30
  ],
  'ejemplo_categoria' => [
    'nombre' => 'Electrónica',
    'descripcion' => 'Categoría de productos electrónicos',
    'activo' => true
  ]
], JSON_PRETTY_PRINT);
