<?php
/**
 * Get the client
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Define configuration
 */

/* Username, password and endpoint used for server to server web-service calls */
LyraNetwork\Client::setDefaultUsername("69876357");
LyraNetwork\Client::setDefaultPassword("testpassword_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M");
LyraNetwork\Client::setDefaultEndpoint("https://secure.payzen.eu");

/* publicKey and used by the javascript client */
LyraNetwork\Client::setDefaultPublicKey("69876357:testpublickey_DEMOPUBLICKEY95me92597fd28tGD4r5");

/* SHA256 key */
LyraNetwork\Client::setDefaultSHA256Key("38453613e7f44dc58732bad3dca2bca3");

