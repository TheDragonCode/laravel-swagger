# laravel-swagger

Documentation generation for Swagger without OpenAPI

## Installation for dev

1. Clone repository:
```
clone https://github.com/andrey-helldar/laravel-swagger.git
```

2. Add the following code to the `composer.json` file:
```
"repositories": [
    {
        "type": "path",
        "url": "../andrey-helldar/laravel-swagger"
    }
]
```

3. Execute the command:
```
composer require andrey-helldar/laravel-swagger:dev-master
```

> Note:
> 
> In order for the composer to be able to install an unstable package, in the option "minimum-stability" of the file "composer.json" the value must be "dev".
