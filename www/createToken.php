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
$client = new LyraNetwork\Client();  
$client->setPrivateKey($_privateKey);       /* key defined in keys.php file */
$client->setPublicKey($_publicKey);         /* key defined in keys.php file */
$client->setEndpoint($_endpoint);           /* REST API endpoint defined in keys.php file */

if (isset($_POST['amount']) and isset($_POST['currency'])) {
    $currency = $_POST['currency'];
    $amount = $_POST['amount'];
    // I format the amount data
    $formatted_amount = round($amount, 2) * 100;

    /**
    * I create a formToken
    */
    $store = array("amount" => $formatted_amount, "currency" => $currency);
    $response = $client->post("Charge/CreatePayment", $store);

    /* I check if there is some errors */
    if ($response['status'] != 'SUCCESS') {
        /* an error occurs, I throw an exception */
        $error = $response['answer'];
        header("Status: 500", true, 500);
        echo "Invalid input data";
    } else {
        /* everything is fine, I extract the formToken */
        $formToken = $response["answer"]["formToken"];

        header("Content-Type", "application/json");
        echo $formToken;
    }
} else {
    header("Status: 500", true, 500);
    echo "Invalid input data";
}