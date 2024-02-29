<?php

require_once '../src/autoload.php';

// ---- print awb pdf ----

$fan = Fancourier\Fancourier::testInstance();

$request = new Fancourier\Request\PrintAwb();
$request->setAwb('2060400120378');

$response = $fan->printAwb($request);
if ($response->isOk()) {
    file_put_contents('awb.pdf', $response->getBody());
} else {
    var_dump($response->getErrorMessage());
}

