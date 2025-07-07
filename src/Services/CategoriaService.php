<?php

namespace App\Services;

use App\Interfaces\CategoriaServiceInterface;
use App\Interfaces\CategoriaRepositoryInterface;
use App\Models\Categoria;
use InvalidArgumentException;

class CategoriaService implements CategoriaServiceInterface
{
  private $categoriaRepository;

  public function __construct(CategoriaRepositoryInterface $categoriaRepository)
  {
    $this->categoriaRepository = $categoriaRepository;
  }

  public function getAllCategorias()
  {
    $categorias = $this->categoriaRepository->findAll();

    return array_map(function (Categoria $categoria) {
      return $categoria->toArray();
    }, $categorias);
  }

  public function getCategoriaById($id)
  {
    $this->validateId($id);

    $categoria = $this->categoriaRepository->findById($id);

    if (!$categoria) {
      throw new InvalidArgumentException("Categoría con ID {$id} no encontrada");
    }

    return $categoria->toArray();
  }

  public function createCategoria($data)
  {
    $this->validateCategoriaData($data);

    $categoria = new Categoria(
      $data['nombre'],
      $data['descripcion'] ?? null,
      $data['activo'] ?? true,
      null
    );

    $createdCategoria = $this->categoriaRepository->create($categoria);

    return $createdCategoria->toArray();
  }

  public function updateCategoria($id, $data)
  {
    $this->validateId($id);
    $this->validateCategoriaData($data, false);

    $existingCategoria = $this->categoriaRepository->findById($id);

    if (!$existingCategoria) {
      throw new InvalidArgumentException("Categoría con ID {$id} no encontrada");
    }

    // Actualizar solo los campos proporcionados
    $updatedCategoria = new Categoria(
      $data['nombre'] ?? $existingCategoria->getNombre(),
      $data['descripcion'] ?? $existingCategoria->getDescripcion(),
      $data['activo'] ?? $existingCategoria->getActivo(),
      $id
    );

    $result = $this->categoriaRepository->update($id, $updatedCategoria);

    return $result->toArray();
  }

  public function deleteCategoria($id)
  {
    $this->validateId($id);

    $categoria = $this->categoriaRepository->findById($id);

    if (!$categoria) {
      throw new InvalidArgumentException("Categoría con ID {$id} no encontrada");
    }

    return $this->categoriaRepository->delete($id);
  }

  public function getCategoriasActivas()
  {
    // Implementación simple usando findAll y filtrado
    $categorias = $this->categoriaRepository->findAll();

    $categoriasActivas = array_filter($categorias, function (Categoria $categoria) {
      return $categoria->getActivo();
    });

    return array_map(function (Categoria $categoria) {
      return $categoria->toArray();
    }, $categoriasActivas);
  }

  private function validateId($id)
  {
    if (!is_numeric($id) || $id <= 0) {
      throw new InvalidArgumentException('ID debe ser un número positivo');
    }
  }

  private function validateCategoriaData($data, $required = true)
  {
    if ($required && empty($data['nombre'])) {
      throw new InvalidArgumentException('El nombre es requerido');
    }

    if (isset($data['nombre'])) {
      if (!is_string($data['nombre']) || strlen(trim($data['nombre'])) === 0) {
        throw new InvalidArgumentException('El nombre debe ser una cadena no vacía');
      }

      if (strlen($data['nombre']) > 100) {
        throw new InvalidArgumentException('El nombre no puede exceder 100 caracteres');
      }
    }

    if (isset($data['descripcion']) && !is_string($data['descripcion']) && !is_null($data['descripcion'])) {
      throw new InvalidArgumentException('La descripción debe ser una cadena o null');
    }

    if (isset($data['activo']) && !is_bool($data['activo'])) {
      throw new InvalidArgumentException('El campo activo debe ser booleano');
    }
  }
}
