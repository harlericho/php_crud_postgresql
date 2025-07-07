<?php

namespace App\Controllers;

use App\Interfaces\CategoriaServiceInterface;
use InvalidArgumentException;
use PDOException;

class CategoriaController
{
  private $categoriaService;
  private $messages;
  public function __construct(CategoriaServiceInterface $categoriaService)
  {
    $this->categoriaService = $categoriaService;
    $this->messages = [
      'categoria_not_found' => 'Categoria no encontrada'
    ];
  }
  public function index()
  {
    try {
      $categorias = $this->categoriaService->getAllCategorias();
      $this->sendJsonResponse([
        'success' => true,
        'data' => $categorias,
        'message' => 'Categorias obtenidas exitosamente'
      ]);
    } catch (PDOException $e) {
      $this->sendJsonResponse([
        'success' => false,
        'message' => 'Error al obtener categorias',
        'error' => $e->getMessage()
      ], 500);
    }
  }
  public function show($id)
  {
    try {
      $categoria = $this->categoriaService->getCategoriaById($id);

      if ($categoria) {
        $this->sendJsonResponse([
          'success' => true,
          'data' => $categoria,
          'message' => 'Categoria encontrada'
        ]);
      } else {
        $this->sendJsonResponse([
          'success' => false,
          'message' => $this->messages['categoria_not_found']
        ], 404);
      }
    } catch (InvalidArgumentException $e) {
      $this->sendJsonResponse([
        'success' => false,
        'message' => $e->getMessage()
      ], 400);
    }
  }
  public function store()
  {
    try {
      $data = $this->getJsonInput();
      $categoria = $this->categoriaService->createCategoria($data);
      $this->sendJsonResponse([
        'success' => true,
        'data' => $categoria,
        'message' => 'Categoria creada exitosamente'
      ], 201);
    } catch (InvalidArgumentException $e) {
      $this->sendJsonResponse([
        'success' => false,
        'message' => $e->getMessage()
      ], 400);
    } catch (PDOException $e) {
      $this->sendJsonResponse([
        'success' => false,
        'message' => 'Error al crear categoria',
        'error' => $e->getMessage()
      ], 500);
    }
  }
  public function update($id)
  {
    try {
      $data = $this->getJsonInput();
      $categoria = $this->categoriaService->updateCategoria($id, $data);

      if ($categoria) {
        $this->sendJsonResponse([
          'success' => true,
          'data' => $categoria,
          'message' => 'Categoria actualizada exitosamente'
        ]);
      } else {
        $this->sendJsonResponse([
          'success' => false,
          'message' => $this->messages['categoria_not_found']
        ], 404);
      }
    } catch (InvalidArgumentException $e) {
      $this->sendJsonResponse([
        'success' => false,
        'message' => $e->getMessage()
      ], 400);
    } catch (PDOException $e) {
      $this->sendJsonResponse([
        'success' => false,
        'message' => 'Error al actualizar categoria',
        'error' => $e->getMessage()
      ], 500);
    }
  }
  public function destroy($id)
  {
    try {
      $deleted = $this->categoriaService->deleteCategoria($id);

      if ($deleted) {
        $this->sendJsonResponse([
          'success' => true,
          'message' => 'Categoria eliminada exitosamente'
        ]);
      } else {
        $this->sendJsonResponse([
          'success' => false,
          'message' => $this->messages['categoria_not_found']
        ], 404);
      }
    } catch (PDOException $e) {
      $this->sendJsonResponse([
        'success' => false,
        'message' => 'Error al eliminar categoria',
        'error' => $e->getMessage()
      ], 500);
    }
  }
  public function showActivas()
  {
    try {
      $categorias = $this->categoriaService->getCategoriasActivas();
      $this->sendJsonResponse([
        'success' => true,
        'data' => $categorias,
        'message' => 'Categorías activas obtenidas exitosamente'
      ]);
    } catch (PDOException $e) {
      $this->sendJsonResponse([
        'success' => false,
        'message' => 'Error al obtener categorías activas',
        'error' => $e->getMessage()
      ], 500);
    }
  }
  private function getJsonInput()
  {
    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new InvalidArgumentException('JSON inválido');
    }

    return $data ?? [];
  }

  private function sendJsonResponse($data, $statusCode = 200)
  {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data, JSON_PRETTY_PRINT);
  }
}
