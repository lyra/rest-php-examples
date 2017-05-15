<?php 
/**
 * Charge a payment method using a previously
 * generated token
 * 
 * To run the example, go to 
 * https://github.com/LyraNetwork/krypton-php-examples
 */

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
$client->setUsername($_username);           /* username defined in keys.php file */
$client->setPassword($_password);           /* password defined in keys.php file */
$client->setPublicKey($_publicKey);         /* key defined in keys.php file */
$client->setEndpoint($_endpoint);           /* REST API endpoint defined in keys.php file */


/* Retrieve the token from GET parameters */
if (!array_key_exists('token', $_GET)) {
    print 'There is no token defined, start with <a href="createACardToken.php">createACardToken.php</a>';
    die();
}
$token = $_GET["token"];

/**
 * I create a formToken with the payment method token
 */
$store = array("amount" => 150, "currency" => "EUR", "paymentMethod" => $token);
$response = $client->post("Charge/CreatePayment", $store);

/* I check if there is some errors */
if ($response['status'] != 'SUCCESS') {
    /* an error occurs, I throw an exception */
    $error = $response['answer'];
    throw new Exception("error " . $error['errorCode'] . ": " . $error['errorMessage'] );
}

/* 
 * everything is fine 
 * createPayment returns directly a billingTransaction object
 */
$billingTransaction = $response["answer"];

?>

<html>
<head>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/styles/dracula.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="skinned/assets/paid.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/highlight.min.js"></script>

</head>
<body>
    <h1>Transaction paid using a payment method token !</h1>
<div class="container">

<h2>billingTransaction object is:</h2>
<pre><code class="json"><?php print json_encode($billingTransaction, JSON_PRETTY_PRINT) ?></code></pre>

Note that paymentMethodSource is set to TOKEN.

</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });
    });
</script>

<h1><a href="/">Back to demo menu</a></h1>

</body></html>