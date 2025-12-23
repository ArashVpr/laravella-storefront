# 🚀 Quick Reference Card

## Most Important Commands

### Daily Development
```bash
# Start local server
php artisan serve

# Run Horizon (queue worker)
php artisan horizon

# Run tests
./vendor/bin/pest --parallel

# Check code quality
./vendor/bin/phpstan analyse
```

### Monitoring Dashboards
- **Telescope** (local debug): `http://localhost/telescope`
- **Pulse** (metrics): `http://localhost/pulse`
- **Horizon** (queues): `http://localhost/horizon`
- **API Docs**: `http://localhost/api/documentation`

### Docker
```bash
# Start everything
docker-compose up -d

# Stop everything
docker-compose down

# View logs
docker-compose logs -f app

# Execute commands in container
docker-compose exec app php artisan migrate
```

### Testing
```bash
# Run all tests
./vendor/bin/pest

# With coverage
./vendor/bin/pest --coverage --min=70

# Specific test
./vendor/bin/pest tests/Feature/HomePestTest.php

# Static analysis
./vendor/bin/phpstan analyse

# Code style
./vendor/bin/pint
```

### API Testing
```bash
# Login
curl -X POST http://localhost:8000/api/v1/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'

# List cars
curl http://localhost:8000/api/v1/cars

# With auth
curl http://localhost:8000/api/v1/user \
  -H "Authorization: Bearer YOUR_TOKEN"
```

### Queue & Jobs
```bash
# Test job dispatch
php artisan tinker
>>> App\Jobs\ProcessCarImages::dispatch(App\Models\Car::first());
>>> exit

# View logs
tail -f storage/logs/laravel.log

# Failed jobs
php artisan queue:failed
php artisan queue:retry all
```

### Cache & Optimization
```bash
# Clear everything
php artisan optimize:clear

# Optimize for production
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Git & Deployment
```bash
# Commit changes
git add .
git commit -m "feat: your changes"
git push origin main

# Create release (triggers deployment)
git tag -a v1.0.0 -m "Version 1.0.0"
git push origin v1.0.0

# Manual deployment via GitHub Actions:
# Go to Actions → Deploy to Production → Run workflow
```

## File Locations

### Configuration
- Redis/Queue: `.env`
- PHPStan: `phpstan.neon`
- Docker: `docker-compose.yml`, `Dockerfile`
- CI/CD: `.github/workflows/*.yml`

### API
- Routes: `routes/api.php`
- Controllers: `app/Http/Controllers/Api/V1/`
- Resources: `app/Http/Resources/`
- Documentation: `API.md`

### Background Jobs
- Jobs: `app/Jobs/`
- Horizon config: `config/horizon.php`
- Supervisor: `docker/supervisor/supervisord.conf`

### Monitoring
- Telescope: `config/telescope.php`
- Pulse: `config/pulse.php`
- Horizon: `config/horizon.php`

### Tests
- Pest config: `tests/Pest.php`
- Feature tests: `tests/Feature/`
- Unit tests: `tests/Unit/`

## Environment Variables

### Redis & Queues
```env
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

QUEUE_CONNECTION=redis
CACHE_STORE=redis
SESSION_DRIVER=redis
```

### API
```env
SANCTUM_STATEFUL_DOMAINS=localhost,127.0.0.1
```

## GitHub Actions Secrets

Required for deployment:
- `SSH_HOST` - Server IP/domain
- `SSH_USERNAME` - SSH username
- `SSH_PORT` - SSH port (usually 22)
- `SSH_KEY` - Private SSH key

## Troubleshooting Quick Fixes

### Horizon not working?
```bash
redis-cli ping  # Check Redis
php artisan horizon:terminate
php artisan horizon
```

### Tests failing?
```bash
php artisan config:clear
./vendor/bin/pest --parallel
```

### Docker issues?
```bash
docker-compose down -v
docker-compose up -d --build
```

### Telescope blank?
```bash
php artisan telescope:clear
php artisan migrate
```

### API returning 500?
```bash
php artisan optimize:clear
tail -f storage/logs/laravel.log
```

## Port Reference

- **8000** - Laravel app (php artisan serve)
- **80** - Docker nginx
- **3306** - MySQL
- **6379** - Redis
- **5173** - Vite dev server

## Key Documentation

1. [MODERNIZATION.md](MODERNIZATION.md) - What was implemented
2. [VERIFICATION.md](VERIFICATION.md) - How to test everything
3. [API.md](API.md) - Complete API documentation
4. [.github/workflows/README.md](.github/workflows/README.md) - CI/CD setup

## Quick Health Check

Run this to verify everything works:
```bash
php artisan --version         # Laravel working?
redis-cli ping                # Redis up? (should return PONG)
./vendor/bin/pest            # Tests pass?
./vendor/bin/phpstan analyse # Static analysis works?
docker-compose ps            # All services running?
```

## Production Deployment Checklist

Before deploying:
- [ ] All tests pass: `./vendor/bin/pest`
- [ ] PHPStan clean: `./vendor/bin/phpstan analyse`
- [ ] Code style good: `./vendor/bin/pint --test`
- [ ] .env configured correctly
- [ ] Database backed up
- [ ] GitHub secrets added

## Resources

- Laravel Docs: https://laravel.com/docs
- Pest PHP: https://pestphp.com
- PHPStan: https://phpstan.org
- Docker: https://docs.docker.com
- GitHub Actions: https://docs.github.com/actions

---

**Save this file for quick reference!** 📌
