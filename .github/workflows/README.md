# GitHub Actions CI/CD Setup

This directory contains GitHub Actions workflows for continuous integration and deployment.

## Workflows

### 1. CI Pipeline (`ci.yml`)
Runs on every push and pull request to `main` and `develop` branches.

**Jobs:**
- **Code Quality**: Runs PHPStan static analysis and Laravel Pint code style checks
- **Tests**: Executes Pest PHP test suite with coverage reporting (70% minimum)
- **Security**: Audits PHP and Node dependencies for vulnerabilities
- **Build**: Compiles frontend assets with Vite
- **Docker**: Builds Docker image (only on main branch)
- **Notify**: Reports overall pipeline status

**Services:**
- MySQL 8.0
- Redis (Alpine)

**Requirements:**
- All jobs must pass for merge
- PHPStan Level 6 must pass without errors
- Test coverage must be ≥70%

### 2. API Tests (`api-tests.yml`)
Runs when API-related files change.

**Jobs:**
- **API Tests**: Unit tests for API endpoints
- **Integration Tests**: End-to-end API testing with curl
- **Documentation Check**: Validates API.md and Scramble config
- **Performance Test**: Apache Bench load testing

**Triggers:**
- Changes to `app/Http/Controllers/Api/**`
- Changes to `app/Http/Resources/**`
- Changes to `routes/api.php`
- Changes to `tests/Feature/Api/**`
- Manual workflow dispatch

### 3. Deployment (`deploy.yml`)
Deploys to production server.

**Jobs:**
- **Pre-Deployment Checks**: Verifies CI passed
- **Database Backup**: Creates timestamped MySQL dump (keeps 7 days)
- **Deploy**: Zero-downtime deployment with maintenance mode
- **Post-Deployment**: Verification checks
- **Rollback**: Automatic rollback on failure

**Triggers:**
- GitHub Release created
- Manual workflow dispatch

**Deployment Steps:**
1. Enable maintenance mode
2. Pull latest code from main/tag
3. Install dependencies (Composer + npm)
4. Build frontend assets
5. Run database migrations
6. Optimize caches
7. Restart queue workers
8. Disable maintenance mode
9. Verify deployment health

## Required GitHub Secrets

### For CI Workflow
No secrets required (uses public runners)

### For Deployment Workflow
```
SSH_HOST           # Your server IP or domain
SSH_USERNAME       # SSH username
SSH_PORT           # SSH port (usually 22)
SSH_KEY            # Private SSH key for authentication
```

### Optional Secrets
```
CODECOV_TOKEN      # For coverage reporting to Codecov
```

## Setup Instructions

### 1. Enable GitHub Actions
GitHub Actions are automatically enabled for this repository.

### 2. Configure Deployment Secrets
Go to **Settings → Secrets and variables → Actions** and add:

```bash
# SSH connection details
SSH_HOST: your-server.com
SSH_USERNAME: your-username
SSH_PORT: 22
SSH_KEY: -----BEGIN OPENSSH PRIVATE KEY-----
...your private key...
-----END OPENSSH PRIVATE KEY-----
```

### 3. Server Requirements

Your server must have:
- PHP 8.3+ with required extensions
- Composer
- Node.js 20+
- MySQL 8.0+
- Redis
- Git
- Supervisor (for Horizon)

### 4. Server Directory Structure

```
/home/your-username/
├── backups/                    # Database backups
└── htdocs/
    └── srv813866.hstgr.cloud/  # Your app directory
        ├── .env
        ├── composer.json
        ├── package.json
        └── ...
```

### 5. Server Permissions

Ensure the deployment user has:
```bash
# Write access to storage and cache
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Ability to restart PHP-FPM (add to sudoers)
your-username ALL=(ALL) NOPASSWD: /usr/sbin/service php8.3-fpm restart
```

### 6. Manual Deployment Trigger

To manually trigger a deployment:

1. Go to **Actions** tab
2. Select **Deploy to Production**
3. Click **Run workflow**
4. Choose environment (production/staging)
5. Click **Run workflow**

## Workflow Status Badges

Add to your README.md:

```markdown
![CI Pipeline](https://github.com/YOUR-USERNAME/laravella-storefront/workflows/CI%20Pipeline/badge.svg)
![API Tests](https://github.com/YOUR-USERNAME/laravella-storefront/workflows/API%20Tests/badge.svg)
![Deploy](https://github.com/YOUR-USERNAME/laravella-storefront/workflows/Deploy%20to%20Production/badge.svg)
```

## Local Testing

### Test CI workflow locally with act
```bash
# Install act
brew install act  # macOS
# or
curl https://raw.githubusercontent.com/nektos/act/master/install.sh | sudo bash

# Run workflows
act push
act pull_request
```

### Run tests locally
```bash
# Code quality
./vendor/bin/phpstan analyse
./vendor/bin/pint --test

# Tests
./vendor/bin/pest --parallel --coverage

# Security
composer audit
npm audit
```

## Troubleshooting

### CI fails with "PHPStan errors"
Run locally: `./vendor/bin/phpstan analyse`
Fix reported type issues

### Tests fail in CI but pass locally
- Check database seeding
- Verify Redis connection
- Check environment variables

### Deployment fails
1. Check SSH connection: `ssh user@host`
2. Verify secrets are correct
3. Check server disk space: `df -h`
4. Review deployment logs in Actions tab

### Rollback needed
Workflow automatically rolls back on failure.
Manual rollback:
```bash
ssh user@host
cd htdocs/srv813866.hstgr.cloud
git reset --hard HEAD~1
composer install
npm ci && npm run build
php artisan optimize
php artisan up
```

## Best Practices

1. **Never commit secrets** - Use GitHub Secrets
2. **Test locally first** - Run tests before pushing
3. **Use feature branches** - Protect main branch
4. **Review PHPStan errors** - Keep code quality high
5. **Monitor deployments** - Check post-deployment verification
6. **Keep backups** - Deployment creates automatic DB backups

## Maintenance

### Update PHP version
Edit `.github/workflows/ci.yml` and `deploy.yml`:
```yaml
php-version: '8.3'  # Change to desired version
```

### Update Node version
```yaml
node-version: 23  # Change to desired version
```

### Adjust test coverage threshold
In `ci.yml`:
```yaml
run: ./vendor/bin/pest --parallel --coverage --min=70  # Change 70 to desired %
```

## Resources

- [GitHub Actions Documentation](https://docs.github.com/en/actions)
- [Laravel Deployment](https://laravel.com/docs/11.x/deployment)
- [PHPStan Documentation](https://phpstan.org/user-guide/getting-started)
- [Pest PHP Documentation](https://pestphp.com/docs)
