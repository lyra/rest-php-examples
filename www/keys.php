<?php
/**
 * Get the client
 */
require_once __DIR__ . '/vendor/autoload.php';

/**
 * Define configuration
 */

/* Username, password and endpoint used for server to server web-service calls */
Lyra\Client::setDefaultUsername("31916241");
Lyra\Client::setDefaultPassword("testpassword_KmsHiyWyJEaMBn5sO2gLdxYyVjMZKPBSaDDSuOrMuXikD");
Lyra\Client::setDefaultEndpoint("https://api.payzen.lat/");

/* publicKey and used by the javascript client */
Lyra\Client::setDefaultPublicKey("31916241:testpassword_KmsHiyWyJEaMBn5sO2gLdxYyVjMZKPBSaDDSuOrMuXikD");

/* SHA256 key */
//sha1(31916241:testpassword_KmsHiyWyJEaMBn5sO2gLdxYyVjMZKPBSaDDSuOrMuXikD)
Lyra\Client::setDefaultSHA256Key("38453613e7f44dc58732bad3dca2bca3");