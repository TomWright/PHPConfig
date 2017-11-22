# JSONFileReader

Reads config values from a PHP file in the form of an array.

## Usage

### Config initialisation:
```php
$config = new \TomWright\PHPConfig\Config([
    'readers' => [
        new \TomWright\PHPConfig\ConfigReader\JSON\JSONFileReader('/path/to/config.json'),
    ],
]);
```

### `/path/to/config.json`:
```json
{
  "contacts": [
    {
      "name": "Tom"
    },
    {
      "name": "Jim"
    },
    {
      "name": "Jess"
    }
  ],
  "primaryContact": "Tom"
}
```

### Config usage
```
$config->get('primaryContact'); // 'Tom'

$config->get('contacts'); // [ [ 'name' => 'Tom' ], [ 'name' => 'Jim' ], [ 'name' => 'Jess' ] ]

$config->get('contacts.0.name'); // 'Tom'
```
