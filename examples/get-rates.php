<?php

require_once '../src/autoload.php';

//---- get estimated shipping cost ----

$fan = Fancourier\Fancourier::testInstance();

$request = new Fancourier\Request\GetRates();
$request
    ->setParcels(1)
    ->setWeight(2)
    ->setRegion('Arad')
    ->setCity('Aciuta')
    ->setDeclaredValue(125);

$response = $fan->getRates($request);
var_dump($response->isOk() ? $response->getBody() : $response->getErrorMessage());
