# Employee Management System for HR

A comprehensive Human Resources management application built with Vue.js and Laravel, designed to streamline employee data management, performance tracking, and organizational workflows. Developed during a summer internship, this full-stack web application demonstrates modern development practices and enterprise-level architecture.

## Table of Contents
- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [System Architecture](#system-architecture)
- [Installation](#installation)
- [API Documentation](#api-documentation)
- [User Roles and Permissions](#user-roles-and-permissions)
- [Database Schema](#database-schema)
- [Development](#development)

## Overview

This Employee Management System is a modern HR solution that enables organizations to efficiently manage their workforce. The application provides a centralized platform for managing employee profiles, tracking leave requests, monitoring skills and training, conducting performance evaluations, and visualizing organizational data through interactive dashboards.

## Features

### Core Functionality
- **Employee Management**: Complete CRUD operations for employee records with comprehensive profile information
- **Department Organization**: Organize employees by departments with visualization of department distribution
- **Leave Management**: Track and manage employee leave requests with configurable leave allowances
- **Skills Tracking**: Document and evaluate employee skills with scoring capabilities
- **Training Records**: Maintain records of employee training programs and certifications
- **Performance Evaluations**: Conduct and track employee performance evaluations
- **Archive System**: Soft delete functionality with the ability to restore archived employees

### Dashboard and Analytics
- **Gender Distribution Chart**: Visual representation of workforce gender diversity
- **Department Distribution**: Bar chart showing employee distribution across departments
- **Recent Employees**: Quick access to recently added team members
- **Real-time Statistics**: Dynamic data visualization using Chart.js

### Security and Authentication
- **JWT Authentication**: Secure token-based authentication system
- **Role-Based Access Control**: Granular permissions system with multiple user roles
- **Protected Routes**: Frontend and backend route protection based on user permissions
- **Password Hashing**: Secure password storage using bcrypt

## Technology Stack

### Frontend
- **Vue.js 2.6.12**: Progressive JavaScript framework for building user interfaces
- **Vue Router 3.2.0**: Official router for Vue.js single-page applications
- **Vuex 3.4.0**: State management pattern and library for Vue.js applications
- **Axios 0.20.0**: Promise-based HTTP client for API communications
- **Chart.js 2.9.3**: JavaScript charting library for data visualization
- **Bootstrap 4.5.2**: CSS framework for responsive design
- **SCSS**: CSS preprocessor for maintainable stylesheets

### Backend
- **Laravel 7.24**: PHP web application framework
- **PHP 7.2.5+**: Server-side programming language
- **MySQL**: Relational database management system
- **JWT Auth**: JSON Web Token authentication for Laravel
- **Spatie Laravel Permission 3.16**: Advanced roles and permissions management
- **Laravel CORS**: Cross-Origin Resource Sharing support
- **L5-Swagger**: API documentation generator

## System Architecture

The application follows a modern client-server architecture with clear separation of concerns:

### Frontend Architecture
- **Component-Based Design**: Reusable Vue components for UI elements
- **Centralized State Management**: Vuex store for application state
- **Route Guards**: Authentication and permission checks at the routing level
- **Mixins**: Shared functionality across components via Vue mixins
- **Modular Structure**: Organized by feature with clear separation of views and components

### Backend Architecture
- **RESTful API**: Well-structured API endpoints following REST principles
- **MVC Pattern**: Model-View-Controller architecture for clean code organization
- **Repository Pattern**: Database abstraction layer for flexibility
- **Request Validation**: Form request classes for input validation
- **Resource Transformation**: API resources for consistent data formatting
- **Policy-Based Authorization**: Laravel policies for fine-grained access control

## Installation

### Prerequisites
- PHP >= 7.2.5
- Composer
- Node.js and npm
- MySQL database
- Git

### Backend Setup

1. Clone the repository:
```bash
git clone https://github.com/yourusername/EmployeesManagementAppForHR.git
cd EmployeesManagementAppForHR/server
```

2. Install PHP dependencies:
```bash
composer install
```

3. Create environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your database in the `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

6. Generate JWT secret:
```bash
php artisan jwt:secret
```

7. Run database migrations:
```bash
php artisan migrate
```

8. Seed the database with roles and permissions:
```bash
php artisan db:seed --class=RolesAndPermissionsSeeder
```

9. Start the Laravel development server:
```bash
php artisan serve
```

### Frontend Setup

1. Navigate to the client directory:
```bash
cd ../client
```

2. Install dependencies:
```bash
npm install
```

3. Configure API endpoint in your environment file

4. Start the development server:
```bash
npm run serve
```

## API Documentation

The API follows RESTful conventions with the following main endpoints:

### Authentication Endpoints
- `POST /api/auth/login` - User authentication
- `POST /api/auth/logout` - User logout
- `POST /api/auth/refresh` - Refresh JWT token
- `GET /api/auth/me` - Get authenticated user details

### Collaborator Management
- `POST /api/collaborators` - List all collaborators (paginated)
- `GET /api/collaborators/{id}` - Get specific collaborator details
- `POST /api/collaborators/create` - Create new collaborator
- `PUT /api/collaborators/{id}` - Update collaborator information
- `DELETE /api/collaborators/{id}` - Soft delete collaborator
- `GET /api/collaborators/{id}/restore` - Restore deleted collaborator
- `DELETE /api/collaborators/{id}/delete-permanently` - Permanently delete collaborator

### Statistics Endpoints
- `GET /api/collaborators/gender` - Get employee count by gender
- `GET /api/collaborators/department` - Get employee count by department

### Related Resources
- `CRUD /api/collaborators/{id}/leaves` - Manage employee leaves
- `CRUD /api/collaborators/{id}/skills` - Manage employee skills
- `CRUD /api/collaborators/{id}/trainings` - Manage employee trainings
- `CRUD /api/collaborators/{id}/evaluations` - Manage employee evaluations

### Department Management
- `GET /api/departments` - List all departments
- `POST /api/departments` - Create new department
- `DELETE /api/departments/{id}` - Delete department

## User Roles and Permissions

The system implements a comprehensive role-based access control system:

### Roles
1. **Admin (Manager)**
   - Full system access
   - All permissions granted
   - Can manage user accounts

2. **HR (Human Resources)**
   - View collaborators
   - Add collaborators
   - Edit collaborators
   - Delete collaborators

3. **Project Manager**
   - Limited access based on specific project needs
   - Customizable permissions

### Permissions
- `view collaborators` - View employee profiles and lists
- `add collaborators` - Create new employee records
- `edit collaborators` - Modify existing employee information
- `delete collaborators` - Archive or delete employee records
- `manage accounts` - Admin-specific account management

## Database Schema

### Key Tables
- **users** - Stores all user and employee information
- **departments** - Department information
- **skills** - Available skills catalog
- **skill_user** - Many-to-many relationship for user skills
- **leaves** - Employee leave records
- **trainings** - Employee training history
- **evaluations** - Performance evaluation records
- **roles** - System roles
- **permissions** - System permissions
- **model_has_roles** - User-role associations
- **model_has_permissions** - Direct permission assignments

## Development

### Code Standards
- PSR-4 autoloading standard for PHP
- Vue.js style guide compliance
- ESLint configuration for JavaScript code quality
- Consistent naming conventions across the stack

### Testing
- PHPUnit for backend testing
- Vue Test Utils for frontend component testing
- Feature and unit test structure

### Build Commands

Frontend:
```bash
npm run serve   # Development server
npm run build   # Production build
npm run lint    # Run ESLint
```

Backend:
```bash
php artisan serve              # Development server
php artisan test              # Run tests
php artisan migrate:fresh     # Reset database
php artisan cache:clear       # Clear application cache
```

## Security Considerations

- JWT tokens for stateless authentication
- CORS configuration for API security
- Input validation at multiple levels
- SQL injection prevention through Eloquent ORM
- XSS protection through Vue.js reactivity
- CSRF protection for web routes
- Password hashing using bcrypt
- Environment-based configuration

## Performance Optimizations

- Lazy loading of Vue components
- Paginated data loading
- Indexed database queries
- Caching strategies for frequently accessed data
- Optimized asset bundling with Webpack
- API resource transformation for minimal data transfer

## Future Enhancements

- Email notifications for leave requests
- Advanced reporting and analytics
- Multi-language support
- Mobile application development
- Integration with third-party HR systems
- Advanced search and filtering capabilities
- Bulk import/export functionality

## License

This project was developed as part of a summer internship program. Please refer to your organization's licensing terms.

## Author

Developed by a dedicated intern during summer internship program, showcasing full-stack development skills with modern web technologies.