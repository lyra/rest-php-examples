<!DOCTYPE html>
<?php 
/**
* Popin Form VueJS example
* 
* To run the example, go to 
* https://github.com/LyraNetwork/krypton-php-examples
*/

/**
* I initialize the PHP SDK
*/
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../keys.php';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VueJS Popin Form</title>
    <script src="<?php $client->getEndpoint()?>/V3.1/stable/kr-payment-form.min.js"
        kr-public-key="<?php echo $_publicKey;?>"
        kr-post-url-success="paid.php"
        kr-shop-name="My company"
        kr-button-label="Pay now!"
        kr-order-summary="super bike">
    </script>
    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- VueJS library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.3.4/vue.min.js"></script>
</head>
<body style="padding-top:20px">
    <div id="paymentFormApp">
        <!-- Create form data -->
        <input v-model="amount" name="amount" type="number" step="0.01"/>
        <select v-model="currency" name="currency">
            <option value="EUR">EUR</option>
            <option value="USD">USD</option>
        </select>
        <button v-on:click="createForm">Create or update form</button>
        <!-- Popin form -->
        <div class="form" v-if="formToken !== ''">
            <div class="kr-checkout"></div>
            <p v-html="postData"></p>
        </div>
        <!-- Error message -->
        <p v-html="errorMessage" style="color:red"></p>
    </div>

    <!-- VueJS app -->
    <script type="text/javascript">
        var paymentFormApp = new Vue({
            el: '#paymentFormApp',
            data: {
                amount: 1.50,
                currency: 'EUR',
                formToken: '',
                postData: '',
                errorMessage: ''
            },
            methods: {
                createForm: function() {
                    var _this = this;
                    /**
                     * I use jquery to request the formToken with the submitted
                     * amount and currency data
                     */
                    $.ajax({
                        method: "POST",
                        data: {
                            amount: this.amount, 
                            currency: this.currency
                        },
                        url: `/createToken.php`,
                        success: function(response) {
                            // If the response is successful, I set the formToken variable 
                            _this.formToken = response;
                            _this.errorMessage = '';

                            /** 
                             * After data setting, I force vue re-render to see the changes.
                             * Necessary step due to I'm setting the data inside a callback.
                             */
                            _this.$forceUpdate();

                            // I call to KR.updateForm to render the form
                            window.KR.updateForm(response).then(function() {

                                /**
                                 * API post request to '/paymentDone/submit', which executes the callback
                                 * when the payment is intercepted.
                                 */
                                window.KR.post("/paymentDone/submit", {
                                    callback: function(paymentStore) {
                                        /**
                                         * When the paymentData is recieved, I set the vue variable
                                         * postData to show the data on '<p v-html="postData"></p>'.
                                         */
                                        _this.postData = JSON.stringify(paymentStore.json);
                                        _this.errorMessage = '';
                                        _this.$forceUpdate();

                                        // I return false to avoid the post redirection.
                                        return false;
                                    }
                                });
                            }).catch(function(){});
                        },
                        error: function(error) {
                            // If the response is not ok, I show the error data
                            _this.errorMessage = error.responseText;
                            _this.$forceUpdate();
                        }
                    });

                    // API post request to "/listeners", which allows to recieve the errors from client.
                    window.KR.post("/listeners", {
                        events: ["legacy_fireError"],
                        callback: (error) => {
                            // When any error is recieved, I show the data.
                            _this.errorMessage = error.code + ' - ' + error.message;
                            _this.$forceUpdate();
                        }
                    });
                }
            }
        });  
    </script>
</body>
</html>