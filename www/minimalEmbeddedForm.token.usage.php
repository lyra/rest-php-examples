<?php 
/**
 * Use a already created payment method token
 * 
 * To run the example, go to 
 * hhttps://github.com/lyra/rest-php-example
 */

/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/keys.php';
require_once __DIR__ . '/helpers.php';

/** 
 * Initialize the SDK 
 * see keys.php
 */
$client = new Lyra\Client();

/**
 * create a transaction with a payment method token
 */
$store = array(
  "amount" => 250, 
  "currency" => "EUR",
  "paymentMethodToken" => "b6e51ba31f934ac5b25ccad2a52ccd56"
);

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
