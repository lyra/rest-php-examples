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
$total = number_format($total_final, 2, '', '');
$token = $payToken;
//$total = $total . 0000;
if (isset($_GET['requestObject'])) {
    $store = json_decode($_GET['requestObject']);
} else {
    $store = array( "amount" => $total,
        "currency" => "ARS",
        "paymentMethodToken"=> $token,
        "formAction" => "SILENT",

        "transactionOptions"=> array(
                "cardOptions"=> array("installmentNumber"=> $silent_cuotas)
            )
        );
}

//print_r($store);

/**
 * I create a formToken
 */

$responseSlient = $client->post("V4/Charge/CreatePayment", $store);

//* I check if there are some errors */
if ($responseSlient['status'] != 'SUCCESS') {
    /* an error occurs */
    $error = $responseSlient['answer'];
    header("Content-Type", "application/json");
    header('HTTP/1.1 500 Internal Server Error');
    echo '{"error": "' . $error['errorCode'] . '", "_type": "DemoError" }';
    die();
}

/* everything is fine, I extract the formToken */
$Token = $responseSlient["answer"]["paymentMethodToken"];

//header("Content-Type", "application/json");
//echo '{"formToken": "' . $formToken . '"", "_type": "DemoFormToken" }';

