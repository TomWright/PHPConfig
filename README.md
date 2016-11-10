# Config

```php
$c = Config::getInstance();
$c->setItem('my.conf.key', 'my_conf_value');

echo $c->getItem('my.conf.key'); // my_conf_value
```