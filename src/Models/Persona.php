<?php

namespace App\Models;

class Persona
{
  private $id;
  private $nombre;
  private $apellido;
  private $email;
  private $edad;

  public function __construct(
    $nombre,
    $apellido,
    $email,
    $edad,
    $id = null
  ) {
    $this->id = $id;
    $this->nombre = $nombre;
    $this->apellido = $apellido;
    $this->email = $email;
    $this->edad = $edad;
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

  public function getApellido()
  {
    return $this->apellido;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function getEdad()
  {
    return $this->edad;
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

  public function setApellido($apellido)
  {
    $this->apellido = $apellido;
  }

  public function setEmail($email)
  {
    $this->email = $email;
  }

  public function setEdad($edad)
  {
    $this->edad = $edad;
  }

  // Método para convertir a array
  public function toArray()
  {
    return [
      'id' => $this->id,
      'nombre' => $this->nombre,
      'apellido' => $this->apellido,
      'email' => $this->email,
      'edad' => $this->edad
    ];
  }

  // Método estático para crear desde array
  public static function fromArray($data)
  {
    return new self(
      $data['nombre'],
      $data['apellido'],
      $data['email'],
      $data['edad'],
      $data['id'] ?? null
    );
  }
}
