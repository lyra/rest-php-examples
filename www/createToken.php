<?php
/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/keys.php';

/** 
 * Initialize the SDK 
 * Please update your keys in keys.php
 */
$client = new Lyra\Client();         /* Create the client SDK */
$client->setUsername($_username);           /* username defined in keys.php file */
$client->setPassword($_password);           /* password defined in keys.php file */
$client->setPublicKey($_publicKey);         /* key defined in keys.php file */
$client->setEndpoint($_endpoint);           /* REST API endpoint defined in keys.php file */

if (isset($_GET['requestObject'])) {
    /**
     * I create a formToken
     */
    $store = json_decode($_GET['requestObject']);
    $response = $client->post("V4/Charge/CreatePayment", $store);

    /* I check if there is some errors */
    if ($response['status'] != 'SUCCESS') {
        /* an error occurs, I throw an exception */
        $error = $response['answer'];
        header("Status: 500", true, 500);
        echo "error " . $error['errorCode'] . ": " . $error['errorMessage'];
        die();
    }

    /* everything is fine, I extract the formToken */
    $formToken = $response["answer"]["formToken"];
    header("Content-Type", "application/json");
    echo $formToken;
} else {
    header("Status: 500", true, 500);
    echo "Invalid input data";
}