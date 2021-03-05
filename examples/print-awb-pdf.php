<?php

require_once '../src/autoload.php';

// ---- print awb pdf ----

$fan = Fancourier\Fancourier::testInstance();

$request = new Fancourier\Request\PrintAwb();
$request->setAwb('2150900120086');

$response = $fan->printAwb($request);
if ($response->isOk()) {
    echo $response->getBody();
} else {
    var_dump($response->getErrorMessage());
}

