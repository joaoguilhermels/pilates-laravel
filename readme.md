# Pilates Studio Management System

This application is a comprehensive management system for pilates studios, handling scheduling, payments, client management, and reporting.

## Laravel Upgrade Project

This branch contains the upgrade from Laravel 9 to Laravel 11. The following changes have been made:

- Updated PHP requirement from ^7.2|^8.0 to ^8.2
- Updated Laravel Framework from ^9.0 to ^11.0
- Updated all dependencies to their Laravel 11 compatible versions
- Created modern factory pattern files for models
- Updated routes to use named routes
- Updated controllers with proper return types
- Updated models with proper type declarations

## Features

- User Management: Authentication system for different user roles
- Client Management: Track client information and history
- Professional Management: Manage instructors and staff
- Schedule Management: Calendar for booking and managing classes
- Payment Processing: Handle payments and financial transactions
- Room Management: Manage studio spaces
- Reporting: Financial and operational reporting capabilities

## Technical Stack

- **Backend**: Laravel 11.x with PHP 8.2+
- **Frontend**: Vue.js with Vite
- **Styling**: Bootstrap/Tailwind CSS
- **Database**: MySQL
- **Testing**: PHPUnit

## Upgrade Process Checklist

- [x] Create a new branch for the upgrade
- [x] Update composer.json with Laravel 11 requirements
- [x] Create MCP configuration file
- [x] Update routes syntax for new Laravel standards
- [x] Update models for the new Laravel 11 conventions
- [x] Update controllers for the new Laravel 11 conventions
- [x] Update Blade templates for Laravel 11 compatibility
- [x] Update Vite configuration for Laravel 11
- [x] Create modern factory pattern files
- [ ] Update PHP dependency to 8.2+
- [ ] Update Laravel Framework to 11.x
- [ ] Upgrade all packages to their Laravel 11 compatible versions
- [ ] Update database migrations if needed
- [ ] Implement comprehensive tests
- [ ] Run tests to ensure application functionality
- [ ] Fix any issues found during testing

## Running the Application

```bash
# Clone the repository
git clone <repository-url>

# Install dependencies
composer install
npm install

# Set up environment
cp .env.example .env
php artisan key:generate

# Run migrations
php artisan migrate

# Start the development server
php artisan serve
npm run dev
```

## Testing

```bash
php artisan test
```

## Code Coverage

Current code coverage: TBD

## Laravel 11 Upgrade Notes

### Key Changes

1. **Route Definitions**

   - Updated to use controller class references instead of string actions
   - Added route names to all routes for better maintainability

2. **Controllers**

   - Added proper return type declarations
   - Updated dependency injection
   - Using validated() method for form requests

3. **Models**

   - Added HasFactory trait
   - Added proper type declarations for relations
   - Updated property PHPDoc

4. **Views**

   - Updated Blade templates to use route() helpers instead of action()
   - Using modern Blade directives like @forelse

5. **Factories**
   - Created proper factory classes for models
   - Implemented the latest factory pattern

## Next Steps

1. Complete the upgrade by testing all features
2. Ensure all database migrations work correctly
3. Implement comprehensive test coverage
4. Document any breaking changes
