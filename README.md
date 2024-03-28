# FANCourier API v2

## Table of contents
- <a href="#installation">Installation</a>
    - <a href="#composer">Requirements</a>
    - <a href="#composer">Composer</a>
- <a href="#usage">Usage</a>
    - <a href="#authentication">Authentication</a>
    - <a href="#get-estimated-shipping-cost">Get estimated shipping cost</a>
    - <a href="#create-awb">Create AWB</a>
    - <a href="#create-awb-bulk">Create AWB in bulk</a>
    - <a href="#track-awb">Track AWB</a>
    - <a href="#print-awb">Print AWB</a>
    - <a href="#print-awb-html">Print AWB Html</a>
    - <a href="#delete-awb">Delete AWB</a>
    - <a href="#track-awb-in-bulk">Track AWB in bulk</a>
    - <a href="#get-cities">Get cities</a>
    - <a href="#get-counties">Get counties</a>
    - <a href="#get-services">Get services</a>
- <a href="#features-not-implemented">Features not implemented</a>
- <a href="#contributing">Contributing</a>
- <a href="#license">License</a>

## Installation
### Requirements

* PHP >= 7.0
* ext-curl
* ext-json

### Composer
Require the package via composer
```bash
composer require firewizard/fancourier-api
```

### Manual
If used without composer, you will need to manually require the `autoload.php` file
```php
require_once '/path/to/fancourier-api/src/autoload.php';
```

## Breaking changes from v1
* removed Auth class
* removed SendsFile trait
* getCities city array keys have changed (_county_ instead of _judet_, _name_ instead of _localitate_, _exteriorKm_ instead of _km_)
* CreateAwbBulk response body is now an array of AWBs instead of an array of CreateAwb response objects
* trackAwb now returns the full events list, as an array, not just the last message
* trackAwbBulk now returns the full events list, as an array, with info about all AWBs in the request. It's up to you to group by AWB


## Usage
### Authentication
Create a new instance of `Fancourier.php` supplying the `client_id`, `username` and `password`.
```php
$clientId = 'your_client_id';
$username = 'your_username';
$password = 'your_password';

$fan = new Fancourier\Fancourier($clientId, $username, $password);
```

Or you can use the test instance static method:
```php
$fan = Fancourier\Fancourier::testInstance();
```

### Caching the auth token
By default, authentication is always called, which means for every regular request, 
there will be an extra request to obtain the auth token. 
You can fix this and cache the auth token in your app.

First, you need to create a new class that implements `Fancourier\AuthTokenCacheContract`:
```php
class FancourierAuthCache implements AuthTokenCacheContract
{
    const CACHE_KEY = 'fancourier_auth_token';
    const CACHE_LIFETIME = 43200; //12 hrs

    public function get()
    {
        return Cache::get(static::CACHE_KEY);
    }

    public function set($value)
    {
        Cache::put(static::CACHE_KEY, $value, static::CACHE_LIFETIME);
    }
}
```
Then, pass this to the main Fancourier object:
```php
$api = new Fancourier(...);
$api->useAuthTokenCache(new FancourierAuthCache());
```

*Note*: Tokens change every 24 hours according to Fan Courier, so might want to use a lower cache TTL.

### Get estimated shipping cost
Request
```php
$request = new Fancourier\Request\GetRates();
$request
    ->setParcels(1)
    ->setWeight(2)
    ->setRegion('Arad')
    ->setCity('Aciuta')
    ->setDeclaredValue(125);
```
Response
```php
$response = $fan->getRates($request);
if ($response->isOk()) {
    var_dump($response->getBody());
} else {
    var_dump($response->getErrorMessage());
}
```

### Create AWB
Request
```php
$request = new Fancourier\Request\CreateAwb();
$request
    ->setParcels(1)
    ->setWeight(2)
    ->setReimbursement(125)
    ->setDeclaredValue(125)
    ->setNotes('testing notes')
    ->setContents('SKU-1, SKU-2')
    ->setRecipient("John Ivy")
    ->setPhone('0723000000')
    ->setRegion('Arad')
    ->setCity('Aciuta')
    ->setStreet('Str Lunga nr 1');
```
Response
```php
$response = $fan->createAwb($request);
if ($response->isOk()) {
    var_dump($response->getBody());
} else {
    var_dump($response->getErrorMessage());
}
```

### Create AWB Bulk
Request
```php
$batchRequest = new Fancourier\Request\CreateAwbBulk();
$request = new Fancourier\Request\CreateAwb();
$request
    ->setParcels(1)
    ->setWeight(2)
    ->setReimbursement(125)
    ->setDeclaredValue(125)
    ->setNotes('testing notes')
    ->setContents('SKU-1, SKU-2')
    ->setRecipient("John Ivy")
    ->setPhone('0723000000')
    ->setRegion('Arad')
    ->setCity('Aciuta')
    ->setStreet('Str Lunga nr 1')
;
$batchRequest->append($request);

$request
    ->setParcels(1)
    ->setWeight(1.5)
    ->setReimbursement(50)
    ->setDeclaredValue(50)
    ->setContents('SKU-7')
    ->setRecipient("Tester Testerson")
    ->setPhone('0722111000')
    ->setRegion('Sibiu')
    ->setCity('Sibiu')
    ->setStreet('Calea Bucuresti nr 1')
;
$batchRequest->append($request);

$response = $fan->createAwbBulk($batchRequest);
if (!$response->isOk()) {
    //general error
    die($response->getErrorMessage());
}

foreach ($response->getBody() as $awb) {
    echo $awb . "\n";
}
```

### Track AWB
Request
```php
$request = new Fancourier\Request\TrackAwb();
$request->setAwb('2150900120086');
```
Response
```php
$response = $fan->trackAwb($request);
if ($response->isOk()) {
    print_r($response->getBody());
} else {
    print_r($response->getErrorMessage());
}
```

### Print AWB
Request
```php
$request = new Fancourier\Request\PrintAwb();
$request->setAwb('2150900120086');
```
Response
```php
$response = $fan->printAwb($request);
if ($response->isOk()) {
    echo $response->getBody();
} else {
    var_dump($response->getErrorMessage());
}
```

### Print AWB Html
Request
```php
$request = new Fancourier\Request\PrintAwbHtml();
$request->setAwb('2150900120086');
```
Response
```php
$response = $fan->printAwbHtml($request);
if ($response->isOk()) {
    echo $response->getBody();
} else {
    var_dump($response->getErrorMessage());
}
```

### Delete AWB
Request
```php
$request = new Fancourier\Request\DeleteAwb();
$request->setAwb('2150900120086');
```
Response
```php
$response = $fan->deleteAwb($request);
if ($response->isOk()) {
    var_dump($response->getBody());
} else {
    var_dump($response->getErrorMessage());
}
```

### Track awb in bulk
Request
```php
$request = new Fancourier\Request\TrackAwbBulk();
$request->setAwbs(['2162900120047']);
```
Response
```php
$response = $fan->trackAwbBulk($request);
if ($response->isOk()) {
    print_r($response->getBody());
} else {
    var_dump("ERROR: " . $response->getErrorMessage());
}
```

### Get cities
Request - There's no request for this method

Response - will return an array of cities (and other info)
```php
$response = $fan->getCities();
if ($response->isOk()) {
    print_r($response->getBody());
} else {
    var_dump("ERROR: " . $response->getErrorMessage());
}
```

### Get counties
Request - There's no request for this method

Response - will return an array of counties
```php
$response = $fan->getCounties();
if ($response->isOk()) {
    print_r($response->getBody());
} else {
    var_dump("ERROR: " . $response->getErrorMessage());
}
```

### Get services
Request - There's no request for this method

Response - will return an array with all services
```php
$response = $fan->getServices();
if ($response->isOk()) {
    print_r($response->getBody());
} else {
    var_dump("ERROR: " . $response->getErrorMessage());
}
```

## Features not implemented
Feel free to open a pull request for the following features:
* get pudo
* get streets
* external functions
* create carrier request
* delete carrier request
* summary
* get awb tracking events
* bank transfers
* orders functions
* branches

## Contributing

Thank you for considering contributing to the Fancourier API, all pull requests are appreciated.

## License

Fancourier Api is open-source software licensed under the [MIT license](./LICENSE).



