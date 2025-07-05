<?php

namespace App\Config;

use App\Config\DatabaseConnection;
use App\Repositories\PersonaRepository;
use App\Services\PersonaService;
use App\Interfaces\DatabaseConnectionInterface;
use App\Interfaces\PersonaRepositoryInterface;
use App\Interfaces\PersonaServiceInterface;
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

    // Repository
    $this->services[PersonaRepositoryInterface::class] = function () {
      return new PersonaRepository($this->get(DatabaseConnectionInterface::class));
    };

    // Service
    $this->services[PersonaServiceInterface::class] = function () {
      return new PersonaService($this->get(PersonaRepositoryInterface::class));
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
