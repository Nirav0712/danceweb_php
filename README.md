# Dynamice Children Academy — PHP Architecture

Modern, lightweight MVC PHP Architecture for Hostinger Shared Hosting.

## Requirements
- PHP 8.0+ (Tested on PHP 8.0.30 & fully compatible with PHP 8.2+)
- MySQL / MariaDB (Database: `dynamice_academy_db`)
- Apache with `mod_rewrite` enabled

## Directory Structure
- `app/Core/`: Router, Request, Response, Database, Session, CSRF, View, Env, Logger
- `app/Controllers/`: AuthController, DashboardController
- `app/Middleware/`: AuthMiddleware, RoleMiddleware
- `app/Models/`: User
- `app/Services/`: AuthService, Permissions
- `config/`: Application and database configuration
- `public/`: Webroot (`index.php`, `.htaccess`, assets)
- `resources/views/`: Admin and error templates
- `routes/`: Web route definitions
