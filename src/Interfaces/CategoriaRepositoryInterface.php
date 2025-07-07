<?php

namespace App\Interfaces;

use App\Models\Categoria;

interface CategoriaRepositoryInterface
{
  public function findAll();
  public function findById($id);
  public function findName($name);
  public function create(Categoria $categoria);
  public function update($id, Categoria $categoria);
  public function delete($id);
}
