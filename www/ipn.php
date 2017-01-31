<?php 
/**
 * Instant Payment Notification (IPN) merchant script example
 * 
 * To start the PHP server, go to 
 * https://github.com/LyraNetwork/krypton-php-examples
 *
 * to simulate an IPN call with CURL
 * 
   curl http://localhost:6980 \
      -X POST \
      -H 'Content-type: application/json' \
      -d '{ "orderId": "7d25c5e45cf74198b9f86ad656b3daf3",
            "_type": "V3/Charge/TransactionIPN",
            "shopId": "69876357",
            "transactions": [
              {"id": "5cd1b2538c4b4fb3939ea75310b3210f"}
            ]
           }'
 */

/**
 * I initialize the PHP SDK
 */
require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/keys.php';

/** 
 * Initialize the SDK 
 * Please update your keys in keys.php
 */
$client = new LyraNetwork\Client();  
$client->setPrivateKey($_privateKey);       /* key defined in keys.php file */
$client->setPublicKey($_publicKey);         /* key defined in keys.php file */
$client->setEndpoint($_endpoint);           /* REST API endpoint defined in keys.php file */

/* Get Raw JSON data from the IPN and decode it */
$rawJson = file_get_contents('php://input');
$json = json_decode($rawJson, true);

/* No data ? there is something wrong */
if (is_null($json)) {
    throw new Exception("invalid or empty json data!");
}

/* Retrieve the billingTransaction id from the IPN data */
$billingTransactionId = $json["transactions"][0]["id"];

/** 
 * We check the billingTransaction status using Charge/Get web-service
 */
$store = array("id" => $billingTransactionId);
$response = $client->post('Charge/Get', $store);

/* Check if there is no errors */
if ($response['status'] != 'SUCCESS') {
    $error = $response['answer'];
    throw new Exception("error " . $error['errorCode'] . ": " . $error['errorMessage'] );
}

/* Now I have the billingTransaction object */
$billingTransaction = $response['answer'];

/* I update my database if needed */
/* Add here your custom code */ 

/**
 * Message returned to the IPN caller
 * You can return want you want but
 * HTTP response code should be 200
 */
print "OK!";
?>