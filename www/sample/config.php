<?php

/**
 * Define configuration
  * Configuration initialisation, using Lyra account informations.
 * provided in your Back Office (Menu: Settings > Shop > API REST Keys).
 
 **/

// SUBSTITUTE THE KEY NUMBER BY YOUR MERCHANT SHOP (Menu: Settings > Shop > API REST Keys)
 define('USERNAME', 'KEY Number 1');
 define('PASSWORD', 'KEY Number 2');
 define('PUBLIC_KEY', 'KEY Number 3');
 define('SHA_KEY', 'KEY Number 4');
 define('SERVER', 'KEY Number 5');
 $URL_JS = 'KEY Number 6';

/* To have the configuration of the DEMO SHOP, go to the technical documentary :
 - step 2 Authenticate
 _ sample file : config.php


 /* DOMAIN_URL :  domain of URL_JS */
define('DOMAIN_URL', strstr($URL_JS,'/static/',true));

?>




