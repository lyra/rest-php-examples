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
  $post["kr-hash"] = "9074a0bd1b926fd78ed91eec074affc8d844ed26439fc471e0ca4e6723fa049e";
  $post["kr-hash-key"] = "password";
  $post["kr-hash-algorithm"] =  "sha256_hmac";
  $post["kr-answer"] = "{\"shopId\":\"69876357\",\"orderCycle\":\"CLOSED\",\"orderStatus\":\"PAID\",\"serverDate\":\"2018-11-08T08:35:09+00:00\",\"orderDetails\":{\"orderTotalAmount\":990,\"orderCurrency\":\"EUR\",\"mode\":\"TEST\",\"orderId\":\"myOrderId-187033\",\"_type\":\"V4/OrderDetails\"},\"customer\":{\"billingDetails\":{\"address\":null,\"category\":null,\"cellPhoneNumber\":null,\"city\":null,\"country\":null,\"district\":null,\"firstName\":null,\"identityCode\":null,\"language\":\"FR\",\"lastName\":null,\"phoneNumber\":null,\"state\":null,\"streetNumber\":null,\"title\":null,\"zipCode\":null,\"_type\":\"V4/Customer/BillingDetails\"},\"email\":\"sample@example.com\",\"reference\":null,\"shippingDetails\":{\"address\":null,\"address2\":null,\"category\":null,\"city\":null,\"country\":null,\"deliveryCompanyName\":null,\"district\":null,\"firstName\":null,\"identityCode\":null,\"lastName\":null,\"legalName\":null,\"phoneNumber\":null,\"shippingMethod\":null,\"shippingSpeed\":null,\"state\":null,\"streetNumber\":null,\"zipCode\":null,\"_type\":\"V4/Customer/ShippingDetails\"},\"extraDetails\":{\"browserAccept\":null,\"fingerPrintId\":null,\"ipAddress\":\"37.1.253.83\",\"browserUserAgent\":\"Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36\",\"_type\":\"V4/Customer/ExtraDetails\"},\"shoppingCart\":{\"insuranceAmount\":null,\"shippingAmount\":null,\"taxAmount\":null,\"cartItemInfo\":null,\"_type\":\"V4/Customer/ShoppingCart\"},\"_type\":\"V4/Customer/Customer\"},\"transactions\":[{\"shopId\":\"69876357\",\"uuid\":\"971b6b3b9e364e87bfbe9886b3a75df4\",\"amount\":990,\"currency\":\"EUR\",\"paymentMethodType\":\"CARD\",\"paymentMethodToken\":null,\"status\":\"PAID\",\"detailedStatus\":\"AUTHORISED\",\"operationType\":\"DEBIT\",\"effectiveStrongAuthentication\":\"DISABLED\",\"creationDate\":\"2018-11-08T08:35:09+00:00\",\"errorCode\":null,\"errorMessage\":null,\"detailedErrorCode\":null,\"detailedErrorMessage\":null,\"metadata\":null,\"transactionDetails\":{\"liabilityShift\":\"NO\",\"effectiveAmount\":990,\"effectiveCurrency\":\"EUR\",\"creationContext\":\"CHARGE\",\"cardDetails\":{\"paymentSource\":\"EC\",\"manualValidation\":\"NO\",\"expectedCaptureDate\":\"2018-11-08T08:35:09+00:00\",\"effectiveBrand\":\"CB\",\"pan\":\"497010XXXXXX0055\",\"expiryMonth\":11,\"expiryYear\":2021,\"country\":\"FR\",\"emisorCode\":null,\"effectiveProductCode\":\"F\",\"legacyTransId\":\"900147\",\"legacyTransDate\":\"2018-11-08T08:35:03+00:00\",\"paymentMethodSource\":\"NEW\",\"authorizationResponse\":{\"amount\":990,\"currency\":\"EUR\",\"authorizationDate\":\"2018-11-08T08:35:09+00:00\",\"authorizationNumber\":\"3fe034\",\"authorizationResult\":\"0\",\"authorizationMode\":\"FULL\",\"_type\":\"V4/PaymentMethod/Details/Cards/CardAuthorizationResponse\"},\"captureResponse\":{\"refundAmount\":null,\"captureDate\":null,\"captureFileNumber\":null,\"refundCurrency\":null,\"_type\":\"V4/PaymentMethod/Details/Cards/CardCaptureResponse\"},\"threeDSResponse\":{\"authenticationResultData\":{\"transactionCondition\":\"COND_3D_ERROR\",\"enrolled\":\"UNKNOWN\",\"status\":\"UNKNOWN\",\"eci\":null,\"xid\":null,\"cavvAlgorithm\":null,\"cavv\":null,\"signValid\":null,\"brand\":\"VISA\",\"_type\":\"V4/PaymentMethod/Details/Cards/CardAuthenticationResponse\"},\"_type\":\"V4/PaymentMethod/Details/Cards/ThreeDSResponse\"},\"installmentNumber\":null,\"markAuthorizationResponse\":{\"amount\":null,\"currency\":null,\"authorizationDate\":null,\"authorizationNumber\":null,\"authorizationResult\":null,\"_type\":\"V4/PaymentMethod/Details/Cards/MarkAuthorizationResponse\"},\"_type\":\"V4/PaymentMethod/Details/CardDetails\"},\"fraudManagement\":null,\"parentTransactionUuid\":null,\"mid\":\"6969696\",\"sequenceNumber\":1,\"_type\":\"V4/TransactionDetails\"},\"_type\":\"V4/PaymentTransaction\"}],\"_type\":\"V4/Payment\"}";

  return $post;
}