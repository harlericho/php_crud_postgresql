<?php

namespace App\Interfaces;

interface PersonaServiceInterface
{
  public function getAllPersonas();
  public function getPersonaById($id);
  public function createPersona($data);
  public function updatePersona($id, $data);
  public function deletePersona($id);
}
