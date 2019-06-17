<?php
/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/keys.php';

/** 
 * Initialize the SDK 
 * see keys.php
 */
$client = new Lyra\Client();

if (isset($_GET['requestObject'])) {
    $store = json_decode($_GET['requestObject']);
} else {
    $store = array( "amount" => 250, 
                    "currency" => "EUR", 
                    "orderId" => uniqid("MyOrderId"),
                    "customer" => array(
                    "email" => "sample@example.com"
                    ));
}

/**
 * I create a formToken
 */

$response = $client->post("V4/Charge/CreatePayment", $store);

//* I check if there are some errors */
if ($response['status'] != 'SUCCESS') {
    /* an error occurs */
    $error = $response['answer'];
    header("Content-Type", "application/json");
    header('HTTP/1.1 500 Internal Server Error');
    echo '{"error": "' . $error['errorCode'] . '", "_type": "DemoError" }';
    die();
}

/* everything is fine, I extract the formToken */
$formToken = $response["answer"]["formToken"];
header("Content-Type", "application/json");
echo '{"formToken": "' . $formToken . '"", "_type": "DemoFormToken" }';
