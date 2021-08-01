# Stripe Setup Instruction

## Server Requirements
```
PHP >= 8.0
```

# Getting started

## Installation

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/8.x)

Alternative installation is possible without local dependencies relying on [Docker](#docker). 

Clone the repository

    git@github.com:buhahemal/stripe.git
Switch to the repo folder

    cd stripe

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    PHP artisan key:generate

Run the setup database migrations & sedding command (**Set the database connection in .env before migrating**)

    PHP artisan redeploy

Start the local development server

    go to localhost/stripe
