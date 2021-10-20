## About Project

This project is developed for senior PHP developer practical test.

## Technologies
- PHP
- Laravel
- Mysql
- Docker
- VueJs
- Redis

## Installation Process
*Please install Docker before start.

- __Step 1:__ Clone the project
    > git clone --recurse-submodules https://github.com/akandeBolaji/ssp-demo.git
- __Step 2:__ For getting into project directory run  
    > cd ssp-demo
- __Step 3:__ Now create environment file
    > cp .env.example .env
- __Step 4:__ Now setup database configuration into .env
    > sudo nano .env

        DB_CONNECTION=mysql
        DB_HOST=mysql
        DB_PORT=3306
        DB_DATABASE=ssp_demo
        DB_USERNAME=root
        DB_PASSWORD=root
        REDIS_HOST=redis
- __Step 5:__ For get into project docker directory run  
    > cd laradock
- __Step 6:__ Create docker environment file by copying env-example file to .env 
    > cp env-example .env
- __Step 7:__ Set same db credential in docker environment file.
    > nano .env
  
        MYSQL_VERSION=latest
        MYSQL_DATABASE=ssp_demo
        MYSQL_USER=default
        MYSQL_PASSWORD=root
        MYSQL_PORT=3306
        MYSQL_ROOT_PASSWORD=root
        MYSQL_ENTRYPOINT_INITDB=./mysql/docker-entrypoint-initdb.d
- __Step 8:__ Now build docker
    > docker-compose up -d nginx mysql redis
- __Step 14:__ Now login into workspace container for application setup
    > docker exec -it laradock_workspace_1 bash
- __Step 15:__ Download laravel dependencies 
    > composer install
- __Step 16:__ Now create environment key for laravel
    > php artisan key:generate
- __Step 17:__ Create soft link with storage folder 
    > php artisan storage:link
- __Step 18:__ Give required permissions to create dummy images during seed
    > sudo chmod -R 755 storage
- __Step 18:__ Run migration with seed
    > php artisan migrate:fresh --seed
- __Step 17:__ Now browse http://localhost/ for application
- __Step 18:__ For system test 
    > php artisan test



