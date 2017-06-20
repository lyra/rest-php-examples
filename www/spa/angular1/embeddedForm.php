<!DOCTYPE html>
<?php 
/**
* Embbeded Form angularJS example
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
    <title>AngularJS Embedded Form</title>
    <script src="https://krypton.purebilling.io/V3.1/stable/kr-payment-form.min.js"
        kr-public-key="<?php echo $_publicKey;?>"
        kr-post-url="paid.php"
        kr-theme="icons-2">
    </script>
    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- AngularJS library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.6.1/angular.min.js"></script>
</head>
<body ng-app="paymentFormApp">
    <div ng-controller="FormController">
        <!-- Create form data -->
        <input ng-model="amount" name="amount" type="number" step="0.01"/>
        <select ng-model="currency" name="currency">
            <option value="EUR">EUR</option>
            <option value="USD">USD</option>
        </select>
        <button ng-click="createForm()">Create form</button>
        <!-- Embedded form -->
        <div class="form" ng-if="formToken">
            <div class="kr-embedded">
                <div class="kr-pan"></div>
                <div class="kr-expiry"></div>
                <div class="kr-security-code"></div>
                <button class="kr-payment-button">Pay now!</button>
            </div>
            <p ng-bind="postData"></p>
        </div>
        <!-- Error message -->
        <p ng-bind="errorMessage" style="color:red"></p>
    </div>

    <script type="text/javascript">
        // I declare the new module (ng-app)
        var paymentFormApp = angular.module('paymentFormApp', []);

        // I add a new controller to the module (ng-controller), including the necessary $timeout service
        paymentFormApp.controller('FormController', ['$scope', '$timeout', function($scope, $timeout) {
            // I set the default amount & currency
            $scope.amount = 1.50;
            $scope.currency = "EUR";

            $scope.createForm = function() {
                /**
                 * I use jquery to request the formToken with the submitted
                 * amount and currency data
                 */
                $.ajax({
                    method: "POST",
                    data: {
                        amount: $scope.amount, 
                        currency: $scope.currency
                    },
                    url: `/createToken.php`,
                    success: function(response) {
                        // If the response is successful, I set the formToken variable and 
                        $scope.formToken = response;
                        $scope.errorMessage = '';

                        /** 
                         * After data setting, I update angular bindings to see the changes.
                         * Necessary step due to I'm setting the data inside a callback.
                         */
                        $timeout(function() {
                            $scope.$apply();
                            
                            // I call to KR.updateForm to render the form
                            window.KR.updateForm(response).then(function() {

                                /**
                                * API post request to '/paymentDone/submit', which executes the callback
                                * when the payment is intercepted.
                                */
                                window.KR.post("/paymentDone/submit", {
                                    callback: function(paymentStore) {
                                        /**
                                        * When the paymentData is recieved, I declare the angular variable
                                        * postData to show the data on '<p ng-bind="postData"></p>'.
                                        */
                                        $scope.postData = JSON.stringify(paymentStore.json);

                                        $timeout(function() {
                                            $scope.$apply();
                                        });

                                        // I return false to avoid the post redirection.
                                        return false;
                                    }
                                });
                            }).catch(function(){});
                        });
                    },
                    error: function(error) {
                        // If the response is not ok, I show the error data
                        $scope.errorMessage = error.responseText;
                        $timeout(function() {
                            $scope.$apply();
                        });
                    }
                });
            };

            // API post request to "/listeners", which allows to recieve the errors from client.
            window.KR.post("/listeners", {
                events: ["legacy_fireError"],
                callback: (error) => {
                    // When any error is recieved, I show the data.
                    $scope.errorMessage = error.code + ' - ' + error.message;
                    $timeout(function() {
                        $scope.$apply();
                    });
                }
            });
        }]);
    </script>
</body>
</html>