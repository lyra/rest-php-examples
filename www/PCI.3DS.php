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
 * Define the card to use (we use a 3DS enabled card)
 */
$card = array(
  "paymentMethodType" => "CARD",
  "pan" => "4970100000000022",
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
  "paymentForms" => array($card),
  "merchantPostUrlSuccess" => "http://mockbin.com/request",
  "merchantPostUrlRefused" => "http://mockbin.com/request",
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

/* I check the answer type, if it's a RedirectRequest */
/* we have to redirect the buyer to the 3DS page */
if ($response['answer']['_type'] != 'V4/Charge/RedirectRequest') {
    /* There is no 3DS requested */
    die("No 3DS requested, transaction is " + $response['answer']['orderStatus']);
}

$redirectRequest = $response['answer'];
?>
<html>
<head>
    <title>redirect to 3DS</title>
</head>
<body>
<form id="goTo3DS" action="<?php echo $redirectRequest['redirectUrl'] ?>" method="POST">
<?php
    foreach ($redirectRequest['postData'] as $key => $value) {
        echo "<input type='hidden' name='".htmlentities($key)."' value='".htmlentities($value)."'>\n";
    }
?>
</form>
<script type="text/javascript">
    document.getElementById('goTo3DS').submit();
</script>
</body>
</html>
