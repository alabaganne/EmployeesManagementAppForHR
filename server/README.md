# Laravel Backend API

RESTful API for the HR Management System built with Laravel 7.

## Requirements

- PHP >= 7.2.5
- Composer
- MySQL

## Tech Stack

- **Laravel 7** - PHP framework
- **JWT Auth** - Token authentication
- **Spatie Permissions** - Role-based access control
- **MySQL** - Database
- **L5-Swagger** - API documentation

## Installation

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan jwt:secret

# Configure database in .env
php artisan migrate --seed
php artisan serve
```

## Environment Variables

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

JWT_SECRET=your-jwt-secret
```

## Main API Endpoints

### Authentication
- `POST /api/auth/login`
- `POST /api/auth/logout`
- `GET /api/auth/me`

### Employees
- `POST /api/collaborators` - List (paginated)
- `GET /api/collaborators/{id}` - Show
- `POST /api/collaborators/create` - Create
- `PUT /api/collaborators/{id}` - Update
- `DELETE /api/collaborators/{id}` - Delete

### Employee Resources
- `/api/collaborators/{id}/leaves`
- `/api/collaborators/{id}/skills`
- `/api/collaborators/{id}/trainings`
- `/api/collaborators/{id}/evaluations`

### Other
- `/api/departments`
- `/api/collaborators/gender` - Statistics
- `/api/collaborators/department` - Statistics

## Authentication

Use JWT Bearer token in headers:
```
Authorization: Bearer {token}
```

## Roles & Permissions

- **Admin**: Full access
- **HR**: Manage collaborators
- **Project Manager**: Limited access

## Testing

```bash
php artisan test
```

## API Documentation

Swagger docs available at: `http://localhost:8000/api/documentation`