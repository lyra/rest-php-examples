<!DOCTYPE html>
<?php
/**
* Embbeded Form VueJS example
*
* To run the example, go to
* https://github.com/LyraNetwork/krypton-php-examples
*/

/**
* I initialize the PHP SDK
*/
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../keys.php';
$_endpoint = "https://krypton.purebilling.io";
?>

  <html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VueJS Embedded Form</title>
    <script src="<?php echo $_endpoint?>/static/js/krypton-client/V3.1/stable/kr-payment-form.min.js" 
        kr-public-key="<?php echo $_publicKey;?>" 
        kr-post-url-success="paid.php">
    </script>

    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- VueJS library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.13/vue.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.3.4/vue-resource.min.js"></script>
    <!-- Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- MaterializeCSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <!-- HighlightJS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/dracula.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/highlight.min.js"></script>

    <!-- Classic -->
    <link href="<?php echo $_endpoint?>/static/js/krypton-client/V3.1/ext/classic.css" rel="stylesheet">
    <script src="<?php echo $_endpoint?>/static/js/krypton-client/V3.1/ext/classic.js"></script>

    <style>
      #paymentFormApp {
        margin-top: 10px;
      }
      
      form {
        padding-top: 10px;
      }

      div#errorData {
        border: 1px solid black;
      }

      #errorData table thead {
        background-color: #B71C1C;
        color: #FFFFFF;
        border: 0;
      }

      #errorData table thead th {
          border-radius: 0;
      }

      #errorData table tr th {
          padding-left: 15px;
      }

      #errorData table tr th:first-child {
          width: 30%;
      }

      #errorData table tr th:last-child {
          width: 70%;
      }
    </style>
  </head>

  <body>
    <div id="paymentFormApp">
        <!-- Create form data -->
        <div class="container">
            <div class="row">
                <div class="col s12 m6">
                    <div class="card">
                        <div class="card-content">
                            <span class="card-title"><i class="material-icons left">shopping_cart</i>Shopping cart</span>
                            <form class="row">
                                <div class="input-field col s6">
                                    <label for="amount">Amount</label>
                                    <input v-model="amount" v-on:keyup="updateForm" id="amount" name="amount" type="number" step="0.01" />
                                </div>
                                <label class="col s6">Currency</label>
                                <select class="browser-default col s6" v-model="currency" v-on:change="updateForm">
                                    <option>EUR</option>
                                    <!-- <option>USD</option> -->
                                </select>
                                <label class="col s12">Transport</label>
                                <select class="browser-default col s12" v-model="transport" v-on:change="updateForm">
                                    <option>Standard</option>
                                    <option>Express</option>
                                </select>
                            </form>
                        </div>
                        <div class="card-action black">
                            <a href="#" class="white-text" v-on:click="updateForm"><i class="material-icons left">replay</i>update form</a>
                        </div>
                    </div>
                </div>

                <!-- Embedded form -->
                <div class="col s6" v-if="formToken !== ''">
                    <div class="kr-embedded">
                        <div class="kr-pan"></div>
                        <div class="kr-expiry"></div>
                        <div class="kr-security-code"></div>
                        <button class="kr-payment-button"></button>
                        <div class="kr-form-error"></div>
                    </div>
                </div>
                
                <!-- Webservice Error Message -->
                <div class="col s12" v-show="errorCode !== ''" style="display:none;">
                    <div id="errorData">
                        <table class="striped">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
    
                            <tbody>
                                <tr>
                                    <td>web service:</td>
                                    <td>{{webService}}</td>
                                </tr>
                                <tr>
                                    <td>errorCode:</td>
                                    <td>{{errorCode}}</td>
                                </tr>
                                <tr>
                                    <td>errorMessage:</td>
                                    <td>{{errorMessage}}</td>
                                </tr>
                                <tr>
                                    <td>detailedErrorCode:</td>
                                    <td>{{detailedErrorCode}}</td>
                                </tr>
                                <tr>
                                    <td>detailedErrorMessage:</td>
                                    <td>{{detailedErrorMessage}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <!-- POST Data -->
                <div class="col s12" v-show="postData !== ''">
                    <pre v-highlightjs="postData"><code class="json"></code></pre>
                </div>
            </div>
        </div>
        
    </div>

    <!-- VueJS app -->
    <script type="text/javascript">
        Vue.directive('highlightjs', {
            deep: true,
            // When the postData is recieved, highlight is applied
            componentUpdated: function(el, binding) {
                let targets = el.querySelectorAll('code')
                targets.forEach((target) => {
                    if (binding.value) {
                        target.textContent = binding.value
                        hljs.highlightBlock(target)
                    }
                })
            }
        });
        
        var paymentFormApp = new Vue({
            el: '#paymentFormApp',
            data: {
                amount: 12.50,
                currency: 'EUR',
                transport: 'Standard',
                formToken: '',
                postData: '',
                // Error Data
                webService: '',
                errorCode: '',
                errorMessage: '',
                detailedErrorCode: '',
                detailedErrorMessage: ''
            },
            mounted: function() {
                const _this = this;
                
                // Listen errors
                window.KR.post("/listeners", {
                    events: ["fireError", "paymentStart"],
                    callback: (data, event) => {
                        if(event == "fireError") {
                            /**
                             * If the error recieved is a webservice error
                             * show the table with data
                             */
                            if(data.error.code.indexOf('INT') == 0) {
                                _this.errorCode = data.error.code;
                                _this.errorMessage = data.error.message;
                            }
                        } else if(event == "paymentStart") {
                            _this.webService = "";
                            _this.errorCode = "";
                            _this.errorMessage = "";
                            _this.detailedErrorCode = "";
                            _this.detailedErrorMessage = "";
                        }
                    }
                });

                // Init the form with default values
                this.updateForm();
            },
            methods: {
                updateForm: function() {
                    var _this = this;

                    this.getToken().then(function(response) {
                            this.formToken = response.data;
                            window.KR.setFormToken(_this.formToken);
                        })
                        .then(function() {
                            _this.setPostCallbacks();
                        })
                        .catch(console.log);
                },
                getRequestObject: function() {
                    var _this = this;
                    var transportAmount;

                    switch(this.transport.toLowerCase()) {
                        case "standard":
                            transportAmount = 2.50;
                            break;
                        case "express":
                            transportAmount = 4.50;
                            break;
                    }
                    
                    var totalAmount = parseInt((parseFloat(this.amount) + transportAmount) * 100);
                    var requestObject = {
                        "amount": totalAmount,
                        "currency": this.currency
                    };
                    
                    return requestObject;
                },
                getToken: function() {
                    var requestObject = encodeURIComponent(JSON.stringify(this.getRequestObject()));
                    return this.$http.get(window.location.origin + '/createToken.php?requestObject=' + requestObject);
                },
                setPostCallbacks: function(postType) {
                    var _this = this;

                    window.KR.post('/paymentDone/submit', {
                        formId: null,
                        callback: function(paymentStore) {
                            _this.formatPostData(paymentStore);
                            return false;
                        },
                    });
                    window.KR.post('/paymentRefused/submit', {
                        formId: null,
                        callback: function(paymentStore) {
                            _this.formatPostData(paymentStore);
                            return false;
                        },
                    });
                },
                formatPostData: function(paymentStore) {
                    this.postData = paymentStore.post();
                    this.postData["kr-answer"] = JSON.parse(this.postData["kr-answer"]);
                    this.postData = JSON.stringify(this.postData, null, '  ');
                }
            }
        });
    </script>
  </body>

  </html>