<?php
   include_once 'config.php';
   
   // STEP 1 : check the signature with the password
   if (!checkHash($_POST, PASSWORD)) {
       echo 'Invalid signature. <br />';
       echo '<pre>' . print_r($_POST, true) . '</pre>';
       die();
   }
   
   $answer = array();
   $answer['kr-hash'] = $_POST['kr-hash'];
   $answer['kr-hash-algorithm'] = $_POST['kr-hash-algorithm'];
   $answer['kr-answer-type'] = $_POST['kr-answer-type'];
   $answer['kr-answer'] = json_decode($_POST['kr-answer'], true);
           
   function checkHash($data, $key)
   {
       $supported_sign_algos = array('sha256_hmac');
       if (!in_array($data['kr-hash-algorithm'], $supported_sign_algos)) {
           return false;
       }
       $kr_answer = str_replace('\/', '/', $data['kr-answer']);
       $hash = hash_hmac('sha256', $kr_answer, $key);
       return ($hash == $data['kr-hash']);
   }
   
   /* STEP 2 : get some parameters from the answer */
   $orderStatus = $answer['kr-answer'] ['orderStatus'];
   $orderId = $answer['kr-answer']['orderDetails']['orderId'];
   $transactionUuid = $answer['kr-answer']['transactions'][0]['uuid'] ;
   
   /* I update my database if needed */
   /* Add here your custom code */ 
   
   /**
    * Message returned to the IPN caller
    * You can return want you want but
    * HTTP response code should be 200
    */
   print 'OK! OrderStatus is ' . $orderStatus;
   ?>