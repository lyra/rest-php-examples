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

  <script type="text/javascript">
    // RequireJS Configuration
    var requirejs = {
        paths: {
            krypton:      '<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/stable/kr-payment-form.min',
            kryptonTheme: '<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/ext/classic'
        }
    };
  </script>
  
  <script src="https://requirejs.org/docs/release/2.3.6/minified/require.js" type="text/javascript"></script>
  
  <!-- Javascript form library loaded with requirejs-->
  <script type="text/javascript">
    requirejs(['krypton', 'kryptonTheme'], function() {
      // use KR global variable to manipulate the form library
      // for example here, we intercept the error message
      KR.onError( function(event) { 
        var code = event.errorCode;
        var message = event.errorMessage;
        var myMessage = code + ": " + message; 
        console.log(myMessage);
      });
    });    
  </script>

  <!-- theme and plugins. should be loaded after the javascript library -->
  <!-- not mandatory but helps to have a nice payment form out of the box -->
  <link rel="stylesheet" 
   href="<?php echo $client->getClientEndpoint();?>/static/js/krypton-client/V4.0/ext/classic-reset.css">
</head>
<body style="padding-top:20px">
  <!-- payment form with configuration directives -->
  <div class="kr-embedded"
       kr-public-key="<?php echo $client->getPublicKey();?>"
       kr-post-url-success="/paid.php"
       kr-post-url-refused="/refused.php"
       kr-form-token="<?php echo $formToken;?>">

    <!-- payment form fields -->
    <div class="kr-pan"></div>
    <div class="kr-expiry"></div>
    <div class="kr-security-code"></div>  

    <!-- payment form submit button -->
    <button class="kr-payment-button"></button>

    <!-- error zone -->
    <div class="kr-form-error"></div>
  </div>  
</body>
</html>
