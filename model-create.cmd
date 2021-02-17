@echo off

:: Create Model and Migration
php artisan make:model %1 -m

:: Create API Controller
php artisan make:controller %1Controller --api --model=%1

:: Create Resource
php artisan make:resource %1Resource

:: Create Form Requests
php artisan make:request %1/%1IndexRequest
php artisan make:request %1/%1StoreRequest
php artisan make:request %1/%1ShowRequest
php artisan make:request %1/%1UpdateRequest
php artisan make:request %1/%1DestroyRequest

:: Create Factory
php artisan make:factory %1Factory --model=%1

:: Create Test
php artisan make:test %1Test
