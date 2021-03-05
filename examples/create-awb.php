<?php

require_once '../src/autoload.php';

// ---- create awb ----

$fan = Fancourier\Fancourier::testInstance();

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

$response = $fan->createAwb($request);
var_dump($response->isOk() ? $response->getBody() : $response->getErrorMessage());