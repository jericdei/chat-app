# Chat App

A simple real-time chat application using [Laravel Reverb](https://reverb.laravel.com/).

## Running Locally

### Lando

This project has a configuration for [Lando](https://lando.dev/) to easily spin up Docker containers that are needed to run this application. If you have Lando installed on your machine, you can build and run the containers using the following steps:

Build the containers

```bash
lando start
```

Install Composer and Bun dependencies

```bash
lando composer install
lando bun install
```

Setup Laravel

```bash
cp. env.example .env

lando artisan key:generate

lando artisan migrate:fresh --seed
```

Make sure to generate your own Reverb Credentials and update your `.env` file

```env
REVERB_APP_ID={my-app-id}
REVERB_APP_KEY={my-app-key}
REVERB_APP_SECRET={my-app-secret}
```

Run the Vite development server

```bash
lando dev
```

### LAMP

If you don't have Lando setup and just want to run this locally in your machine:

#### Requirements

-   Linux/Mac or WSL if Windows
-   PHP 8.2 or higher
-   Composer
-   Web Server (Nginx/Apache) or just `php artisan serve` to serve the app
-   Supervisor (Optional)
-   MySQL Server
-   Bun

<br />

Install Composer and Bun dependencies

```bash
composer install
bun install
```

Setup Laravel

```bash
cp. env.example .env

php artisan key:generate

# Make sure to configure your correct database credentials
# first before running this
php artisan migrate:fresh --seed
```

Make sure to generate your own Reverb Credentials and update your `.env` file

```env
REVERB_APP_ID={my-app-id}
REVERB_APP_KEY={my-app-key}
REVERB_APP_SECRET={my-app-secret}
```

##### If you have Supervisor installed, you can use the configuration file:

```bash
# Make sure to replace all `/path/to/project`
# to the correct path of your project before copying.
sudo cp .config/supervisor.conf /etc/supervisor/conf.d/supervisor.conf
```

Run Supervisor service together with the queue and Reverb services

```bash
sudo service supervisor start

sudo supervisorctl start laravel-queue:*
sudo supervisorctl start laravel-reverb:*
```

##### If you don't have or don't want to use Supervisor:

```bash
# Separate terminal session
php artisan queue:work

# Separate terminal session
php artisan reverb:start
```

Run the Vite development server

```bash
bun run dev
```
