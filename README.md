# Restfony 
Simple REST interface built on Synfony 4.1

------------

### Features
* RESTfull API
* JSON Response
* HTTP Status
* Exception Handling
* Doctrine ORM

### Installation
Download or Clone this repo
```
git clone https://github.com/shuhailshuvo/Restfony.git
```
Install Dependency

```
composer install
```

Configure Databse in `.env` file

```
DATABASE_URL="mysql://USER:PASS@HOST:PORT/DB"
```

Create Database

```
php bin/console doctrine:database:create
```

Database Migration

```
php bin/console doctrine: migrations: migrate
```

Run the API service

```
php bin/console server:run
```

Download the Postman Collection

[![Download](https://addons-media.operacdn.com/media/extensions/45/130645/1.0.8-rev1/icons/icon_64x64_f5afb36b86cd5d8f4b5de581d6d0da2b.png)](https://www.getpostman.com/collections/4139657aad11d5e1e753 "Download")


### TODO
* Custom Validator
* Custom Exception Handler
* Functional Testing
* JWT
* CORS
