# Weather Api

A service, which returns product recommendations depending on the weather forecast

## Application

Description: This application gives user different product recommendations for three days depending on the current weather in selected location.
Application development environment is hosted in heroku and can be accessed via following link: https://quiet-brushlands-89468.herokuapp.com

## Technology used

-   PHP 8.0 version;
-   Laravel 8.54 version framework;
-   MySQL database engine;

## API reference

API used to generate daily weather forecast - Meteo.lt. For API documentation please follow the link
https://api.meteo.lt/

## Usage

-   ### Retrieve all products: `/api/products`

-   ### Retrieve specific category with 2 randomly selected products: `/products/recommended/:city'`
