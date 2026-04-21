# Aircraft Tools Management

Aircraft Tools Management is a comprehensive web application designed to streamline the management of aviation maintenance tools. Upgraded from a legacy PHP architecture to the modern **Laravel 11** framework, it provides robust features for inventory tracking, employee management, tool check-in/check-out logs, and maintenance reporting. 

## Features

- **Dashboard:** At-a-glance metrics for tools, employees, and maintenance logs.
- **Tool Inventory:** Complete CRUD (Create, Read, Update, Delete) management for aviation tools, including barcode tracking, quantity, and status monitoring.
- **Employee Management:** Manage staff profiles, roles, and departmental assignments.
- **Check In / Check Out:** Maintain an unalterable history of which employee borrowed which tool, ensuring strict accountability.
- **Tools Maintenance:** Track tools that are damaged or under repair with detailed logs.
- **Secure Authentication:** Powered by Laravel Breeze for secure login and profile management.
- **Responsive UI:** Developed using Tailwind CSS and Alpine.js for a modern, responsive user experience.

---

## Installation Setup

Follow these steps to set up the project locally on your machine.

### Prerequisites

- **PHP**: ^8.2
- **Composer**: Dependency Manager for PHP
- **Node.js & NPM**: For building frontend assets (Vite)
- **MySQL/MariaDB**: Database server

### Step-by-Step Guide

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd Aircraft-Tools-Management
   ```

2. **Install PHP Dependencies**
   ```bash
   composer install
   ```

3. **Install Frontend Dependencies**
   ```bash
   npm install
   npm run build
   ```

4. **Environment Configuration**
   Copy the example environment file and configure your local database credentials:
   ```bash
   cp .env.example .env
   ```
   Open the `.env` file and update your database settings:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tools_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Run Migrations & Seed the Database**
   This command creates the database tables and populates them with initial dummy data (including tools and admin user):
   ```bash
   php artisan migrate --seed
   ```

7. **Start the Development Server**
   ```bash
   php artisan serve
   ```
   The application will be available at `http://127.0.0.1:8000`.

---

## Default Login Credentials

If you seeded the database, you can log in using your pre-configured credentials.
## License

This project is open-sourced software.
