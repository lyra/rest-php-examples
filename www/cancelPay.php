<?php
/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/keys.php';
require_once __DIR__ . '/helpers.php';
/**
 * Initialize the SDK
 * see keys.php
 */
$client = new Lyra\Client();


//$total = $total . 0000;
if (isset($_GET['requestObject'])) {
    $store = json_decode($_GET['requestObject']);
} else {
    $store = array( "amount" => $total,
        "currency" => "$currency",
        "uuid" => $uuid
        );
}

/**
 * I create a formToken
 */

$responseCancel = $client->post("V4/Transaction/CancelOrRefund", $store);

//* I check if there are some errors */
if ($responseCancel['status'] != 'SUCCESS') {
    /* an error occurs */
//    $error = $responseCancel['answer'];
//    header("Content-Type", "application/json");
//    header('HTTP/1.1 500 Internal Server Error');
//    echo '{"error": "' . $error['errorCode'] . '", "_type": "DemoError" }';
//    die();
}

/* everything is fine, I extract the formToken */
//$formToken = $responseCancel["answer"]["formToken"];
//header("Content-Type", "application/json");
//echo '{"formToken": "' . $formToken . '"", "_type": "DemoFormToken" }';

