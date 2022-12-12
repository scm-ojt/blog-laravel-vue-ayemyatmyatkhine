# NuxtOjt Project
## Requirements
- php 8.0
- Apache
- MySQL 8.0.29
- Composer 2.4.1
- Laravel 9.37.0
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
- php artisan storage:link
- Start the local development server
  - php artisan serve
- cd nuxt-app
  - npm install
  - npm run dev
- Use ```http://localhost:3000/``` to run nuxt 

![Screenshot 2022-12-12 113745](https://user-images.githubusercontent.com/97345280/206989408-1a983f29-5f4a-4366-b84c-f4dd38fa0880.png)

![Screenshot 2022-12-12 114110](https://user-images.githubusercontent.com/97345280/206989478-eca9e20d-ca6c-4c08-9181-e40d21fa8b01.png)

![Screenshot 2022-12-12 141335](https://user-images.githubusercontent.com/97345280/206989543-cffa25a3-98d7-4f45-ab51-b33410ed0f58.png)
