# progressive seeder

## About the package

Progressive seeder is a simple laravel package that monitors seeders on a Laravel project.

To run a seeder in the laravel you need to run the all seeders file which is usually run in the initialization of a project
or to run each seeder using this command

`php artisan db:seed --class=ClassName`

Imagine having a project that you need to run a lot of seeders after updating the project, 
it will be tedious to do for each seeder that command in the production.

This package saves the seeder classes run by the project, and it runs automatically only the newest seeders.

Also, this package helps to keep track of what seeders are already run.

## Install on laravel project

`composer require elison/progressive-seeder`

### Add the provider in the app.php

`config/app.php`

`\Elison\ProgressiveSeeder\ProgressiveSeederProvider::class`

### Add the table that saves the history of seeders that are already run

`php artisan migrate`

### Example

#### Add seeders that already run before installation or seeders to be skipped from the automatic command

`php artisan progressive-seeder:run UsersPermissionsSeeder`

#### Run the newest seeders automatically

`php artisan progressive-seeder:run`
