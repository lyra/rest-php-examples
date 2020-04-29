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
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../keys.php';
require_once __DIR__ . '/../../helpers.php';

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

  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

  <!-- Javascript library. Should be loaded in head section -->
  <script 
  src="<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
   kr-public-key="<?php echo $client->getPublicKey();?>"
   kr-post-url-success="/paid.php">
  </script>

  <!-- theme and plugins. should be loaded after the javascript library -->
  <!-- not mandatory but helps to have a nice payment form out of the box -->
  <link rel="stylesheet" 
   href="<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/ext/classic-reset.css">
  <script 
   src="<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/ext/classic.js">
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
          KR.onBrandChanged( function({KR, cardInfo}) {
            var myMessage = "brand selected: " + cardInfo.brand;

            $("#custommessage").html(myMessage);
          });
    });
  </script>
</head>
<body style="padding-top:20px">
  <!-- payment form -->
  <div class="kr-embedded"
   kr-form-token="<?php echo $formToken;?>">

    <!-- payment form fields -->
    <div class="kr-pan"></div>
    <div class="kr-expiry"></div>
    <div class="kr-security-code"></div>  

    <!-- payment form submit button -->
    <button class="kr-payment-button"></button>
  </div>  
  <div id="custommessage"></div>
</body>
</html>
