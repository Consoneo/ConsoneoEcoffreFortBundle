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

# Run a single test
./vendor/bin/phpunit -c phpunit.xml.dist Tests/CoffreTest.php

# Run a specific test method
./vendor/bin/phpunit -c phpunit.xml.dist --filter testPutFile
```

Tests are integration tests that call the real e-coffre-fort.fr API. Copy `Tests/parameter.yml.dist` to `Tests/parameter.yml` and fill in credentials before running.

## Architecture

### Two API Wrappers sharing a base class

- **`ECoffreFort.php`** — Abstract base class. Holds Doctrine, EventDispatcher, Logger. All subclasses dispatch events on every API call.
- **`Coffre.php`** — Standard e-coffre API (PUT/GET/DEL/CERT/MOVE). Uses cURL with multipart forms for upload, encrypted base64 auth for retrieval.
- **`TiersArchivage.php`** — Third-party archiving API (PUT/GET/CERT/LIST/DEL/GETPROP/SAFEGETPROP). All POST-based.

### Service Locator Pattern

`CoffreMap` and `TiersArchivageMap` are service locators populated at container build time by `ConsoneoEcoffreFortExtension`. Multiple coffre/archive instances are configured in YAML and accessed via `ecoffrefort.coffre_map->get('name')` or `ecoffrefort.tiers_archivage_map->get('name')`.

### Event-Driven Persistence

Every API operation dispatches a typed event (`PutEvent`, `GetEvent`, `DelEvent`, etc.). `CoffreSubscriber` listens to all events and:
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

- `Admin/` — Sonata Admin classes (LogQuery, Annuaire)
- `Command/` — CLI commands (put, del, list)
- `DependencyInjection/` — Bundle extension and configuration tree
- `Entity/` — Doctrine entities (LogQuery stores API logs, Annuaire stores file registry)
- `Event/` — Event classes dispatched by API wrappers
- `EventSubscriber/` — CoffreSubscriber handles persistence

### Autoloading

Uses PSR-0 with namespace `Consoneo\Bundle\EcoffreFortBundle` and `target-dir` in composer.json.

## Compatibility

Currently targets PHP >=5.4.1 and Symfony ~2.3||^3.0||^4.4. Services are marked `public: true` for Symfony 4+ compatibility.
