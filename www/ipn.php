<?php 
/**
 * Instant Payment Notification (IPN) merchant script example
 * 
 * To start the PHP server, go to 
 * https://github.com/LyraNetwork/krypton-php-examples
 *
 */



/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/keys.php';
require_once __DIR__ . '/helpers.php';

/**
 * to simulate an IPN call with CURL, uncomment the following code:
 * 
$_POST = getIPNSimulatedPOSTData();
 */

/** 
 * Initialize the SDK 
 * Please update your keys in keys.php
 */
$client = new LyraNetwork\Client();  
$client->setUsername($_username);           /* username defined in keys.php file */
$client->setPassword($_password);           /* password defined in keys.php file */
$client->setPublicKey($_publicKey);         /* key defined in keys.php file */
$client->setEndpoint($_endpoint);           /* REST API endpoint defined in keys.php file */

/* Check the signature using password */
$hashKey = $_sha256Key; /* defined in keys.php file */

if (!$client->checkHash($hashKey)) {
    //something wrong, probably a fraud ....
    signature_error($formAnswer['kr-answer']['transactions'][0]['uuid'], $hashKey, 
                    $client->getLastCalculatedHash(), $_POST['kr-hash']);
    throw new Exception("invalid signature");
}

/* Retrieve the IPN content */
$formAnswer = $client->getParsedFormAnswer();

/* Retrieve the billingTransaction id from the IPN data */
$transaction = $formAnswer["transactions"][0];

/* I update my database if needed */
/* Add here your custom code */ 

/**
 * Message returned to the IPN caller
 * You can return want you want but
 * HTTP response code should be 200
 */
print "OK!";
?>