# User Service

This is the authentication and user management microservice for the ERP system. It handles user registration, login, organization switching, role-based permissions, and other related features.

---

## 🚀 Features

- User registration and login
- Role-based access control (RBAC)
- Organization switching
- JWT/Token-based authentication
- Laravel Passport support
- Multi-tenant ready (via organization_id)
- RESTful API

---

## 📦 Tech Stack

- PHP 8.2+
- Laravel 11
- Laravel Passport
- MySQL / MariaDB
- Docker (optional)
- Redis (for caching or queues)

---

## 🛠️ Setup Instructions

### 1. Clone the repository

   ```bash
   git clone https://github.com/TonRichards/user_service.git
   cd user_service
   ```

### 2. Install PHP dependencies.
   ```bash
   composer install
   ```
### 3. Copy the example environment file and generate the application key.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
### 4. Adjust database connection settings in `.env` and run migrations.
   ```bash
   php artisan migrate
   ```
###  5. Seed the neccessary data
   ```bash
   php artisan db:seed
   ```
