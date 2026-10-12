# Clothing E-commerce — Laravel

A Laravel-based clothing store application featuring product discovery, filtering, shopping cart management, checkout workflows, inventory updates, and order history.

![PHP](https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=flat&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?style=flat&logo=tailwindcss&logoColor=white)
![SQLite](https://img.shields.io/badge/Database-SQLite-003B57?style=flat&logo=sqlite&logoColor=white)
![Architecture](https://img.shields.io/badge/Architecture-MVC-blue?style=flat)
![License](https://img.shields.io/badge/License-MIT-green?style=flat)

## Overview

Clothing E-commerce is a web application built with Laravel that models the core workflows of an online clothing store. It combines a product catalog, category navigation, shopping cart operations, checkout, and customer order management in a traditional MVC architecture.

The project emphasizes practical backend development through Eloquent relationships, request validation, access checks, database transactions, and inventory updates.

**Implementation note:** The authentication flow is not yet fully configured, and an admin dashboard is not implemented. Features that depend on authenticated sessions require those gaps to be resolved before the complete user journey can be tested.

## Features

### Product Catalog

- Paginated product listings.
- Filtering by category, price range, size, and color.
- Text-based product search.
- Sorting by price, newest arrivals, and featured products.
- Product detail pages with multiple images.
- Related product suggestions based on category.
- Category and subcategory navigation.

### Shopping Cart

- Session-based cart support for guest visitors.
- Cart operations for authenticated users.
- Add, update, and remove cart items through application endpoints.
- JSON responses for cart operations where implemented.

### Checkout and Orders

- Billing and shipping information forms.
- Calculation of subtotals, taxes, and shipping costs.
- Order creation inside a database transaction.
- Inventory updates during checkout.
- Customer order history and order detail pages.

### Customer Profile

- Update personal information.
- Delete an account after confirming the current password.
- Newsletter subscription with email validation and uniqueness checks.

The availability of authenticated features depends on completing and testing the authentication configuration.

## Technology Stack

| Technology | Purpose |
|---|---|
| PHP 8.2+ | Backend language |
| Laravel 12 | Application framework |
| Eloquent ORM | Models, relationships, and database queries |
| SQLite | Default development database configuration |
| Blade | Server-rendered templates |
| Tailwind CSS 4 | User interface styling |
| Vite | Frontend asset development and build |
| Intervention Image | Image processing dependency |
| Composer | PHP dependency management |
| npm | Frontend dependency management |

## Architecture

The application follows Laravel's MVC structure.

```text
Browser
   |
   v
Laravel Routes
   |
   v
Controllers
   |
   +--------------------+
   |                    |
   v                    v
Form Requests       Eloquent Models
   |                    |
   v                    v
Validation          Database
   |
   v
Blade Views / JSON Responses
```

The main domain models include:

- `Product` — product information and catalog attributes.
- `Category` — product categories and navigation.
- `ProductImage` — product image records.
- `CartItem` — shopping cart entries.
- `Order` — customer orders and checkout information.
- `OrderItem` — items associated with an order.
- `NewsletterSubscriber` — newsletter subscription records.
- `User` — customer account information.

## Project Structure

```text
Clothing-ecommerce/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Requests/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
├── routes/
│   └── web.php
├── public/
├── composer.json
└── package.json
```

## Getting Started

### Prerequisites

- PHP 8.2 or later
- Composer
- Node.js and npm
- PHP extensions required by Laravel and the selected database driver

### 1. Clone the Repository

```bash
git clone https://github.com/ELGHAD/Clothing-ecommerce.git
cd Clothing-ecommerce
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Configure the Environment

Create a local environment file from the supplied example:

```bash
cp .env.example .env
php artisan key:generate
```

The provided configuration uses SQLite by default. Create the database file if it does not already exist:

```bash
touch database/database.sqlite
```

Review `.env` and confirm that `DB_CONNECTION` and `DB_DATABASE` point to the intended SQLite database.

### 4. Initialize the Database

```bash
php artisan migrate --seed
```

### 5. Build Frontend Assets

For development:

```bash
npm run dev
```

For a production asset build:

```bash
npm run build
```

### 6. Start the Application

In a separate terminal:

```bash
php artisan serve
```

Open [http://localhost:8000](http://localhost:8000).

**Before testing:** Confirm that migrations and seeders complete successfully. Authentication-dependent pages will not provide a complete user journey until the authentication routes and views have been configured.

## Security and Engineering Practices

The current implementation includes several useful backend practices:

- **CSRF protection:** Laravel's standard protection for applicable web forms.
- **Request validation:** Input validation through Laravel validation rules and a dedicated profile update request.
- **Mass-assignment controls:** Explicitly configured model fillable attributes.
- **Transactional checkout:** Database transaction handling to avoid partially completed order creation when an exception occurs.
- **Ownership checks:** Authorization checks intended to prevent users from accessing other customers' orders or modifying their cart items.
- **Password confirmation:** Current-password confirmation before account deletion.

These mechanisms are useful foundations, but they do not replace a complete security review or automated testing.

## Current Limitations

The repository still has several gaps to address:

- **Authentication:** Laravel Breeze is listed as a dependency, but its authentication scaffolding and routes are not fully configured.
- **Admin dashboard:** An `is_admin` field exists, but a functional administration interface and associated access controls are not implemented.
- **Authenticated workflows:** Checkout and profile routes rely on authentication, so the complete customer journey cannot be verified until login and registration work.
- **Database documentation:** SQLite is the default development configuration; deployment requirements and database setup should be documented consistently.
- **Automated testing:** Checkout calculations, inventory changes, authorization, and cart operations should be covered by tests.
- **Production readiness:** Payment integration, operational monitoring, and deployment configuration are outside the current documented scope.

This repository should be treated as a portfolio project under development, rather than a production-ready online store.

## Roadmap

1. Complete Laravel Breeze authentication and verify registration, login, logout, and password handling.
2. Implement admin authorization and a protected product and category management dashboard.
3. Add automated tests for cart operations, checkout, inventory updates, and order ownership.
4. Validate inventory availability and prevent overselling under concurrent checkout requests.
5. Improve error handling and checkout validation.
6. Add product image storage configuration and deployment documentation.
7. Configure CI, production environment variables, and a reproducible deployment workflow.

## Author

**Hamza Elrhadiouini**

- GitHub: [@ELGHAD](https://github.com/ELGHAD)
- Portfolio: [elghad.github.io/hamza-elrhadiouini-portfolio](https://elghad.github.io/hamza-elrhadiouini-portfolio)
