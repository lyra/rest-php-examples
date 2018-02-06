<?php

/**
 * Display a nice error code block
 */
function display_error($response)
{
    $error = $response['answer'];
    ?>
    <p style="font-family: Verdana,sans-serif;font-size:18px;color:#a52828;font-weight: BOLD;">web-service call returns an error:</p>
    <table style="border: 1px solid black;border-collapse: collapse;font-family: Verdana,sans-serif;line-height: 1.5;text-align: left;padding: 8px;">
            <tr style="background-color:#a52828;color:white;">
                <th style="padding: 8px;">Field</th>
                <th style="padding: 8px;">value</th>
			</tr> 
            <tr style="background-color: #f2f2f2">
              <td style="padding: 8px;">web service:</td>
              <td style="padding: 8px;"><?php echo $response['webService'];?></td>
            </tr>       
            <tr>
              <td style="padding: 8px;">errorCode:</td>
              <td style="padding: 8px;"><?php echo $error['errorCode'];?></td>
            </tr>
            <tr style="background-color: #f2f2f2">
              <td style="padding: 8px;">errorMessage:</td>
              <td style="padding: 8px;"><?php echo $error['errorMessage'];?></td>
            </tr>
            <tr>
              <td style="padding: 8px;">detailedErrorCode:</td>
              <td style="padding: 8px;"><?php echo $error['detailedErrorCode'];?></td>
            </tr>
            <tr style="background-color: #f2f2f2">
              <td style="padding: 8px;">detailedErrorMessage:</td>
              <td style="padding: 8px;"><?php echo $error['detailedErrorMessage'];?></td>
            </tr>
        <tdody>
        </tbody>
     </table>
    <?php
} 

/**
 * Display a nice signature error
 */
function signature_error($tr_uuid, $sha_key, $expected, $received)
{
    ?>
    <p style="font-family: Verdana,sans-serif;font-size:18px;color:#a52828;font-weight: BOLD;">SHA256 validation failed</p>
    <table style="border: 1px solid black;border-collapse: collapse;font-family: Verdana,sans-serif;line-height: 1.5;text-align: left;padding: 8px;">
            <tr style="background-color:#a52828;color:white;">
                <th style="padding: 8px;">Field</th>
                <th style="padding: 8px;">value</th>
			</tr> 
            <tr style="background-color: #f2f2f2">
              <td style="padding: 8px;">transaction uuid:</td>
              <td style="padding: 8px;"><?php echo $tr_uuid;?></td>
            </tr>       
            <tr>
              <td style="padding: 8px;">sha key:</td>
              <td style="padding: 8px;"><?php echo $sha_key;?></td>
            </tr>
            <tr style="background-color: #f2f2f2">
              <td style="padding: 8px;">expected value (calculated):</td>
              <td style="padding: 8px;"><?php echo $expected;?></td>
            </tr>
            <tr>
              <td style="padding: 8px;">recieved value (from POST):</td>
              <td style="padding: 8px;"><?php echo $received;?></td>
            </tr>
        <tdody>
        </tbody>
     </table>
    <?php
} 

/**
 * return POST data to simpulate an IPN
 */
function getIPNSimulatedPOSTData() {
  $post = array();
  $post["kr-answer-type"] = "V3.1/IPNRequest";
  $post["kr-hash"] = "a023b9c9a66706caf23e5076a3e70a0b0026d0e1a54389d658f3a1201938dfe5";
  $post["kr-hash-algorithm"] =  "sha256";
  $post["kr-answer"] = "{\"shopId\":\"69876357\",\"orderCycle\":\"CLOSED\",\"orderStatus\":\"PAID\",\"orderDetails\":{\"orderTotalAmount\":250,\"orderCurrency\":\"EUR\",\"mode\":\"TEST\",\"orderId\":null,\"_type\":\"V3.1/OrderDetails\"},\"customer\":{\"billingDetails\":{\"address\":null,\"category\":null,\"cellPhoneNumber\":null,\"city\":null,\"country\":null,\"district\":null,\"firstName\":null,\"identityCode\":null,\"language\":\"EN\",\"lastName\":null,\"phoneNumber\":null,\"state\":null,\"streetNumber\":null,\"title\":null,\"zipCode\":null,\"_type\":\"V3.1/Customer/BillingDetails\"},\"email\":\"sample@example.com\",\"reference\":null,\"shippingDetails\":{\"address\":null,\"address2\":null,\"category\":null,\"city\":null,\"country\":null,\"deliveryCompanyName\":null,\"district\":null,\"firstName\":null,\"identityCode\":null,\"lastName\":null,\"legalName\":null,\"phoneNumber\":null,\"shippingMethod\":null,\"shippingSpeed\":null,\"state\":null,\"streetNumber\":null,\"zipCode\":null,\"_type\":\"V3.1/Customer/ShippingDetails\"},\"extraDetails\":{\"browserAccept\":\"*/*\",\"fingerPrintId\":null,\"ipAddress\":\"90.71.64.161\",\"browserUserAgent\":\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10.13; rv:57.0) Gecko/20100101 Firefox/57.0\",\"_type\":\"V3.1/Customer/ExtraDetails\"},\"shoppingCart\":{\"insuranceAmount\":null,\"shippingAmount\":null,\"taxAmount\":null,\"cartItemInfo\":[],\"_type\":\"V3.1/Customer/ShoppingCart\"},\"_type\":\"V3.1/Customer/Customer\"},\"transactions\":[{\"shopId\":\"69876357\",\"uuid\":\"d7524a0b17724015a4b2859bb23bac6a\",\"amount\":250,\"currency\":\"EUR\",\"paymentMethodType\":\"CARD\",\"paymentMethodToken\":\"0b600ede3aff464e9807d160ed3cd8a9\",\"status\":\"PAID\",\"detailedStatus\":\"AUTHORISED\",\"operationType\":\"DEBIT\",\"effectiveStrongAuthentication\":\"DISABLED\",\"creationDate\":\"2018-02-06T10:36:30+00:00\",\"errorCode\":null,\"errorMessage\":null,\"detailedErrorCode\":null,\"detailedErrorMessage\":null,\"metadata\":null,\"transactionDetails\":{\"liabilityShift\":\"NO\",\"effectiveAmount\":250,\"effectiveCurrency\":\"EUR\",\"creationContext\":\"CHARGE\",\"cardDetails\":{\"paymentSource\":\"EC\",\"manualValidation\":\"NO\",\"expectedCaptureDate\":\"2018-02-06T10:36:20+00:00\",\"effectiveBrand\":\"CB\",\"pan\":\"497010XXXXXX0055\",\"expiryMonth\":11,\"expiryYear\":2021,\"country\":\"FR\",\"emisorCode\":17807,\"effectiveProductCode\":\"F\",\"legacyTransId\":\"904176\",\"legacyTransDate\":\"2018-02-06T10:36:20+00:00\",\"paymentMethodSource\":\"NEW\",\"authorizationResponse\":{\"amount\":250,\"currency\":\"EUR\",\"authorizationDate\":\"2018-02-06T10:36:30+00:00\",\"authorizationNumber\":\"3fdc7c\",\"authorizationResult\":\"0\",\"_type\":\"V3.1/PaymentMethod/Details/Cards/CardAuthorizationResponse\"},\"captureResponse\":{\"refundAmount\":null,\"captureDate\":\"2018-02-06T10:36:30+00:00\",\"captureFileNumber\":null,\"refundCurrency\":null,\"_type\":\"V3.1/PaymentMethod/Details/Cards/CardCaptureResponse\"},\"threeDSResponse\":{\"authenticationResultData\":{\"transactionCondition\":\"COND_3D_ERROR\",\"enrolled\":\"UNKNOWN\",\"status\":\"UNKNOWN\",\"eci\":null,\"xid\":null,\"cavvAlgorithm\":null,\"cavv\":null,\"signValid\":null,\"brand\":\"VISA\",\"_type\":\"V3.1/PaymentMethod/Details/Cards/CardAuthenticationResponse\"},\"_type\":\"V3.1/PaymentMethod/Details/Cards/ThreeDSResponse\"},\"_type\":\"V3.1/PaymentMethod/Details/CardDetails\"},\"fraudManagement\":null,\"parentTransactionUuid\":null,\"mid\":\"9876357\",\"_type\":\"V3.1/TransactionDetails\"},\"_type\":\"V3.1/IPNRequestTransaction\"}],\"serverDate\":\"2018-02-06T10:36:31+00:00\",\"_type\":\"V3.1/IPNRequest\"}";

  return $post;
}