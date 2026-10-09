# Simple Blog Application

A simple blog application built with **Laravel 13**.

The application supports user authentication, blog post management, guest and authenticated comments, and authorization rules.

## Features

- User registration, login, and logout using Laravel Breeze
- Password reset and email verification functionality
- User profile management
- Public blog post listing with pagination
- Create, edit, and delete blog posts
- Authorization: only post authors can edit or delete their posts
- Comments from authenticated users and guests
- Guest name validation
- Comment deletion by the comment author or post author
- Database migrations, factories, and seeders
- Automated feature tests
- Docker support

## Tech Stack

- PHP 8.4
- Laravel 13
- SQLite
- Laravel Breeze
- Blade
- PHPUnit
- Docker and Docker Compose
- Apache

## Requirements

**Docker setup (recommended):**
- Docker Desktop
- Docker Compose

**Local setup:**
- PHP 8.4
- Composer
- SQLite PHP extension

## Installation with Docker

### 1. Clone the repository

```bash
git clone <repository-url>
cd simple-blog-app
```

### 2. Configure the environment

Create a `.env` file from `.env.example`.

**Linux / macOS / Git Bash:**

```bash
cp .env.example .env
touch database/database.sqlite
```

**Windows PowerShell:**

```powershell
Copy-Item .env.example .env
New-Item database/database.sqlite -ItemType File
```

Make sure the environment configuration uses SQLite:

```env
DB_CONNECTION=sqlite
```

### 3. Build and start the containers

```bash
docker compose up -d --build
```

### 4. Generate the application key

```bash
docker compose exec app php artisan key:generate
```

### 5. Run migrations

```bash
docker compose exec app php artisan migrate --force
```

### 6. Seed the database

```bash
docker compose exec app php artisan db:seed
```

The seeders generate demonstration data:

- 5 users
- 20 blog posts
- 60 comments

### 7. Open the application

Visit:

**http://localhost:8000**

## Running Tests

Run the automated tests inside Docker:

```bash
docker compose exec -e APP_ENV=testing app php artisan test
```

The test suite currently contains **43 automated tests** covering:

- User registration, login, and logout
- Password reset and email verification
- User profile management
- Post creation, updating, and deletion
- Post ownership and authorization
- Guest and authenticated comments
- Comment validation
- Comment deletion permissions

Tests use an in-memory SQLite database, keeping application data separate from test data.

## Local Installation (Without Docker)

### 1. Install dependencies

```bash
composer install
```

### 2. Configure the environment

Copy `.env.example` to `.env`, configure SQLite, and create the database file if needed.

**Linux / macOS / Git Bash:**

```bash
cp .env.example .env
touch database/database.sqlite
```

**Windows PowerShell:**

```powershell
Copy-Item .env.example .env
New-Item database/database.sqlite -ItemType File
```

Ensure the `.env` file contains:

```env
DB_CONNECTION=sqlite
```

### 3. Generate the application key

```bash
php artisan key:generate
```

### 4. Run migrations and seeders

```bash
php artisan migrate --seed
```

### 5. Start the development server

```bash
php artisan serve
```

Open **http://localhost:8000**.

### 6. Run tests

```bash
php artisan test
```

## Authorization Rules

### Posts

| Action | Permission |
|---|---|
| View posts | Everyone |
| Create posts | Authenticated users |
| Edit posts | Post author |
| Delete posts | Post author |

### Comments

| Action | Permission |
|---|---|
| View comments | Everyone |
| Create comments | Guests and authenticated users |
| Delete own comment | Authenticated comment author |
| Delete comments on own post | Post author |
| Delete other comments | Not allowed unless the user owns the post |

Guests must provide their name when submitting comments.

## Authentication

Authentication is implemented using **Laravel Breeze**.

The application provides:

- User registration
- User login and logout
- Password reset functionality
- Email verification functionality
- Profile information updates
- Password updates
- Account deletion

Authentication is required to create, edit, or delete blog posts.

Public blog posts and comments can be viewed without authentication.

## Database

The application uses SQLite.

Database migrations define the required tables and relationships for users, posts, and comments.

Factories and seeders provide demonstration data for local development and testing.

To reset and reseed the database locally:

```bash
php artisan migrate:fresh --seed
```

**Warning:** This command deletes all existing database tables and data. Use it only when you want to reset the database.

## Project Structure

- `app/Http/Controllers` — Application controllers
- `app/Http/Controllers/Auth` — Authentication controllers
- `app/Http/Requests` — Form request validation
- `app/Models` — Eloquent models
- `app/Policies` — Authorization policies
- `database/migrations` — Database schema
- `database/factories` — Model factories
- `database/seeders` — Database seeders
- `resources/views` — Blade templates
- `public/css/style.css` — Application styling
- `routes/web.php` — Blog and profile routes
- `routes/auth.php` — Authentication routes
- `tests/Feature` — Feature tests

## Notes

- The application uses Laravel policies to enforce ownership and authorization rules.
- Guests can submit comments by providing their names.
- Authenticated users can manage their own blog posts.
- Comment authors and post authors have permission to delete the relevant comments.
- Docker provides a containerized environment for running the application.
- Automated tests verify the main application functionality and authorization rules.
