<?php 
/**
 * Embbeded Form minimal integration example
 * With a card token registration enabled
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

/**
 * I create a formToken
 * With register card option set to true 
 * to register the card for later use
 */
$cardOptions = array("register" => true);
$paymentMethodOptions = array("cardOptions" => $cardOptions);
$store = array("amount" => 150, "currency" => "EUR", "paymentMethodOptions" => $paymentMethodOptions);
$response = $client->post("Charge/CreatePayment", $store);

/* I check if there is some errors */
if ($response['status'] != 'SUCCESS') {
    /* an error occurs, I throw an exception */
    $error = $response['answer'];
    throw new Exception("error " . $error['errorCode'] . ": " . $error['errorMessage'] );
}

/* everything is fine, I extract the formToken */
$formToken = $response["answer"]["formToken"];

print "newly generated formToken is $formToken <br>\n";

?>

<h1>Create a card token demo</h1>

<!-- payment form HTML code -->
<div class="kr-embedded">
    <div class="kr-pan"></div>
    <div class="kr-expiry"></div>
    <div class="kr-security-code"></div>

    <div class="kr-form-error"></div>

    <button class="kr-payment-button kr-text-animated">Pay now!</button>
</div>

<!-- Javascript library. Should be loaded after the payment form -->
<script src="<?php echo $client->getEndPoint();?>/static/js/krypton-client/V3/stable/kr.min.js?formToken=<?php echo $formToken;?>"
    kr-public-key="<?php echo $client->getPublicKey();?>"
    kr-post-url="paid-register.php"
    kr-theme="icons-1">
</script>