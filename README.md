# Laravel Dynamic Routing
This package allows you to have basic-dynamic cachable routes.

## Installation
```bash
composer require recoded/dynamic-routes
```
The package has auto discovery, should this not work then you should add `Recoded\DynamicRoutes\RouteServiceProvider`
your `app.php` config in the Providers section.


```bash
php artisan vendor:publish --provider="Recoded\DynamicRoutes\RouteServiceProvider"
```
This step is _optional_ but required if you wish to change the `DynamicRouteResolver`.

## How it works
The package is based on the `DynamicRouteResolver` interface/contract. It enforces you to provide an array
of all possible values the dynamic variable can receive, to pre-cache the routes and all variants of them.
This contract also has a `resolve` method which is used to retrieve the current dynamic value.
(this gets passed as the first argument to the callback of the `dynamic` macro on the Laravel Router)

## Usage
The package ships with a default `LocaleRouteResolver` which looks at the current locale
of the application set with e.g. `app()->setLocale()` and uses all folders inside your language resources
as possible values. This is useful when you have for example a ServiceProvider that determines the locale
of your app based on the first segment of the URL (e.g. /en, /nl, /de) or based on subdomains. (stateless data)

## Example
I don't think the `DynamicRouteResolver` needs explanation and is pretty straight forward. But here is an
example of you you can load different routes based on e.g. language:
```php
Route::dynamic(function (string $key) {
    require sprintf('%s/%s.php', __DIR__, $key);
});
```
This allows you to have separate files for each language your app supports. But you could also just use
the `trans()` helper for example to translate your routes.

### Warning
The `DynamicRouteResolver` gets resolved before Middleware so you will not be able to use session values.
Which makes sense because routing happens before Middleware.
