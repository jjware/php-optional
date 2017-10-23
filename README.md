# php-optional    
![Build Status](https://travis-ci.org/jjware/php-optional.svg?branch=master)

An optional structure for PHP based on the Java interface

## Getting Started
```
composer require jjware/php-optional
```
## Creation
The `Optional` class resides in namespace `JJWare\Util`

You can create an `Optional` simply by calling the static `of` method:
```php
$opt = Optional::of('example value');
```
If you have a variable that may contain a `null` value, you may use the `ofNullable` static method:
```php
$opt = Optional::ofNullable($value);
```
If you have a case where you need to return an empty value, you may use the `empty` static method:
```php
$opt = Optional::empty();
```
## Usage
Once you have an `Optional`, there are many operations you can perform against it.

Let's say we have a function that may or may not return a value:
```php
function getSetting(string $setting) : Optional
{
    // Try to find the setting if it exists...
    return Optional::ofNullable($result);
}
```
You may provide a default value in the case that your `Optional` is empty:
```php
$port = getSetting('port')->orElse(8080);
```
If your default value requires expensive calculation or calls to external resources, you may only want to get the default value when necessary:
```php
$port = getSetting('port')->orElseGet(function () {
    return getDefaultPortFromDatabase();
});

// or as a method reference

$port = getSetting('port')->orElseGet('DB::getDefaultPort');
```
You may need to change the value within the `Optional` in some way if it exists:
```php
$port = getSetting('port')->map(function ($x) {
   return intval($x);
})->orElse(8080);

// or using a function reference

$port = getSetting('port')->map('intval')->orElse(8080);
```
You may not want the value unless it meets specific criteria:
```php
$port = getSetting('port')->filter(function ($x) {
    return $x > 8000 && $x < 9000;
})->orElse(8080);
```
