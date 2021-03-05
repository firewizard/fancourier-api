<?php

require_once '../src/autoload.php';

// ---- track awb ----

$fan = Fancourier\Fancourier::testInstance();

$request = new Fancourier\Request\TrackAwb();
$request
    ->setAwb('2150900120086')
    ->setDisplayMode(Fancourier\Request\TrackAwb::MODE_LAST_STATUS)
    ;

$response = $fan->trackAwb($request);

var_dump($response->isOk() ? $response->getBody() : $response->getErrorMessage());
