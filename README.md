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

## Hostinger Shared Hosting Setup (.env)
When deploying to Hostinger via Git or File Manager:
1. In Hostinger File Manager, open `public_html/`.
2. Create a new file named `.env`.
3. Copy the template from `.env.hostinger.example`:
   ```ini
   APP_NAME="Dynamice Children Academy"
   APP_ENV="production"
   APP_DEBUG=false
   APP_URL="https://endless-coral-rook-02.hostingersite.com"

   DB_HOST="localhost"
   DB_PORT="3306"
   DB_NAME="u521358425_danceacademy"
   DB_USER="u521358425_danceuser"
   DB_PASS="YOUR_HOSTINGER_DATABASE_PASSWORD"
   DB_CHARSET="utf8mb4"

   SESSION_LIFETIME=7200
   SESSION_SECURE=true
   ```
4. Enter the password set for `u521358425_danceuser` in Hostinger hPanel.
5. Save the file.
6. Verify connection at `/health`. Once connected, the homepage (`/`) will immediately render with HTTP 200.
