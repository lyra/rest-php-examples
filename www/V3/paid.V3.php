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
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../keys.php';
require_once __DIR__ . '/../helpers.php';

/** 
 * Initialize the SDK 
 * Please !!UPDATE!! your keys in keys.php
 */
$client = new LyraNetwork\Client();

/* No POST data ? paid page in not called after a payment form */
if (empty($_POST)) {
    throw new Exception("no post data received!");
}

/* Check the SHA256 value to detect parameter changes */
$sha256Key = $_sha256Key; /* defined in keys.php file */
$sha256String =  $_POST["kr_billingTransaction"] . ":" . $sha256Key;
$validSha256 = hash("sha256", $sha256String);

if ($validSha256 != $_POST['kr_sha256']) {
    //something wrong, probably a fraud ....
    signature_error($_POST["kr_billingTransaction"], $sha256Key, $validSha256, $_POST['kr_sha256']);
    throw new Exception("invalid signature");
}

/** 
 * To check if the payment has been paid in a secure way
 * I retrieve the billingTransaction values from Charge/Get web-service
 */
$store = array("id" => $_POST["kr_billingTransaction"]);
$response = $client->post('V3/Charge/Get', $store);

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
<h2>Data received:</h2>
<pre><code class="json"><?php print json_encode($_POST, JSON_PRETTY_PRINT) ?></code></pre>

<h2>billingTransaction object is:</h2>
<pre><code class="json"><?php print json_encode($billingTransaction, JSON_PRETTY_PRINT) ?></code></pre>

<h2>To simulate IPN call with CURL, execute in your terminal:</h2>
<pre><code class="json">
curl http://localhost:6980/ipn.php \
     -X POST \
     -H 'Content-type: application/json' \
     -d '{ "orderId": "<?echo $billingTransaction['orderId'];?>",
           "_type": "V3/Charge/TransactionIPN",
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