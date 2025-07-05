<?php

// Establecer cabeceras CORS
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit();
}

require_once __DIR__ . '/../vendor/autoload.php';

use App\Config\Container;
use App\Config\Router;
use App\Interfaces\PersonaServiceInterface;
use Dotenv\Dotenv;

try {
  // Cargar variables de entorno
  $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
  $dotenv->load();

  // Crear contenedor de dependencias
  $container = new Container();

  // Obtener el servicio de personas
  $personaService = $container->get(PersonaServiceInterface::class);

  // Crear y ejecutar el router
  $router = new Router($personaService);
  $router->route();
} catch (Exception $e) {
  http_response_code(500);
  header('Content-Type: application/json');
  echo json_encode([
    'success' => false,
    'message' => 'Error interno del servidor',
    'error' => ($_ENV['APP_DEBUG'] ?? 'false') === 'true' ? $e->getMessage() : 'Error interno'
  ]);
}
