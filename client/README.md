# HR Management System - Vue.js Frontend

A modern, responsive single-page application built with Vue.js that provides an intuitive interface for managing employees, departments, and HR operations. This frontend application consumes the Laravel backend API to deliver a seamless user experience.

## Table of Contents
- [Features](#features)
- [Technical Stack](#technical-stack)
- [Application Architecture](#application-architecture)
- [Installation](#installation)
- [Configuration](#configuration)
- [Project Structure](#project-structure)
- [Components Overview](#components-overview)
- [State Management](#state-management)
- [Routing](#routing)
- [Development](#development)
- [Building for Production](#building-for-production)

## Features

### User Interface
- **Responsive Design**: Mobile-first approach using Bootstrap 4
- **Dynamic Dashboard**: Real-time statistics with interactive charts
- **Employee Management**: Intuitive interface for CRUD operations
- **Advanced Search**: Real-time search functionality for employees
- **Data Visualization**: Charts for gender distribution and department analytics
- **Archive System**: Easy access to archived employee records
- **Profile Management**: Comprehensive employee profile views

### Technical Features
- **JWT Authentication**: Secure token-based authentication
- **Route Guards**: Protected routes based on user permissions
- **Lazy Loading**: Components loaded on-demand for performance
- **State Persistence**: Vuex state management with localStorage
- **API Integration**: Axios-based API client with interceptors
- **Form Validation**: Client-side validation with error handling
- **Reusable Components**: Modular component architecture

## Technical Stack

- **Vue.js 2.6.12**: Progressive JavaScript framework
- **Vue Router 3.2.0**: Official router for SPA navigation
- **Vuex 3.4.0**: Centralized state management
- **Axios 0.20.0**: HTTP client for API communication
- **Bootstrap 4.5.2**: CSS framework for responsive design
- **Chart.js 2.9.3**: Data visualization library
- **SCSS**: CSS preprocessor for maintainable styles
- **Vue CLI 4.5.0**: Development tooling

## Application Architecture

### Directory Structure
```
client/
├── public/
│   ├── favicon.ico
│   └── index.html
├── src/
│   ├── assets/
│   │   ├── images/
│   │   └── scss/
│   ├── components/
│   │   ├── charts/
│   │   │   ├── HorizontalBarChart.vue
│   │   │   └── PieChart.vue
│   │   ├── collaborator/
│   │   │   ├── CollaboratorCard.vue
│   │   │   ├── CreateEditCollaborator.vue
│   │   │   ├── CreateEditViewTable.vue
│   │   │   └── ShowDataTable.vue
│   │   ├── Loader.vue
│   │   └── Modal.vue
│   ├── core/
│   │   ├── Errors.js
│   │   └── Form.js
│   ├── mixins/
│   │   └── collaboratorMixin.js
│   ├── router/
│   │   └── index.js
│   ├── store/
│   │   ├── auth.js
│   │   ├── index.js
│   │   └── subscriber.js
│   ├── views/
│   │   ├── Collaborators/
│   │   │   ├── archive.vue
│   │   │   ├── create.vue
│   │   │   ├── edit.vue
│   │   │   ├── index.vue
│   │   │   └── show.vue
│   │   ├── User/
│   │   │   └── settings.vue
│   │   ├── Dashboard.vue
│   │   └── Login.vue
│   ├── App.vue
│   ├── Layout.vue
│   └── main.js
├── .env
├── package.json
└── README.md
```

## Installation

1. **Prerequisites**:
   - Node.js 12.x or higher
   - npm or yarn package manager
   - Backend API running (see server README)

2. **Clone and navigate to client directory**:
```bash
cd client
```

3. **Install dependencies**:
```bash
npm install
```

4. **Environment configuration**:
Create a `.env` file in the client directory:
```env
VUE_APP_API_URL=http://localhost:8000/api
VUE_APP_TITLE=HR Management System
```

5. **Start development server**:
```bash
npm run serve
```

The application will be available at `http://localhost:8080`

## Configuration

### API Configuration
Configure the API base URL in `.env`:
```env
VUE_APP_API_URL=http://localhost:8000/api
```

### Axios Configuration
The axios instance is configured in `main.js` with:
- Base URL from environment
- JWT token interceptor
- Error handling interceptor

## Components Overview

### Layout Components
- **Layout.vue**: Main application layout with sidebar navigation
- **App.vue**: Root component with router outlet

### Feature Components

#### Charts
- **PieChart.vue**: Gender distribution visualization
- **HorizontalBarChart.vue**: Department distribution chart

#### Collaborator Components
- **CollaboratorCard.vue**: Employee card display component
- **CreateEditCollaborator.vue**: Form for creating/editing employees
- **CreateEditViewTable.vue**: Tabular data management component
- **ShowDataTable.vue**: Display component for employee data

### Shared Components
- **Loader.vue**: Loading spinner component
- **Modal.vue**: Reusable modal dialog component

## State Management

### Vuex Store Structure

#### Auth Module (`store/auth.js`)
- **State**: token, user
- **Getters**: isAuthenticated, user, permissions
- **Actions**: login, logout, refresh
- **Mutations**: SET_TOKEN, SET_USER

#### Store Configuration
- Modular structure with namespaced modules
- Persistence using localStorage
- Automatic token refresh handling

### API State Management
- Centralized error handling
- Loading states
- Automatic retry logic for failed requests

## Routing

### Route Structure
```javascript
/                    - Redirects to dashboard
/login               - Authentication page
/dashboard           - Main dashboard with statistics
/collaborators       - Employee listing
/collaborators/create - Add new employee
/collaborators/:id/edit - Edit employee
/collaborators/:id/profile - View employee profile
/collaborators/archive - Archived employees
/settings            - User account settings
```

### Route Guards
- Authentication check on all protected routes
- Permission-based access control
- Automatic redirect to login for unauthenticated users
- Role-based navigation restrictions

## Development

### Available Scripts

```bash
# Development server with hot reload
npm run serve

# Production build
npm run build

# Lint and fix files
npm run lint

# Run unit tests
npm run test:unit

# Run e2e tests
npm run test:e2e
```

### Development Features
- Hot module replacement
- Source maps
- ESLint integration
- Vue DevTools support

### Code Style
- Vue.js style guide compliance
- ESLint configuration
- Prettier formatting
- Component naming conventions

## Building for Production

### Build Command
```bash
npm run build
```

### Build Output
- Minified and optimized bundles
- Code splitting for better performance
- Asset optimization
- Production environment variables

### Deployment
The built files in `dist/` directory can be served by any static file server:
- Nginx configuration example
- Apache configuration example
- CDN deployment options

### Performance Optimizations
- Lazy-loaded routes
- Component code splitting
- Image optimization
- CSS extraction and minification
- Tree shaking for unused code

## Features in Detail

### Dashboard
- Real-time employee statistics
- Gender distribution pie chart
- Department distribution bar chart
- Recent employees table
- Quick navigation links

### Employee Management
- Paginated employee listing
- Real-time search functionality
- Employee cards with profile images
- Quick actions (view, edit, delete)
- Bulk operations support

### Employee Profiles
- Comprehensive information display
- Skills and competencies section
- Training history
- Leave management
- Performance evaluations
- Document attachments

### Archive System
- Soft-deleted employees listing
- Restore functionality
- Permanent deletion option
- Search within archives

## API Integration

### Axios Interceptors
```javascript
// Request interceptor for auth token
axios.interceptors.request.use(config => {
    const token = store.getters['auth/token'];
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
});

// Response interceptor for error handling
axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response.status === 401) {
            store.dispatch('auth/logout');
        }
        return Promise.reject(error);
    }
);
```

### API Service Pattern
- Centralized API calls
- Error handling
- Loading state management
- Response transformation

## Browser Support

- Chrome (latest)
- Firefox (latest)
- Safari (latest)
- Edge (latest)
- Mobile browsers

## Troubleshooting

### Common Issues

1. **CORS Errors**
   - Ensure backend CORS configuration
   - Check API URL in .env

2. **Authentication Issues**
   - Verify JWT token validity
   - Check token refresh logic

3. **Build Failures**
   - Clear node_modules and reinstall
   - Check Node.js version compatibility

## Future Enhancements

- Vue 3 migration
- TypeScript integration
- PWA capabilities
- Offline support
- Real-time notifications
- Advanced filtering and sorting
- Export functionality
- Multi-language support

## License

This project was developed as part of a summer internship program.
