# Quick Start

To get started with LinkCutter is pretty simple, as it is a Laravel application.

## Setup Development Environment

1. Clone repository.
2. Run `composer install` to install dependencies.
3. Create a copy of `.env.example` file, rename it to `.env` and input your own values.
4. Run `php vendor/bin/homestead make` to generate Vagrantfile and Homestead.yaml configuration
    (see [Laravel Homestead](https://laravel.com/docs/5.6/homestead)).
5. Edit Homestead.yaml in order to setup project URL.
6. Add vagrant IP to hosts file.
7. Run `vagrant up` to start virtual machine.
8. Run `vagrant ssh` to connect to virtual machine.
9. Go to `/vagrant` directory.
10. Run `php artisan key:generate` to generate random crypto key.
11. Run `php artisan storage:link` to create symbolic link in public folder, pointing to actual file storage folder.
12. Run `php artisan migrate` to create database tables.
13. Run `php artisan db:seed` to insert test data.


> Please note that the seeding process will take some time. Because the visitors for the links need to be
created after the link, therefore bulk insert is not possible.

### Login credentials

After the setup is finished you will have one admin user in your database:

**Username**: `admin@admin.io`<br>
**Password**: `admin`
