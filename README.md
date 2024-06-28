<p align="center">
    <picture>
      <source media="(prefers-color-scheme: dark)" srcset="https://jaya.tech/images/logo-white.png" />
      <source media="(prefers-color-scheme: light)" srcset="https://jaya.tech/images/logo-black.png" />
      <img alt="logo" src="https://jaya.tech/images/logo-black.png" />
    </picture>
</p>

## Table of contents
* [Getting Started](#getting-started)
  * [API](#api)
      * [Swagger](#swagger)
          * [api-docs.json](#api-docsjson)
          * [Swagger UI](#swagger-ui)
  * [CLI](#cli)
  * [Online Demo](#online-demo)
* [Install](#install)
  * [Config](#config)
* [Test](#test)
* [Technologies](#technologies)
  
## Getting Started
**Jaya Exchange** it's a currency exchange rates Rest API wrote using PHP and the Laravel framework.

To access real-time exchange rates we use the [Exchange Rates Api](https://exchangeratesapi.io/) and we support **all** currencies supported by then.

The code is divided in model, view, control and service layers. 

The transactions resource is the main and only one available via api. For simplicity there's no endpoint to manipulate users, when creating a transaction the user is also created case not found.

Thanks to database limitations the maximum digits limit used on the application numbers it's 13, any digits beyond are rounded using the [half to even rule](https://www.php.net/manual/en/function.round.php).

### API
Our API counts with the following endpoints:

- \[POST\] **/transactions** - Create a transaction
- \[​GET\] **/transactions/{user_id}** - User transactions paginated list

Default base url: [http://localhost](http://localhost)

The API full documentation it's available via [Swagger](https://swagger.io/) as shown below.

#### Swagger
The API documentation it's delivered using [Swagger](https://swagger.io/) and you have two ways to access it:

##### api-docs.json
The json file with the OpenAPI specification: [api-docs.json](https://raw.githubusercontent.com/gabriel2m/jaya-credit-card-payment/master/storage/api-docs/api-docs.json)

##### Swagger UI
The [Swagger UI](https://swagger.io/tools/swagger-ui/) web interface that allows to visualize and interact with the API’s resources who the default url is: [http://localhost](http://localhost)

### CLI
For the docker environment and cli commands we use [Sail](https://laravel.com/docs/11.x/sail). 

To see the commands list run:
```sh
./vendor/bin/sail
```
In case you want to configure a shell alias:
```sh
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```
Start application command:
```sh
./vendor/bin/sail up -d
```
For more details access the sail [documentation](https://laravel.com/docs/11.x/sail).

### Online Demo
You can access this application demonstration on: [https://jaya-exchange.vercel.app](https://jaya-exchange.vercel.app)

## Install
To install this application first you have to have installed **[docker](https://docs.docker.com/engine/install)** and **[docker compose](https://docs.docker.com/compose/install)**.

Then once on the application folder you have two options:
1. Run the install script, but for that first you have to have installed **[make](https://www.gnu.org/software/make/)**, then just run: 
```sh
make install
```
2. Run the script lines by yourself:
```sh
docker run --rm --interactive --tty --volume .:/app --user $(id -u):$(id -g) composer install

cp .env.example .env

./vendor/bin/sail up -d

./vendor/bin/sail npm install

./vendor/bin/sail artisan key:generate

./vendor/bin/sail artisan migrate
```

Once installed you can access all the applications links listed on the sections above.

### Config
After install you can set your [Exchange Rates Api](https://exchangeratesapi.io/) access key by editing the config **EXCHANGE_RATES_API_ACCESS_KEY** on the .env file but thats not mandatory.

You can also edit the others configs on the .env file and config folder if you want. To see more about you can access the Laravel [documentation](https://laravel.com/docs/11.x/configuration).

## Test
Command to run the application tests:
```sh
./vendor/bin/sail artisan test
```

## Technologies
- Language: **[PHP 8.3](https://www.php.net)**
- Framework: **[Laravel 11](https://laravel.com)**
- Database: **[PostgreSQL](https://www.postgresql.org)**
- Api Documentation: **[OpenAPI](https://www.openapis.org/)**
- Git Hooks: **[Husky](https://typicode.github.io/husky)**
- Linter: **[Laravel Pint](https://laravel.com/docs/11.x/pint)**
- Containerization: **[Docker](https://www.docker.com)**
- Tests: **[PHPUnit](https://phpunit.de/index.html)**
- Online Demo: **[Vercel](https://vercel.com)**
- And more...