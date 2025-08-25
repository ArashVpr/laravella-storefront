# car-hub.xyz

![Laravel Logo](https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg)

## Overview

car-hub.xyz is a Laravel-based web application for managing cars, their features, user authentication, watchlists, and more. It leverages Laravel's Eloquent ORM, Blade templates, and Sanctum for API authentication.

## Features

-   Car management: add, edit, delete, and view cars
-   Manage car features and images
-   User authentication (login, signup, password reset, OAuth via Google/Facebook)
-   Watchlist: add/remove cars
-   Profile management
-   Search and filter cars
-   Admin panel (Filament)

## Accessibility

-   Semantic HTML for screen readers
-   High color contrast and readable font sizes
-   Keyboard-accessible navigation
-   Properly labeled forms and error messages
-   Responsive design for all devices

## Database Structure

Main tables:

-   `users`: User information
-   `cars`: Car details
-   `car_features`: Features for each car
-   `car_images`: Image paths for cars
-   `favorite_cars`: User watchlist
-   `personal_access_tokens`: API authentication

## Testing

Feature tests cover authentication, signup, car CRUD, watchlist, profile, password reset, and homepage display.

**Main Feature Tests:**

-   AuthTest
-   SignupTest
-   WatchlistTest
-   CarTest
-   ProfileTest
-   PasswordResetTest
-   HomeTest

Run all tests:

```bash
php artisan test
```

## Installation

1. Clone the repository
2. Install dependencies:
    - `composer install`
    - `npm install`
3. Copy `.env.example` to `.env`
4. Generate app key: `php artisan key:generate`
5. Configure your database in `.env` and run migrations: `php artisan migrate --seed`
6. Build frontend assets: `npm run dev`
7. Start the server: `php artisan serve`

## Configuration

-   Set environment variables in `.env` for database, mail, and third-party services
-   Configure queues in `config/queue.php`

## Deployment

Uses GitHub Actions for CI/CD. See `.github/workflows/deploy.yml` for workflow details.

## Documentation

See [`resources/views/components/documentation.blade.php`](resources/views/components/documentation.blade.php) for full documentation.

## License

MIT

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
