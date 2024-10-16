# Authentication API

This project is a simple authentication API built using the Slim Framework. It provides endpoints for user login, logout, registration, and session management.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)

## Features

- User registration with unique email and username
- User login with password authentication
- Session management with "remember me" functionality
- Logout functionality

## Requirements

- PHP 7.4 or higher
- Composer
- SQLite database

## Installation

1. **Clone the repository:**

   ```bash
   git clone <repository-url>
   cd <repository-directory>
   ```

2. **Install composer:**

   ```bash
    composer install
   ```

3. **Create database if is not created:**

   ```bash
    touch database/database.sqlite
   ```

4. **Create users table if its not in the database:**

   ```bash
    php database/migrations/CreateUsersTable.php
   ```

5. **Create user test in data:**

   ```bash
    php database/factories/FactoryUser.php
   ```

6. **Start the app:**

   ```bash
   php -S localhost:8000
   ```
