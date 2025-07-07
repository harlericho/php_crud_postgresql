<?php

namespace App\Interfaces;

interface CategoriaServiceInterface
{
  public function getAllCategorias();
  public function getCategoriaById($id);
  public function createCategoria($data);
  public function updateCategoria($id, $data);
  public function deleteCategoria($id);
  public function getCategoriasActivas();
}
