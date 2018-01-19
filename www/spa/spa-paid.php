<?php 
/**
 * Payment done landing page example
 * 
 * To run the example, go to 
 * https://github.com/LyraNetwork/krypton-php-examples
 */

/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/keys.php';
require_once __DIR__ . '/helpers.php';

/** 
 * Initialize the SDK 
 * Please !!UPDATE!! your keys in keys.php
 */
$client = new LyraNetwork\Client();  
$client->setUsername($_username);           /* username defined in keys.php file */
$client->setPassword($_password);           /* password defined in keys.php file */
$client->setPublicKey($_publicKey);         /* key defined in keys.php file */
$client->setEndpoint($_endpoint);           /* REST API endpoint defined in keys.php file */

/* No POST data ? paid page in not called after a payment form */
if (empty($_GET)) {
    throw new Exception("no post data received!");
}

/** 
 * To check if the payment has been paid in a secure way
 * I retrieve the billingTransaction values from V3.1/Transaction/Get web-service
 */
$store = array("id" => $_GET["kr_transaction_uuid"]);
$response = $client->post('V3.1/Transaction/Get', $store);

/* Check if there is no errors */
if ($response['status'] != 'SUCCESS') {
    display_error($response);
    $error = $response['answer'];
    throw new Exception("error " . $error['errorCode'] . ": " . $error['errorMessage'] );
}

/* Now I have the billingTransaction object */
$billingTransaction = $response['answer'];

/* I check if it's really paid */
if ($billingTransaction['status'] != 'PAID') {
     $title = "Transaction not paid !";
} else {
    $title = "Transaction paid !";
}
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
    <h1><?php echo $title;?></h1>
<div class="container">

<h2>billingTransaction object is:</h2>
<pre><code class="json"><?php print json_encode($billingTransaction, JSON_PRETTY_PRINT) ?></code></pre>

<h2>To simulate IPN call with CURL, execute in your terminal:</h2>
<pre><code class="json">
curl http://localhost:6980/ipn.php \
     -X POST \
     -H 'Content-type: application/json' \
     -d '{ "orderId": "<?echo $billingTransaction['orderId'];?>",
           "_type": "V3.1/IPNRequest",
           "shopId": "<?echo $billingTransaction['shopId'];?>",
           "transactions": [
             {"id": "<?echo $billingTransaction['id'];?>"}
           ]
          }'
</code></pre>

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
