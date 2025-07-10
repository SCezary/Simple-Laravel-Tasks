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
