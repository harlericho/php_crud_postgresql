<?php

namespace App\Services;

use App\Interfaces\PersonaServiceInterface;
use App\Interfaces\PersonaRepositoryInterface;
use App\Models\Persona;
use InvalidArgumentException;

class PersonaService implements PersonaServiceInterface
{
  private $personaRepository;

  public function __construct(PersonaRepositoryInterface $personaRepository)
  {
    $this->personaRepository = $personaRepository;
  }

  public function getAllPersonas()
  {
    $personas = $this->personaRepository->findAll();

    return array_map(function (Persona $persona) {
      return $persona->toArray();
    }, $personas);
  }

  public function getPersonaById($id)
  {
    $this->validateId($id);

    $persona = $this->personaRepository->findById($id);

    return $persona ? $persona->toArray() : null;
  }

  public function createPersona($data)
  {
    $this->validatePersonaData($data);

    $persona = new Persona(
      $data['nombre'],
      $data['apellido'],
      $data['email'],
      $data['edad']
    );

    $createdPersona = $this->personaRepository->create($persona);

    return $createdPersona->toArray();
  }

  public function updatePersona($id, $data)
  {
    $this->validateId($id);
    $this->validatePersonaData($data, false);

    // Verificar si la persona existe
    $existingPersona = $this->personaRepository->findById($id);
    if (!$existingPersona) {
      return null;
    }

    // Actualizar solo los campos proporcionados
    $updatedPersona = new Persona(
      $data['nombre'] ?? $existingPersona->getNombre(),
      $data['apellido'] ?? $existingPersona->getApellido(),
      $data['email'] ?? $existingPersona->getEmail(),
      $data['edad'] ?? $existingPersona->getEdad()
    );

    $result = $this->personaRepository->update($id, $updatedPersona);

    return $result ? $result->toArray() : null;
  }

  public function deletePersona($id)
  {
    $this->validateId($id);

    return $this->personaRepository->delete($id);
  }

  private function validateId($id)
  {
    if (!is_numeric($id) || $id <= 0) {
      throw new InvalidArgumentException("El ID debe ser un número positivo");
    }
  }

  private function validatePersonaData($data, $requireAll = true)
  {
    if (!is_array($data)) {
      throw new InvalidArgumentException("Los datos deben ser un array válido");
    }

    $requiredFields = ['nombre', 'apellido', 'email', 'edad'];

    foreach ($requiredFields as $field) {
      if ($requireAll && !isset($data[$field])) {
        throw new InvalidArgumentException("El campo '{$field}' es requerido");
      }

      if (isset($data[$field])) {
        $this->validateField($field, $data[$field]);
      }
    }
  }

  private function validateField($field, $value)
  {
    switch ($field) {
      case 'nombre':
      case 'apellido':
        if (empty(trim($value)) || !is_string($value)) {
          throw new InvalidArgumentException("El campo '{$field}' debe ser un texto válido");
        }
        if (strlen($value) > 100) {
          throw new InvalidArgumentException("El campo '{$field}' no puede exceder 100 caracteres");
        }
        break;

      case 'email':
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
          throw new InvalidArgumentException("El email debe tener un formato válido");
        }
        break;

      case 'edad':
        if (!is_numeric($value) || $value < 0 || $value > 150) {
          throw new InvalidArgumentException("La edad debe ser un número entre 0 y 150");
        }
        break;
    }
  }
}
