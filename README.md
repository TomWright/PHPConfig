# Config

[![Build Status](https://travis-ci.org/TomWright/PHPConfig.svg?branch=master)](https://travis-ci.org/TomWright/PHPConfig)
[![Latest Stable Version](https://poser.pugx.org/tomwright/php-config/v/stable)](https://packagist.org/packages/tomwright/php-config)
[![Total Downloads](https://poser.pugx.org/tomwright/php-config/downloads)](https://packagist.org/packages/tomwright/php-config)
[![Monthly Downloads](https://poser.pugx.org/tomwright/php-config/d/monthly)](https://packagist.org/packages/tomwright/php-config)
[![Daily Downloads](https://poser.pugx.org/tomwright/php-config/d/daily)](https://packagist.org/packages/tomwright/php-config)
[![License](https://poser.pugx.org/tomwright/php-config/license.svg)](https://packagist.org/packages/tomwright/php-config)

## Usage

```php
$c = Config::getInstance();
$c->setItem('my.conf.key', 'my_conf_value');

echo $c->getItem('my.conf.key'); // my_conf_value
```