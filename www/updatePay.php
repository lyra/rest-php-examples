<?php
/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/keys.php';
require_once __DIR__ . '/helpers.php';
/**
 * Initialize the SDK
 * see keys.php
 */
$client = new Lyra\Client();
$total = number_format($total_final, 2, '', '');
$uuid = $uu_id;
//$total = $total . 0000;
if (isset($_GET['requestObject'])) {
    $store = json_decode($_GET['requestObject']);
} else {
    $store = array( "amount" => $total,
        "uuid" => $uuid,
        "cardUpdate" => array(
            "amount" => $total,
            "currency" => "ARS"

        ));
}

/**
 * I create a formToken
 */

$responseUpdate = $client->post("V4/Transaction/Update", $store);

//* I check if there are some errors */
if ($responseUpdate['status'] != 'SUCCESS') {
    /* an error occurs */
    $error = $responseUpdate['answer'];
    header("Content-Type", "application/json");
    header('HTTP/1.1 500 Internal Server Error');
    echo '{"error": "' . $error['errorCode'] . '", "_type": "DemoError" }';
    die();
}

/* everything is fine, I extract the formToken */
$formToken = $responseUpdate["answer"]["formToken"];
//header("Content-Type", "application/json");
//echo '{"formToken": "' . $formToken . '"", "_type": "DemoFormToken" }';

