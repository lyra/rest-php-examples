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
"customer" => array(
  "email" => "sample@example.com",
  "orderId" => uniqid("MyOrderId")
));
$response = $client->post("V4/Charge/CreatePayment", $store);

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

  <style>
    /* Custom button styling */
    .kr-embedded button#myPaymentButton {
      width: 100%;
      height: 50px;
      background-color: #00796B;
      display: flex;
      flex-direction: row;
      justify-content: center;
      align-items: center;
      position: relative;
      cursor: pointer;
      border-radius: 5px;
    }
    .kr-embedded button#myPaymentButton span.label {
      color: #fff;
      font-family: 'Roboto', sans-serif;
      cursor: pointer;
    }

    .kr-embedded button#myPaymentButton .wrapper {
      display: none;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%); 
    }

    /* Loading state (hide label, show animation) */
    .kr-embedded button#myPaymentButton.loading span.label {
      display: none;
    }
    .kr-embedded button#myPaymentButton.loading .wrapper {
      display: block;
    }

    /* Loading animation */
    .kr-embedded button#myPaymentButton .circle{
      display: inline-block;
      width: 10px;
      height: 10px;
      background-color: #CCC;
      border-radius: 50%;
      animation: loading 1s cubic-bezier(.8, .5, .2, 1.4) infinite;
      transform-origin: bottom center;
      position: relative;
    }
    @keyframes loading{
      0%{
        transform: translateY(-5px);
        background-color: #CCC;
      }
      50%{
        transform: translateY(5px);
        background-color: #FFF;
      }
      100%{
        transform: translateY(-5px);
        background-color: #CCC;
      }
    }
    .kr-embedded button#myPaymentButton .circle-1{
      animation-delay: -0.4s;
    }
    .kr-embedded button#myPaymentButton .circle-2{
      animation-delay: -0.3s;
    }
    .kr-embedded button#myPaymentButton .circle-3{
      animation-delay: -0.2s;
    }
    .kr-embedded button#myPaymentButton .circle-4{
      animation-delay: -0.1s;
    }
  </style>
</head>
<body style="padding-top:20px">
  <!-- payment form -->
  <div class="kr-embedded"
   kr-form-token="<?php echo $formToken;?>">

    <!-- payment form fields -->
    <div class="kr-pan"></div>
    <div class="kr-expiry"></div>
    <div class="kr-security-code"></div>  

    <!-- error zone -->
    <div class="kr-form-error"></div>

    <!-- Custom payment button -->
    <button id="myPaymentButton">
      <span class="label">Click to Pay</span>
      <!-- Animation -->
      <div class="wrapper">
        <span class="circle circle-1"></span>
        <span class="circle circle-2"></span>
        <span class="circle circle-3"></span>
        <span class="circle circle-4"></span>
      </div>
    </button>
    <!-- Invisible payment button -->
    <button class="kr-payment-button" style="display: none;"></button>
  </div>
  <script type="text/javascript">
    KR.onFormReady(function() {
      var $btn = $('button#myPaymentButton')
      var removeLoading = function (e) {
        $btn.removeClass('loading')
      }
      // Listen to error or submit response to remove the animation
      KR.onError(removeLoading)
      KR.onSubmit(removeLoading)
      // Manage the custom payment button click
      $btn.click(function(e) {
        // Trigger the submit
        KR.submit().then(function() {
          $btn.addClass('loading')
        }).catch()
      })
    })
  </script>
</body>
</html>
