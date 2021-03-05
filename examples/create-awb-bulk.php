<?php

use Fancourier\Response\CreateAwb;

require_once '../src/autoload.php';

// ---- create awb bulk ----

$fan = Fancourier\Fancourier::testInstance();

$batchRequest = new Fancourier\Request\CreateAwbBulk();
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
$batchRequest->append($request);

$request
    ->setParcels(1)
    ->setWeight(1.5)
    ->setReimbursement(50)
    ->setDeclaredValue(50)
    ->setContents('SKU-7')
    ->setRecipient("Tester Testerson")
    ->setPhone('0722111000')
    ->setRegion('Sibiu')
    ->setCity('Sibiu')
    ->setStreet('Calea Bucuresti nr 1')
;
$batchRequest->append($request);

$response = $fan->createAwbBulk($batchRequest);
if (!$response->isOk()) {
    //general error
    die($response->getErrorMessage());
}

foreach ($response->getBody() as $lineResponse) {
    /** @var CreateAwb $lineResponse */

    if ($lineResponse->isOk()) {
        echo $lineResponse->getBody() . "\n";
    } else {
        echo $lineResponse->getErrorMessage() . "\n";
    }
}