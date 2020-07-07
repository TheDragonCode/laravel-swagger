# laravel-swagger

Documentation generation for Swagger without OpenAPI

## Installation

> Note:
> In order for the composer to be able to install an unstable package, in the option "minimum-stability" of the file "composer.json" the value must be "dev".

### Laravel

1. Execute the command:
```
composer require andrey-helldar/laravel-swagger:dev-master --dev
```

2. Use the `swagger:generate` command to generate documentation.

### Lumen

1. Execute the command:
```
composer require andrey-helldar/laravel-swagger:dev-master
```

2. Copy the configuration file to the [config](config/laravel-swagger.php) folder.

3. Register the configuration file in `bootstrap/app.php`:
```
$app->configure('laravel-swagger');
```

4. Register the service provider in `bootstrap/app.php`:
```
$app->register(Helldar\LaravelSwagger\ServiceProvider::class);
```

5. Use the `swagger:generate` command to generate documentation.
