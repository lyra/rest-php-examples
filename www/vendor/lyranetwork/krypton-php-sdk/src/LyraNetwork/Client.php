<?php
namespace LyraNetwork;

use LyraNetwork\Exceptions\LyraNetworkException;
use LyraNetwork\Constants;

class Client
{
    private $_username = null;
    private $_password = null;
    private $_publicKey = null;
    private $_connectionTimeout = 45;
    private $_timeout = 45;
    private $_proxyHost = null;
    private $_proxyPort = null;
    private $_endpoint = null;
    private $_clientEndpoint = null;
    private $_lastCalculatedHash = null;

    public function getVersion() {
        return Constants::SDK_VERSION;
    }

    public function setEndpoint($endpoint) {
         $this->_endpoint = $endpoint;
    }

    public function setClientEndpoint($clientEndpoint) {
        $this->_clientEndpoint = $clientEndpoint;
    }

    public function getEndpoint() {
         return $this->_endpoint;
    }

    public function getClientEndpoint() {
        if ($this->_clientEndpoint) return $this->_clientEndpoint;
        return $this->_endpoint;
   }

    public function setPrivateKey($privateKey) {
        $auth = explode(':', $privateKey);

        if (count($auth) != 2) {
            throw new LyraNetworkException("invalid private key");
        }

        $this->_username = $auth[0];
        $this->_password = $auth[1];
    }

    public function setUsername($username) {
        $this->_username = $username;
    }

    public function setPassword($password) {
        $this->_password = $password;
    }

    public function setPublicKey($publicKey) {
        $this->_publicKey = $publicKey;
    }

    public function getPublicKey() {
        return $this->_publicKey;
    }

    public function setProxy($host, $port) {
        $this->_proxyHost = $host;
        $this->_proxyPort = $port;
    }

    public function setTimeOuts($connectionTimeout, $timeout) {
        $this->_connectionTimeout = $connectionTimeout;
        $this->_timeout = $timeout;
    }

    public function post($target, $array)
    {
        if (!$this->_username) {
            throw new LyraNetworkException("username is not defined in the SDK");
        }

        if (!$this->_password) {
            throw new LyraNetworkException("password is not defined in the SDK");
        }

        if (!$this->_endpoint) {
            throw new LyraNetworkException("REST API endpoint not defined in the SDK");
        }

        if (extension_loaded('curl')) {
            return $this->postWithCurl($target, $array);
        } else {
            return $this->postWithFileGetContents($target, $array);
        }
    }

    public function getUrlFromTarget($target)
    {
        $url = $this->_endpoint . "/api-payment/" . $target;
        $url = preg_replace('/([^:])(\/{2,})/', '$1/', $url); 
        
        return $url;
    }


    public function postWithCurl($target, $array)
    {
        $authString = $this->_username . ":" . $this->_password;
        $url = $this->getUrlFromTarget($target);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_USERAGENT, 'Krypton PHP SDK ' . Constants::SDK_VERSION);
        curl_setopt($curl, CURLOPT_USERPWD, $authString);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($array));
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT , $this->_connectionTimeout);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->_timeout);

        if($this->_proxyHost && $this->_proxyPort) {
          curl_setopt($curl, CURLOPT_PROXY, $this->_proxyHost);
          curl_setopt($curl, CURLOPT_PROXYPORT, $this->_proxyPort);
        }

        $raw_response = curl_exec($curl);

        /**
         * CA ROOT misconfigured, we try with a local CA bundle
         * It's a common error with a WAMP local server
         */
        if (curl_errno($curl) == 60 && strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            curl_setopt($curl, CURLOPT_CAINFO, dirname(__FILE__) . '/cacert.pem');
            $raw_response = curl_exec($curl);
        }
                  

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $allowedCode = array(200, 401);
        $response = json_decode($raw_response , true);

        if ( !in_array($status, $allowedCode) || is_null($response)) {
            throw new LyraNetworkException("Error: call to URL $url failed with status $status, response $raw_response, curl_error " . curl_error($curl) . ", curl_errno " . curl_errno($curl));
        }

        return $response;
    }

    public function postWithFileGetContents($target, $array)
    {
        $url = $this->getUrlFromTarget($target);
        $authString = $this->_username . ":" . $this->_password;

        $http = array(
            'method'        => 'POST',
            'header'        => 'Authorization: Basic ' . base64_encode($authString) . "\r\n".
                              'Content-Type: application/json',
            'content'       => json_encode($array),
            'user_agent'    => 'Krypton PHP SDK fallback ' . Constants::SDK_VERSION,
            'timeout'       => $this->_timeout,
            'ignore_errors' => true
        );

        if($this->_proxyHost && $this->_proxyPort) {
            $http['proxy'] = $this->_proxyHost . ':' . $this->_proxyPort;
        }

        $context = stream_context_create(array('http' => $http));
        $raw_response = file_get_contents($url, false, $context);

        if (!$raw_response) {
            throw new LyraNetworkException("Error: call to URL $url failed.");
        }

        $response = json_decode($raw_response, true);

        if (!$response) {
            throw new LyraNetworkException("Error: call to URL $url failed.");
        }

        return $response;
    }

    /**
     * Retrieve payment form answer from POST data
     */
    public function getParsedFormAnswer()
    {
        if (!array_key_exists("kr-hash", $_POST)) throw new LyraNetworkException("kr-hash not found in POST parameters");
        if (!array_key_exists("kr-hash-algorithm", $_POST)) throw new LyraNetworkException("kr-hash-algorithm not found in POST parameters");
        if (!array_key_exists("kr-answer-type", $_POST)) throw new LyraNetworkException("kr-answer-type not found in POST parameters");
        if (!array_key_exists("kr-answer", $_POST)) throw new LyraNetworkException("kr-answer not found in POST parameters");

        $answer = array();
        $answer['kr-hash'] = $_POST['kr-hash'];
        $answer['kr-hash-algorithm'] = $_POST['kr-hash-algorithm'];
        $answer['kr-answer-type'] = $_POST['kr-answer-type'];

        try {
            $answer['kr-answer'] = json_decode($_POST['kr-answer'], true);
        } catch(Exception $e) {
            throw new LyraNetworkException("kr-answer JSON decoding failed");
        }
        
        return $answer;
    }

    /**
     * retrieve the last calculated hash
     */
    public function getLastCalculatedHash()
    {
        return $this->_lastCalculatedHash;
    }

    /**
     * check kr-answer object signature
     */
    public function checkHash($hashKey)
    {
        /* check if the hash algorithm is supported */
        if ($_POST['kr-hash-algorithm'] != "sha256") {
            throw new LyraNetworkException("hash algorithm not supported:" . $_POST['kr-hash-algorithm']);
        }

        /* calculating the hash on our side */
        $stringToHash = $_POST['kr-answer'] . "+" . $hashKey;
        $calculatedHash = hash($_POST['kr-hash-algorithm'], $stringToHash);
        $this->_lastCalculatedHash = $calculatedHash;

        /* return true if calculated hash and sent hash are the same */
        return ($calculatedHash == $_POST['kr-hash']);
    }
}