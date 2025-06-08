# Installation and Integration Guide

## System Requirements

### Server Requirements
- PHP 8.1 or higher
- MySQL 8.0+ or PostgreSQL 13+
- Node.js 16+ and NPM
- Redis Server
- Elasticsearch 8.x
- Composer 2.x

### PHP Extensions
```bash
# Required PHP extensions
php-curl
php-dom
php-gd
php-json
php-mbstring
php-xml
php-zip
php-redis
php-pgsql # If using PostgreSQL
php-mysql # If using MySQL
```

## Installation Steps

### 1. Clone Repository and Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install

# Build assets
npm run build
```

### 2. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate

# Configure environment variables
APP_NAME=ProjectManagement
APP_ENV=production
APP_DEBUG=false

# Database configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pms
DB_USERNAME=development
DB_PASSWORD=Development01

# Redis configuration
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# WebSocket configuration
PUSHER_APP_ID=local
PUSHER_APP_KEY=local
PUSHER_APP_SECRET=local
PUSHER_HOST=127.0.0.1
PUSHER_PORT=6001
PUSHER_SCHEME=http
PUSHER_APP_CLUSTER=mt1

# Elasticsearch configuration
SCOUT_DRIVER=elasticsearch
ELASTICSEARCH_HOST=http://localhost:9200
ELASTICSEARCH_INDEX=laravel

# File storage configuration
FILESYSTEM_DISK=local
```

### 3. Database Setup

```bash
# Run database migrations
php artisan migrate

# Seed initial data
php artisan db:seed
```

### 4. Storage Setup

```bash
# Create storage symlinks
php artisan storage:link

# Set directory permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 5. WebSocket Server Setup

```bash
# Install WebSocket server
composer require beyondcode/laravel-websockets

# Publish WebSocket configuration
php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="config"

# Start WebSocket server
php artisan websockets:serve
```

### 6. Elasticsearch Setup

```bash
# Install and configure Elasticsearch
curl -fsSL https://artifacts.elastic.co/GPG-KEY-elasticsearch | sudo gpg --dearmor -o /usr/share/keyrings/elastic.gpg

# Add Elasticsearch repository
echo "deb [signed-by=/usr/share/keyrings/elastic.gpg] https://artifacts.elastic.co/packages/8.x/apt stable main" | sudo tee /etc/apt/sources.list.d/elastic-8.x.list

# Install Elasticsearch
sudo apt update && sudo apt install elasticsearch

# Start Elasticsearch service
sudo systemctl start elasticsearch
sudo systemctl enable elasticsearch

# Configure Laravel Scout
php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"

# Import existing data to Elasticsearch
php artisan scout:import "App\Models\Project"
```

### 7. Queue Worker Setup

```bash
# Configure queue connection in .env
QUEUE_CONNECTION=redis

# Start queue worker
php artisan queue:work --queue=high,default,low

# For production, set up supervisor
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path/to/project/artisan queue:work --queue=high,default,low --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=8
redirect_stderr=true
stdout_logfile=/path/to/project/storage/logs/worker.log
stopwaitsecs=3600
```

### 8. Scheduled Tasks Setup

```bash
# Add cron entry
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1

# Verify schedule
php artisan schedule:list
```

### 9. Media Library Setup

```bash
# Install media library
composer require spatie/laravel-medialibrary

# Publish configuration
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="config"

# Run migrations
php artisan migrate
```

### 10. Export Functionality Setup

```bash
# Install Excel and PDF packages
composer require maatwebsite/excel
composer require dompdf/dompdf

# Publish Excel configuration
php artisan vendor:publish --provider="Maatwebsite\Excel\ExcelServiceProvider" --tag="config"
```

## Integration Testing

### 1. WebSocket Testing
```bash
# Start WebSocket server
php artisan websockets:serve

# Test connection
wscat -c ws://localhost:6001
```

### 2. Elasticsearch Testing
```bash
# Verify Elasticsearch connection
curl http://localhost:9200

# Test search functionality
php artisan scout:flush "App\Models\Project"
php artisan scout:import "App\Models\Project"
```

### 3. Queue Testing
```bash
# Test queue processing
php artisan queue:listen

# Monitor failed jobs
php artisan queue:failed
```

## Security Checklist

1. File Permissions
```bash
# Set proper permissions
find /path/to/project -type f -exec chmod 644 {} \;
find /path/to/project -type d -exec chmod 755 {} \;
```

2. Environment Security
```bash
# Secure environment file
chmod 600 .env

# Generate strong APP_KEY
php artisan key:generate
```

3. Database Security
```bash
# Create dedicated database user
CREATE USER 'project_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT SELECT, INSERT, UPDATE, DELETE ON project_management.* TO 'project_user'@'localhost';
```

## Monitoring Setup

### 1. Laravel Telescope (Development)
```bash
# Install Telescope
composer require laravel/telescope --dev

# Publish assets
php artisan telescope:install
php artisan migrate
```

### 2. Error Tracking
```bash
# Configure logging
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# Set up daily log rotation
LOG_CHANNEL=daily
```

## Backup Configuration

```bash
# Install backup package
composer require spatie/laravel-backup

# Publish configuration
php artisan vendor:publish --provider="Spatie\Backup\BackupServiceProvider"

# Configure backup settings in config/backup.php

# Test backup
php artisan backup:run

# Set up backup schedule in app/Console/Kernel.php
$schedule->command('backup:clean')->daily()->at('01:00');
$schedule->command('backup:run')->daily()->at('02:00');
```

## Production Deployment Checklist

1. Environment Configuration
```bash
APP_ENV=production
APP_DEBUG=false
```

2. Cache Configuration
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

3. Optimize Autoloader
```bash
composer install --optimize-autoloader --no-dev
```

4. Queue Worker Configuration
```bash
# Set up supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```

5. WebSocket Configuration
```bash
# Configure SSL for WebSocket server
LARAVEL_WEBSOCKETS_SSL_LOCAL_CERT=/path/to/ssl/cert.pem
LARAVEL_WEBSOCKETS_SSL_LOCAL_PK=/path/to/ssl/key.pem
```

## Maintenance Commands

```bash
# Clear application cache
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear

# Clear compiled classes
php artisan clear-compiled

# Rebuild class loader
composer dump-autoload

# Update database schema
php artisan migrate

# Check for failed jobs
php artisan queue:failed

# Monitor WebSocket connections
php artisan websockets:statistics
```


Pusher Installation:
KEY: ACr_yxblMCa6MjCd1pQM0wpIO-Qu4lgMnfpOTqyFVSw