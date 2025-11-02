# Clothing Brand E-commerce Website

A professional, responsive e-commerce website for a clothing brand built with Laravel 12, MySQL, and TailwindCSS. Features a clean, luxury design inspired by Ralph Lauren's aesthetic with modern functionality.

## Features

### Frontend
- **Homepage**: Hero banner, product categories, featured products, brand story, newsletter signup
- **Product Catalog**: Advanced filtering and sorting by category, price, size, color
- **Product Details**: Zoomable images, size/color selection, add to cart functionality
- **Shopping Cart**: Session-based cart for guests, persistent cart for users
- **Checkout**: Guest checkout or user login, shipping/billing forms, order confirmation
- **User Accounts**: Registration, login, profile management, order history
- **Responsive Design**: Mobile-first design optimized for all devices

### Backend
- **Admin Dashboard**: Manage products, categories, orders, users, newsletter subscribers
- **Order Management**: Track order status, update shipping information
- **Inventory Management**: Stock tracking, product variants (size/color)
- **User Management**: Customer accounts, admin roles
- **Newsletter System**: Subscriber management and email collection

### Technical Features
- **Laravel 12**: Latest Laravel framework with modern PHP features
- **MySQL Database**: Robust relational database with optimized queries
- **TailwindCSS**: Utility-first CSS framework for rapid UI development
- **Laravel Breeze**: Authentication scaffolding
- **Image Management**: Product image upload and optimization
- **SEO Optimized**: Meta tags, clean URLs, semantic HTML
- **Security**: CSRF protection, input validation, secure authentication

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL 5.7 or higher

### Setup Instructions

1. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

2. **Environment Configuration**
   ```bash
   cp .env.example .env
   ```
   
   Update your `.env` file with MySQL database configuration:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=brandd
   DB_USERNAME=root
   DB_PASSWORD=your_mysql_password
   ```

3. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

4. **Run Migrations and Seeders**
   ```bash
   php artisan migrate --seed
   ```

5. **Install Laravel Breeze**
   ```bash
   composer require laravel/breeze --dev
   php artisan breeze:install blade
   ```

6. **Compile Assets**
   ```bash
   npm run build
   ```

7. **Create Storage Link**
   ```bash
   php artisan storage:link
   ```

8. **Start Development Server**
   ```bash
   php artisan serve
   ```

## Database Structure

### Core Tables
- `users` - Customer and admin accounts
- `categories` - Product categories with hierarchical structure
- `products` - Product catalog with variants and inventory
- `product_images` - Product image management
- `product_categories` - Many-to-many relationship
- `orders` - Order management and tracking
- `order_items` - Individual order line items
- `cart_items` - Shopping cart persistence
- `newsletter_subscribers` - Email marketing list

## Default Users

After running the seeders, you can log in with these test accounts:

**Admin Account:**
- Email: admin@example.com
- Password: password

**Customer Accounts:**
- Email: john@example.com / Password: password
- Email: jane@example.com / Password: password

## Key Routes

### Public Routes
- `/` - Homepage
- `/products` - Product catalog
- `/products/{product}` - Product details
- `/category/{category}` - Category pages
- `/cart` - Shopping cart

### Authentication Required
- `/checkout` - Checkout process
- `/profile` - User profile
- `/orders` - Order history

## Customization

### Brand Configuration
Update `config/app.php` to change the application name:
```php
'name' => env('APP_NAME', 'Your Brand Name'),
```

### Styling
The design uses TailwindCSS with custom components in `resources/css/app.css`. Key design elements:
- Clean, minimalist aesthetic
- Luxury color palette (grays, whites, blacks)
- Elegant typography (Inter + Playfair Display)
- Smooth animations and transitions

### Product Management
Products support:
- Multiple categories
- Size and color variants
- Stock management
- Sale pricing
- Featured products
- SEO meta tags

## Development

### Running in Development
```bash
# Start Laravel development server
php artisan serve

# Watch for asset changes
npm run dev

# Run queue workers (for background jobs)
php artisan queue:work
```

### Testing
```bash
php artisan test
```

## Production Deployment

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false`
3. Configure proper database credentials
4. Run `composer install --optimize-autoloader --no-dev`
5. Run `npm run build`
6. Configure web server (Apache/Nginx)
7. Set up SSL certificate
8. Configure email settings for order confirmations

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
