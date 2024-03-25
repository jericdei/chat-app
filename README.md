# Chat App

A simple real-time chat application using [Laravel Reverb](https://reverb.laravel.com/).

## Running Locally
This project uses [Lando](https://lando.dev/) to easily spin up Docker containers that are needed to run this application. If you have Lando installed on your machine, you can build the containers using this command:
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
