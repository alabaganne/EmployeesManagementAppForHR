# Vue.js Frontend

Single-page application for the HR Management System built with Vue.js.

## Requirements

- Node.js 12.x or higher
- npm or yarn

## Tech Stack

- **Vue.js 2.6** - JavaScript framework
- **Vuex** - State management
- **Vue Router** - SPA routing
- **Axios** - HTTP client
- **Bootstrap 4** - UI framework
- **Chart.js** - Data visualization
- **SCSS** - CSS preprocessor

## Installation

```bash
npm install

# Create .env file
VUE_APP_API_URL=http://localhost:8000/api

npm run serve
```

Runs on `http://localhost:8080`

## Available Scripts

```bash
npm run serve    # Development server
npm run build    # Production build
npm run lint     # Lint files
```

## Project Structure

```
src/
├── components/     # Reusable components
├── views/          # Page components
├── store/          # Vuex state management
├── router/         # Vue Router config
├── assets/         # Images, styles
└── core/           # Utilities

## Main Routes

- `/login` - Authentication
- `/dashboard` - Main dashboard
- `/collaborators` - Employee list
- `/collaborators/create` - Add employee
- `/collaborators/:id/profile` - View profile
- `/collaborators/archive` - Archived employees
- `/settings` - User settings

## Features

- Dashboard with charts (gender/department distribution)
- Employee management (CRUD)
- Leave, skills, training, and evaluation tracking
- Archive system with restore
- JWT authentication
- Role-based access control
- Responsive design

## State Management

Uses Vuex with modules:
- **auth** - Authentication state
- Persisted to localStorage

## Building for Production

```bash
npm run build
```

Output in `dist/` directory.
