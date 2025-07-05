<?php

namespace App\Repositories;

use App\Interfaces\PersonaRepositoryInterface;
use App\Interfaces\DatabaseConnectionInterface;
use App\Models\Persona;
use PDO;
use PDOException;

class PersonaRepository implements PersonaRepositoryInterface
{
  private $connection;

  public function __construct(DatabaseConnectionInterface $databaseConnection)
  {
    $this->connection = $databaseConnection->getConnection();
  }

  public function findAll()
  {
    try {
      $sql = "SELECT * FROM personas ORDER BY id ASC";
      $stmt = $this->connection->prepare($sql);
      $stmt->execute();

      $personas = [];
      while ($row = $stmt->fetch()) {
        $personas[] = Persona::fromArray($row);
      }

      return $personas;
    } catch (PDOException $e) {
      throw new PDOException("Error al obtener personas: " . $e->getMessage());
    }
  }

  public function findById($id)
  {
    try {
      $sql = "SELECT * FROM personas WHERE id = :id";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();

      $row = $stmt->fetch();

      return $row ? Persona::fromArray($row) : null;
    } catch (PDOException $e) {
      throw new PDOException("Error al obtener persona: " . $e->getMessage());
    }
  }
  public function findName($name)
  {
    try {
      $sql = "SELECT * FROM personas WHERE nombre ILIKE :nombre ORDER BY id ASC";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindValue(':nombre', '%' . $name . '%', PDO::PARAM_STR);
      $stmt->execute();

      $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

      $personas = [];
      foreach ($rows as $row) {
        $personas[] = Persona::fromArray($row);  // Esto crea múltiples objetos Persona
      }

      return $personas;
    } catch (PDOException $e) {
      throw new PDOException("Error al buscar persona por nombre: " . $e->getMessage());
    }
  }

  public function create(Persona $persona)
  {
    try {
      $sql = "INSERT INTO personas (nombre, apellido, email, edad)
                    VALUES (:nombre, :apellido, :email, :edad)
                    RETURNING id";

      $stmt = $this->connection->prepare($sql);
      $stmt->bindValue(':nombre', $persona->getNombre());
      $stmt->bindValue(':apellido', $persona->getApellido());
      $stmt->bindValue(':email', $persona->getEmail());
      $stmt->bindValue(':edad', $persona->getEdad(), PDO::PARAM_INT);

      $stmt->execute();
      $id = $stmt->fetchColumn();

      $persona->setId($id);

      return $persona;
    } catch (PDOException $e) {
      throw new PDOException("Error al crear persona: " . $e->getMessage());
    }
  }

  public function update($id, Persona $persona)
  {
    try {
      $sql = "UPDATE personas
                    SET nombre = :nombre, apellido = :apellido, email = :email, edad = :edad
                    WHERE id = :id";

      $stmt = $this->connection->prepare($sql);
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->bindValue(':nombre', $persona->getNombre());
      $stmt->bindValue(':apellido', $persona->getApellido());
      $stmt->bindValue(':email', $persona->getEmail());
      $stmt->bindValue(':edad', $persona->getEdad(), PDO::PARAM_INT);

      $stmt->execute();

      if ($stmt->rowCount() > 0) {
        $persona->setId($id);
        return $persona;
      }

      return null;
    } catch (PDOException $e) {
      throw new PDOException("Error al actualizar persona: " . $e->getMessage());
    }
  }

  public function delete($id)
  {
    try {
      $sql = "DELETE FROM personas WHERE id = :id";
      $stmt = $this->connection->prepare($sql);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();

      return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
      throw new PDOException("Error al eliminar persona: " . $e->getMessage());
    }
  }
}
