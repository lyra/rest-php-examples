<?php 
/**
 * SDK installation and test minimal code
 * 
 * To run the example, go to 
 * hhttps://github.com/lyra/rest-php-example
 */

/**
 * I initialize the PHP SDK
 */
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/keys.php';
require_once __DIR__ . '/helpers.php';

/** 
 * Initialize the SDK 
 * Please update your keys in keys.php
 */
$client = new Lyra\Client();  

/**
 * I send test data
 */
$store = array("value" => "my testing value");
$response = $client->post("V4/Charge/SDKTest", $store);
?>

<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
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