# PHPFileReader

Reads config values from a PHP file in the form of an array.

## Usage

### Config initialisation:
```php
$config = new \TomWright\PHPConfig\Config([
    'readers' => [
        new \TomWright\PHPConfig\ConfigReader\PHP\PHPFileReader('/path/to/config.php'),
    ],
]);
```

### `/path/to/config.php`:
```php
return [
    'first-key' => 'first-value',
    'second-key' => [
        'third-key' => 'second-value',
    ],
];
```

### Config usage
```
$config->get('first-key'); // 'first-value'

$config->get('second-key'); // [ 'third-key' => 'second-value' ]

$config->get('second-key.third-key'); // 'second-value'
```
