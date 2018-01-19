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
  $post["kr-hash"] = "8a09000b4469833ab38b486cb24ecaa1987b3b27be07c6c1867c2b60c1331505";
  $post["kr-hash-algorithm"] =  "sha256";
  $post["kr-answer"] = "{\"shopId\":\"69876357\",\"orderCycle\":\"CLOSED\",\"orderStatus\":\"PAID\",\"orderDetails\":{\"orderTotalAmount\":250,\"orderCurrency\":\"EUR\",\"mode\":\"TEST\",\"orderId\":\"7722f772928c4e8f86ba589bb11dc7ce\",\"_type\":\"V3.1/OrderDetails\"},\"transactions\":[{\"uuid\":\"05b786fc9eb84bbe94db1a4b6c4d4be0\",\"status\":\"PAID\",\"detailedStatus\":\"AUTHORISED\",\"_type\":\"V3.1/BrowserRequestTransaction\"}],\"serverDate\":\"2018-01-19T14:02:09+00:00\",\"_type\":\"V3.1/BrowserRequest\"}";

  return $post;
}