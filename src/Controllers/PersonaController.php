<?php

namespace App\Controllers;

use App\Interfaces\PersonaServiceInterface;
use InvalidArgumentException;
use PDOException;

class PersonaController
{
  private $personaService;
  private $messages;

  public function __construct(PersonaServiceInterface $personaService)
  {
    $this->personaService = $personaService;
    $this->messages = [
      'persona_not_found' => 'Persona no encontrada'
    ];
  }

  public function index()
  {
    try {
      $personas = $this->personaService->getAllPersonas();
      $this->sendJsonResponse([
        'success' => true,
        'data' => $personas,
        'message' => 'Personas obtenidas exitosamente'
      ]);
    } catch (PDOException $e) {
      $this->sendJsonResponse([
        'success' => false,
        'message' => 'Error al obtener personas',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function show($id)
  {
    try {
      $persona = $this->personaService->getPersonaById($id);

      if ($persona) {
        $this->sendJsonResponse([
          'success' => true,
          'data' => $persona,
          'message' => 'Persona encontrada'
        ]);
      } else {
        $this->sendJsonResponse([
          'success' => false,
          'message' => $this->messages['persona_not_found']
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
        'message' => 'Error al obtener persona',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function store()
  {
    try {
      $data = $this->getJsonInput();
      $persona = $this->personaService->createPersona($data);

      $this->sendJsonResponse([
        'success' => true,
        'data' => $persona,
        'message' => 'Persona creada exitosamente'
      ], 201);
    } catch (InvalidArgumentException $e) {
      $this->sendJsonResponse([
        'success' => false,
        'message' => $e->getMessage()
      ], 400);
    } catch (PDOException $e) {
      $this->sendJsonResponse([
        'success' => false,
        'message' => 'Error al crear persona',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function update($id)
  {
    try {
      $data = $this->getJsonInput();
      $persona = $this->personaService->updatePersona($id, $data);

      if ($persona) {
        $this->sendJsonResponse([
          'success' => true,
          'data' => $persona,
          'message' => 'Persona actualizada exitosamente'
        ]);
      } else {
        $this->sendJsonResponse([
          'success' => false,
          'message' => $this->messages['persona_not_found']
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
        'message' => 'Error al actualizar persona',
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function destroy($id)
  {
    try {
      $deleted = $this->personaService->deletePersona($id);

      if ($deleted) {
        $this->sendJsonResponse([
          'success' => true,
          'message' => 'Persona eliminada exitosamente'
        ]);
      } else {
        $this->sendJsonResponse([
          'success' => false,
          'message' => $this->messages['persona_not_found']
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
        'message' => 'Error al eliminar persona',
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
