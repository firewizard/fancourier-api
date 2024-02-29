<?php

require_once '../src/autoload.php';

// ---- track awb in bulk ----

$fan = Fancourier\Fancourier::testInstance();

$request = new Fancourier\Request\TrackAwbBulk();
$request->setAwbs(['2060400120536', '2060400120537']);

$response = $fan->trackAwbBulk($request);
if ($response->isOk()) {
    print_r($response->getBody());
} else {
    var_dump("ERROR: " . $response->getErrorMessage());
}
