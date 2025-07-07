<?php

namespace App\Models;


class Categoria
{
  private $id;
  private $nombre;
  private $descripcion;
  private $activo;

  public function __construct(
    $nombre,
    $descripcion,
    $activo,
    $id = null
  ) {
    $this->id = $id;
    $this->nombre = $nombre;
    $this->descripcion = $descripcion;
    $this->activo = $activo;
  }

  // Getters
  public function getId()
  {
    return $this->id;
  }
  public function getNombre()
  {
    return $this->nombre;
  }

  public function getDescripcion()
  {
    return $this->descripcion;
  }
  public function getActivo()
  {
    return $this->activo;
  }

  // Setters
  public function setId($id)
  {
    $this->id = $id;
  }

  public function setNombre($nombre)
  {
    $this->nombre = $nombre;
  }

  public function setDescripcion($descripcion)
  {
    $this->descripcion = $descripcion;
  }
  public function setActivo($activo)
  {
    $this->activo = $activo;
  }
  // Método para convertir a array
  public function toArray()
  {
    return [
      'id' => $this->id,
      'nombre' => $this->nombre,
      'descripcion' => $this->descripcion,
      'activo' => $this->activo,
    ];
  }
  // Método estático para crear desde array
  public static function fromArray($data)
  {
    return new self(
      $data['nombre'],
      $data['descripcion'],
      $data['activo'],
      $data['id'] ?? null
    );
  }
}
