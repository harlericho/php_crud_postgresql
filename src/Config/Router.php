<?php

namespace App\Config;

use App\Controllers\PersonaController;
use App\Controllers\CategoriaController;
use App\Interfaces\PersonaServiceInterface;
use App\Interfaces\CategoriaServiceInterface;

class Router
{
  private $personaController;
  private $categoriaController;

  public function __construct(PersonaServiceInterface $personaService, CategoriaServiceInterface $categoriaService)
  {
    $this->personaController = new PersonaController($personaService);
    $this->categoriaController = new CategoriaController($categoriaService);
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
    if (count($segments) < 2 || $segments[0] !== 'api') {
      $this->sendNotFound();
      return;
    }

    // Determinar qué controlador usar basado en el recurso
    $resource = $segments[1];

    switch ($resource) {
      case 'personas':
        $this->handlePersonasRoute($method, $segments);
        break;
      case 'categorias':
        $this->handleCategoriasRoute($method, $segments);
        break;
      default:
        $this->sendNotFound();
        break;
    }
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
    } elseif (count($segments) === 3 && !is_numeric($segments[2])) {
      // GET /api/personas/{nombre}
      $this->personaController->showByName($segments[2]);
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

  private function handleCategoriasRoute($method, $segments)
  {
    switch ($method) {
      case 'GET':
        $this->handleCategoriasGetRequest($segments);
        break;

      case 'POST':
        $this->handleCategoriasPostRequest($segments);
        break;

      case 'PUT':
        $this->handleCategoriasPutRequest($segments);
        break;

      case 'DELETE':
        $this->handleCategoriasDeleteRequest($segments);
        break;

      default:
        $this->sendMethodNotAllowed();
        break;
    }
  }

  private function handleCategoriasGetRequest($segments)
  {
    if (count($segments) === 2) {
      // GET /api/categorias
      $this->categoriaController->index();
    } elseif (count($segments) === 3 && is_numeric($segments[2])) {
      // GET /api/categorias/{id}
      $this->categoriaController->show((int) $segments[2]);
    } elseif (count($segments) === 3 && $segments[2] === 'activas') {
      // GET /api/categorias/activas
      $this->categoriaController->showActivas();
    } else {
      $this->sendNotFound();
    }
  }

  private function handleCategoriasPostRequest($segments)
  {
    if (count($segments) === 2) {
      // POST /api/categorias
      $this->categoriaController->store();
    } else {
      $this->sendNotFound();
    }
  }

  private function handleCategoriasPutRequest($segments)
  {
    if (count($segments) === 3 && is_numeric($segments[2])) {
      // PUT /api/categorias/{id}
      $this->categoriaController->update((int) $segments[2]);
    } else {
      $this->sendNotFound();
    }
  }

  private function handleCategoriasDeleteRequest($segments)
  {
    if (count($segments) === 3 && is_numeric($segments[2])) {
      // DELETE /api/categorias/{id}
      $this->categoriaController->destroy((int) $segments[2]);
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
