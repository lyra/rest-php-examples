<?php 
/**
 * Embbeded Form minimal integration example
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
 * Please update your keys in keys.php
 */
$client = new LyraNetwork\Client();

/**
 * I create a formToken
 */
$store = array("amount" => 250, "currency" => "EUR");
$response = $client->post("V3/Charge/CreatePayment", $store);

/* I check if there is some errors */
if ($response['status'] != 'SUCCESS') {
    /* an error occurs, I throw an exception */
    display_error($response);
    $error = $response['answer'];
    throw new Exception("error " . $error['errorCode'] . ": " . $error['errorMessage'] );
}

/* everything is fine, I extract the formToken */
$formToken = $response["answer"]["formToken"];
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" 
   content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> 
</head>
<body>
  <!-- payment form -->
  <div class="kr-embedded"
   kr-form-token="<?php echo $formToken;?>">

    <!-- payment form fields -->
    <div class="kr-pan"></div>
    <div class="kr-expiry"></div>
    <div class="kr-security-code"></div>  

    <!-- payment form submit button -->
    <button class="kr-payment-button kr-text-animated">Pay now!</button>

    <!-- error zone -->
    <div class="kr-form-error"></div>
  </div> 
  
  <!-- Javascript library. Should be loaded after the payment form -->
  <script src="<?php echo $client->getClientEndPoint();?>/static/js/krypton-client/V3/stable/kr.min.js?formToken=<?php echo $formToken;?>"
      kr-public-key="<?php echo $client->getPublicKey();?>"
      kr-post-url="paid.V3.php"
      kr-theme="icons-1">
  </script>
</body>
</html>
