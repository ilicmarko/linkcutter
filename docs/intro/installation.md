# Installation

As this is a Laravel project it uses Homestead, therefore the setup is standard.

1. Clone repository.
2. Create a copy of `.env.example` file, rename it to `.env` and input your own values.
3. Run `composer install` to install dependencies.
4. Run `php vendor/bin/homestead make` to generate Vagrantfile and Homestead.yaml configuration.
    (see [Laravel Homestead](https://laravel.com/docs/5.8/homestead)).
5. Edit Homestead.yaml in order to setup project URL.
6. Run `vagrant up` to start virtual machine.
7. Run `vagrant ssh` to connect to virtual machine.
8. Go to `/vagrant` directory.
9. Run `php artisan storage:link` to create symbolic link in public folder, pointing to actual file storage folder.
10. Run `php artisan migrate` to create database tables.
11. Run `php artisan db:seed` to insert test data.
12. Run `npm install` to fetch frontend dependencies.
13. Run `npm run dev` to build frontend assets.
