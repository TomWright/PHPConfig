# Config

[![Build Status](https://travis-ci.org/TomWright/PHPConfig.svg?branch=master)](https://travis-ci.org/TomWright/PHPConfig)
[![Latest Stable Version](https://poser.pugx.org/tomwright/php-config/v/stable)](https://packagist.org/packages/tomwright/php-config)
[![Total Downloads](https://poser.pugx.org/tomwright/php-config/downloads)](https://packagist.org/packages/tomwright/php-config)
[![Monthly Downloads](https://poser.pugx.org/tomwright/php-config/d/monthly)](https://packagist.org/packages/tomwright/php-config)
[![Daily Downloads](https://poser.pugx.org/tomwright/php-config/d/daily)](https://packagist.org/packages/tomwright/php-config)
[![License](https://poser.pugx.org/tomwright/php-config/license.svg)](https://packagist.org/packages/tomwright/php-config)

## Installation

```
composer require tomwright/php-config
```

## General Usage

Create an instance of `Config` to get going:
```php
$config = new Config();
```

### Add values to the config as follows
```php
$config->put('key', 'value');
```

### Get values from the config as follows
```php
$value = $config->get('key');
```

## Storing Data
You can add separators to the `key` string in order to have the data stored slightly differently.

For example, let's say we have a contact name and email address. You can set this in any of the following ways:

```php
$config->put('contact', [
    'name' => 'Tom',
    'email' => 'contact@tomwright.me',
]);

$config->put('contact.name', 'Tom');
$config->put('contact.email', 'contact@tomwright.me');
```

You can even mix and match between the above:

```php
$config->put('contact', [
    'name' => 'Tom',
]);

$config->put('contact.email', 'contact@tomwright.me');
```

## Fetching Data

You can use the dot separators in a similar way to the above when fetching data too.

Assuming we have the same contact details stored, let's look at the following:

```php
$config->get('contact'); // [ 'name' => 'Tom', 'email' => 'contact@tomwright.me' ]

$config->get('contact.name'); // Tom
$config->get('contact.email'); // contact@tomwright.me
```

## Separators

You can use as many separators in the key as you would like. The following will end up working in the same way as the above, just with a deeper level of storage.

```
$config->put('company.person.tom.email', 'contact@tomwright.me');
$config->put('company.person.jim.email', 'jim@tomwright.me');

$config->get('company');
/*
[
    'person' => [
        'tom' => [ 'email' => 'contact@tomwright.me' ],
        'jim' => [ 'email' => 'jim@tomwright.me' ],
    ]
]
*/
```

If you would like to use a separator other than the `.` character, you may set one using the `setSeparator()` method, or by passing it in in the Config constructor.

```php
$config = new Config([
    'separator' => '|', // Equal
]);
$config->setSeparator('|'); // Equal

$config->put('contact', [
    'contact' => [
        'name' => 'Tom',
        'email' => 'contact@tomwright.me',
    ],
]);

$config->get('contact|name'); // Tom
$config->get('contact.email'); // NULL
```

## Config Readers

Config readers are classes to help you auto-populate the config object with values.
To use a Config Reader, simply pass it into `$config->read()`.

```
$config = new Config();
$config->read(new SomeConfigReader());
$config->get('some.value.from.my.reader');
```

You can also pass an array of Config Readers into the Config constructor:

```
$config = new Config([
    'readers' => [
        new SomeConfigReader(),
    ],
]);
$config->get('some.value.from.my.reader');
```

### Existing Config Readers

If you would like to create a Config Reader please feel free. The only requirement is that you implement the `ConfigReader` interface.
If you have already created a Config Reader and would like it to appear here, please submit a pull request.

- [PHPFileReader](/docs/PHPFileReader.md)
