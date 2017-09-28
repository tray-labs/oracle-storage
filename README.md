# Oracle Storage

A service made to provide, set up your application to connect Oracle cloud storage.

## Installing

* Add this line to require section of ```composer require "tray-labs/oracle-storage"```

* If do you use php make like this:
* Make a config file like this:
```php
<?php
return [
    'user' => [
        'username' => 'your@email.com',
        'password' => 'yourPassword'
    ],
    'account' => [
        'identifier' => 'yourIdentifierStorage',
        'auth_uri' => 'yourAuthUri',
    ],
    'storage' => [
        'container' => 'yourContainer',
        'local_path' => 'localWhereDoYouSaveTheFile'
    ]
];
```

* To use:
```php

```

* Or if do you use laravel make like this:

* Add this lines to yours config/app.php

```php
'providers' => [
    TrayLabs\OracleStorage\Providers\ServiceProvider::class,
]
```

```php
'aliases' => [
    'OracleStorage' => TrayLabs\OracleStorage\Facades\OracleStorage::class,
]
```

* Define env variables to connect to OracleStorage

```ini
ORACLE_STORAGE_USERNAME=your@email.com
ORACLE_STORAGE_PASSWORD=yourPassword
ORACLE_STORAGE_IDENTIFIER=yourStorageIdentifier
ORACLE_STORAGE_AUTH_URI=yourAuthUri
ORACLE_STORAGE_CONTAINER=yourContainer
ORACLE_STORAGE_LOCAL_PATH=localWhereDoYouSaveTheFile
```

* Write this into your terminal inside your project

```ini
php artisan vendor:publish
```

## Upload
* In php:
```php
<?php

use \TrayLabs\OracleStorage\OracleStorage;
use \TrayLabs\OracleStorage\Object\File;
use \TrayLabs\OracleStorage\Exception\FileNotFound;

$client = new OracleStorage(require 'yourConfigFile.php');
// execute upload your file
$fileName = $client->upload('fileName', new File($yourFile));
```
* In Laravel:
```php
<?php
 use TrayLabs\OracleStorage\Facades\OracleStorage;

// execute upload your file 
 $fileName = OracleStorage::upload('fileName', new File($yourFile));
```

## Download
```php
<?php

use \TrayLabs\OracleStorage\OracleStorage;
use \TrayLabs\OracleStorage\Object\File;
use \TrayLabs\OracleStorage\Exception\FileNotFound;

$client = new OracleStorage(require 'yourConfigFile.php');
// execute download your file
$client->download('fileName');
```
* In Laravel:
```php
<?php
 use TrayLabs\OracleStorage\Facades\OracleStorage;
 
 // execute download your file
 OracleStorage::download('fileName');
```

## Delete
* In php:
```php
<?php

use \TrayLabs\OracleStorage\OracleStorage;
use \TrayLabs\OracleStorage\Object\File;
use \TrayLabs\OracleStorage\Exception\FileNotFound;

$client = new OracleStorage(require 'yourConfigFile.php');
// execute delete your file
$client->delete('fileName');
```
* In Laravel:
```php
 <?php
 use TrayLabs\OracleStorage\Facades\OracleStorage;

// execute delete your file 
 OracleStorage::delete('fileName');
```

## Metadata
* In php:
```php
<?php

use \TrayLabs\OracleStorage\OracleStorage;
use \TrayLabs\OracleStorage\Object\File;
use \TrayLabs\OracleStorage\Exception\FileNotFound;

$client = new OracleStorage(require 'yourConfigFile.php');
// get information about your file
$client->metadata('fileName');
```
* In Laravel:   
```php
 <?php
 use TrayLabs\OracleStorage\Facades\OracleStorage;
 
 // get information about your file
 OracleStorage::metadata('fileName');
```

License
----

This project is licensed under the MIT License
