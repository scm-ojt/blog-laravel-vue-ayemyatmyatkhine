# NuxtOjt Project
## Requirements
- php 8.0
- Apache
- MySQL 8.0.29
- Composer 2.4.1
- Laravel 9.37.0
- npm 6.14.8
## Installation
Please check the official laravel installation guide for server requirements before you start.
Official Documentation
## Clone the repository
git clone https://github.com/scm-ojt/blog-laravel-vue-ayemyatmyatkhine.git
## Install all the dependencies
- Copy the example env file and make the required configuration changes in the .env file
  - cp .env.example .env
- Generate a new application key 
  - php artisan key:generate
- Run the database migrations (Set the database connection in .env before migrating)
  - php artisan migrate
- Start the local development server
  - php artisan serve
- cd nuxt-app
  - npm install
  - npm run dev
- Use ```http://localhost:3000/``` to run nuxt 
