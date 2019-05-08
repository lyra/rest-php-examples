<?php 
/**
 * Instant Payment Notification (IPN) merchant script example
 * 
 * To start the PHP server, go to 
 * https://github.com/lyra/rest-php-example
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
 */
$_POST = getIPNSimulatedPOSTData();

/** 
 * Initialize the SDK 
 * see keys.php
 */
$client = new Lyra\Client();  

/* No POST data ? paid page in not called after a payment form */
if (empty($_POST)) {
    throw new Exception('no post data received!');
}

/* Check the signature using password */

if (!$client->checkHash()) {
    //something wrong, probably a fraud ....
    signature_error($formAnswer['kr-answer']['transactions'][0]['uuid'], $hashKey, 
                    $client->getLastCalculatedHash(), $_POST['kr-hash']);
    throw new Exception('invalid signature');
}

/* Retrieve the IPN content */
$rawAnswer = $client->getParsedFormAnswer();
$formAnswer = $rawAnswer['kr-answer'];

/* Retrieve the transaction id from the IPN data */
$transaction = $formAnswer['transactions'][0];

/* get some parameters from the answer */
$orderStatus = $formAnswer['orderStatus'];
$orderId = $formAnswer['orderDetails']['orderId'];
$transactionUuid = $transaction['uuid'];

/* I update my database if needed */
/* Add here your custom code */ 

/**
 * Message returned to the IPN caller
 * You can return want you want but
 * HTTP response code should be 200
 */
print 'OK! OrderStatus is ' . $orderStatus;
?>