<?php
/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/keys.php';
require_once __DIR__ . '/helpers.php';
/**
 * Initialize the SDK
 * see keys.php
 */
function create_pagos(string $tipoForm, float $monto,  $compra, string $token = null) {
    $client = new Lyra\Client();

    $total = number_format($monto, 2, '', '');
    $paytoken = $token;

    if (isset($_GET['requestObject'])) {
        $store = json_decode($_GET['requestObject']);
    } else {
        switch ($tipoForm){
            case "REGISTER_PAY":
                $store = array( "amount" => $total,
                    "formAction" => "REGISTER_PAY",
                    "currency" => "ARS",
                    "orderId" => uniqid($compra->get_id()),
                    "customer" => array(
                        "email" => $compra->get_idUser()->get_email()

                    ));
                break;

            case "SILENT":
                $store = array( "amount" => $total,
                    "currency" => "ARS",
                    "paymentMethodToken"=> $paytoken,
                    "formAction" => "SILENT",
                    "orderId" => uniqid($compra->get_id()),
                    "customer" => array(
                        "email" => $compra->get_idUser()->get_email(),
                        "reference"=> "12345678"
                    )
                );
                break;
        }

    }

    $response = $client->post("V4/Charge/CreatePayment", $store);

//* I check if there are some errors */
    if ($response['status'] != 'SUCCESS') {
        /* an error occurs */
        $error = $response['answer'];
        header("Content-Type", "application/json");
        header('HTTP/1.1 500 Internal Server Error');
        echo '{"error": "' . $error['errorCode'] . '", "_type": "DemoError" }';
        die();
    }

    /* everything is fine, I extract the formToken */
    $formToken = $response["answer"]["formToken"];
//header("Content-Type", "application/json");
//echo '{"formToken": "' . $formToken . '"", "_type": "DemoFormToken" }';

}





