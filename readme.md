# E-Commerce Platform Built with Laravel 5.7
> Note: This application is still in the early stages of development, for the latest changes check the deveopment branch. 

## Installation

### For Docker Users:
If you are a docker user you may easily spin up this project without installing any additional software to your machine.  

### Step 1: 
Clone my docker build directory found here https://github.com/ko1eda/build into the same root directory you intend to clone the project. 
```
git clone git@github.com:ko1eda/build.git

cd build

```

### Step 2:

Edit the docker-compose.dev.yml file to suit your needs specifcially
> Note: You may want to change the restart policy for each service to unless-stopped

```
version : '3'

services : 
  nginx:
    build: 
      context: ./nginx
      dockerfile: DockerFile
    image: <name_space>/nginx:1.0.0
    volumes: 
      - <path/to/app/directory/>:/var/www/html
    ports:
      - 80:80
    networks: 
      - appnet
    depends_on:
      - php-fpm
    restart: unless-stopped

```

### Step 3: 
To use the Money package that is utizalized by this application add this to the DockerFile found in the .php directory above where it stays WORKDIR

```
RUN apt-get update && apt-get install php7.2-intl php7.2-bcmath

WORKDIR /var/www/html
```


### Step 4
Follow the additional steps from regular installation (up to Step 2), noting any mentioned differences for docker users. Once you have completed all those instructions run the following commands. 

``` cd build && docker-compose -f docker-compose.dev.yml up -d php-fpm mysql redis nginx ```


Finally run 

``` 
docker ps 

docker exec -it <container_id_php-fpm> bash

php artisan migrate 
```

### Important Note:
Nuxt.js the frontend of this application currently has issues running its dev server inside a docker container [See Here](https://github.com/nuxt/nuxt.js/issues/4543).

Luckily there is no extra setup required to connect between Nuxt running uncontainerized on your development machine. 


---

### Regular Installation

### Step 1: 
Clone the project to your development machine, cd into the project directory and install all composer dependencies. You will also need to generate an application key.

```
git clone git@github.com:ko1eda/e-commerce-api.git

cd e-commerce-api

composer install

php artisan generate:key

```
### Step 2: 
Initialize the relevant services insert the relevant information into the projects included .env.example file, when you are finished rename the file to .env

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=test_db
DB_USERNAME=root
DB_PASSWORD=root
```

> Note: If you are using docker you would use container hostnames instead of the local loopback address for _HOST fields

```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=test_db
DB_USERNAME=root
DB_PASSWORD=root
```

### Step 3: 
After creating and wiring up your database you must then run all the included migration files

``` php artisan migrate ```