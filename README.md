# Simple Blog Application

A simple blog application built with **Laravel 13**.

The application supports user authentication, blog post management, guest and authenticated comments, and authorization rules.

## Features

- User registration, login, and logout using Laravel Fortify
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
- Laravel Fortify
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

Make sure the environment configuration uses SQLite.

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

The test suite contains **20 feature tests** covering:

- User registration, login, and logout
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
