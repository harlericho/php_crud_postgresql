<?php

namespace App\Config;

use App\Config\DatabaseConnection;
use App\Repositories\PersonaRepository;
use App\Repositories\CategoriaRepository;
use App\Services\PersonaService;
use App\Services\CategoriaService;
use App\Interfaces\DatabaseConnectionInterface;
use App\Interfaces\PersonaRepositoryInterface;
use App\Interfaces\PersonaServiceInterface;
use App\Interfaces\CategoriaRepositoryInterface;
use App\Interfaces\CategoriaServiceInterface;
use Exception;

class ContainerException extends Exception {}

class Container
{
  private $services = [];

  public function __construct()
  {
    $this->registerServices();
  }

  private function registerServices()
  {
    // Database Connection
    $this->services[DatabaseConnectionInterface::class] = function () {
      return new DatabaseConnection();
    };

    // Persona Repository
    $this->services[PersonaRepositoryInterface::class] = function () {
      return new PersonaRepository($this->get(DatabaseConnectionInterface::class));
    };

    // Persona Service
    $this->services[PersonaServiceInterface::class] = function () {
      return new PersonaService($this->get(PersonaRepositoryInterface::class));
    };

    // Categoria Repository
    $this->services[CategoriaRepositoryInterface::class] = function () {
      return new CategoriaRepository($this->get(DatabaseConnectionInterface::class));
    };

    // Categoria Service
    $this->services[CategoriaServiceInterface::class] = function () {
      return new CategoriaService($this->get(CategoriaRepositoryInterface::class));
    };
  }

  public function get($serviceId)
  {
    if (!isset($this->services[$serviceId])) {
      throw new ContainerException("Servicio '{$serviceId}' no encontrado");
    }

    if (is_callable($this->services[$serviceId])) {
      $this->services[$serviceId] = $this->services[$serviceId]();
    }

    return $this->services[$serviceId];
  }
}
