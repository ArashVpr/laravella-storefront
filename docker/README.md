# Docker Setup for Laravella Storefront

This directory contains Docker configuration files for running the application in containers.

## Quick Start

### Development Environment

```bash
# Copy environment file
cp .env.example .env

# Start all services
docker-compose up -d

# Install dependencies
docker-compose exec app composer install
docker-compose exec app npm install && npm run build

# Run migrations
docker-compose exec app php artisan migrate --seed

# Generate application key
docker-compose exec app php artisan key:generate
```

### Access the Application

- **Application**: http://localhost
- **Horizon Dashboard**: http://localhost/horizon
- **Telescope**: http://localhost/telescope
- **Pulse**: http://localhost/pulse

### Available Services

- **app**: PHP-FPM 8.3 with Laravel
- **nginx**: Nginx web server
- **mysql**: MySQL 8.0 database
- **redis**: Redis for caching and queues
- **horizon**: Laravel Horizon queue worker
- **scheduler**: Laravel task scheduler

## Useful Commands

```bash
# View logs
docker-compose logs -f app

# Run artisan commands
docker-compose exec app php artisan [command]

# Run tests
docker-compose exec app php artisan test

# Access MySQL
docker-compose exec mysql mysql -u laravella_user -p laravella

# Access Redis CLI
docker-compose exec redis redis-cli

# Rebuild containers
docker-compose down
docker-compose build --no-cache
docker-compose up -d

# Stop all services
docker-compose down

# Stop and remove volumes (⚠️ deletes database)
docker-compose down -v
```

## Production Build

Build the production-optimized image:

```bash
docker build -t laravella-storefront:latest .
```

Run production container:

```bash
docker run -d \
  -p 80:80 \
  -e APP_ENV=production \
  -e APP_KEY=your-app-key \
  -e DB_HOST=your-db-host \
  -e DB_DATABASE=your-database \
  -e DB_USERNAME=your-username \
  -e DB_PASSWORD=your-password \
  --name laravella \
  laravella-storefront:latest
```

## Configuration Files

- `Dockerfile`: Multi-stage production build
- `docker-compose.yml`: Local development services
- `docker/php/php.ini`: PHP configuration
- `docker/php/opcache.ini`: OPcache settings
- `docker/nginx/nginx.conf`: Main Nginx config
- `docker/nginx/default.conf`: Site configuration
- `docker/supervisor/supervisord.conf`: Process management

## Troubleshooting

### Permission Issues
```bash
docker-compose exec app chown -R www-data:www-data /var/www/storage
docker-compose exec app chmod -R 755 /var/www/storage
```

### Clear Cache
```bash
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:clear
docker-compose exec app php artisan view:clear
```

### Database Connection Errors
Ensure MySQL is healthy:
```bash
docker-compose ps mysql
docker-compose logs mysql
```

## Health Checks

All services include health checks:
- MySQL: `mysqladmin ping`
- Redis: `redis-cli ping`
- App: `php artisan health:check`

## Performance Optimization

The production Dockerfile includes:
- ✅ Multi-stage builds (smaller image size)
- ✅ OPcache enabled
- ✅ Composer autoload optimization
- ✅ Asset compilation
- ✅ Nginx gzip compression
- ✅ Static file caching headers
- ✅ Supervisor for process management

## Security Features

- ✅ Non-root user (www-data)
- ✅ Security headers (X-Frame-Options, X-Content-Type-Options)
- ✅ Hidden PHP version
- ✅ Restricted .env access
- ✅ Proper file permissions

## CI/CD Integration

Example GitLab CI/GitHub Actions:

```yaml
build:
  script:
    - docker build -t $CI_REGISTRY_IMAGE:$CI_COMMIT_SHA .
    - docker push $CI_REGISTRY_IMAGE:$CI_COMMIT_SHA
```

## Environment Variables

Required environment variables (see `.env.example`):

- `APP_KEY`: Application encryption key
- `DB_*`: Database credentials
- `REDIS_HOST`: Redis hostname
- `MAIL_*`: Mail configuration

## Support

For issues or questions, check:
- Laravel Docker documentation
- Docker Compose documentation
- Project README.md
