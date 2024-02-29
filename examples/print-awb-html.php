<?php

require_once '../src/autoload.php';

// ---- print awb html ----

$fan = Fancourier\Fancourier::testInstance();

$request = new Fancourier\Request\PrintAwbHtml();
$request->setAwb('2060400120378');

$response = $fan->printAwbHtml($request);
if ($response->isOk()) {
    echo $response->getBody();
} else {
    var_dump($response->getErrorMessage());
}
