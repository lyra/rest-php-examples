<?php 
/**
 * Embbeded Form minimal integration example
 * 
 * To run the example, go to 
 * hhttps://github.com/lyra/rest-php-example
 */

/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../keys.php';
require_once __DIR__ . '/../helpers.php';

/** 
 * Initialize the SDK 
 * see keys.php
 */
$client = new Lyra\Client();

/**
 * I create a formToken
 */
$store = array("amount" => 250, 
"currency" => "EUR", 
"orderId" => uniqid("MyOrderId"),
"customer" => array(
  "email" => "sample@example.com"
));
$response = $client->post("V4/Charge/CreatePayment", $store);

/* I check if there are some errors */
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

  <!-- Javascript library. Should be loaded in head section -->
  <script 
   src="<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
   kr-public-key="<?php echo $client->getPublicKey();?>"
   kr-post-url-success="paid.php"
   kr-language="es-CO">
  </script>

  <!-- theme and plugins. should be loaded after the javascript library -->
  <!-- not mandatory but helps to have a nice payment form out of the box -->
  <link rel="stylesheet" 
   href="<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/ext/neon-reset.css">
  <script 
   src="<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/ext/neon.js">
  </script>

  <!-- define the merchant callback called when a new BIN is entered by the buyer -->
  <!-- Should return the new formToken is the price is changed, or the original one if not -->
  <script type="text/javascript">
      KR.setBinUpdateNotificationUrl('/amount_update/AmountUpdateCallback.php');
   </script>

</head>
<body style="padding-top:20px">

  <!-- payment form -->
  <div class="kr-smart-form"
   kr-form-token="<?php echo $formToken;?>">
  </div>  

   <div>
      59701003 (MASTERCARD TEST CARDS): 0,50€ discount<br>
      37828200 (AMEX TEST CARDS): 1,00€ discount<br>
      51001200 (MASTERCARD_DEBIT): timeout (15s)<br>
   </div>

</body>
</html>