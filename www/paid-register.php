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

/* No POST data ? paid page in not called after a payment form */
if (empty($_POST)) {
    throw new Exception("no post data received!");
}

/* Check the SHA256 value to detect parameter changes */
$sha256Key = $_shaKey; /* key defined in keys.php file */
$sha256String =  $_POST["kr_billingTransaction"] . ":" . $sha256Key;
$validSha256 = hash("sha256", $sha256String);

if ($validSha256 != $_POST['kr_sha256']) {
    //something wrong, probably a fraud ....
    throw new Exception("SHA256 error");
}

/** 
 * To check if the payment has been paid in a secure way
 * I retrieve the billingTransaction values from Charge/Get web-service
 */
$store = array("id" => $_POST["kr_billingTransaction"]);
$response = $client->post('Charge/Get', $store);

/* Check if there is no errors */
if ($response['status'] != 'SUCCESS') {
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

</div>

<h2>card is registered with ID: <?php print $billingTransaction['paymentMethod'];?></h2>

<a href="chargeAToken.php?token=<?php print $billingTransaction['paymentMethod'];?>">
    Try to charge <?php print $billingTransaction['paymentMethod'];?> card
</a>


<script type="text/javascript">
    $(document).ready(function() {
        $('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });
    });
</script>
</body></html>