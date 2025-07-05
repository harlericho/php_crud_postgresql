<?php

namespace App\Interfaces;

use App\Models\Persona;

interface PersonaRepositoryInterface
{
  public function findAll();
  public function findById($id);
  public function create(Persona $persona);
  public function update($id, Persona $persona);
  public function delete($id);
}
