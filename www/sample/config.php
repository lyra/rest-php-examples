<?php

/**
 * Define configuration
  * Configuration initialisation, using Lyra account informations.
 * provided in your Back Office (Menu: Settings > Shop > API REST Keys).
 
 **/

// SUBSTITUTE THE !!!CHANGEME!!! BY YOUR MERCHANT SHOP (Menu: Settings > Shop > API REST Keys)
 define('USERNAME', '!!!CHANGEME!!!');
 define('PASSWORD', '!!!CHANGEME!!!');
 define('PUBLIC_KEY', '!!!CHANGEME!!!');
 define('SHA_KEY', '!!!CHANGEME!!!');
 define('SERVER', '!!!CHANGEME!!!');
 $URL_JS = '!!!CHANGEME!!!';

/* To have the configuration of the DEMO SHOP, go to the technical documentary :
 - step 2 Authenticate
 _ sample file : config.php


 /* DOMAIN_URL :  domain of URL_JS */
define('DOMAIN_URL', strstr($URL_JS,'/static/',true));

?>




