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

-   PHP 8.2 or higher
-   Composer
-   Web Server (Nginx/Apache) or just `php artisan serve` to serve the app
-   Supervisor
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

Run the Vite development server

```bash
bun run dev
```
