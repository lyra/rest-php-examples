<?php 
/**
 * SDK installation and test minimal code
 * 
 * To run the example, go to 
 * https://github.com/LyraNetwork/krypton-php-examples
 */

/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/keys.php';

/** 
 * Initialize the SDK 
 * Please update your keys in keys.php
 */
$client = new LyraNetwork\Client();  
$client->setUsername($_username);           /* username defined in keys.php file */
$client->setPassword($_password);           /* password defined in keys.php file */
$client->setPublicKey($_publicKey);         /* key defined in keys.php file */
$client->setEndpoint($_endpoint);           /* REST API endpoint defined in keys.php file */

/**
 * I send test data
 */
$store = array("value" => "my testing value");
$response = $client->post("Charge/SDKTest", $store);
?>

<html>
<head>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/styles/dracula.min.css">
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="skinned/assets/paid.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.3.0/highlight.min.js"></script>

</head>

<body>
    <h1>SDK intallation test</h1>

<h2>post data sent:</h2>
<pre><code class="json"><?php print json_encode($store, JSON_PRETTY_PRINT) ?></code></pre>

<h2>data received:</h2>
<pre><code class="json"><?php print json_encode($response, JSON_PRETTY_PRINT) ?></code></pre>

<script type="text/javascript">
    $(document).ready(function() {
        $('pre code').each(function(i, block) {
            hljs.highlightBlock(block);
        });
    });
</script>

<h1><a href="/">Back to demo menu</a></h1>

</body></html>