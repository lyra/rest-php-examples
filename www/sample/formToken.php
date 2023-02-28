<?php
 include_once 'config.php'; 

// STEP 1 : the data request to create the payment
$data = array(
    'orderId' => uniqid('order_'),
    'amount' => 250, 
    'currency' => 'EUR',
    'customer' => array(
        'email' => 'sample@example.com',
        'reference' => uniqid('customer_'),
        'billingDetails' => array(
            'language' => 'fr',
            'title' => 'M.',
            'firstName' => 'Test',
            'lastName' => 'Krypton',
            'category' => 'PRIVATE',
            'address' => '25 rue de l\'Innovation', 
            'zipCode' => '31000',
            'city' => 'Testville',
            'phoneNumber' => '0615665555',
            'country' => 'FR'
       )
    ),
    'transactionOptions' => array(
        'cardOptions' => array(
            'retry' => 1
        )
    )
);

// STEP 3 : call the endpoint V4/Charge/CreatePayment with the json data.


$response = post('V4/Charge/CreatePayment', json_encode($data));

// Check if there is errors.
if ($response['status'] != 'SUCCESS') {
    // An error occurs, throw exception
    $error = $response['answer'];
    throw new Exception('error ' . $error['errorCode'] . ': ' . $error['errorMessage']);
}


// STEP 4 : the answer with the creation of the formToken
// Everything is fine, extract the formToken
$formToken = $response['answer']['formToken'];


// STEP 2 : send data with curl command with a function

function post($target, $data)
{
    $url = 'https://api.payzen.eu/api-payment/' . $target;

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_USERAGENT, 'test');
    curl_setopt($curl, CURLOPT_USERPWD, USERNAME . ':' . PASSWORD);
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 45);
    curl_setopt($curl, CURLOPT_TIMEOUT, 45);

    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

    $raw_response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    if (!in_array($status, array(200, 401))) {
        curl_close($curl);

        throw new \Exception("Error: call to URL $url failed with unexpected status $status, response $raw_response.");
    }

    $response = json_decode($raw_response, true);
    if (!is_array($response)) {
        $error = curl_error($curl);
        $errno = curl_errno($curl);

        curl_close($curl);

        throw new \Exception("Error: call to URL $url failed, response $raw_response, curl_error $error, curl_errno $errno.");
    }
    curl_close($curl);
    return $response;
}