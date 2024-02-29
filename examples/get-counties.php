<?php

require_once '../src/autoload.php';

//---- get cities list ----

$fan = Fancourier\Fancourier::testInstance();

$response = $fan->getCounties();
print_r($response->isOk() ? $response->getBody() : $response->getErrorMessage());
