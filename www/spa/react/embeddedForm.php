<!DOCTYPE html>
<?php 
/**
* Embbeded Form React example
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
    <title>React Embedded Form</title>
    <script src="https://krypton.purebilling.io/V3.1/stable/kr-payment-form.min.js"
        kr-public-key="<?php echo $_publicKey;?>"
        kr-post-url="paid.php"
        kr-theme="icons-2">
    </script>
    <!-- jQuery library -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- React library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.6.1/react.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/react/15.6.1/react-dom.js"></script>
    <!-- Babel transpiler (for ECMA6) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/babel-standalone/6.25.0/babel.js"></script>
</head>
<body>
    <div id="paymentForm"></div>

    <script type="text/babel">
        class PaymentFormControl extends React.Component {
            constructor(props) {
                super(props);
                this.handleInputChange = this.handleInputChange.bind(this);
                this.createForm = this.createForm.bind(this);
                this.state = {
                    amount: 1.50,
                    currency: "EUR",
                    formToken: '',
                    postData: ''
                };
            }

            // Method to handle input changes
            handleInputChange(event) {
                const name = event.target.name;

                this.setState({
                    [name]: event.target.value
                });
            }

            createForm() {
                const _this = this;
                /**
                 * I use jquery to request the formToken with the submitted
                 * amount and currency data
                 */
                $.ajax({
                    method: "POST",
                    data: {
                        amount: this.state.amount, 
                        currency: this.state.currency
                    },
                    url: `/createToken.php`,
                    success: function(response) {
                        // If the response is successful, I set the formToken variable 
                        _this.setState({
                            formToken: response,
                            errorMessage: ''
                        });

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
                                    * postData to show the data on '<p>{this.state.postData}</p>'.
                                    */
                                    _this.setState({
                                        postData: JSON.stringify(paymentStore.json),
                                        errorMessage: ''
                                    });

                                    // I return false to avoid the post redirection.
                                    return false;
                                }
                            });
                        }).catch(function(){});
                    },
                    error: function(error) {
                        // If the response is not ok, I show the error data
                        _this.setState({
                            errorMessage: error.responseText
                        });
                    }
                });

                // API post request to "/listeners", which allows to recieve the errors from client.
                window.KR.post("/listeners", {
                    events: ["legacy_fireError"],
                    callback: (error) => {
                        // When any error is recieved, I show the data.
                        _this.setState({
                            errorMessage: error.code + ' - ' + error.message
                        });
                    }
                });
            }

            render() {
                let form = null;

                // Only render the payment form when the formToken has a value
                if(this.state.formToken) {
                    form = (
                        <div is class="form">
                            <div is class="kr-embedded">
                                <div is class="kr-pan"></div>
                                <div is class="kr-expiry"></div>
                                <div is class="kr-security-code"></div>
                                <button is class="kr-payment-button">Pay now!</button>
                            </div>
                        </div>
                    );
                }

                return (
                    <div>
                        <input value={this.state.amount} name="amount" type="number" is step="0.01" onChange={this.handleInputChange}/>
                        <select value={this.state.currency} name="currency" onChange={this.handleInputChange}>
                            <option value="EUR">EUR</option>
                            <option value="USD">USD</option>
                        </select>
                        <button onClick={this.createForm}>Create form</button>
                        {form}
                        <p>{this.state.postData}</p>
                        <p style={{color:"red"}}>{this.state.errorMessage}</p>
                    </div>
                );
            }
        }

        ReactDOM.render(<PaymentFormControl/>, document.getElementById('paymentForm'));
    </script>
</body>
</html>