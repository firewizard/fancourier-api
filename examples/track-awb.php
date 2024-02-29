<?php

require_once '../src/autoload.php';

// ---- track awb ----

$fan = Fancourier\Fancourier::testInstance();

$request = new Fancourier\Request\TrackAwb();
$request
    ->setAwb('2060400120378')
    ->setDisplayMode(Fancourier\Request\TrackAwb::MODE_LAST_STATUS)
    ;

$response = $fan->trackAwb($request);

print_r($response->isOk() ? $response->getBody() : $response->getErrorMessage());
