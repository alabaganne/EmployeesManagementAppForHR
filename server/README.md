# HR Management System - Laravel Backend API

A robust RESTful API built with Laravel 7 that serves as the backend for the Employee Management System. This API provides comprehensive endpoints for managing employees, departments, skills, training, evaluations, and leave management with JWT authentication and role-based access control.

## Table of Contents
- [Features](#features)
- [Technical Stack](#technical-stack)
- [API Architecture](#api-architecture)
- [Installation](#installation)
- [Configuration](#configuration)
- [API Endpoints](#api-endpoints)
- [Authentication](#authentication)
- [Database Structure](#database-structure)
- [Testing](#testing)
- [Deployment](#deployment)

## Features

### Core API Capabilities
- **JWT Authentication**: Secure token-based authentication system
- **Role-Based Access Control**: Granular permissions using Spatie Laravel Permission
- **Employee CRUD Operations**: Complete employee lifecycle management
- **Department Management**: Organizational structure management
- **Skills & Training Tracking**: Employee development monitoring
- **Leave Management**: Leave request and approval system
- **Performance Evaluations**: Employee assessment tracking
- **Soft Deletes**: Archive functionality with restoration capability
- **API Documentation**: Auto-generated Swagger/OpenAPI documentation

### Security Features
- JWT token authentication with refresh capability
- Role and permission-based authorization
- Request validation and sanitization
- CORS configuration for cross-origin requests
- Password hashing using bcrypt
- API rate limiting

## Technical Stack

- **Framework**: Laravel 7.24
- **PHP Version**: 7.2.5 or higher
- **Database**: MySQL (configurable)
- **Authentication**: tymon/jwt-auth 1.0
- **Permissions**: spatie/laravel-permission 3.16
- **API Documentation**: darkaonline/l5-swagger 8.0
- **CORS Support**: fruitcake/laravel-cors 2.0

## API Architecture

### Directory Structure
```
server/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php
│   │   │   ├── Collaborators/
│   │   │   │   ├── CollaboratorController.php
│   │   │   │   ├── EvaluationController.php
│   │   │   │   ├── LeaveController.php
│   │   │   │   ├── SkillController.php
│   │   │   │   └── TrainingController.php
│   │   │   ├── DepartmentController.php
│   │   │   └── UserController.php
│   │   ├── Middleware/
│   │   ├── Requests/
│   │   └── Resources/
│   ├── Models/
│   ├── Policies/
│   └── Providers/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeds/
├── routes/
└── storage/
```

### Design Patterns
- **MVC Architecture**: Clean separation of concerns
- **Repository Pattern**: Database abstraction (where applicable)
- **Resource Transformation**: Consistent API responses
- **Request Validation**: Dedicated form request classes
- **Policy Authorization**: Fine-grained access control

## Installation

1. **Clone and navigate to server directory**:
```bash
cd server
```

2. **Install dependencies**:
```bash
composer install
```

3. **Environment configuration**:
```bash
cp .env.example .env
```

4. **Generate application key**:
```bash
php artisan key:generate
```

5. **Generate JWT secret**:
```bash
php artisan jwt:secret
```

6. **Configure database** in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hr_management
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. **Run migrations**:
```bash
php artisan migrate
```

8. **Seed initial data**:
```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

9. **Generate API documentation**:
```bash
php artisan l5-swagger:generate
```

10. **Start development server**:
```bash
php artisan serve
```

## Configuration

### JWT Configuration
Configure JWT settings in `config/jwt.php`:
- Token TTL (time to live)
- Refresh TTL
- Blacklist settings
- Algorithm selection

### CORS Configuration
Configure CORS in `config/cors.php`:
- Allowed origins
- Allowed methods
- Allowed headers
- Max age

### Permission Configuration
Permissions are defined in `database/seeds/RolesAndPermissionsSeeder.php`:
- `view collaborators`
- `add collaborators`
- `edit collaborators`
- `delete collaborators`
- `manage accounts`

## API Endpoints

### Authentication
```
POST   /api/auth/login         - User login
POST   /api/auth/logout        - User logout
POST   /api/auth/refresh       - Refresh JWT token
GET    /api/auth/me           - Get authenticated user
```

### Employee Management
```
POST   /api/collaborators                  - List employees (paginated, searchable)
GET    /api/collaborators/{id}             - Get employee details
POST   /api/collaborators/create           - Create new employee
PUT    /api/collaborators/{id}             - Update employee
DELETE /api/collaborators/{id}             - Soft delete employee
GET    /api/collaborators/{id}/restore     - Restore deleted employee
DELETE /api/collaborators/{id}/delete-permanently - Hard delete
POST   /api/collaborators/archive          - List archived employees
```

### Statistics
```
GET    /api/collaborators/gender           - Employee count by gender
GET    /api/collaborators/department       - Employee count by department
```

### Employee Resources
```
# Leaves
GET    /api/collaborators/{id}/leaves      - List employee leaves
POST   /api/collaborators/{id}/leaves      - Create leave request
PUT    /api/collaborators/{id}/leaves/{leaveId} - Update leave
DELETE /api/collaborators/{id}/leaves/{leaveId} - Delete leave

# Skills
GET    /api/collaborators/{id}/skills      - List employee skills
POST   /api/collaborators/{id}/skills      - Add skill
PUT    /api/collaborators/{id}/skills/{skillId} - Update skill
DELETE /api/collaborators/{id}/skills/{skillId} - Remove skill

# Training
GET    /api/collaborators/{id}/trainings   - List trainings
POST   /api/collaborators/{id}/trainings   - Add training
PUT    /api/collaborators/{id}/trainings/{trainingId} - Update
DELETE /api/collaborators/{id}/trainings/{trainingId} - Delete

# Evaluations
GET    /api/collaborators/{id}/evaluations - List evaluations
POST   /api/collaborators/{id}/evaluations - Create evaluation
PUT    /api/collaborators/{id}/evaluations/{evalId} - Update
DELETE /api/collaborators/{id}/evaluations/{evalId} - Delete
```

### Department Management
```
GET    /api/departments                    - List all departments
POST   /api/departments                    - Create department
POST   /api/departments/{id}               - Get department users
DELETE /api/departments/{id}               - Delete department
```

### User Account
```
POST   /api/account/update                 - Update own account
POST   /api/users/{id}/profile-image       - Upload profile image
```

### Validation Endpoints
```
POST   /api/validate/leave                 - Validate leave data
POST   /api/validate/skill                 - Validate skill data
POST   /api/validate/training              - Validate training data
POST   /api/validate/evaluation            - Validate evaluation data
```

## Authentication

### Login Request
```json
POST /api/auth/login
{
    "email": "user@example.com",
    "password": "password"
}
```

### Response
```json
{
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGc...",
    "token_type": "bearer",
    "expires_in": 3600
}
```

### Using the Token
Include the token in the Authorization header:
```
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGc...
```

## Database Structure

### Main Tables

#### users
- Personal information (name, email, phone, address)
- Professional details (position, grade, department)
- Contract information (hiring date, contract type)
- Authentication credentials
- Soft delete support

#### departments
- Department name
- Relationship with users

#### skills & skill_user
- Skills catalog
- User-skill relationships with ratings

#### leaves
- Leave type
- Number of days
- User relationship

#### trainings
- Training details
- User relationship

#### evaluations
- Evaluation type
- Manager information
- Status and date
- User relationship

### Migrations Order
1. Create users table
2. Create password resets table
3. Create failed jobs table
4. Create skills table
5. Create leaves table
6. Create departments table
7. Create evaluations table
8. Create permission tables
9. Create trainings table
10. Add department to users
11. Add soft deletes to users
12. Create skill_user pivot table

## Testing

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Run with coverage
php artisan test --coverage
```

### Test Structure
```
tests/
├── Feature/
│   ├── AuthenticationTest.php
│   ├── CollaboratorManagementTest.php
│   └── PermissionsTest.php
└── Unit/
    ├── UserModelTest.php
    └── ValidationTest.php
```

## Development Commands

```bash
# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Refresh database
php artisan migrate:fresh --seed

# Generate IDE helper files
php artisan ide-helper:generate
php artisan ide-helper:models

# View routes
php artisan route:list

# Tinker REPL
php artisan tinker
```

## API Documentation

Swagger documentation is available at: `http://localhost:8000/api/documentation`

The documentation is auto-generated from PHPDoc annotations in the controllers.

## Error Handling

The API returns consistent error responses:

### Validation Error (422)
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email field is required."]
    }
}
```

### Authentication Error (401)
```json
{
    "message": "Unauthenticated."
}
```

### Authorization Error (403)
```json
{
    "message": "This action is unauthorized."
}
```

### Not Found Error (404)
```json
{
    "message": "Resource not found."
}
```

## Deployment

### Production Checklist
1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Generate and set strong `APP_KEY`
4. Configure production database
5. Set proper JWT secret
6. Configure mail settings
7. Set up queue workers if needed
8. Configure cache driver (Redis recommended)
9. Run `composer install --optimize-autoloader --no-dev`
10. Run `php artisan config:cache`
11. Run `php artisan route:cache`
12. Set up SSL/TLS
13. Configure web server (Nginx/Apache)
14. Set up monitoring and logging

### Environment Variables
Key environment variables for production:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

DB_CONNECTION=mysql
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=your-db-name
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password

JWT_SECRET=your-jwt-secret
JWT_TTL=60
JWT_REFRESH_TTL=20160

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis
```

## Performance Optimization

- Use eager loading to prevent N+1 queries
- Implement API response caching where appropriate
- Use database indexing on frequently queried columns
- Paginate large datasets
- Use API resources for response transformation
- Configure OPcache for production

## Security Best Practices

- Keep dependencies updated
- Use HTTPS in production
- Implement rate limiting
- Validate all input data
- Use prepared statements (Eloquent ORM)
- Implement API versioning
- Regular security audits
- Monitor failed login attempts

## License

This project was developed as part of a summer internship program.