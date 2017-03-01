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
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . '/keys.php';

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
 */
$store = array("amount" => 150, "currency" => "EUR");
$response = $client->post("Charge/CreatePayment", $store);

/* I check if there is some errors */
if ($response['status'] != 'SUCCESS') {
    /* an error occurs, I throw an exception */
    $error = $response['answer'];
    throw new Exception("error " . $error['errorCode'] . ": " . $error['errorMessage'] );
}

/* everything is fine, I extract the formToken */
$formToken = $response["answer"]["formToken"];

print "newly generated formToken is " . $formToken . " <br>\n";

?>
<!-- dots loader style from https://martinwolf.org/blog/2015/01/pure-css-savingloading-dots-animation-->
<link rel="stylesheet" href="css/dot_loader.css">
<link rel="stylesheet" href="css/button.css">

<!-- payment form HTML code -->
<div class="kr-embedded">
    <div class="kr-pan"></div>
    <div class="kr-expiry"></div>
    <div class="kr-security-code"></div>

    <div class="kr-row-no-gutter">
        <div class="kr-payment-button-wrap">
            <button class="kr-payment-button kr-text-animated">
                <span class="regular-label">Pay now!</span>

                <!-- necessary element to print dots loader -->
                <div class="waiting-animation">
                    <div class="dot-wrapper">
                        <div class="dot"></div>
                        <div class="dot"></div>
                        <div class="dot"></div>
                    </div>
                </div>
            </button>
        </div>
        <div class="kr-payment-button-wrap">
            <div class="kr-form-error kr-form-error-doc-embedded"></div>
        </div>

    </div>

</div>

<!-- Javascript library. Should be loaded after the payment form -->
<script src="<?php echo $client->getEndPoint();?>/static/js/krypton-client/V3/stable/kr.min.js?formToken=<?php echo $formToken;?>"
    kr-public-key="<?php echo $client->getPublicKey();?>"
    kr-post-url="../paid.php"
    kr-theme="icons-1">
</script>

<!-- listen events to show and hide the dots loading -->
<script language="javascript">
    KR.$(document).ready(function() {
        var $krLoading = KR.$(".waiting-animation");
        var $spanButton = KR.$(".regular-label");
        var $krError = KR.$(".kr-form-error");

        // shows loading when the payment starts
        KR.event.handler.listen("paymentStart", function(error) {
            $spanButton.hide();
            // $krLoading.show();
            $krLoading.css('display', 'inline-block');
            $krError.hide();
        });
        // hides loading if the payment fails
        KR.event.handler.listen("fireError", function(error) {
            $spanButton.show();
            $krLoading.hide();
            $krError.show();
        });
    });

</script>