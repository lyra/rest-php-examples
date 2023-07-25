<?php
/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../keys.php';
require_once __DIR__ . '/../helpers.php';

/** 
 * Initialize the SDK 
 * see keys.php
 */
$client = new Lyra\Client();

/* Get the request content */
$rawRequest = file_get_contents('php://input');
$request = (array) json_decode($rawRequest);

/* Define new price depending on the BIN */
$newPrice = null;
switch($request['bin']) {
    case '59701003':
        $newPrice = 200;
        break;
    case '37828200':
        $newPrice = 150;
        break;
    case '51001200':
        /* simulate a timeout */
        sleep(45);
        $newPrice = 100;
        break;

}

/* default formToken is the initial one, sent in the request */
$formToken = $request['formToken'];

/* update the formToken if nedded */
if ($newPrice) {
    /**
     * I update the formToken
     */
    $store = array();
    $store['updatedAmount'] = $newPrice;
    $store['cardBin'] = $request['bin'];
    $store['formToken'] = $request['formToken'];
    
    $response = $client->post("V4/Charge/UpdatePaymentAmount", $store);

    /* I check if there are some errors */
    if ($response['status'] != 'SUCCESS') {
        /* an error occurs, I throw an exception */
        display_error($response);
        $error = $response['answer'];
        throw new Exception("error " . $error['errorCode'] . ": " . $error['errorMessage'] );
    }

    /* everything is fine, I extract the formToken with the new price */
    $formToken = $response["answer"]["formToken"];

}

/* I return the new formToken to the smart form */
$answer = array();
$answer['formToken'] = $formToken;
header('Content-Type: application/json; charset=utf-8');
echo json_encode($answer);
?>