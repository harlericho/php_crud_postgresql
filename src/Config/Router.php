<?php

namespace App\Config;

use App\Controllers\PersonaController;
use App\Interfaces\PersonaServiceInterface;

class Router
{
  private $personaController;

  public function __construct(PersonaServiceInterface $personaService)
  {
    $this->personaController = new PersonaController($personaService);
  }

  public function route()
  {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];

    // Remover query string
    $uri = strtok($uri, '?');

    // Remover slash inicial si existe
    $uri = ltrim($uri, '/');

    // Dividir la URI en segmentos
    $segments = explode('/', $uri);

    // Verificar que sea una ruta de API
    if (count($segments) < 2 || $segments[0] !== 'api' || $segments[1] !== 'personas') {
      $this->sendNotFound();
      return;
    }

    $this->handlePersonasRoute($method, $segments);
  }

  private function handlePersonasRoute($method, $segments)
  {
    switch ($method) {
      case 'GET':
        $this->handleGetRequest($segments);
        break;

      case 'POST':
        $this->handlePostRequest($segments);
        break;

      case 'PUT':
        $this->handlePutRequest($segments);
        break;

      case 'DELETE':
        $this->handleDeleteRequest($segments);
        break;

      default:
        $this->sendMethodNotAllowed();
        break;
    }
  }

  private function handleGetRequest($segments)
  {
    if (count($segments) === 2) {
      // GET /api/personas
      $this->personaController->index();
    } elseif (count($segments) === 3 && is_numeric($segments[2])) {
      // GET /api/personas/{id}
      $this->personaController->show((int) $segments[2]);
    } else {
      $this->sendNotFound();
    }
  }

  private function handlePostRequest($segments)
  {
    if (count($segments) === 2) {
      // POST /api/personas
      $this->personaController->store();
    } else {
      $this->sendNotFound();
    }
  }

  private function handlePutRequest($segments)
  {
    if (count($segments) === 3 && is_numeric($segments[2])) {
      // PUT /api/personas/{id}
      $this->personaController->update((int) $segments[2]);
    } else {
      $this->sendNotFound();
    }
  }

  private function handleDeleteRequest($segments)
  {
    if (count($segments) === 3 && is_numeric($segments[2])) {
      // DELETE /api/personas/{id}
      $this->personaController->destroy((int) $segments[2]);
    } else {
      $this->sendNotFound();
    }
  }

  private function sendNotFound()
  {
    http_response_code(404);
    header('Content-Type: application/json');
    echo json_encode([
      'success' => false,
      'message' => 'Ruta no encontrada'
    ]);
  }

  private function sendMethodNotAllowed()
  {
    http_response_code(405);
    header('Content-Type: application/json');
    echo json_encode([
      'success' => false,
      'message' => 'Método no permitido'
    ]);
  }
}
