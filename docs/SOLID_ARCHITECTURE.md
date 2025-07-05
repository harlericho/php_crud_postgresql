# Arquitectura SOLID

Este proyecto implementa los principios SOLID para mantener un código limpio, mantenible y extensible.

## Principios SOLID Implementados

### 1. Single Responsibility Principle (SRP)

Cada clase tiene una única responsabilidad:

- **Persona**: Modelo de datos con atributos y comportamientos básicos
- **PersonaRepository**: Acceso a datos de la tabla personas
- **PersonaService**: Lógica de negocio para operaciones de personas
- **PersonaController**: Manejo de requests HTTP y responses
- **DatabaseConnection**: Conexión a la base de datos
- **Router**: Enrutamiento de requests
- **Container**: Inyección de dependencias

### 2. Open/Closed Principle (OCP)

Las clases están abiertas para extensión pero cerradas para modificación:

- Uso de interfaces que permiten implementaciones alternativas
- Nuevos repositorios pueden implementar `PersonaRepositoryInterface`
- Nuevos servicios pueden implementar `PersonaServiceInterface`

### 3. Liskov Substitution Principle (LSP)

Las implementaciones pueden sustituir a sus interfaces:

- `PersonaRepository` puede sustituir a `PersonaRepositoryInterface`
- `PersonaService` puede sustituir a `PersonaServiceInterface`
- `DatabaseConnection` puede sustituir a `DatabaseConnectionInterface`

### 4. Interface Segregation Principle (ISP)

Interfaces específicas y cohesivas:

- `DatabaseConnectionInterface`: Solo manejo de conexión
- `PersonaRepositoryInterface`: Solo operaciones de persistencia
- `PersonaServiceInterface`: Solo lógica de negocio

### 5. Dependency Inversion Principle (DIP)

Dependencias de abstracciones, no de concreciones:

- `PersonaController` depende de `PersonaServiceInterface`
- `PersonaService` depende de `PersonaRepositoryInterface`
- `PersonaRepository` depende de `DatabaseConnectionInterface`

## Estructura de Capas

```
┌─────────────────────┐
│    Presentation     │ ← PersonaController
│      (API Layer)    │
└─────────────────────┘
           │
┌─────────────────────┐
│     Business        │ ← PersonaService
│   (Service Layer)   │
└─────────────────────┘
           │
┌─────────────────────┐
│   Data Access       │ ← PersonaRepository
│ (Repository Layer)  │
└─────────────────────┘
           │
┌─────────────────────┐
│     Database        │ ← PostgreSQL
│   (Persistence)     │
└─────────────────────┘
```

## Beneficios de esta Arquitectura

1. **Mantenibilidad**: Cambios en una capa no afectan otras capas
2. **Testabilidad**: Fácil mockeo de dependencias para testing
3. **Escalabilidad**: Nuevas funcionalidades se pueden agregar fácilmente
4. **Flexibilidad**: Cambio de base de datos o framework sin afectar lógica de negocio
5. **Reutilización**: Componentes pueden reutilizarse en otros contextos

## Extensiones Posibles

- Implementar cache con `PersonaCacheRepository`
- Agregar logging con decoradores
- Implementar autenticación/autorización
- Agregar validaciones más complejas
- Implementar eventos y listeners
