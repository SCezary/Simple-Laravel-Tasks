### Hi there!
It is simple Laravel v11 Tasks Project.**

## Installation
1. Install packages
``` bash
composer install && npm install 
```
2. Copy .env.example -> .env and set database environment
```bash
cp .env.example .env
```
3. Generate entryption key
```bash
php artisan key:generate
```
4. Run migrations (create DB if not exists)
``` bash
php artisan migrate
```
5. Start Project in two console instances
```bash
php artisan serve
npm run dev
```
6. Start workers in two console instances
```bash
php artisan schedule:work
php artisan queue:work
```

Mail scheduler is set every 1 minute.

## Docker Installation
#### Optional Installation - should work.
#### http://laravel-tasks.localhost <- Default APP_URL
1. Copy .env.docker.example -> .env
```bash
cp .env.docker.example .env
```
2. Generate entryption key
```bash
php artisan key:generate
```
3. Build docker containers
```bash
docker compose build
```
4. Run docker containers
```bash
docker compose up
```
5. Get in to container
```
docker exec -it app bash
```
6. Run migrations (create DB if not exists)
``` bash
php artisan migrate
```
7. Start vite
```bash
npm run dev
```
8. Get in to container and run in each console instance
```bash
php artisan schedule:work
php artisan queue:work
```
9. Set in hosts (example /etc/hosts)
```
127.0.0.1 http://laravel-tasks.localhost
```

All docker files/configs are located in /docker directory.

_**Versions used:**_
```
PHP 8.4
NODE 24.1.0
NPM 11.3.0
COMPOSER 2.8.3
```
