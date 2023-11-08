<?php
/**
 * Get the client
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Define configuration
 */

/* Username, password and endpoint used for server to server web-service calls */
//Lyra\Client::setDefaultUsername("31916241");
//Lyra\Client::setDefaultPassword("testpassword_KmsHiyWyJEaMBn5sO2gLdxYyVjMZKPBSaDDSuOrMuXikD");
//Lyra\Client::setDefaultEndpoint("https://api.payzen.lat/");
//
///* publicKey and used by the javascript client */
//Lyra\Client::setDefaultPublicKey("31916241:testpassword_KmsHiyWyJEaMBn5sO2gLdxYyVjMZKPBSaDDSuOrMuXikD");
//
///* SHA256 key */
////sha1(31916241:testpassword_KmsHiyWyJEaMBn5sO2gLdxYyVjMZKPBSaDDSuOrMuXikD)
Lyra\Client::setDefaultSHA256Key($claveSHA256);

/* Username, password and endpoint used for server to server web-service calls */
Lyra\Client::setDefaultUsername($shopID);
Lyra\Client::setDefaultPassword($clave);
Lyra\Client::setDefaultEndpoint($endPoint);
//Lyra\Client::setDefaultEndpoint("https://static.payzen.lat");

/* publicKey and used by the javascript client */
Lyra\Client::setDefaultPublicKey($publicKey);

/* Javascript content delivery server */
Lyra\Client::setDefaultClientEndpoint("https://static.payzen.eu");

/* SHA256 key */
Lyra\Client::setDefaultSHA256Key($claveSHA256);