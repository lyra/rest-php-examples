<?php 
/**
 * REST API example creating a payment method token
 * 
 * To run the example, go to 
 * hhttps://github.com/lyra/rest-php-example
 */

/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/keys.PCI.php';
require_once __DIR__ . '/helpers.php';

/** 
 * Initialize the SDK 
 * see keys.php
 */
$client = new Lyra\Client();

/**
 * Define the card to use
 */
$card = array(
  "paymentMethodType" => "CARD",
  "pan" => "4970100000000055",
  "expiryMonth" => "11",
  "expiryYear" => "21",
  "securityCode" => "123"
);

/**
 * starting to create a transaction
 */
$store = array(
  "amount" => 250, 
  "currency" => "EUR",
  "formAction" => "REGISTER_PAY",
  "paymentForms" => array($card),
  "customer" => array(
    "email" => "sample@example.com",
    "orderId" => uniqid("MyOrderId")
));

/**
 * do the web-service call
 */
$response = $client->post("V4/Charge/CreatePayment", $store);

/* I check if there are some errors */
if ($response['status'] != 'SUCCESS') {
    /* an error occurs, I throw an exception */
    display_error($response);
    $error = $response['answer'];
    throw new Exception("error " . $error['errorCode'] . ": " . $error['errorMessage'] );
}

?>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/styles/dracula.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="skinned/assets/paid.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/highlight.min.js"></script>

    <script type="text/javascript">
    $(document).ready(function() {
        $('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });
    });
</script>
</head>
<body>
<div class="container">  
    <h2>web-service request:</h2>
    <pre><code class="json"><?php print json_encode($store, JSON_PRETTY_PRINT) ?></code></pre>

    <h2>web-service answer:</h2>
    <pre><code class="json"><?php print json_encode($response, JSON_PRETTY_PRINT) ?></code></pre>
</div>

<?php
/* I check if it's really paid */
if ($response['answer']['orderStatus'] != 'PAID') {
     $title = "Transaction not paid !";
} else {
    $title = "Transaction paid !";
}
?>

<h1><?php echo $title;?></h1>
<h1><a href="/">Back to demo menu</a></h1>

</body></html>
