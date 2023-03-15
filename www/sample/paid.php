<?php
   include_once 'config.php';
   
   // STEP 1 : check the signature with the SHA_KEY on the file config.php
   if (!checkHash($_POST, SHA_KEY)) {
       echo 'Invalid signature. <br />';
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
   ?>
<html>
   <head>
      <meta http-equiv="Pragma" content="no-cache">
      <meta http-equiv="Expires" content="-1">
      <title>Successful payment</title>
   </head>
   <body>
      <body>
         <div class="container">
            <h2>Data recevied :</h2>
            <!-- STEP 2 : get some parameters from the 'kr-answer'  -->
            <strong>Numéro de la boutique :</strong>
            <?php echo $answer['kr-answer'] ['shopId'] ;?>
            <br />
            <strong>Le statut de la transaction :</strong>
            <?php echo $answer['kr-answer'] ['orderStatus'] ;?>
            <br />
            <strong>Numéro de la transaction :</strong>
            <?php echo $answer['kr-answer']['transactions'][0]['uuid'] ; ?>
            <br />
            <strong>Numéro de la commande :</strong>
            <?php echo $answer['kr-answer']['orderDetails']['orderId'] ; ?>
            <br />
         </div>
   </body>
</html>