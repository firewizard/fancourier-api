<?php

require_once '../src/autoload.php';

// ---- delete awb ----

$fan = Fancourier\Fancourier::testInstance();

$request = new Fancourier\Request\DeleteAwb();
$request->setAwb('2060400120378');

$response = $fan->deleteAwb($request);

var_dump($response->isOk() ? $response->getBody() : $response->getErrorMessage());
