<?php
namespace Lyra\Tests;

use PHPUnit_Framework_TestCase;
use Lyra\Client;
use Lyra\Constants;

/**
 * ./vendor/bin/phpunit src/Lyra/Tests/ClientTest.php
 */
class ClientTest extends PHPUnit_Framework_TestCase
{
    private function getCredentials()
    {
        $credentials = array();
        $credentials["username"] = "69876357";
        $credentials["password"] = "testprivatekey_DEMOPRIVATEKEY23G4475zXZQ2UA5x7M";
        $credentials["endpoint"] = "https://api.payzen.eu";
        $credentials["publicKey"] = "69876357:testpublickey_DEMOPUBLICKEY95me92597fd28tGD4r5";
        $credentials["sha256Key"] = "ktM7bSeTJpclvpm4eEE9N0LIyoxUvsQ9AAYbQI1xQx7Qh";

        return $credentials;
    }

    private function fakePostData()
    {
        $_POST['kr-hash'] = "e9c3b47330380460880e025a256d98d97aeb26bd6807c3826fa366166ba212b4";
        $_POST['kr-hash-algorithm'] = "sha256_hmac";
        $_POST['kr-answer-type'] = "V4\/Payment";
        $_POST['kr-answer'] = '{"shopId":"33148340","orderCycle":"CLOSED","orderStatus":"PAID","orderDetails":{"orderTotalAmount":990,"orderCurrency":"EUR","mode":"TEST","orderId":"myOrderId-415662","_type":"V3.1\/OrderDetails"},"transactions":[{"uuid":"a84a1267f1b342f4baf8eb9a7a6e86df","status":"PAID","detailedStatus":"AUTHORISED","_type":"V3.1\/BrowserRequestTransaction"}],"serverDate":"2018-05-29T15:04:10+00:00","_type":"V3.1\/BrowserRequest"}';
    }

    /**
     * ./vendor/bin/phpunit --filter testClientValidCall src/Lyra/Tests/ClientTest.php
     */
    public function testClientValidCall()
    {
        $credentials = $this->getCredentials();
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setUsername($credentials['username']);
        $client->setPassword($credentials['password']);
        $client->setEndpoint($credentials['endpoint']);
        $response = $client->post('V4/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals("V4", $response["version"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testClientUsernamePasswordValidCall src/Lyra/Tests/ClientTest.php
     */
    public function testClientUsernamePasswordValidCall()
    {
        $client = new Client();
        $credentials = $this->getCredentials();
        $store = array("value" => "sdk test string value");

        $client->setUsername($credentials['username']);
        $client->setPassword($credentials['password']);
        $client->setEndpoint($credentials['endpoint']);
        $response = $client->post('V4/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testFileGetContentsPrivateKeyClientValidCall src/Lyra/Tests/ClientTest.php
     */
    public function testFileGetContentsPrivateKeyClientValidCall()
    {
        $credentials = $this->getCredentials();
        $client = new Client();
        $store = array("value" => "sdk test string value");

        $client->setUsername($credentials['username']);
        $client->setPassword($credentials['password']);
        $client->setEndpoint($credentials['endpoint']);
        $response = $client->postWithFileGetContents('V4/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testFileGetContentsClientValidCall src/Lyra/Tests/ClientTest.php
     */
    public function testFileGetContentsClientValidCall()
    {
        $credentials = $this->getCredentials();
        $client = new Client();
        $store = array("value" => "sdk test string value");

        $client->setUsername($credentials['username']);
        $client->setPassword($credentials['password']);
        $client->setEndpoint($credentials['endpoint']);
        $response = $client->postWithFileGetContents('V4/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testDoubleSlash src/Lyra/Tests/ClientTest.php
     */
    public function testDoubleSlash()
    {
        $credentials = $this->getCredentials();
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setUsername($credentials['username']);
        $client->setPassword($credentials['password']);
        $client->setEndpoint($credentials['endpoint']);
        $response = $client->post('V4/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testGetUrlFromTarget src/Lyra/Tests/ClientTest.php
     */
    public function testGetUrlFromTarget()
    {
        $credentials = $this->getCredentials();
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setUsername($credentials['username']);
        $client->setPassword($credentials['password']);

        $client->setEndpoint($credentials['endpoint']);
        $this->assertEquals($credentials['endpoint'] . "/api-payment/V4/Charge/Get", $client->getUrlFromTarget("V4/Charge/Get"));

        $client->setEndpoint($credentials['endpoint']);
        $this->assertEquals($credentials['endpoint'] . "/api-payment/V4/Charge/Get", $client->getUrlFromTarget("V4/Charge/Get"));
    }

    /**
     * ./vendor/bin/phpunit --filter testNoPrivateKey src/Lyra/Tests/ClientTest.php
     *
     * @expectedException Lyra\Exceptions\LyraException
     */
    public function testNoPrivateKey()
    {
        $client = new Client();
        $client->post("A", array());
    }

    /**
     * ./vendor/bin/phpunit --filter testNoUsername src/Lyra/Tests/ClientTest.php
     *
     * @expectedException Lyra\Exceptions\LyraException
     */
    public function testNoUsername()
    {
        $client = new Client();
        $credentials = $this->getCredentials();

        $client->setPassword($credentials['password']);
        $client->post("A", array());
    }

    /**
     * ./vendor/bin/phpunit --filter testNoPassword src/Lyra/Tests/ClientTest.php
     *
     * @expectedException Lyra\Exceptions\LyraException
     */
    public function testNoPassword()
    {
        $client = new Client();
        $credentials = $this->getCredentials();

        $client->setUsername($credentials['username']);
        $client->post("A", array());
    }

    /**
     * ./vendor/bin/phpunit --filter testNoEndpoint src/Lyra/Tests/ClientTest.php
     *
     * @expectedException Lyra\Exceptions\LyraException
     */
    public function testNoEndpoint()
    {
        $client = new Client();
        $credentials = $this->getCredentials();

        $client->setUsername("A");
        $client->setPassword("B");
        $client->post("A", array());
    }

    /**
     * ./vendor/bin/phpunit --filter testInvalidKey src/Lyra/Tests/ClientTest.php
     */
    public function testInvalidKey()
    {
        $credentials = $this->getCredentials();
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setUsername($credentials['username']);
        $client->setPassword("69876357:testprivatekey_FAKE");
        $client->setEndpoint($credentials['endpoint']);
        $response = $client->post('V4/Charge/SDKTest', $store);

        $this->assertEquals("ERROR", $response["status"]);
        $this->assertEquals("INT_905", $response["answer"]["errorCode"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testFileGetContentsInvalidKey src/Lyra/Tests/ClientTest.php
     */
    public function testFileGetContentsInvalidKey()
    {
        $credentials = $this->getCredentials();
        $store = array("value" => "sdk test string value");
        
        $client = new Client();
        $client->setUsername($credentials['username']);
        $client->setPassword("69876357:testprivatekey_FAKE");
        $client->setEndpoint($credentials['endpoint']);
        $response = $client->postWithFileGetContents('V4/Charge/SDKTest', $store);

        $this->assertEquals("ERROR", $response["status"]);
        $this->assertEquals("INT_905", $response["answer"]["errorCode"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testClientConfiguration src/Lyra/Tests/ClientTest.php
     */
    public function testClientConfiguration()
    {
        $client = new Client();
        $credentials = $this->getCredentials();

        $client->setUsername($credentials['username']);
        $client->setPassword("testprivatekey_FAKE");
        $client->setEndpoint($credentials['endpoint']);
        $client->setPublickey($credentials["publicKey"]);

        $this->assertEquals(Constants::SDK_VERSION, $client->getVersion());
        $this->assertEquals($credentials['publicKey'], $client->getPublicKey());
        $this->assertEquals($credentials['endpoint'], $client->getEndpoint());
        $this->assertEquals($credentials['endpoint'], $client->getClientEndpoint());

        $client->setClientEndpoint("https://url.client");
        $this->assertEquals($credentials['endpoint'], $client->getEndpoint());
        $this->assertEquals("https://url.client", $client->getClientEndpoint());
    }

    /**
     * ./vendor/bin/phpunit --filter testDefaultClientConfiguration src/Lyra/Tests/ClientTest.php
     */
    public function testDefaultClientConfiguration()
    {
        $credentials = $this->getCredentials();

        Client::setDefaultUsername($credentials['username']);
        Client::setDefaultPassword($credentials['password']);
        Client::setDefaultEndpoint($credentials['endpoint']);
        Client::setDefaultPublicKey($credentials['publicKey']);
        Client::setDefaultClientEndpoint("https://url.client");
        Client::setdefaultSHA256Key($credentials['sha256Key']);

        $client = new Client();
        $store = array("value" => "sdk test string value");
        $response = $client->post('V4/Charge/SDKTest', $store);

        $this->assertEquals("SUCCESS", $response["status"]);
        $this->assertEquals($store["value"], $response["answer"]["value"]);

        $this->assertEquals(Constants::SDK_VERSION, $client->getVersion());
        $this->assertEquals($credentials['publicKey'], $client->getPublicKey());
        $this->assertEquals($credentials['username'], $client->getUsername());
        $this->assertEquals($credentials['password'], $client->getPassword());
        $this->assertEquals($credentials['endpoint'], $client->getEndpoint());
        $this->assertEquals("https://url.client", $client->getClientEndpoint());
        $this->assertEquals($credentials['sha256Key'], $client->getSHA256Key());
        $this->assertEquals(null, $client->getProxyHost());
        $this->assertEquals(null, $client->getProxyPort());

        Client::setDefaultProxy("simple.host", "1234");
        $client2 = new Client();
        $this->assertEquals($credentials['username'], $client2->getUsername());
        $this->assertEquals("simple.host", $client2->getProxyHost());
        $this->assertEquals("1234", $client2->getProxyPort());

        Client::resetDefaultConfiguration();
        $client = new Client();
        $this->assertEquals(null, $client->getPublicKey());
        $this->assertEquals(null, $client->getUsername());
        $this->assertEquals(null, $client->getPassword());
        $this->assertEquals(null, $client->getEndpoint());
        $this->assertEquals(null, $client->getClientEndpoint());
        $this->assertEquals(null, $client->getSHA256Key());
        $this->assertEquals(null, $client->getProxyHost());
        $this->assertEquals(null, $client->getProxyPort());
    }

    /**
     * ./vendor/bin/phpunit --filter testFakeProxy src/Lyra/Tests/ClientTest.php
     *
     * @expectedException Lyra\Exceptions\LyraException
     */
    public function testFakeProxy()
    {
        $client = new Client();
        $credentials = $this->getCredentials();

        $client->setUsername($credentials['username']);
        $client->setPassword($credentials['password']);
        $client->setEndpoint($credentials['endpoint']);
        $client->setTimeOuts(1,1);
        $client->setProxy('fake.host', 1234);

        $store = array("value" => "sdk test string value");
        $response = $client->post('V4/Charge/SDKTest', $store);
        $this->assertEquals("fake.host", $client->getProxyHost());
        $this->assertEquals("1234", $client->getProxyPort());
    }

    /**
     * ./vendor/bin/phpunit --filter testInvalidAnswer src/Lyra/Tests/ClientTest.php
     */
    public function testInvalidAnswer()
    {
        $client = new Client();
        $credentials = $this->getCredentials();

        $client->setUsername($credentials['username']);
        $client->setPassword($credentials['password']);

        $client->setEndpoint($credentials['endpoint']);

        $store = "FAKE";
        $response = $client->post('V4/Charge/SDKTest', $store);

        $this->assertEquals("ERROR", $response["status"]);
        $this->assertEquals("INT_902", $response["answer"]["errorCode"]);
    }

    /**
     * ./vendor/bin/phpunit --filter testGetParsedFormAnswer src/Lyra/Tests/ClientTest.php
     */
    public function testGetParsedFormAnswer()
    {
        $client = new Client();
        $this->fakePostData();
        $answer = $client->getParsedFormAnswer();

        $this->assertEquals($_POST['kr-hash'], $answer['kr-hash']);
        $this->assertEquals($_POST['kr-hash-algorithm'], $answer['kr-hash-algorithm']);
        $this->assertEquals($_POST['kr-answer-type'], $answer['kr-answer-type']);

        $rebuild_string_answer = json_encode($answer['kr-answer']);
        /* php 5.3.3 does not support JSON_UNESCAPED_SLASHES */

        $this->assertEquals($_POST['kr-answer'], $rebuild_string_answer);
        $this->assertEquals("array", gettype($answer['kr-answer']));
    }

    /**
     * ./vendor/bin/phpunit --filter testCheckHash256HMAC src/Lyra/Tests/ClientTest.php
     */
    public function testCheckHash256HMAC()
    {
        $client = new Client();
        $credentials = $this->getCredentials();
        $this->fakePostData();
        $this->assertNull($client->getLastCalculatedHash());

        $client->setSHA256Key($credentials["sha256Key"]);
        $isValid = $client->checkHash($client->getSHA256Key());

        $this->assertTrue($isValid);
        $this->assertNotNull($client->getLastCalculatedHash());
    }
}