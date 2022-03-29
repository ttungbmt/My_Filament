# My_Filament

## Packages
- filament/filament
- owenvoke/blade-fontawesome

## Get started

```shell
docker-compose exec --user=laradock workspace zsh
cd My_Filament
composer create-project laravel/laravel laravel-app
cd laravel-app
composer require filament/filament
```

Setup database

```shell
php artisan make:filament-user
php artisan vendor:publish --tag=filament-config
php artisan vendor:publish --tag=filament-translations
```