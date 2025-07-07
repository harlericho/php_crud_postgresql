<?php

namespace App\Repositories;

use App\Interfaces\CategoriaRepositoryInterface;
use App\Interfaces\DatabaseConnectionInterface;
use App\Models\Categoria;
use PDO;
use PDOException;
use PhpParser\Node\Stmt\TryCatch;

class CategoriaRepository implements CategoriaRepositoryInterface
{
  private $connection;

  public function __construct(DatabaseConnectionInterface $databaseConnection)
  {
    $this->connection = $databaseConnection->getConnection();
  }

  public function findAll()
  {
    try {
      $sql = "SELECT * FROM categorias ORDER BY id ASC";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();

      $categorias = [];
      while ($row = $stmt->fetch()) {
        $categorias[] = Categoria::fromArray($row);
      }

      return $categorias;
    } catch (PDOException $e) {
      throw new PDOException("Error al obtener categorias: " . $e->getMessage());
    }
  }

  public function findById($id)
  {
    try {
      $sql = "SELECT * FROM categorias WHERE id = :id";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();

      $row = $stmt->fetch();

      return $row ? Categoria::fromArray($row) : null;
    } catch (PDOException $e) {
      throw new PDOException("Error al obtener categoria: " . $e->getMessage());
    }
  }

  public function findName($name)
  {
    // Implementation
  }

  public function create(Categoria $categoria)
  {
    try {
      $sql = "INSERT INTO categorias (nombre, descripcion, activo) VALUES (:nombre, :descripcion, :activo)";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':nombre', $categoria->getNombre(), PDO::PARAM_STR);
      $stmt->bindParam(':descripcion', $categoria->getDescripcion(), PDO::PARAM_STR);
      $stmt->bindParam(':activo', $categoria->getActivo(), PDO::PARAM_BOOL);
      $stmt->execute();

      $categoria->setId($this->connection->lastInsertId());
      return $categoria;
    } catch (PDOException $e) {
      throw new PDOException("Error al crear categoria: " . $e->getMessage());
    }
  }

  public function update($id, Categoria $categoria)
  {
    try {
      $sql = "UPDATE categorias SET nombre = :nombre, descripcion = :descripcion, activo = :activo WHERE id = :id";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':nombre', $categoria->getNombre(), PDO::PARAM_STR);
      $stmt->bindParam(':descripcion', $categoria->getDescripcion(), PDO::PARAM_STR);
      $stmt->bindParam(':activo', $categoria->getActivo(), PDO::PARAM_BOOL);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();

      return $categoria;
    } catch (PDOException $e) {
      throw new PDOException("Error al actualizar categoria: " . $e->getMessage());
    }
  }

  public function delete($id)
  {
    try {
      $sql = "DELETE FROM categorias WHERE id = :id";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();

      return true;
    } catch (PDOException $e) {
      throw new PDOException("Error al eliminar categoria: " . $e->getMessage());
    }
  }
}
