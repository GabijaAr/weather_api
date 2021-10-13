# Weather Api

Adeo Web task for Junior PHP Back-end Developer position: Create a service, which returns product recommendations depending on the weather forecast

## Application

Description: This application gives user different product recommendations for three days depending on the current weather in selected location.

## Technology used

-   PHP 8.0 version;
-   Laravel 8.54 version framework;
-   MySQL database engine;

## API reference

API used to generate daily weather forecast - Meteo.lt. For API documentation please follow the link
https://api.meteo.lt/

## Usage

-   ### Retrieve all products: **GET** `/api/products`

-   ### Retrieve specific category with 2 randomly selected products: **GET** `/products/recommended/:city'`

## Installation

### You can run application locally

Clone the repository locally:

```sh
git clone https://github.com/GabijaAr/weather_api.git
cd weather_api
```

To run the application write these commands into terminal:

```sh
php artisan migrate:fresh --seed
```

There are test available:

```sh
php artisan test
```

To refresh weather forecast database daily use scheduler loccaly:

```sh
php artisan schedule:work
```
