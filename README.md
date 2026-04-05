# Payroll Management System

A PHP + MySQL based web application for managing employee payroll operations.

## Features

- Admin login
- Employee management (add, edit, delete, search, sort)
- Department management
- Overtime and bonus management
- Income and tax update flow
- Leave management

## Tech Stack

- PHP (core PHP)
- MySQL
- HTML, CSS, JavaScript
- Bootstrap (CDN)

## Project Structure (important files)

- `admin_login.html` – Admin login page
- `auth.php` – Login authentication handler
- `admin_dashboard.php` – Main admin dashboard
- `employee_management.php` – Employee listing and management
- `create_tables.sql` – Database schema and seed admin user
- `config.php` – Database connection configuration

## Prerequisites

- XAMPP / WAMP / LAMP (Apache + PHP + MySQL)
- Web browser

## Setup Instructions

1. Clone/download the project.
2. Move project folder to your web server root:
   - XAMPP: `htdocs/Payroll_Management_System`
   - WAMP: `www/Payroll_Management_System`
3. Start **Apache** and **MySQL**.
4. Create database in MySQL:
   - Database name: `payroll_management_system`
5. Import SQL schema:
   - Import `create_tables.sql` into `payroll_management_system`.
6. Configure DB credentials in `config.php` if needed:
   - `DB_HOST`
   - `DB_USER`
   - `DB_PASSWORD`
   - `DB_NAME`
7. Open in browser:
   - `http://localhost/Payroll_Management_System/admin_login.html`

## Default Admin Credentials

From `create_tables.sql`:

- Username: `admin`
- Password: `password`

> Change the default credentials immediately for security.

## Basic Usage

1. Login from `admin_login.html`.
2. Open dashboard and navigate modules:
   - Employee Management
   - Add Employee
   - Add Department
   - Add Overtime/Bonuses
   - Leave Management
   - Update Tax / OT / Bonus

## Notes

- Database connection is configured in `config.php`.
- Ensure MySQL is running before accessing modules.

