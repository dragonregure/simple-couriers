# Simple Couriers API

API-only Laravel project for courier master data.

## Stack

- Laravel 13 and PHP 8.4
- Modular monolith Courier module
- MySQL, phpMyAdmin, Docker, Xdebug
- Swagger UI at `http://localhost:8000/api/documentation`
- OpenAPI YAML at `http://localhost:8000/api/docs`
- PHPStan/Larastan and PHPCS

## Run With Docker

```bash
docker compose up --build
docker compose exec backend php artisan migrate
```

API base URL: `http://localhost:8000/api/v1`

phpMyAdmin: `http://localhost:8080`

## Useful Commands

```bash
composer test
composer analyse
composer lint
```

## Courier Endpoints

- `GET /api/v1/couriers`
- `POST /api/v1/couriers`
- `GET /api/v1/couriers/{courier}`
- `PUT /api/v1/couriers/{courier}`
- `DELETE /api/v1/couriers/{courier}`

Index examples:

- `GET /api/v1/couriers?search=budi+agung`
- `GET /api/v1/couriers?level=2,3`
- `GET /api/v1/couriers?sort=registered_at&direction=desc`
