# User Service

User Service provides user authentication and management APIs. It is built with Laravel and acts as a standalone service for handling users, roles and organizations.

## Installation

1. Install PHP dependencies.
   ```bash
   composer install
   ```
2. Copy the example environment file and generate the application key.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
3. Adjust database connection settings in `.env` and run migrations.
   ```bash
   php artisan migrate
   ```
4. Seed the neccessary data
   ```bash
   php artisan db:seed
   ```
