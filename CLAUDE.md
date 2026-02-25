# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Symfony bundle (`consoneo/ecoffre-fort-bundle`) providing HTTP API integration with e-coffre-fort.fr, a secure digital archiving service. Supports two distinct APIs: standard Coffre (GET-based with encrypted auth) and TiersArchivage (POST-based third-party archiving).

## Commands

```bash
# Install dependencies
composer install

# Run all tests
./vendor/bin/phpunit -c phpunit.xml.dist

# Run only unit tests (no API credentials needed)
./vendor/bin/phpunit -c phpunit.xml.dist --filter 'MapTest'

# Run a single test file
./vendor/bin/phpunit -c phpunit.xml.dist Tests/CoffreTest.php

# Run a specific test method
./vendor/bin/phpunit -c phpunit.xml.dist --filter testPutFile
```

`CoffreTest` and `TiersArchivageTest` are integration tests that call the real e-coffre-fort.fr API. Copy `Tests/parameter.yml.dist` to `Tests/parameter.yml` and fill in credentials before running. `CoffreMapTest` and `TiersArchivageMapTest` are unit tests that run without credentials.

## Architecture

### Two API Wrappers sharing a base class

- **`ECoffreFort.php`** — Abstract base class. Holds `ManagerRegistry`, `EventDispatcher`, `LoggerInterface`. All subclasses dispatch events on every API call.
- **`Coffre.php`** — Standard e-coffre API (PUT/GET/DEL/CERT/MOVE). Uses cURL with multipart forms for upload, encrypted base64 auth for retrieval.
- **`TiersArchivage.php`** — Third-party archiving API (PUT/GET/CERT/LIST/DEL/GETPROP/SAFEGETPROP). All POST-based.

### Service Locator Pattern

`CoffreMap` and `TiersArchivageMap` are service locators populated at container build time by `ConsoneoEcoffreFortExtension`. Multiple coffre/archive instances are configured in YAML and accessed via `ecoffrefort.coffre_map->get('name')` or `ecoffrefort.tiers_archivage_map->get('name')`.

### Event-Driven Persistence

Every API operation dispatches a typed event (`PutEvent`, `GetEvent`, `DelEvent`, etc.) using the Symfony 7 dispatch signature: `dispatch($event, EventName)`. Events do not extend any base class. `CoffreSubscriber` listens to all events and:
1. Logs every operation to `LogQuery` entity
2. Creates/updates/deletes `Annuaire` (file registry) entries on PUT/MOVE/DEL

### Bundle Configuration

```yaml
consoneo_ecoffre_fort:
  coffres:
    coffre1:
      email_origin: ...
      safe_id: ...
      part_id: ...
      password: ...
  tiers_archivages:
    ta1:
      safe_room: ...
      safe_id: ...
      user_login: ...
      user_password: ...
```

### Key Directories

- `Admin/` — Sonata Admin classes extending `AbstractAdmin` (LogQuery, Annuaire)
- `Command/` — CLI commands using `#[AsCommand]` attribute (put, del, list), injecting `TiersArchivageMap`
- `DependencyInjection/` — Bundle extension and configuration tree (`TreeBuilder` with named root nodes)
- `Entity/` — Doctrine entities with PHP 8 attributes (`#[ORM\*]`, `#[Gedmo\*]`), typed properties
- `Event/` — Event classes dispatched by API wrappers (no parent class)
- `EventSubscriber/` — CoffreSubscriber using `EntityManagerInterface` and `Annuaire::class` for repository calls

### Autoloading

Uses PSR-4 with namespace `Consoneo\Bundle\EcoffreFortBundle`.

## Compatibility

Targets PHP >=8.4 and Symfony ^7.4 (`symfony/framework-bundle`). Uses Doctrine ORM ^2.14||^3.0, Gedmo ^3.13, PHPUnit ^11.0.

## Conventions

- Entities use PHP 8 attributes (not annotations) for Doctrine and Gedmo mappings
- Commands use `#[AsCommand]` attribute (not `$defaultName`)
- Sonata Admin classes extend `AbstractAdmin` with `configureDefaultSortValues()` and `: void` return types
- French strings containing apostrophes must use double quotes to avoid parse errors
- Event dispatch uses Symfony 7 signature: `$dispatcher->dispatch($event, EventName)`
- Services registered in `Resources/config/services.yml`, Sonata admins use tag attributes (`model_class`, `controller`)
