# Lyra Network REST api SDK


[![Build Status](https://travis-ci.org/LyraNetwork/krypton-php-sdk.svg?branch=master)](https://travis-ci.org/LyraNetwork/krypton-php-sdk)
[![Coverage Status](https://coveralls.io/repos/github/LyraNetwork/krypton-php-sdk/badge.svg?branch=master)](https://coveralls.io/github/LyraNetwork/krypton-php-sdk?branch=master)
[![Latest Stable Version](https://poser.pugx.org/lyranetwork/krypton-php-sdk/v/stable)](https://packagist.org/packages/lyranetwork/krypton-php-sdk)
[![Latest Unstable Version](https://poser.pugx.org/lyranetwork/krypton-php-sdk/v/unstable)](//packagist.org/packages/LyraNetwork/krypton-php-sdk)
[![Total Downloads](https://poser.pugx.org/lyranetwork/krypton-php-sdk/downloads)](https://packagist.org/packages/lyranetwork/krypton-php-sdk)
[![License](https://poser.pugx.org/lyranetwork/krypton-php-sdk/license)](https://packagist.org/packages/lyranetwork/krypton-php-sdk)

Lyra Network REST API SDK.

##Requirements

PHP 5.3.3 and later.

## Installation

Lyra Network REST api SDK is available via [Composer/Packagist](https://packagist.org/packages/lyranetwork/krypton-php-sdk). Just add this line to your `composer.json` file:

```json
"lyranetwork/krypton-php-sdk": "~3.0"
```

or

```sh
composer require lyranetwork/krypton-php-sdk:~3.0
```

To use the SDK, use Composer's [autoload](https://getcomposer.org/doc/00-intro.md#autoloading):

```php
require_once('vendor/autoload.php');
```

## Manual Installation

If you do not want to use Composer, you can download the [latest release from github](https://github.com/LyraNetwork/krypton-php-sdk/releases). 
To use the SDK, include the `autoload.php` file:

```php
require_once('/path/to/php-sdk/autoload.php');
```

## SDK Usage

A simple integration example is [available here](https://github.com/LyraNetwork/krypton-php-examples/blob/master/src/SDKTest.php)

You can also take a look to our github examples repository: https://github.com/LyraNetwork/krypton-php-examples

## Run tests

start docker using docker compose:

```sh
docker-compose up -d
````

Install deps
```sh
docker exec -ti krypton-sdk php composer.phar install
```

and run the test suite with:

```sh
docker exec -ti krypton-sdk ./vendor/bin/phpunit src/
```